<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feature;
use App\Models\Review;
use App\Models\Post;
use App\Models\Contact;

class PageController extends Controller
{
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
