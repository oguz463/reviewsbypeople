<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Review;
use App\Models\Product;
use App\Models\Post;
use App\Models\Category;
use App\Models\User;

class GenerateSitemap extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $sitemap = Sitemap::create()
        ->add(Url::create('/'))
        ->add(Url::create('/reviews'))
        ->add(Url::create('/categories'))
        ->add(Url::create('/posts'))
        ->add(Url::create('/about'))
        ->add(Url::create('/privacy'))
        ->add(Url::create('/cookies-policy'))
        ->add(Url::create('/term-of-services'));

        Category::all()->each(function (Category $category) use ($sitemap) {
            $lastModified = $category->reviews()->max('reviews.updated_at');

            $url = Url::create("/category/{$category->slug}");

            if ($lastModified) {
                $url->setLastModificationDate(\Illuminate\Support\Carbon::parse($lastModified));
            }

            $sitemap->add($url);
        });

        User::whereHas('reviews')->get()->each(function (User $user) use ($sitemap) {
            $sitemap->add(Url::create("/author/{$user->id}"));
        });

        Review::whereNotNull('published_at')->get()->each(function (Review $review) use ($sitemap) {
            $url = Url::create("/{$review->slug}")
                ->setLastModificationDate($review->updated_at);

            if ($review->img) {
                $url->addImage(
                    asset("storage/uploads/1218-609/{$review->img}"),
                    $review->seo_title ?: $review->title
                );
            }

            $sitemap->add($url);
        });

        Product::whereNotNull('published_at')->with('review')->get()->each(function (Product $product) use ($sitemap) {
            if ($product->review && $product->review->published_at) {
                $sitemap->add(Url::create("/{$product->review->slug}/{$product->slug}"));
            }
        });

        Post::whereNotNull('published_at')->get()->each(function (Post $post) use ($sitemap) {
            $sitemap->add(
                Url::create("/post/{$post->slug}")
                    ->setLastModificationDate($post->updated_at)
            );
        });

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated with ' . count($sitemap->getTags()) . ' URLs.');
    }
}
