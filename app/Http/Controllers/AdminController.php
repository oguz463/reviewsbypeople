<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Review;
use App\Models\Product;
use App\Models\Post;
use App\Models\Feature;
use App\Models\Category;
use App\Models\Note;
use App\Models\Comment;

class AdminController extends Controller
{
    public function index()
    {
        return view('old.admin.index');
    }

    public function review_submit(Review $review)
    {
        $review->update([
            'published_at' => now()
        ]);

        return back();
    }

    public function product_submit(Product $product)
    {
        $product->update([
            'published_at' => now()
        ]);

        return back();
    }

    public function post_submit(Post $post)
    {
        $post->update([
            'published_at' => now()
        ]);

        return back();
    }

    public function review_deactive(Review $review)
    {
        $review->update([
            'published_at' => null
        ]);

        $review->feature()->delete();
        $review->amazon()->delete();

        return back();
    }

    public function product_deactive(Product $product)
    {
        $product->update([
            'published_at' => null
        ]);
        
        $product->feature()->delete();
        $product->amazon()->delete();

        return back();
    }

    public function post_deactive(Post $post)
    {
        $post->update([
            'published_at' => null
        ]);

        $post->feature()->delete();
        $post->amazon()->delete();

        return back();
    }

    public function comment_submit(Comment $comment)
    {
        $comment->update([
            'published_at' => now()
        ]);

        return back();
    }

    public function featured_change($type, $type_id)
    {
        $model = 'App\\Models\\' . ucfirst($type);
        if (class_exists($model) && $modelRecord = $model::find($type_id)) {
            if (!(bool) $record = $modelRecord->feature) {
                return abort(403);
            }
            
            $record->is_featured = !$record->is_featured;
            $record->save();
    
            return back();
        }

        abort(403);
    }

    public function pick_change($type, $type_id)
    {
        $model = 'App\\Models\\' . ucfirst($type);
        if (class_exists($model) && $modelRecord = $model::find($type_id)) {
            if (!(bool) $record = $modelRecord->feature) {
                return abort(403);
            }
            
            $record->is_picked = !$record->is_picked;
            $record->save();
    
            return back();
        }

        abort(403);
    }

    /**
     * Add a new Category or Edit existing category.
     * Request->edit value == 0 add a new Category
     * Request->edit value == Category->id edit Category
     * @return \Illuminate\Http\Response
     */
    public function edit_category(Request $request)
    {
        $request->validate([
        'edit' => 'required|numeric'
      ]);

        if ($request->edit == 0) { // adding a new category starts here
            $request->validate([
              'parent' => 'required|numeric',
              'name'   => 'required|string',
              'color'  => 'required|string',
              'slug'   => 'alpha_dash|nullable'
            ]);

            Category::create([
              'name'  => $request->name,
              'slug'  => $request->slug ? $request->slug : str_slug($request->name . '-'),
              'color' => $request->color,
              'parent_id' => $request->parent
            ]);

            return back();
        } // adding ends

        else {  //Editing starts here

            $request->validate([
              'parent' => 'required|numeric|different:edit',
              'name'   => 'required|string',
              'color'  => 'required|string',
              'slug'   => 'alpha_dash|nullable'
            ]);

            $category = Category::find($request->edit);
            if ($category->parent_id ==! $request->parent) { //if any changes in parent/sub relations

                if ($category->parent_id === 0) { //if category becomes a sub
                    Category::find($request->parent)->allReviews()->attach($category->allReviews);
                    foreach ($category->alt as $alt) {
                        $category->allReviews()->detach($alt->allReviews);
                        $alt->update(['parent_id' => $request->parent]);
                    }
                } else { //if category becomes a parent
                    $category->parent->allReviews()->detach($category->allReviews);
                }
                $category->update([
                    'name'  => $request->name,
                    'slug'  => $request->slug ? $request->slug : str_slug($request->name . '-'),
                    'color' => $request->color,
                    'parent_id' => $request->parent
                  ]);
            } //if any changes in parent/sub relations ends here

            else { // if no changes in parent/sub relation
                $category->update([
                'name'  => $request->name,
                'slug'  => $request->slug ? $request->slug : str_slug($request->name . '-'),
                'color' => $request->color,
                'parent_id' => $request->parent
              ]);
            } // if no changes in parent/sub relation ends here
        } //editing ends here

        return back();
    }

    public function make_author(User $user)
    {
        $user->update([
            'user_type' => 'author'
        ]);

        return back();
    }

    public function make_user(User $user)
    {
        $user->update([
            'user_type' => 'user'
        ]);

        return back();
    }

    public function featured_add($type, $type_id)
    {
        $model = 'App\\Models\\' . ucfirst($type);
        if (class_exists($model) && $model::find($type_id)) {
            if ($model::find($type_id)->feature) {
                return abort(403);
            }
            
            Feature::create([
                'featurable_type' => $model,
                'featurable_id' => $type_id
            ]);

            return back();
        }

        abort(403);
    }

    public function all_notes(Review $review)
    {
        foreach ($review->notes as $note) {
            $note->update([
                'fixed_at' => now()
            ]);
        }

        return back();
    }

    public function set_note(Note $id)
    {
        $id->update([
                'fixed_at' => now()
            ]);
        
        return back();
    }

    public function review_delete(Review $review)
    {
        $review->delete();

        return back();
    }

    public function product_delete(Product $product)
    {
        $product->delete();

        return back();
    }

    public function post_delete(Post $post)
    {
        $post->delete();

        return back();
    }

    public function comment_delete(Comment $comment)
    {
        if ($comment->replies) {
            $comment->replies->each->delete();
        }

        $comment->delete();

        return back();
    }

    public function featured_delete($type, $type_id)
    {
        $model = 'App\\Models\\' . ucfirst($type);
        if (class_exists($model) && $record = $model::find($type_id)) {
            if ($record->feature) {
                $record->feature->delete();
                
                return back();
            }

            abort(403);
        }

        abort(403);
    }

    public function category_delete(Category $category)
    {
        $category->delete();
        return back();
    }
}
