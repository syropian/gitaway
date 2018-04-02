<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Tests\Stubs\GitHubUser;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    protected $user;
    protected function setUp()
    {
        parent::setUp();
        $this->user = create('App\Models\User');
    }

    /** @test */
    public function it_can_map_a_github_user_object()
    {
        $githubUser = new GitHubUser();
        $this->user->mapGitHubUser($githubUser);
        $this->assertEquals(
            $githubUser->getNickname(),
            $this->user->username
        );
        $this->assertEquals(
            $githubUser->getId(),
            $this->user->github_id
        );
        $this->assertEquals(
            $githubUser->getName(),
            $this->user->name
        );
        $this->assertEquals(
            $githubUser->getAvatar(),
            $this->user->avatar_url
        );
        $this->assertEquals(
            $githubUser->token,
            $this->user->access_token
        );
    }
}
