<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use TOC\TocGenerator;

class Review extends Model
{
    use Searchable;
    use CommonRelations;

    public function toSearchableArray()
    {
        $array = [
           "id" => $this->id,
           "title" => $this->title,
           "summary" => $this->summary,
           "body" => $this->body
         ];

        return $array;
    }

    public function shouldBeSearchable()
    {
        return (bool) $this->published_at;
    }

    protected $guarded = [];

    public function getContentAttribute()
    {
        $body = $this->body;
        $amazon = $this->amazon;
        if (isset($amazon->data["Errors"])) {
            foreach ($amazon->data["Errors"] as $error) {
                preg_match('/(?<=The\sItemId\s)[^\s]+/', $error["Message"], $matches);
                $brokenAsins[] = current($matches);
            }
        }

        if (isset($amazon->data["ItemsResult"]["Items"])) {
            foreach ($amazon->data["ItemsResult"]["Items"] as $item) {
                if (!isset($item["Offers"])) {
                    $brokenAsins[] = $item["ASIN"];
                }
            }
        }

        $brokenAsins = $brokenAsins ?? [];

        foreach ($brokenAsins as $brokenAsin) {
            preg_match_all("/div[^>]+{$brokenAsin}.[^>]+/", $body, $matches);
            if (!empty($matches[0])) {
                $data = current(current($matches));
                preg_match_all("/[^\s]+(?=\=\")/", $data, $tags);
                preg_match_all("/(?<=\")[^\s][^\"]+/", $data, $values);
                $productData = array_combine($tags[0], $values[0]);
                $encode = urlencode($productData["data-title"]);
                $url = "https://www.amazon.com/s?k={$encode}&tag=anymode-20";
                $body = str_replace($productData["data-url"], $url, $body);
            } else { // product not in divs
                preg_match_all("/href=\"(.+(?={$brokenAsin})[^\"]+)[^>]+.([^<\/]+)/", $body, $matches);
                $find = $matches[1][0] ?? false;
                $encode = isset($matches[2][0]) ? urlencode($matches[2][0]) : false;
                if ($find && $encode) {
                    $replace = "https://www.amazon.com/s?k={$encode}&tag=anymode-20";
                    $body = str_replace($find, $replace, $body);
                }
            }
        }

        $tocMarkup = $body;


        preg_match_all('/(<[hH][1-6](?![^>]*class=\"[^\"]*noTOC[^\"]*\")[^>]*title=\"([^\"]*)\"[^>]*)>(.*)(<\/[hH][1-6])/', $tocMarkup, $matches);

        foreach ($matches[0] as $index => $find) {
            $tocMarkup = str_replace($find, $matches[1][$index] . " id=\"" . Str::slug($matches[3][$index]) . "\">" . $matches[2][$index] . $matches[4][$index], $tocMarkup);
        }

        preg_match_all('/(<[hH][1-6](?![^>]*class=\"[^"]*noTOC[^\"]*\"|[^>]*title=\"[^\"]*\")[^>]*)>(.*)(<\/[hH][1-6]>)/', $tocMarkup, $matches);

        foreach ($matches[0] as $index => $find) {
            $tocMarkup = str_replace($find, $matches[1][$index] . " id=\"" . Str::slug($matches[2][$index]) . "\">" . $matches[2][$index] . $matches[3][$index], $tocMarkup);
        }

        $tocGenerator = new TocGenerator();

        $toc = $tocGenerator->getHtmlMenu($tocMarkup);

        preg_match_all('/(<[hH][1-6](?![^>]*class=\"[^\"]*noTOC[^\"]*\")[^>]*)>(.*)(<\/[hH][1-6]>)/', $body, $matches);

        foreach ($matches[0] as $index => $find) {
            $body = str_replace($find, $matches[1][$index] . " id=\"" . Str::slug($matches[2][$index]) . "\">" . $matches[2][$index] . $matches[3][$index], $body);
        }

        // preg_match_all('/https:\/\/(www.amazon.com|amzn.to)[^"]+/', $body, $links);
        // foreach ($links[0] as $link) {
        //     $body = str_replace($link, "/redirect?l=" . urlencode($link), $body);
        // }

        $body = preg_replace(['/\>\s+/s', '/\s+</s', '/\n{2,8}/', '/\t/'], [">\n", "\n<", "\n", ""], $body);
        $toc = preg_replace(['/\n/', '/>\s*</'], ['', '> <'], $toc);

        preg_match_all('/<div[^\n]+data-url="([^"]+)[^\n]+.<h3[^\n]+data-tag="([^"]+)[^\n]+/s', $body, $findBestones);

        $body = str_replace('src="/storage/uploads', 'class="lazyload" width="400" height="400" data-src="/storage/uploads', $body);

        if (!empty($findBestones[2])) {
            foreach ($findBestones[0] as $key => $value) {
                preg_match_all('/data-title="([^"]+)[^\n]+.[^\n]+data-rank="([^"]+)[^>]+>([^\n]+)<\/h/s', $value, $title);
                if (!empty($value)) {
                    preg_match_all('/data-image="([^"]+).(jpe?g)[^\n]+/s', $value, $image);
                }
                if (isset($image[2][0])) {
                    $imgext = $image[2][0];
                    $image = explode("/", $image[1][0]);
                    $image = end($image);
                }

                $bestones[$findBestones[2][$key]]["jump"] = isset($title[3][0]) ? Str::slug($title[3][0]) : '';
                $bestones[$findBestones[2][$key]]["rank"] = $title[2][0] ?? '';
                $bestones[$findBestones[2][$key]]["title"] = $title[1][0] ?? '';
                $bestones[$findBestones[2][$key]]["url"] = $findBestones[1][$key];
                $bestones[$findBestones[2][$key]]["img"] = $image ?? '';
                $bestones[$findBestones[2][$key]]["img-ext"] = $imgext ?? '';
            }
        }

        $bestones = $bestones ?? [];
        ksort($bestones);

        $body = str_replace("\n", " ", $body);

        return ["bestones" => $bestones, "body" => $body, "toc" => $toc];
    }

    public function path()
    {
        return url($this->slug);
    }
}
