<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\User;
use Creativeorange\Gravatar\Facades\Gravatar;

class CommentController extends Controller
{
    public function store($type, $type_id, Request $request)
    {
        $model = 'App\\Models\\' . ucfirst($type);
        if (class_exists($model) && $modelRecord = $model::find($type_id)) {
            if ($modelRecord->comments === null) {
                abort(403);
            }
            if ($parentId = $request->parentId) {
                $request->validate([
                    'parentId' => 'required|numeric|exists:comments,id'
                ]);

                $parent = Comment::find($parentId);
                if ($parent->parent && $parent->commentable_type !== $model && $parent->commentable_id !== $modelRecord->id) {
                    abort(403);
                }
            } else {
                $parentId = null;
            }

            if (!$request->has('name') && !$request->has('email')) {
                $request->merge([
                    'name' => auth()->check() ? auth()->user()->name : null,
                    'email' => auth()->check() ? auth()->user()->email : null
                ]);
            }

            $request->validate([
                'name' => 'required|alpha_spaces|min:2|max:255',
                'email' => 'required|email|max:255',
                'comment' => 'required|string|min:6|max:1000|url_not_allowed'
            ]);

            if ($user = auth()->check() ? auth()->user() : User::where('email', $request->email)->first()) {
                $avatar = $user->meta["img"] ?? asset('images/no-avatar.jpg');
            } elseif (Gravatar::exists($request->email)) {
                $avatar = Gravatar::get($request->email);
            } else {
                $avatar = asset('images/no-avatar.jpg');
            }

            Comment::create([
                'commentable_type' => $model,
                'commentable_id' => $modelRecord->id,
                'author' => $request->name,
                'email' => $request->email,
                'avatar' => $avatar,
                'parent_id' => $parentId,
                'body' => $request->comment
            ]);

            return back();
        } else {
            abort(403);
        }
    }
}
