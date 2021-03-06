<?php


use Illuminate\Support\Facades\Route;


use App\Http\Livewire\Categories;
use App\Http\Livewire\Categoryscores;
use App\Http\Livewire\Scorecards;
use App\Http\Livewire\Scorecard;
use App\Http\Livewire\Tags;
use App\Http\Livewire\Tagscores;
use App\Http\Livewire\Courses;

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

// Route::get('test', function () {
//     $category = App\Models\Category::find(3);
//     // return $category->scores;

//     $comment = App\Models\Comment::find(152);
//     // return $comment->author;
//     // return $comment->score;

//     $score = App\Models\Score::find(152);
//     // return $score->category;
//     // return $score->author;
//     // return $score->images;
//     // return $score->comments;
//     // return $score->tags;

//     $tag = App\Models\Tag::find(5);
//     // return $tag->scores;

//     $author = App\Models\User::find(88);
//     // return $author->scores;
//     return $author->comments;
// });

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('dashboard/categories', Categories::class)->name('categories');
Route::get('dashboard/categories/{id}/scores', Categoryscores::class);

Route::get('dashboard/scorecards', Scorecards::class)->name('scores');
Route::get('dashboard/scorecards/{id}', Scorecard::class);

Route::get('dashboard/tags', Tags::class)->name('tags');
Route::get('dashboard/tags/{id}/scores', Tagscores::class);

Route::get('dashboard/courses', Courses::class)->name('courses');
//Route::get('dashboard/courses/{id}/scores', CourseScores::class);




