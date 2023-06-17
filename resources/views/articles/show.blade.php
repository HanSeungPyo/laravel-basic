<x-app-layout>
    <div class="container p-5 mx-auto">
        <div class="background-white border rounded mb-3 p-3">
        {{$article->body}}
        </div>
        <x-article-button-group :article=$article/>

        <!-- 댓글영역 시작 -->
        <div>
            <!-- 댓글 작성 폼 시작 -->
            <form action="{{route('comments.store')}}" method="post" class="flex">
                @csrf
                <input type="hidden" name="article_id" value="{{$article->id}}"/>
                <x-text-input name="body"  class="mr-3"/>

                @error('body')
                <x-input-error :messages=$messages/>
                @enderror
                <x-primary-button >댓글 작성</x-primary-button>
            </form>
            <!-- 댓글 작성 폼 끝 -->

            <!-- 댓글 목록 시작 -->

            <!-- 댓글 목록 끝 --> 
        </div>
        <!-- 댓글영역 끝 -->
    </div>
</x-app-layout>