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
            </div>
        @endforeach
    </div>

    <div class="container mt-5">
         {{$articles->links()}}
    </div>
    
</body>
</html>