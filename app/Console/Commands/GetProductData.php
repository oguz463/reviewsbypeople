<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Review;
use App\Models\Asin;
use Revolution\Amazon\ProductAdvertising\Facades\AmazonProduct;

class GetProductData extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'product:api';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get products info.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $reviews = Review::all();
        foreach ($reviews as $review) {
            $matches = false;
            preg_match_all('/(?<=\/dp\/)[^\/|\?|\"\']+/', $review->body, $matches);
            if (!empty(current($matches))) {
                $asins = array_unique(current($matches));
            }
            foreach ($asins as $asin) {
                $productAsins[] = $asin;
            }
            $chunk = array_chunk($productAsins, 10);
            $productAsins = false;
            foreach ($chunk as $asins) {
                $data[] = AmazonProduct::items($asins);
            }
            $productsData = array_merge_recursive(...$data);
            $data = false;
            $review->save();
            Asin::updateOrCreate(
                [
            'data_id' => $review->id,
            'data_type' => 'App\Review'
          ],
                [
            'data' => $productsData
          ]
            );
            sleep(1);
        }
    }
}
