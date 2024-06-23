<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ServiceDeskController;

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
Route::get(
    '/localization/{language}',
    [\App\Http\Controllers\LocalizationController::class, 'switch']
)->name('localization.switch');

Route::get('/', [
    \App\Http\Controllers\BlogController::class, 'home'
])->name('blog.home');

// Route untuk Service Desk
Route::get('/service-desk', [ServiceDeskController::class, 'index'])->name('service-desk.index');
Route::post('/service-desk', [ServiceDeskController::class, 'store'])->name('service-desk.store');
Route::post('/service-desk/give-helpful', [ServiceDeskController::class, 'giveHelpful'])->name('service-desk.give-helpful');
Route::post('/service-desk/remove-helpful', [ServiceDeskController::class, 'removeHelpful'])->name('service-desk.remove-helpful');
Route::put('/service-desk/{id}', [ServiceDeskController::class, 'update'])->name('service-desk.update');
Route::delete('/service-desk/{id}', [ServiceDeskController::class, 'destroy'])->name('service-desk.destroy');
// Route untuk pertanyaan populer
Route::get('/popular-questions', [ServiceDeskController::class, 'getPopularQuestions'])->name('popular-questions');
// reply Service Desk
Route::post('/service-desk/reply/{id}', [ServiceDeskController::class, 'reply'])->name('service-desk.reply.store');
// Route::post('/service-desk/reply/{question_id}', [ServiceDeskController::class, 'reply'])->name('service-desk.reply');
Route::put('/service-desk/reply/{id}', [ServiceDeskController::class, 'updateReply'])->name('service-desk.reply.update');
Route::delete('/service-desk/reply/{id}', [ServiceDeskController::class, 'destroyReply'])->name('service-desk.reply.destroy');

Route::get('/post/{slug}', [
    \App\Http\Controllers\BlogController::class, 'showPostsByDetail'
])->name('blog.posts.detail');

Route::post('/comment/store', [\App\Http\Controllers\CommentController::class, 'store'])->name('comment.store');

Route::get('/categories', [
    \App\Http\Controllers\BlogController::class, 'showCategories'
])->name('blog.categories');

Route::get('/categories/{slug}', [
    \App\Http\Controllers\BlogController::class, 'showPostsByCategory'
])->name('blog.posts.category');

Route::get('/tags', [
    \App\Http\Controllers\BlogController::class, 'showTags'
])->name('blog.tags');

Route::get('/tags/{slug}', [
    \App\Http\Controllers\BlogController::class, 'showPostsByTag'
])->name('blog.posts.tags');

Route::get('/search', [
    \App\Http\Controllers\BlogController::class, 'searchPosts'
])->name('blog.search');

Auth::routes([
    // 'register' => false
]);

Route::group(['prefix' => 'dashboard','middleware' => ['web', 'auth']], function () {
    // dashboard
    Route::get('/', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard.index');
    // categories
    Route::get('/categories/select',[\App\Http\Controllers\CategoryController::class, 'select'])->name('categories.select');
    Route::resource('/categories',\App\Http\Controllers\CategoryController::class);
    // tags
    Route::get('/tags/select',[\App\Http\Controllers\TagController::class, 'select'])->name('tags.select');
    Route::resource('/tags',\App\Http\Controllers\TagController::class)->except('show');
    // posts
    Route::resource('/posts',\App\Http\Controllers\PostController::class);
    // file manager
    Route::group(['prefix' => 'filemanager'], function () {
        Route::get(
            '/index', 
            [\App\Http\Controllers\FileManagerController::class, 'index']
        )->name('filemanager.index');
        \UniSharp\LaravelFilemanager\Lfm::routes();
    });
    // roles
    Route::get('/roles/select',[\App\Http\Controllers\RoleController::class, 'select'])->name('roles.select');
    Route::resource('/roles',\App\Http\Controllers\RoleController::class);
    // users
    Route::resource('/users',\App\Http\Controllers\UserController::class)->except(['show']);
    // Comment reply
    Route::post('/comment/{comment_id}/reply', [CommentController::class, 'reply'])->name('comment.reply');
    // Delete comment route
    Route::delete('/comment/{id}', [\App\Http\Controllers\CommentController::class, 'destroy'])->name('comment.destroy');
    // Delete comment reply route
    Route::delete('/comment/reply/{reply_id}', [\App\Http\Controllers\CommentController::class, 'destroyReply'])->name('comment.reply.destroy');
    // Update comment route
    Route::put('/comment/{id}', [\App\Http\Controllers\CommentController::class, 'update'])->name('comment.update');
    // Update comment reply route
    Route::put('/comment/reply/{id}', [\App\Http\Controllers\CommentController::class, 'updateReply'])->name('comment.reply.update');
});