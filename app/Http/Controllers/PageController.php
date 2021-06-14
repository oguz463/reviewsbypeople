<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feature;
use App\Models\Review;
use App\Models\Post;
use App\Models\Contact;

class PageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $latests= Review::with('author:id,name')->limit(4)->whereNotNull('published_at')->orderByDesc('created_at')->get(['id', 'user_id', 'title', 'seo_title', 'slug', 'img', 'created_at']);

        $posts= Post::limit(5)->orderByDesc('created_at')->whereNotNull('published_at')->get(['id', 'title', 'seo_title','img', 'slug']);

        $features = Feature::with(['featurable' => function ($query) {
            return $query->select(['id', 'user_id', 'title', 'seo_title', 'slug', 'img', 'created_at'])->with('author:id,name');
        }])->where('featurable_type', Review::class)->get();
        
        $featureds = $features->where('is_featured', true)->values();
        $picks = $features->where('is_picked', true)->values();
        
        return view('home', compact('featureds', 'picks', 'latests', 'posts'));
    }

    public function privacy()
    {
        return view('privacy');
    }

    public function cookiespolicy()
    {
        return view('cookiespolicy');
    }

    public function tos()
    {
        return view('tos');
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }

    public function storeMessage(Request $request)
    {
        $request->validate([
        'name' => 'required|string|min:3|max:255',
        'email' => 'required|string|email|max:255',
        'subject' => 'required|string|min:6|max:255',
        'message' => 'required|string|min:10|max:1000',
        'g-recaptcha-response' => 'required|captcha'
      ]);

        Contact::create([
        'name' => $request->name,
        'email' => $request->email,
        'subject' => $request->subject,
        'message' => $request->message,
      ]);

        return redirect()->route('home');
    }

    public function feed()
    {
        // create new feed
        $feed = app()->make("feed");

        // multiple feeds are supported
        // if you are using caching you should set different cache keys for your feeds

        // cache the feed for 60 minutes (second parameter is optional)
        $feed->setCache(30);

        // check if there is cached feed and build new only if is not
        if (!$feed->isCached()) {
            // creating rss feed with our most recent 20 posts
            $posts = Review::where('is_active', true)->orderBy('created_at', 'desc')->take(20)->get();

            // set your feed's title, description, link, pubdate and language
            $feed->title = 'ReviewsByPeople.com';
            $feed->description = 'Latest Reviews on ReviewsByPeople.com';
            $feed->logo = 'https://www.reviewsbypeople.com/images/logo.png';
            $feed->link = url('feed');
            $feed->setDateFormat('datetime'); // 'datetime', 'timestamp' or 'carbon'
            $feed->pubdate = $posts[0]->created_at;
            $feed->lang = 'en';
            $feed->setShortening(true); // true or false
          $feed->setTextLimit(100); // maximum length of description text

          foreach ($posts as $post) {
              // set item's title, author, url, pubdate, description, content, enclosure (optional)*
              $enclosure = ['url'=> "https://www.reviewsbypeople.com/storage/uploads/1218-609/" . $post->img, 'type'=>'image/jpeg'];
              $content = $post->content["body"];
              $content = str_replace("&", "&amp;", $content);
              $content = preg_replace('/\sstyle="[^"]+"/', '', $content);
              $feed->add($post->title, $post->author->name, url($post->slug), $post->created_at->toRfc3339String(), $post->summary, $content, $enclosure);
          }
        }

        // first param is the feed format
        // optional: second param is cache duration (value of 0 turns off caching)
        // optional: you can set custom cache key with 3rd param as string
        $feed->ctype = "text/xml";
        return $feed->render('atom');

        // to return your feed as a string set second param to -1
       // $xml = $feed->render('atom', -1);
    }

    public function redirect()
    {
        $url = urldecode(request('l'));
        if ($url) {
            return redirect()->away($url);
        } else {
            return redirect()->to('/');
        }
    }
}
