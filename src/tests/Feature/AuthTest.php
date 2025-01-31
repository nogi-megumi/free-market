<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{
    use RefreshDatabase;
    public function test_register_invalid_name()
    {
        $response=$this->get('/register');
        $response->assertStatus(200);

        $response = $this->post('/register',[
            'name'=>'',
            'email'=> 'aaa@example.com',
            'password'=>'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('name');

        $errors = session('errors');
        $this->assertEquals('お名前を入力してください', $errors->get('name')[0]);
    }
    public function test_register_invailid_email()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);

        $response = $this->post('/register', [
            'name' => 'TestUser',
            'email' => '',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');

        $errors = session('errors');
        $this->assertEquals('メールアドレスを入力してください', $errors->get('email')[0]);
    }
    public function test_register_invailid_password()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);

        $response = $this->post('/register', [
            'name' => 'TestUser',
            'email' => 'aaa@example.com',
            'password' => '',
            'password_confirmation' => '',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('password');

        $errors = session('errors');
        $this->assertEquals('パスワードを入力してください', $errors->get('password')[0]);
    }
    public function test_register_invailid_password_min()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);

        $response = $this->post('/register', [
            'name' => 'TestUser',
            'email' => 'aaa@example.com',
            'password' => 'pass',
            'password_confirmation' => 'pass',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('password');

        $errors = session('errors');
        $this->assertEquals('パスワードは8文字以上で入力してください', $errors->get('password')[0]);
    }
    public function test_register_invailid_password_confirmed()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);

        $response = $this->post('/register', [
            'name' => 'TestUser',
            'email' => 'aaa@example.com',
            'password' => 'password',
            'password_confirmation' => 'wrong-password',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('password');

        $errors = session('errors');
        $this->assertEquals('パスワードと一致しません', $errors->get('password')[0]);
    }
    public function test_user_can_register()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);

        $response = $this->post('/register', [
            'name' => 'TestUser',
            'email' => 'aaa@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('users', ['email' => 'aaa@example.com']);
    }

    public function test_login_invailid_email()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);

        User::factory()->create(['password' => bcrypt('password')]);
        $response = $this->post('/login', [
            'email' => '',
            'password' => 'password',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');

        $errors = session('errors');
        $this->assertEquals('メールアドレスを入力してください', $errors->get('email')[0]);
    }
    public function test_login_invailid_password()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);

        $user = User::factory()->create(['password' => bcrypt('password')]); 
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => '',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('password');

        $errors = session('errors');
        $this->assertEquals('パスワードを入力してください', $errors->get('password')[0]);
    }
    public function test_login_auth_failed()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);

        User::factory()->create(['password' => bcrypt('password')]);
        $response = $this->post('/login', [
            'email' => 'another-email@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');

        $errors = session('errors');
        $this->assertEquals('ログイン情報が登録されていません', $errors->get('email')[0]);
    }
    public function test_user_can_login()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);

        $user = User::factory()->create(['password' => bcrypt('password')]); 
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(302);
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_can_logout()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->post('/logout');

        $response->assertStatus(302);
        $this->assertGuest();
    }
}
