<?php

namespace Tests\Feature;

use App\Models\Boards;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BoardsTest extends TestCase
{
    use RefreshDatabase;
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_index_guest_redirect()
    {
        $response = $this->get('/boards');

        $response->assertRedirect('/users/login');
    }

    public function test_index_user_auth()
    {
        $user = new User([
            'email' => 'aa@aa.aa'
            ,'name' => '성이름'
            ,'password' => '*Password123'
        ]);
        $user->save();
        $response = $this->actingAs($user)->get('/boards');
        $this->assertAuthenticatedAs($user);
    }
    public function test_index_user_auth_return_view()
    {
        $user = new User([
            'email' => 'aa@aa.aa', 'name' => '성이름', 'password' => '*Password123'
        ]);
        $user->save();
        $response = $this->actingAs($user)->get('/boards');
        $response->assertViewIs('list');
    }

    public function test_index_user_auth_return_view_check_data()
    {
        $user = new User([
            'email' => 'aa@aa.aa'
            , 'name' => '성이름'
            , 'password' => '*Password123'
        ]);
        $user->save();

        $board1 = new Boards([
            'title' => 'test1'
            ,'content' => 'content1'
        ]);
        $board1->save();

        $board2 = new Boards([
            'title' => 'test2', 'content' => 'content2'
        ]);
        $board2->save();

        $response = $this->actingAs($user)->get('/boards');
        $response->assertViewHas('data');
        $response->assertSee('test1');
        $response->assertSee('test2');
    }
}
