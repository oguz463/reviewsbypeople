<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Contact;
use App\Models\Feature;
use App\Models\Note;
use App\Models\Post;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('components.header', function ($view) {
            $view->with('categories', Category::whereNull('parent_id')->get(['id', 'name', 'slug']));
        });

        View::composer('old.layouts.partials.navbar', function ($view) {
            $view->with('categories', Category::whereNull('parent_id')->get(['id', 'name', 'slug']));
        });

        View::composer('old.admin.index', function ($view) {
            $view->with('reviewsCount', Review::whereNotNull('published_at')->count());
            $view->with('productsCount', Product::whereNotNull('published_at')->count());
            $view->with('postsCount', Post::whereNotNull('published_at')->count());

            $view->with('submittedReviewsCount', Review::whereNull('published_at')->count());
            $view->with('submittedProductsCount', Product::whereNull('published_at')->count());
            $view->with('submittedPostsCount', Post::whereNull('published_at')->count());

            $view->with('commentsCount', Comment::whereNull('published_at')->count());
            $view->with('usersCount', User::count());
            $view->with('notesCount', Note::whereNull('fixed_at')->count());
        });

        View::composer('old.admin.includes.allreviews', function ($view) {
            $view->with('reviews', Review::with(['author', 'categories'])->orderByDesc('id')->whereNotNull('published_at')->paginate(10));
        });

        View::composer('old.admin.includes.allproducts', function ($view) {
            $view->with('products', Product::with(['review', 'author'])->orderByDesc('id')->whereNotNull('published_at')->paginate(10));
        });

        View::composer('old.admin.includes.allposts', function ($view) {
            $view->with('posts', Post::with('author')->orderByDesc('id')->whereNotNull('published_at')->paginate(10));
        });

        View::composer('old.admin.includes.featured', function ($view) {
            $view->with('featureds', Feature::with('featurable')->where('is_featured', 1)->get());
            $view->with('picks', Feature::with(['featurable' => function ($query) {
                return $query->with(['author', 'categories']);
            }])->where('is_picked', 1)->get());
            $view->with('lists', Feature::with(['featurable' => function ($query) {
                return $query->with(['author', 'categories']);
            }])->get());
            $view->with('reviews', Review::doesnthave('feature')->with(['author', 'categories'])->orderBy('id', 'desc')->whereNotNull('published_at')->paginate(10));
        });

        View::composer('old.admin.includes.submittedReviews', function ($view) {
            $view->with('reviews', Review::with(['author', 'categories'])->whereNull('published_at')->orderBy('id', 'desc')->paginate(5));
        });

        View::composer('old.admin.includes.submittedProducts', function ($view) {
            $view->with('products', Product::with(['review', 'author'])->whereNull('published_at')->orderBy('id', 'desc')->paginate(5));
        });

        View::composer('old.admin.includes.submittedPosts', function ($view) {
            $view->with('posts', Post::with('author')->whereNull('published_at')->orderBy('id', 'desc')->paginate(5));
        });

        View::composer('old.admin.includes.notes', function ($view) {
            $view->with('reviews', Review::with('notes')->whereNotNull('published_at')->get());
            $view->with('products', Product::with('notes')->whereNotNull('published_at')->get());
            $view->with('posts', Post::with('notes')->whereNotNull('published_at')->get());
        });

        View::composer('old.admin.includes.category', function ($view) {
            $view->with('categories', Category::with('childrens')->get());
            $view->with('cats', Category::with('childrens')->whereNull('parent_id')->orderBy('id')->paginate(2));
        });

        View::composer('old.admin.includes.message', function ($view) {
            $view->with('messages', Contact::orderBy('id', 'desc')->paginate(4));
        });

        View::composer('old.admin.includes.users', function ($view) {
            $view->with('admins', User::where('user_type', 'admin')->get());
            $view->with('authors', User::where('user_type', 'author')->get());
            $view->with('users', User::where('user_type', 'user')->paginate(10));
        });

        View::composer('old.admin.includes.comments', function ($view) {
            $view->with('comments', Comment::whereNull('published_at')->with('commentable')->paginate(10));
        });

        View::composer('old.admin.includes.links', function ($view) {
            $reviews = Review::with('amazon')->whereNotNull('published_at')->get(['id', 'title', 'slug']);
            foreach ($reviews as $review) {
                if (isset($review->amazon->data["Errors"])) {
                    foreach ($review->amazon->data["Errors"] as $error) {
                        $data[$review->slug]["errors"][] = $error["Message"];
                    }
                }

                if (isset($review->amazon->data["ItemsResult"]["Items"])) {
                    foreach ($review->amazon->data["ItemsResult"]["Items"] as $item) {
                        if (!isset($item["Offers"]) && isset($item["ItemInfo"]["Title"]["DisplayValue"])) {
                            $data[$review->slug]["errors"][] = "The ItemId " . $item["ASIN"] . " (" . mb_strimwidth($item["ItemInfo"]["Title"]["DisplayValue"], 0, 30, "...") . ") "  . "is currently not available.";
                        }
                    }
                }

                if (isset($data[$review->slug]["errors"])) {
                    $data[$review->slug]["title"] = $review->title;
                }
            }

            $view->with('data', array_reverse($data));
        });
    }
}
