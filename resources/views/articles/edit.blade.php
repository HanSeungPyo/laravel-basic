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
        <h1 class="text-2xl">글 수정</h1>
        <form action="{{route('articles.update',['article' => $article->id])}}" method="post" class="mt-3">
            @csrf
            @method('PUT')
            <input type="text" name="body" class="block w-full mb-2 rounded" value={{old('body') ?? $article->body; }}>
            
            @error('body')
                <p class="text-xs text-red-500 my-3">{{$message}}</p>
            @enderror

            <button  class="py-1 px-3 bg-black text-white rounded text-xs">저장하기</button>
        </form>
    </div>

</body>
</html>