<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;
use TOC\TocGenerator;

class Product extends Model
{
    use Searchable, CommonRelations;
    
    protected $guarded = [];

    protected $casts = [
        'url' => 'array'
    ];

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

    public function getContentAttribute()
    {
        $body = $this->body;
        
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

        $body = preg_replace(['/\>\s+/s', '/\s+</s', '/\n{2,8}/', '/\t/'], [">\n", "\n<", "\n", ""], $body);
        $toc = preg_replace(['/\n/', '/>\s*</'], ['', '> <'], $toc);

        $body = str_replace("\n", " ", $body);

        return ["body" => $body, "toc" => $toc];
    }

    public function review()
    {
        return $this->belongsTo(Review::class);
    }

    public function path()
    {
        if ($this->review) {
            return url("/{$this->review->slug}/" . $this->slug);
        }
        return url('/product/' . $this->slug);
    }

    public function getImagePathAttribute()
    {
        return '/storage/uploads/products/' . $this->img;
    }
}
