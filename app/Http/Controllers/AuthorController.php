<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use Intervention\Image\ImageManagerStatic as Image;

class AuthorController extends Controller
{
    public function show(User $user)
    {
        $reviews = $user->reviews()->orderBy('id', 'desc')->paginate(5);
        return view('old.author.show', compact(['user', 'reviews']));
    }

    public function edit()
    {
        $user = auth()->user();
        $categories = Category::with('childrensRecursive:id,name,parent_id')->get(['id', 'name', 'parent_id']);
        return view('old.author.edit', compact(['user', 'categories']));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $request->validate([
          'name'        => 'required|string|max:255',
          'sum'         => 'string|max:500',
          'sample1'     => 'active_url|max:255|nullable',
          'sample2'     => 'active_url|max:255|nullable',
          'sample3'     => 'active_url|max:255|nullable',
          'categories'  => 'array',
          'facebook'    => 'active_url|max:255|nullable',
          'twitter'     => 'active_url|max:255|nullable',
          'youtube'     => 'active_url|max:255|nullable',
          'instagram'   => 'active_url|max:255|nullable'
        ]);


        $user->name = $request->name;

        $user["meta->sum"] = $request->sum;

        $user["meta->samples"] = [
          "sample1" => $request->sample1,
          "sample2" => $request->sample2,
          "sample3" => $request->sample3
        ];
        $user["meta->social"] = [
          "facebook"  =>  $request->facebook,
          "twitter"   =>  $request->twitter,
          "youtube"   =>  $request->youtube,
          "instagram" =>  $request->instagram
        ];
        $user["meta->categories"] = $request->categories;

        $user->save();

        return back();
    }

    public function avatar(Request $request)
    {
        $request->validate([
        'avatar' => 'required|image|max:1024|mimes:jpeg,png,jpg'
      ]);

        if ($request->hasfile('avatar')) {
            if ($request->file('avatar')->isValid()) {
                $image = $request->file('avatar');
                $fullname = str_slug(auth()->user()->name) . '.' . $image->extension();
                $path = asset('storage/uploads/avatars/' . $fullname);
                Image::make($image)->fit(100, 100)->save(storage_path('app/public/uploads/avatars/') . $fullname);
                $user = auth()->user();
                $user['meta->img'] = $path;
                $user->save();
            }
        }
        return back();
    }
}
