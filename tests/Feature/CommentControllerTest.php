<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
    /**
     * @test
     */
    public function 댓글을_작성_할_수_있다(): void
    {
        $user = User::factory()->create();
        $article =Article::factory()->create();

        $payload =  [
            'body' => '댓글 입니다.',
            'user_id' => $user->id,
            'article_id'=>$article->id
        ];
       
        $this->actingAs($user)
        ->post(route('comments.store'),$payload)
        ->assertRedirect(route('articles.show', ['article' => $article->id]));

        $this->assertDatabaseHas('comments', $payload);
    }
}
