<?php

namespace App\Models;

/**
 * This trait created for every post types(Review, Product, Post etc.) that share the same logic.
 */
trait CommonRelations
{
    /**
     * Boot the trait.
     */
    protected static function bootCommonRelations(): void
    {
        static::deleting(function ($model) {
            $model->categories()->delete();
            $model->feature()->delete();
            $model->tags()->delete();
            $model->allComments()->delete();
            $model->allNotes()->delete();
            $model->amazon()->delete();
        });
    }

    /**
     * To use eager load ability with Laravel Scout Driver for search results
     * Check for the macro in AppServiceProvider
     *
     * @param array $with
     */
    public function withRelations(array $with)
    {
        $this->with = $with;

        return $this;
    }

    /**
     * Get the author of the post
     *
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the categories of the post
     *
     */

    public function categories()
    {
        return $this->morphToMany(Category::class, 'categorizable');
    }

    /**
     * Get the data of the post if it is picked or featured
     *
     */
    public function feature()
    {
        return $this->morphOne(Feature::class, 'featurable');
    }

    /**
     * Get the tags of the post
     *
     */
    public function tags()
    {
        return $this->morphOne(Tag::class, 'taggable');
    }

    /**
     * Get comments of the post
     *
     */
    public function allComments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
    /**
     * Get only comments which are parent and active then load the childs relationship of the post
     *
     */
    public function comments()
    {
        return $this->allComments()->whereNotNull('published_at')->whereNull('parent_id')->orderBy('created_at')->with(['replies' => function ($query) {
            $query->whereNotNull('published_at')->orderBy('created_at');
        }]);
    }

    /**
     * Get the notes of the post
     *
     */
    public function allNotes()
    {
        return $this->morphMany(Note::class, 'notable');
    }

    /**
     * Get the notes of the post which are not fixed
     *
     */
    public function notes()
    {
        return $this->allNotes()->whereNull('fixed_at');
    }

    /**
     * Get the data from Amazon API for the post
     *
     */
    public function amazon()
    {
        return $this->morphOne(Asin::class, 'data');
    }
}
