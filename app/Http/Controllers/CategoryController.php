<?php

namespace App\Http\Controllers;

use App\Models\Category;
use DB;

class CategoryController extends Controller
{
    public function index()
    {
        $categoryIds = DB::table('categories')->whereNull('parent_id')->get(['id']);

        $sql = '';

        foreach ($categoryIds as $categoryId) {
            $sql .= "(SELECT categories.id as category_id,categories.name as category_name,categories.slug as category_slug,reviews.user_id as review_author,reviews.title as review_title,reviews.seo_title as review_seo_title,reviews.slug as review_slug,reviews.img as review_img,reviews.created_at as review_created_at,author.id as author_id,author.name as author_name FROM categorizables INNER JOIN categories ON categorizables.category_id=categories.id LEFT JOIN reviews INNER JOIN users author ON reviews.user_id=author.id ON categorizables.categorizable_id=reviews.id WHERE categorizables.category_id='{$categoryId->id}' AND categorizables.categorizable_type = 'App\\\\Models\\\\Review' AND categories.parent_id is NULL AND reviews.published_at IS NOT NULL ORDER BY reviews.created_at DESC LIMIT 5) UNION ALL";
        }

        $sql = substr($sql, 0, -10);
        ;
        $categories = collect(DB::select($sql))->groupBy('category_name')->values();

        return view('category.index', compact('categories'));
    }

    public function show(Category $category)
    {
        $reviews = $category->reviews()->with('author:id,name', 'categories:name,slug,color')->orderByDesc('created_at')->paginate(5);
        return view('category.show', compact('category', 'reviews'));
    }
}
