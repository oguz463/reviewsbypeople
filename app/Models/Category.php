<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($category) {
            $category->allReviews->each->delete();
            $category->allProducts->each->delete();
            $category->allPosts->each->delete();
        });
    }

    public function childrens()
    {
        return $this->hasMany(static::class, 'parent_id');
    }

    public function childrensRecursive()
    {
        return $this->childrens()->with('childrenRecursive');
    }

    public function parent()
    {
        return $this->belongsTo(static::class, 'parent_id');
    }

    public function parentRecursive()
    {
        return $this->parent()->with('parentRecursive');
    }

    public function allReviews()
    {
        return $this->morphedByMany(Review::class, 'categorizable');
    }

    public function reviews()
    {
        return $this->allReviews()->whereNotNull('published_at')->with('author:id,name');
    }

    public function allProducts()
    {
        return $this->morphedByMany(Product::class, 'categorizable');
    }

    public function products()
    {
        return $this->allProducts()->whereNotNull('published_at');
    }

    public function allPosts()
    {
        return $this->morphedByMany(Post::class, 'categorizable');
    }

    public function posts()
    {
        return $this->allPosts()->whereNotNull('published_at');
    }

    public function path()
    {
        return url('category', $this->slug);
    }
}
