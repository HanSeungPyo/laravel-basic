<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArtisanController extends Controller
{
    public function create(){
        return view('articles.create');
    }

    public function store(Request $request){
        //유효성 검사 
        $input = $request->validate([
            'body' => ['required','string','max:255'], //필수, 문자, 맥스 255
        ]);
    
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
        return view('articles.show', ['article' => $article]);
    }

    public function edit(Article $article){
        return view('articles.edit', ['article' => $article]);
    }

    public function update(Request $request, Article $article){

        //유효성 검사 
        $input = $request->validate([
            'body' => ['required','string','max:255'], //필수, 문자, 맥스 255
        ]);
  
        $article->body = $input['body'];
        $article->save();
  
        return redirect()->route('articles.index');
    }

    public function destroy(Article $article){
        $article->delete();
        return redirect()->route('articles.index');
    }
}
