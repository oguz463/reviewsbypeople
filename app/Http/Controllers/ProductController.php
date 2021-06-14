<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Product;
use App\Models\Review;
use App\Models\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['author', 'review', 'categories'])->whereNotNull('published_at')->orderByDesc('created_at')->paginate(5);
        return view('product.index', compact('products'));
    }

    public function create()
    {
        $allReviews = Review::orderBy('id', 'desc')->get(['id', 'title']);
        $allPosts = Post::orderBy('id', 'desc')->get(['id', 'title']);
        return view('old.product.create', compact('allReviews', 'allPosts'));
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
          'review' => 'nullable|exists:reviews,id',
          'title' => 'required|string|min:10|max:255|unique:products',
          'summary' => 'required|string|min:10|max:255',
          'body'  => 'required|min:10',
          'slug'  => 'alpha_dash|nullable',
          'seo_title' => 'nullable|string|min:10|max:255',
          'url' => 'required|url',
          'image' => 'required|image|mimes:jpeg,png,jpg|max:1024'
        ]);

        $slug = $request->slug ? str_slug($request->slug, '-') : str_slug($request->title, '-');

        $image = $request->file('image');
        $extension = $image->extension();
        $fullname = "{$slug}.{$extension}";

        $path = storage_path('app/public/uploads') . "/products/{$fullname}";

        Image::make($image)->fit(400, 400)->save($path);

        ImageOptimizer::optimize($path);

        exec("cwebp -q 70 " . $path . " -o " . $path . ".webp");

        preg_match_all('/<img[^>]+src=".*\/storage\/uploads\/post([^"]+)/', $request->body, $matches);
        $images = $matches[1];

        foreach ($images as $image) {
            if (Storage::exists('public/uploads/post' . $image)) {
                $path = storage_path('app/public/uploads/post') . $image;

                ImageOptimizer::optimize($path);

                exec("cwebp -q 70 " . $path . " -o " . $path . ".webp");
            }
        }


        Product::create([
          'user_id' => auth()->id(),
          'review_id' => $request->review,
          'title' => $request->title,
          'seo_title' => $request->seo_title ? $request->seo_title : $request->title,
          'slug' => $slug,
          'summary' => $request->summary,
          'body' => $request->body,
          'url' => $request->url,
          'img' => $fullname
        ]);

        return redirect()->route('home');
    }

    public function show($review, Product $product)
    {
        if ($review <> $product->review->slug) {
            abort(404);
        }
        if ($product->published_at) {
            $relateds = Product::search(str_replace('-', ' ', $product->slug))->take(5)
            ->query(function ($query) {
                $query->select(['id', 'title', 'seo_title', 'slug', 'img']);
            })->get();

            foreach ($relateds as $key => $related) {
                if ($related->title === $product->title) {
                    $relateds->forget($key);
                    break;
                }
            }

            $productTags = $product->tags ? explode(',', $product->tags->tags) : [];
            $amazon = $product->url["amazon"];
            return view('product.show', compact('product', 'relateds', 'productTags', 'amazon'));
        } else {
            abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $allReviews = Review::orderBy('id', 'desc')->get();
        return view('old.product.edit', compact('product', 'allReviews'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'review' => 'nullable|exists:reviews,id',
            'title' => 'required|string|min:10|max:255',
            'summary' => 'required|string|min:10|max:255',
            'body'  => 'required|min:10',
            'slug'  => 'alpha_dash|required',
            'seo_title' => 'required|string|min:10|max:255',
            'url' => 'required|url',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:1024'
        ]);

        if ($product->slug <> $request->slug) {
            $redirect = new Redirect;
            $redirect->old_url = '/product' . '/' . $product->slug;
            $redirect->new_url = '/product' . '/' . $request->slug;
            $redirect->save();
        }

        if ($request->hasFile('image')) {
            if ($request->file('image')->isValid()) {
                $image = $request->file('image');
                $extension = $image->extension();
                $slug = $request->slug;
                $fullname = "{$slug}.{$extension}";
                Storage::delete('public/uploads/products/' . $product->img);

                $path = storage_path('app/public/uploads') . "/products/{$fullname}";

                Image::make($image)->fit(400, 400)->save($path);

                ImageOptimizer::optimize($path);

                exec("cwebp -q 70 " . $path . " -o " . $path . ".webp");
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


        $product->update([
            'review_id' => $request->review ?? $product->review_id,
            'title' => $request->title,
            'seo_title' => $request->seo_title ? $request->seo_title : $request->title,
            'slug' => $request->slug ?? $product->slug,
            'summary' => $request->summary,
            'body' => $request->body,
            'url' => $request->url,
            'img' => $fullname ?? $product->img
        ]);

        return redirect()->route('product.edit', $product->slug);
    }

    public function showInactive(Product $product)
    {
        return view('product.show', compact('product'));
    }
}
