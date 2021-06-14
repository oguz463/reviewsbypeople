<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', [PageController::class, 'index'])->name('home');

require __DIR__.'/auth.php';

Route::get('/redirect', [PageController::class, 'redirect']);

Route::get('feed', [PageController::class, 'feed']);

Route::middleware('can:admin')->name('admin.')->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('/products', [AdminController::class, 'index'])->name('products');
    Route::get('/posts', [AdminController::class, 'index'])->name('posts');
    Route::get('/submit/reviews', [AdminController::class, 'index'])->name('submit.show.reviews');
    Route::get('/submit/products', [AdminController::class, 'index'])->name('submit.show.products');
    Route::get('/submit/posts', [AdminController::class, 'index'])->name('submit.show.posts');
    Route::get('/comments', [AdminController::class, 'index'])->name('comments');
    Route::get('/links', [AdminController::class, 'index'])->name('links');
    Route::get('/notes', [AdminController::class, 'index'])->name('notes');
    Route::get('/category', [AdminController::class, 'index'])->name('category');
    Route::get('/author', [AdminController::class, 'index'])->name('author');
    Route::get('/featured', [AdminController::class, 'index'])->name('featured');
    Route::get('/message', [AdminController::class, 'index'])->name('message');
    Route::put('submit/review/{review:slug}', [AdminController::class, 'review_submit'])->name('submit.review');
    Route::put('submit/product/{product:slug}', [AdminController::class, 'product_submit'])->name('submit.product');
    Route::put('submit/post/{post:slug}', [AdminController::class, 'post_submit'])->name('submit.post');
    Route::put('submit/comment/{comment}', [AdminController::class, 'comment_submit'])->name('submit.comment');
    Route::put('deactive/review/{review:slug}', [AdminController::class, 'review_deactive'])->name('deactive.review');
    Route::put('deactive/product/{product:slug}', [AdminController::class, 'product_deactive' ])->name('deactive.product');
    Route::put('deactive/post/{post:slug}', [AdminController::class, 'post_deactive'])->name('deactive.post');
    Route::put('featured/change/{type}/{type_id}', [AdminController::class, 'featured_change'])->name('featured.change');
    Route::put('pick/change/{type}/{type_id}', [AdminController::class, 'pick_change'])->name('pick.change');
    Route::post('edit/category', [AdminController::class, 'edit_category'])->name('edit.category');
    Route::post('make/{user}/author', [AdminController::class, 'make_author'])->name('make.author');
    Route::post('make/{user}/user', [AdminController::class, 'make_user'])->name('make.user');
    Route::post('featured/add/{type}/{type_id}', [AdminController::class, 'featured_add'])->name('featured.add');
    Route::post('set/note/{id}', [AdminController::class, 'set_note'])->name('set.note');
    Route::post('set/allnotes/{review:slug}', [AdminController::class, 'all_notes'])->name('all.notes');
    Route::delete('delete/review/{review:slug}', [AdminController::class, 'review_delete'])->name('delete.review');
    Route::delete('delete/product/{product:slug}', [AdminController::class, 'product_delete'])->name('delete.product');
    Route::delete('delete/post/{post:slug}', [AdminController::class, 'post_delete'])->name('delete.post');
    Route::delete('delete/comment/{comment}', [AdminController::class, 'comment_delete'])->name('delete.comment');
    Route::delete('delete/category/{category}', [AdminController::class, 'category_delete'])->name('delete.category');
    Route::delete('delete/featured/{type}/{type_id}', [AdminController::class, 'featured_delete'])->name('delete.featured');
});

Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/cookies-policy', [PageController::class, 'cookiespolicy'])->name('cookiespolicy');
Route::get('/term-of-services', [PageController::class, 'tos'])->name('termsofservice');
Route::get('/search', [SearchController::class, 'show'])->name('search');
Route::get('/edit', [AuthorController::class, 'edit'])->name('author.edit')->middleware('auth');
Route::put('/edit', [AuthorController::class, 'update'])->name('author.update')->middleware('auth');
Route::post('/author/avatar', [AuthorController::class, 'avatar'])->name('author.avatar')->middleware('auth');
Route::get('/author/{user}', [AuthorController::class, 'show'])->name('author.show');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'storeMessage'])->name('message.store');
Route::get('/categories', [CategoryController::class, 'index'])->name('category.index');
Route::get('/category/{category:slug}', [CategoryController::class, 'show'])->name('category.show');


Route::get('/products', [ProductController::class, 'index'])->name('product.index');
Route::post('/products', [ProductController::class, 'store'])->name('product.store')->middleware('can:author');
Route::get('/product/create', [ProductController::class, 'create'])->name('product.create')->middleware('can:author');
Route::get('/product/{product:slug}/edit', [ProductController::class, 'edit'])->name('product.edit')->middleware('can:update');
Route::put('/product/{product:slug}/edit', [ProductController::class, 'update'])->name('product.update')->middleware('can:update');

Route::get('/posts', [PostController::class, 'index'])->name('post.index');
Route::post('/posts', [PostController::class, 'store'])->name('post.store')->middleware('can:author');
Route::get('/post/create', [PostController::class, 'create'])->name('post.create')->middleware('can:author');
Route::get('/post/{post:slug}', [PostController::class, 'show'])->name('post.show');
Route::get('/post/{post:slug}/edit', [PostController::class, 'edit'])->name('post.edit')->middleware('can:update');
Route::put('/post/{post:slug}/edit', [PostController::class, 'update'])->name('post.update')->middleware('can:update');

Route::get('/reviews', [ReviewController::class, 'index'])->name('review.index');
Route::get('/create', [ReviewController::class, 'create'])->name('review.create')->middleware('can:author');
Route::post('/reviews', [ReviewController::class, 'store'])->name('review.store')->middleware('can:author');


Route::post('/comment/{type}/{type_id}', [CommentController::class, 'store'])->name('add.comment');

Route::get('/inactive/post/{post:slug}', [PostController::class, 'showInactive'])->name('post.inactive')->middleware('can:admin');
Route::get('/inactive/product/{product:slug}', [ProductController::class, 'showInactive'])->name('product.inactive')->middleware('can:admin');
Route::get('/inactive/{review:slug}', [ReviewController::class, 'showInactive'])->name('review.inactive')->middleware('can:admin');



Route::get('/{review:slug}', [ReviewController::class, 'show'])->name('review.show');
Route::get('/{review:slug}/edit', [ReviewController::class, 'edit'])->name('review.edit')->middleware('can:update');
Route::put('/{review:slug}/edit', [ReviewController::class, 'update'])->name('review.update')->middleware('can:update');
Route::post('/{review:slug}/add/note', [ReviewController::class, 'add_note'])->name('add.note')->middleware('can:update');

Route::get('/{review:slug}/{product:slug}', [ProductController::class, 'show'])->name('product.show');
