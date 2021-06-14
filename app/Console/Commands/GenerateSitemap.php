<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Review;
use App\Models\Product;
use App\Models\Post;
use App\Models\Category;

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
        ->add(Url::create('/about'))
        ->add(Url::create('/contact'))
        ->add(Url::create('/privacy'))
        ->add(Url::create('/cookies-policy'))
        ->add(Url::create('/term-of-services'));

        Category::all()->each(function (Category $category) use ($sitemap) {
            $sitemap->add(Url::create("/category/{$category->slug}"));
        });

        Review::whereNotNull('published_at')->get()->each(function (Review $review) use ($sitemap) {
            $sitemap->add(Url::create("/{$review->slug}"));
        });

        Product::whereNotNull('published_at')->get()->each(function (Product $product) use ($sitemap) {
            if ($product->review) {
                $sitemap->add(Url::create("/{$product->review->slug}/{$product->slug}"));
            } else {
                $sitemap->add(Url::create("/product/{$post->slug}"));
            }
        });

        Post::whereNotNull('published_at')->get()->each(function (Post $post) use ($sitemap) {
            $sitemap->add(Url::create("/post/{$post->slug}"));
        });

        $sitemap->writeToFile(public_path('sitemap.xml'));
    }
}
