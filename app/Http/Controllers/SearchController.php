<?php

namespace App\Http\Controllers;

use App\Models\Review;

class SearchController extends Controller
{
    public function show()
    {
        if (request('query')) {
            request()->validate([
          'query' => 'required|string'
        ]);
            $query = preg_replace('/[^A-Za-z0-9\-\s]/', '', request('query'));
            $results = Review::search($query)->with(['author:id,name', 'categories:name,slug,color'])->paginate(3);
            return view('search', compact('results', 'query'));
        }
        return back();
    }
}
