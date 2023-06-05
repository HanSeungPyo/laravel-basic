<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="container p-5">
        <h1 class="text-2xl">글목록</h1>
        @foreach ($articles as $article)
            <div class="background-white border rounded mb-3">
                <p>
                    <a href="{{route('articles.show',['article'=> $article->id])}}">{{$article->body}}</a>
                </p>   
                <p>{{$article->user->name}}</p>   
                <p>{{$article->created_at->diffForHumans()}}</p>   

                <div class="flex flex-row mt-2 mb-3">
                    <p class="mr-1">
                        <a href="{{route('articles.edit',['article'=> $article->id])}}" class="button rounded bg-blue-500 px-2 py-1 ml-1 text-xs  text-white">수정</a>
                    </p>

                    <form action="{{route('articles.delete', ['article' => $article->id])}}" method="post">
                    @csrf
                    @method('DELETE') 
                    <button class="button rounded bg-red-500 px-2 py-1 ml-1 text-xs  text-white">삭제</button>
                    </form>    
                </div>
            </div>
        @endforeach
    </div>

    <div class="container mt-5">
         {{$articles->links()}}
    </div>
    
</body>
</html>