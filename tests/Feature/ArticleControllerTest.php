<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleControllerTest extends TestCase
{
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
        $user = User::factory()->create();
        $this->actingAs($user)
        ->post(route('articles.store'),$testData)
        ->assertRedirect(route('articles.index'));
    }

    

}
