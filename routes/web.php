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
});

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

    //$article = new Article;
    //$article->body = $input['body'];
    //$article->user_id = Auth::id();
    //$article->save();

      //대량할당 방식
      //Article::create($input);

      //대량할당 방식2
      Article::create([
          'body' => $input['body'],
          'user_id' => Auth::id()
      ]);


    return view('welcome');
});

require __DIR__.'/auth.php';
