<?php

namespace Tests\Feature;

use JWTAuth;
use Mockery;
use Tests\TestCase;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticatesUsersTest extends TestCase
{
    use RefreshDatabase;

    protected function tearDown()
    {
        Mockery::close();
        parent::tearDown();
    }
    /** @test */
    public function it_redirects_to_github()
    {
        $response = $this->get('/auth');
        $this->assertContains('github.com/login/oauth', $response->getTargetUrl());
    }
    /** @test */
    public function it_receives_the_github_response_and_creates_a_new_user()
    {
        $this->mockSocialiteFacade();
        JWTAuth::shouldReceive('fromUser')->withAnyArgs()->andReturn('12345');
        $response = $this->get('/auth/callback');
        $user = User::first();
        $token = JWTAuth::fromUser($user);
        $expiry = auth()->factory()->getTTL() * 60;
        $githubUser = Socialite::driver('github')->user();
        $this->assertEquals($githubUser->getNickname(), $user->username);
        $response->assertRedirect("/auth?token={$token}&token_expiry={$expiry}");
    }

    /** @test */
    public function it_can_fetch_the_currently_authenticated_user()
    {
        $this->login();
        $this->getJson('/api/auth/me')
            ->assertStatus(200)
            ->assertJson(auth()->user()->toArray());
    }
    /** @test */
    public function it_can_fetch_a_refresh_token()
    {
        $this->login();
        $this->getJson('/api/auth/refresh')
            ->assertStatus(200)
            ->assertJsonStructure(['access_token', 'token_type', 'expires_in']);
    }
    /** @test */
    public function a_user_can_logout()
    {
        $this->login();
        $this->assertAuthenticated();
        $this->getJson('/api/auth/logout')
            ->assertStatus(205);
        $this->assertGuest();
    }

    public function mockSocialiteFacade()
    {
        $abstractUser = Mockery::mock('Laravel\Socialite\Two\User');
        $abstractUser->shouldReceive('getId')
            ->andReturn(1234567890)
            ->shouldReceive('getNickname')
            ->andReturn('JaneDoe')
            ->shouldReceive('getName')
            ->andReturn('Jane Doe')
            ->shouldReceive('getAvatar')
            ->andReturn('https://en.gravatar.com/userimage');
        $abstractUser->token = 'abcde12345';
        $provider = Mockery::mock('Laravel\Socialite\Contracts\Provider');
        $provider->shouldReceive('user')->andReturn($abstractUser);
        Socialite::shouldReceive('driver')->with('github')->andReturn($provider);
    }
}
