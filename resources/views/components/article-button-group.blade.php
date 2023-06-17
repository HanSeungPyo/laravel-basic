<div class="flex flex-row mt-2 mb-3">
    @can('update', $article)
    <p class="mr-1">
        <a href="{{route('articles.edit',['article'=> $article->id])}}" class="button rounded bg-blue-500 px-2 py-1 ml-1 text-xs  text-white">수정</a>
    </p>
    @endcan

    @can('delete', $article)
    <form action="{{route('articles.destroy', ['article' => $article->id])}}" method="post">
    @csrf
    @method('DELETE') 
    <button class="button rounded bg-red-500 px-2 py-1 ml-1 text-xs  text-white">삭제</button>
    </form>
    @endcan    
</div>