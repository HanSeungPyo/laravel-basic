<?php

use App\Http\Controllers\ProfileController;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/articles/create', function(){
    return view('articles.create');
})->name('articles.create');

Route::post('/articles', function(Request $request){

    //유효성 검사 
    $input = $request->validate([
        'body' => ['required','string','max:255'], //필수, 문자, 맥스 255
    ]);

   /*
    ORM 사용하는 방법
    php artisan make:model Article
    app/modles/article 모델 생성됨. 테이블명, 모델명 일치시 알아서 상호작용
   */

    $article = new Article;
    $article->body = $input['body'];
    $article->user_id = Auth::id();
    $article->save();

    return redirect()->route('articles.index');
    
})->name("articles.store");

Route::get('articles/index',function(Request $request){
    
    $perPage = $request->input('perPage', 5);

    $articles = Article::with('user')
    ->latest()
    ->paginate($perPage);

    return view('articles.index', ['articles' => $articles]);

})->name("articles.index");

Route::get('articles/{article}', function(Article $article){
    return view('articles.show', ['article' => $article]);
})->name('articles.show');

Route::get('articles/edit/{article}',function(Article $article){

    return view('articles.edit', ['article' => $article]);
})->name('articles.edit');

Route::PUT('articles/{article}',function(Request $request, Article $article){

      //유효성 검사 
      $input = $request->validate([
        'body' => ['required','string','max:255'], //필수, 문자, 맥스 255
    ]);

    $article->body = $input['body'];
    $article->save();

    return redirect()->route('articles.index');

})->name('articles.update');

require __DIR__.'/auth.php';
