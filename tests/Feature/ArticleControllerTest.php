<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function 글쓰기_화면을_볼_수_있다(): void
    {   
        $this->get(route('articles.create'))
        ->assertStatus(200)
        ->assertSee('글쓰기');
    }

    /**
     * @test
     */
    public function 글을_저장_할_수_있다(): void
    {
        $testData = ['body' => 'test article'];
        
        #유저생성
        $user = User::factory()->create();  

        #유저연결
        $this->actingAs($user) 
        ->post(route('articles.store'),$testData)
        ->assertRedirect(route('articles.index'));
    }

    /**
     * @test
     */
    public function 글_목록을_확인할_수_있다(): void{

        #같은시간에 생성되지 않게 시간조절
        $now = Carbon::now();
        $afterOneSecond = (clone $now) ->addSecond();
        $article1 = Article::factory()->create(['created_at' =>  $now]);
        $article2 = Article::factory()->create(['created_at' =>  $afterOneSecond]);
    
        $this->get(route('articles.index'))
        ->assertSeeInOrder([
            $article2->body,
            $article1->body
        ]);
    }

    /**
     * @test
     */
    public function 개별_글을_조회_할_수_있다(): void{

        $article = Article::factory()->create();
    
        $this->get(route('articles.show',['article' => $article]))
        ->assertSuccessful()
        ->assertSee($article->body);
    }

    /**
     * @test
     */
    public function 글수정_화면을_볼_수_있다(): void{
        $article = Article::factory()->create();
        $this->get(route('articles.edit',['article' => $article->id]))
        ->assertStatus(200)
        ->assertSee('글 수정');
    }

     /**
     * @test
     */
    public function 글을_수정_할_수_있다(): void{
        $payload =  ['body' => '수정된 글'];
        $article = Article::factory()->create();
            $this->PUT(route('articles.update',['article' => $article->id]),
            $payload
        )->assertRedirect(route('articles.index'));
        
        #DB에 수정된 글 내용이 저장되어 있는지 확인
        $this->assertDatabaseHas('articles', $payload);
        
        #수정된 글 내용이 기존 글의 내용과 일치하는지 확인
        $this->assertEquals($payload['body'], $article->refresh()->body); 
    }

     /**
     * @test
     */
    public function 글을_삭제_할_수_있다(): void{
        $article = Article::factory()->create();

        $this->delete(route('articles.delete', ['article' => $article->id]))
        ->assertRedirect(route('articles.index'));

        #글이 삭제되었는지 확인
        $this->assertDatabaseMissing('articles', ['id' => $article->id]);
        
    }
}
