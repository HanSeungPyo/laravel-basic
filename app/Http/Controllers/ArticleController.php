<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateArticleRequest;
use App\Http\Requests\DeleteArticleRequest;
use App\Http\Requests\EditArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function __construct()
    {
        #개별 글, 글목록 제외한 권한확인 
        $this->middleware('auth')->except(['index','show']);
    }

    public function create(){
        return view('articles.create');
    }

    public function store(CreateArticleRequest $request){
        //유효성 검사 
        $input = $request->validated();
    
        $article = new Article();
        $article->body = $input['body'];
        $article->user_id = Auth::id();
        $article->save();
    
        return redirect()->route('articles.index');
        
    }

    public function index(Request $request){
        $perPage = $request->input('perPage', 5);

        $articles = Article::with('user')
        ->latest()
        ->paginate($perPage);
    
        return view('articles.index', ['articles' => $articles]);
    
    }

    public function show(Article $article){

        $article->load('comments.user');
        return view('articles.show', ['article' => $article]);
    }

    public function edit(EditArticleRequest $request, Article $article){
        return view('articles.edit', ['article' => $article]);
    }

    public function update(UpdateArticleRequest $request, Article $article){

        //유효성 검사 
        $input = $request->validated();
  
        $article->body = $input['body'];
        $article->save();
  
        return redirect()->route('articles.index');
    }

    public function destroy(DeleteArticleRequest $request, Article $article){
        $article->delete();
        return redirect()->route('articles.index');
    }
}
