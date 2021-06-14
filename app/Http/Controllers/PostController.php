<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['author:id,name', 'categories:name,slug,color'])->whereNotNull('published_at')->orderBy('created_at', 'desc')->paginate(5);
        return view('post.index', compact('posts'));
    }

    public function create()
    {
        return view('old.post.create');
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
          'title' => 'required|string|min:10|max:255|unique:posts',
          'summary' => 'required|string|min:10|max:255',
          'body'  => 'required|min:10',
          'slug'  => 'alpha_dash|nullable',
          'seo_title' => 'nullable|string|min:10|max:255',
          'image' => 'required|image|mimes:jpeg,png,jpg|max:1024'
        ]);

        $slug = $request->slug ? str_slug($request->slug, '-') : str_slug($request->title, '-');

        $image = $request->file('image');
        $extension = $image->extension();
        $fullname = "{$slug}.{$extension}";

        $bigPicturePath = storage_path('app/public/uploads') . "/blog/{$fullname}";
        $smallPicturePath = storage_path('app/public/uploads') . "/blog/98-98/{$fullname}";

        Image::make($image)->fit(1218, 609)->save($bigPicturePath);
        Image::make($image)->fit(98, 98)->save($smallPicturePath);

        ImageOptimizer::optimize($bigPicturePath);
        ImageOptimizer::optimize($smallPicturePath);

        exec("cwebp -q 70 " . $bigPicturePath . " -o " . $bigPicturePath . ".webp");
        exec("cwebp -q 70 " . $smallPicturePath . " -o " . $smallPicturePath . ".webp");

        preg_match_all('/<img[^>]+src=".*\/storage\/uploads\/post([^"]+)/', $request->body, $matches);
        $images = $matches[1];

        foreach ($images as $image) {
            if (Storage::exists('public/uploads/post' . $image)) {
                $path = storage_path('app/public/uploads/post') . $image;

                ImageOptimizer::optimize($path);

                exec("cwebp -q 70 " . $path . " -o " . $path . ".webp");
            }
        }


        Post::create([
          'user_id' => auth()->id(),
          'title' => $request->title,
          'seo_title' => $request->seo_title ? $request->seo_title : $request->title,
          'slug' => $slug,
          'summary' => $request->summary,
          'body' => $request->body,
          'img' => $fullname
        ]);

        return redirect()->route('home');
    }

    public function show(Post $post)
    {
        if ($post->published_at !== null) {
            $relateds = Post::search(str_replace('-', ' ', $post->slug))->take(5)
            ->query(function ($query) {
                $query->select(['id', 'title', 'seo_title', 'slug', 'img']);
            })->get();

            foreach ($relateds as $key => $related) {
                if ($related->title === $post->title) {
                    $relateds->forget($key);
                    break;
                }
            }

            $postTags = $post->tags ? explode(',', $post->tags->tags) : [];

            return view('post.show', compact('post', 'relateds', 'postTags'));
        } else {
            abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('old.post.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
        'title' => 'required|string|min:10|max:255',
        'summary' => 'required|string|min:10|max:255',
        'body'  => 'required|min:10',
        'slug'  => 'alpha_dash|required',
        'seo_title' => 'required|string|min:10|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg|max:1024'
      ]);

        if ($post->slug <> $request->slug) {
            $redirect = new Redirect;
            $redirect->old_url = "/post/{$post->slug}";
            $redirect->new_url = "/post/{$request->slug}";
            $redirect->save();
        }

        if ($request->hasFile('image')) {
            if ($request->file('image')->isValid()) {
                $image = $request->file('image');
                $extension = $image->extension();
                $slug = $request->slug;
                $fullname = "{$slug}.{$extension}";
                Storage::delete('public/uploads/blog/' . $post->img);
                Storage::delete('public/uploads/blog/98-98/' . $post->img);

                $bigPicturePath = storage_path('app/public/uploads') . "/blog/{$fullname}";
                $smallPicturePath = storage_path('app/public/uploads') . "/blog/98-98/{$fullname}";

                Image::make($image)->fit(1218, 609)->save($bigPicturePath);
                Image::make($image)->fit(98, 98)->save($smallPicturePath);

                ImageOptimizer::optimize($bigPicturePath);
                ImageOptimizer::optimize($smallPicturePath);

                exec("cwebp -q 70 " . $bigPicturePath . " -o " . $bigPicturePath . ".webp");
                exec("cwebp -q 70 " . $smallPicturePath . " -o " . $smallPicturePath . ".webp");
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

        $post->update([
        'title' => $request->title,
        'seo_title' => $request->seo_title ? $request->seo_title : $request->title,
        'slug' => $request->slug ?? $post->slug,
        'summary' => $request->summary,
        'body' => $request->body,
        'img' => $fullname ?? $post->img
      ]);

        return redirect()->route('post.edit', $post->slug);
    }

    public function showInactive(Post $post)
    {
        return view('post.show', compact('post'));
    }
}
