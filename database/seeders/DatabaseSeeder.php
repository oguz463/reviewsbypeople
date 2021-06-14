<?php

namespace Database\Seeders;

use App\Models\Asin;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Contact;
use App\Models\Note;
use App\Models\Post;
use App\Models\Product;
use App\Models\Review;
use App\Models\Tag;
use App\Models\User;
use Artisan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Artisan::call('scout:flush "App\\\\Models\\\\Review"');
        Artisan::call('scout:flush "App\\\\Models\\\\Product"');
        Artisan::call('scout:flush "App\\\\Models\\\\Post"');
        $category = new Category;
        $category->setConnection('mysql2');

        $categoryNew = new Category;

        $category->get()->each(function ($category) use (&$categoryNew) {
            $new = $categoryNew->make($category->toArray());
            if ($new->parent_id === 0) {
                $new->parent_id = null;
                $new->save();
            }
        });

        $contact = new Contact;
        $contact->setConnection('mysql2');

        $contactNew = new Contact;

        $contact->get()->each(function ($contact) use (&$contactNew) {
            $contactNew->create($contact->toArray());
        });


        $user = new User();
        $user->setConnection('mysql2');

        $userNew = new User;

        $user->get()->each(function ($user) use (&$userNew) {
            $userNew->create([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'password' => $user->password,
                'meta' => $user->meta,
                'user_type' => 'admin',
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
            ]);
        });

        $review = new Review;
        $review->setConnection('mysql2');

        $reviewNew = new Review;

        $review->get()->each(function ($review) use (&$reviewNew) {
            $reviewNew->create([
                'id' => $review->id,
                'user_id' => $review->user_id,
                'title' => $review->title,
                'seo_title' => $review->seo_title,
                'slug' => $review->slug,
                'summary' => $review->summary,
                'body' => $review->body,
                'img' => $review->img,
                'created_at' => $review->created_at,
                'updated_at' => $review->updated_at,
                'published_at' => $review->is_active ? $review->created_at: null
            ]);
        });

        $products = DB::connection('mysql2')->table('products')->get();

        foreach ($products as $product) {
            Product::create([
                'id' => $product->id,
                'user_id' => $product->user_id,
                'review_id' => $product->review_id,
                'title' => $product->title,
                'seo_title' => $product->seo_title,
                'slug' => $product->slug,
                'summary' => $product->summary,
                'body' => $product->body,
                'img' => $product->img,
                'url' => ['amazon' => $product->url],
                'created_at' => $product->created_at,
                'updated_at' => $product->updated_at,
                'published_at' => $product->is_active ? $product->created_at: null
            ]);
        }

        $post = new Post;
        $post->setConnection('mysql2');

        $postNew = new Post;

        $post->get()->each(function ($post) use (&$postNew) {
            $postNew->create([
                'id' => $post->id,
                'user_id' => $post->user_id,
                'title' => $post->title,
                'seo_title' => $post->seo_title,
                'slug' => $post->slug,
                'summary' => $post->summary,
                'body' => $post->body,
                'img' => $post->img,
                'created_at' => $post->created_at,
                'updated_at' => $post->updated_at,
                'published_at' => $post->is_active ? $post->created_at: null
            ]);
        });

        $comment = new Comment;
        $comment->setConnection('mysql2');

        $commentNew = new Comment;

        $comment->get()->each(function ($comment) use (&$commentNew) {
            $commentNew->create([
                'id' => $comment->id,
                'commentable_type' => Review::class,
                'commentable_id' => $comment->review_id,
                'author' => $comment->name,
                'email' => $comment->email,
                'avatar' => $comment->avatar,
                'parent_id' => $comment->parent_id === 0 ? null : $comment->parent_id,
                'body' => $comment->body,
                'created_at' => $comment->created_at,
                'updated_at' => $comment->updated_at,
                'published_at' => $comment->is_active ? $comment->created_at: null
            ]);
        });

        $categoryRelation = DB::connection('mysql2')->table('reviews_categories')->get();
        
        foreach ($categoryRelation as $relation) {
            DB::table('categorizables')->insert([
                'categorizable_type' => Review::class,
                'categorizable_id' => $relation->review_id,
                'category_id' => $relation->category_id
            ]);
        }
        
        $redirects = DB::connection('mysql2')->table('redirects')->get();
        
        foreach ($redirects as $relation) {
            DB::table('redirects')->insert([
                'old_url' => $relation->old_url,
                'new_url' => $relation->new_url
            ]);
        }

        $features = DB::connection('mysql2')->table('featureds')->get();
        
        foreach ($features as $relation) {
            DB::table('features')->insert([
                'featurable_type' => Review::class,
                'featurable_id' => $relation->review_id,
                'is_featured' => $relation->is_featured,
                'is_picked' => $relation->is_picked,
            ]);
        }

        $notes = new Note;
        $notes->setConnection('mysql2');

        $notesNew = new Note;

        $notes->get()->each(function ($note) use (&$notesNew) {
            $notesNew->create([
                'notable_type' => Review::class,
                'notable_id' => $note->review_id,
                'body' => $note->body,
                'created_at' => $note->created_at,
                'updated_at' => $note->updated_at,
                'fixed_at' => $note->is_done ? $note->updated_at: null,
            ]);
        });

        $tags = new Tag;
        $tags->setConnection('mysql2');

        $tagsNew = new Tag;

        $tags->get()->each(function ($tag) use (&$tagsNew) {
            $tagsNew->create([
                'taggable_type' => Review::class,
                'taggable_id' => $tag->review_id,
                'tags' => $tag->tags
            ]);
        });

        $asins = new Asin;
        $asins->setConnection('mysql2');

        $asinsNew = new Asin;

        $asins->get()->each(function ($asin) use (&$asinsNew) {
            $asinsNew->create([
                'id' => $asin->id,
                'data_type' => Review::class,
                'data_id' => $asin->data_id,
                'data' => $asin->data,
                'created_at' => $asin->created_at,
                'updated_at' => $asin->updated_at,
            ]);
        });
    }
}
