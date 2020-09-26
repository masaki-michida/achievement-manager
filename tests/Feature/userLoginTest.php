<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class userLogin extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use DatabaseTransactions;

    public function getLoginPage()
    {

        $response = $this->get('/login');
        $response->assertSuccessful();
        $response->assertViewIs('auth.login');
        
    }

    /**
     * @test
     */

    public function redirectAuthenticatedUserGetLoginPage(){

        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get('/login');

        $response->assertRedirect('/mypage');

    }

    /**
     * @test
     */

    public function loginWithCorrectPass()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt($password = 'logintest'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertRedirect('/mypage');
        $this->assertAuthenticatedAs($user);
    }


    /**
     * @test
     */

    public function loginWithIncorrectPass(){

        $user = factory(User::class)->create([
            'password' => bcrypt($password = "successor")
        ]);

        $response = $this->post('/login',[
            'email' => $user->email,
            'password' => 'wrongPass',
        ]);



        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();

    }

    /**
     * @test
     */

    public function loginWithRememberMe()
    {
        $user = factory(User::class)->create([
            'id' => random_int(1, 100),
            'password' => bcrypt($password = 'password'),
        ]);
        
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
            'remember' => 'on',
        ]);
        
        $response->assertRedirect('/mypage');

        $this->assertAuthenticatedAs($user);
    }

}
