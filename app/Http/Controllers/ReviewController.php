<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Category;
use App\Models\Note;
use App\Models\Tag;
use App\Models\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reviews = Review::with(['author:id,name', 'categories:name,slug,color'])->whereNotNuLL('published_at')->orderBy('created_at', 'desc')->paginate(5, ['id','user_id', 'title', 'slug', 'img', 'summary', 'created_at']);
        return view('review.index', compact('reviews'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::with('childrensRecursive:id,name,parent_id')->whereNull('parent_id')->get(['id', 'name', 'parent_id']);
        return view('old.review.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
          'title' => 'required|string|min:10|max:255|unique:reviews',
          'summary' => 'required|string|min:10|max:255',
          'body'  => 'required|min:10',
          'slug'  => 'alpha_dash|nullable',
          'seo_title' => 'nullable|string|min:10|max:255',
          'categories' => 'required|array|max:3',
          'featured' => 'required|image|mimes:jpeg,png,jpg|max:1024'
        ]);

        $slug = $request->slug ? str_slug($request->slug, '-') : str_slug($request->title, '-');

        if ($request->hasFile('featured')) {
            if ($request->file('featured')->isValid()) {
                $image = $request->file('featured');
                $extension = $image->extension();
                $fullname = "{$slug}.{$extension}";

                $path = storage_path('app/public/uploads');

                Image::make($image)->fit(604, 356)->save($path . "/604-356/{$fullname}");
                Image::make($image)->fit(98, 98)->save($path . "/98-98/{$fullname}");
                Image::make($image)->fit(400, 240)->save($path . "/400-240/{$fullname}");
                Image::make($image)->fit(303, 182)->save($path . "/303-182/{$fullname}");
                Image::make($image)->fit(1218, 609)->save($path . "/1218-609/{$fullname}");

                ImageOptimizer::optimize($path . "/604-356/{$fullname}");
                ImageOptimizer::optimize($path . "/98-98/{$fullname}");
                ImageOptimizer::optimize($path . "/400-240/{$fullname}");
                ImageOptimizer::optimize($path . "/303-182/{$fullname}");
                ImageOptimizer::optimize($path . "/1218-609/{$fullname}");

                exec("cwebp -q 70 " . $path . "/604-356/{$fullname}" . " -o " . $path . "/604-356/{$fullname}.webp");
                exec("cwebp -q 70 " . $path . "/98-98/{$fullname}" . " -o " . $path . "/604-356/{$fullname}.webp");
                exec("cwebp -q 70 " . $path . "/400-240/{$fullname}" . " -o " . $path . "/604-356/{$fullname}.webp");
                exec("cwebp -q 70 " . $path . "/303-182/{$fullname}" . " -o " . $path . "/604-356/{$fullname}.webp");
                exec("cwebp -q 70 " . $path . "/1218-609/{$fullname}" . " -o " . $path . "/604-356/{$fullname}.webp");
            }
        }

        preg_match_all('/<img[^>]+src=".*\/storage\/uploads\/post([^"]+)/', $request->body, $matches);
        $images = $matches[1];

        foreach ($images as $image) {
            if (Storage::exists('public/uploads/post' . $image)) {
                $path = storage_path('app/public/uploads/post') . $image;

                ImageOptimizer::optimize($path);

                exec("cwebp -q 70 " . $path . " -o " . $path . ".webp");
            }
        }

        $review = Review::create([
          'user_id'   => auth()->id(),
          'title'     => $request->title,
          'seo_title' => $request->seo_title ? $request->seo_title  : $request->title,
          'summary'   => $request->summary,
          'body'      => $request->body,
          'slug'      => $slug,
          'img'       => $fullname
        ]);

        $categories = $request->categories;
        $parents = [];

        foreach ($categories as $category) {
            $category = Category::find($category);
            $category->allReviews()->attach($review);
            if (isset($category->parent)) {
                if (!in_array($category->parent->id, $parents)) {
                    array_push($parents, $category->parent->id);
                }
            }
        }

        foreach ($parents as $parent) {
            $parent = Category::find($parent);
            $parent->allReviews()->attach($review);
        }

        if ($request->tags) {
            Tag::create([
            'review_id' => $review->id,
            'tags' => $request->tags
          ]);
        }

        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
        if ($review->published_at !== null) {
            if (isset($review->tags->tags)) {
                $search = str_replace(',', ' ', $review->tags->tags);
                $reviewTags = $review->tags ? explode(',', $review->tags->tags) : [];
                $relateds = Review::search($search)->take(15)
                    ->query(function ($query) {
                        $query->select(['id', 'title', 'seo_title', 'slug', 'img']);
                    })->get();

                foreach ($relateds as $key => $related) {
                    if ($related->title === $review->title) {
                        $relateds->forget($key);
                        break;
                    }
                }

                return view('review.show', compact(['review', 'relateds', 'reviewTags']));
            }

            return view('review.show', compact('review'));
        } else {
            abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        $categories = Category::with('childrens:id,name,parent_id')->get(['id', 'name', 'parent_id']);
        return view('old.review.edit', compact('review', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review)
    {
        $request->validate([
        'title' => 'required|string|min:10|max:255',
        'summary' => 'required|string|min:10|max:255',
        'body'  => 'required|min:10',
        'slug'  => 'alpha_dash|nullable',
        'seo_title' => 'nullable|string|min:10|max:255',
        'categories' => 'required|array|max:3',
        'featured' => 'nullable|image|mimes:jpeg,png,jpg|max:1024'
      ]);

        $slug = $request->slug ? str_slug($request->slug, '-') : str_slug($request->title, '-');

        if ($review->slug <> $request->slug) {
            $redirect = new Redirect;
            $redirect->old_url = '/'. $review->slug;
            $redirect->new_url = '/'. $request->slug;
            $redirect->save();
        }

        if ($request->hasFile('featured')) {
            if ($request->file('featured')->isValid()) {
                $image = $request->file('featured');
                $extension = $image->extension();
                $fullname = "{$slug}.{$extension}";

                
                
                Storage::delete('public/uploads/604-356/' . str_after($review->img, asset('uploads') . '/'));
                Storage::delete('public/uploads/98-98/' . str_after($review->img, asset('uploads') . '/'));
                Storage::delete('public/uploads/400-240' . str_after($review->img, asset('uploads') . '/'));
                Storage::delete('public/uploads/303-182' . str_after($review->img, asset('uploads') . '/'));
                Storage::delete('public/uploads/1218-609' . str_after($review->img, asset('uploads') . '/'));

                $path = storage_path('app/public/uploads');

                Image::make($image)->fit(604, 356)->save($path . "/604-356/{$fullname}");
                Image::make($image)->fit(98, 98)->save($path . "/98-98/{$fullname}");
                Image::make($image)->fit(400, 240)->save($path . "/400-240/{$fullname}");
                Image::make($image)->fit(303, 182)->save($path . "/303-182/{$fullname}");
                Image::make($image)->fit(1218, 609)->save($path . "/1218-609/{$fullname}");

                ImageOptimizer::optimize($path . "/604-356/{$fullname}");
                ImageOptimizer::optimize($path . "/98-98/{$fullname}");
                ImageOptimizer::optimize($path . "/400-240/{$fullname}");
                ImageOptimizer::optimize($path . "/1218-609/{$fullname}");

                exec("cwebp -q 70 " . $path . "/604-356/{$fullname}" . " -o " . $path . "/604-356/{$fullname}.webp");
                exec("cwebp -q 70 " . $path . "/98-98/{$fullname}" . " -o " . $path . "/98-98/{$fullname}.webp");
                exec("cwebp -q 70 " . $path . "/400-240/{$fullname}" . " -o " . $path . "/400-240/{$fullname}.webp");
                exec("cwebp -q 70 " . $path . "/303-182/{$fullname}" . " -o " . $path . "/303-182/{$fullname}.webp");
                exec("cwebp -q 70 " . $path . "/1218-609/{$fullname}" . " -o " . $path . "/1218-609/{$fullname}.webp");
            }
        }

        preg_match_all('/<img[^>]+src=".*\/storage\/uploads\/post([^"]+)/', $request->body, $matches);
        $images = $matches[1];

        foreach ($images as $image) {
            if (Storage::exists('public/uploads/post' . $image)) {
                $path = storage_path('app/public/uploads/post') . $image;

                ImageOptimizer::optimize($path);

                exec("cwebp -q 70 " . $path . " -o " . $path . ".webp");
            }
        }

        $review->update([
            'title'     => $request->title,
            'seo_title' => $request->seo_title ? $request->seo_title  : $request->title,
            'summary'   => $request->summary,
            'body'      => $request->body,
            'slug'      => $slug,
            'img'       => $fullname ?? $review->img
        ]);

        $review->categories()->detach($review->categories);

        $categories = $request->categories;

        foreach ($categories as $category) {
            $category = Category::find($category);
            $category->allReviews()->attach($review);
        }

        $review->tags->tags = $request->tags;
        $review->tags->save();

        return redirect()->route('review.edit', $review->fresh()->slug);
    }

    public function showInactive(Review $review)
    {
        $excludes = collect([]);
        if (isset($review->tags->tags)) {
            $search = str_replace(',', ' ', $review->tags->tags);
            $reviewtags = explode(',', $review->tags->tags);
            $relateds = Review::search($search)->get();
            foreach ($relateds as $key => $related) {
                if ($related->title == $review->title) {
                    $relateds->forget($key);
                    break;
                }
            }
            return view('old.review.show', compact(['review', 'relateds', 'reviewtags', 'excludes']));
        }

        return view('old.review.show', compact(['review', 'excludes']));
    }

    public function add_note(Review $review, Request $request)
    {
        $request->validate([
            'note' => 'required|string|min:3|max:255'
        ]);

        Note::create([
            'notable_type' => 'App\\Models\\Review',
            'notable_id' => $review->id,
            'body' => $request->note
        ]);
        
        return back();
    }
}
