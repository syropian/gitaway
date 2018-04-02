<?php
namespace App\Lib;

use Zttp\Zttp;
use App\Models\User;
use App\Exceptions\InvalidAccessTokenException;

class GitHubClient
{
    protected $endpoint;
    protected $user;

    public function __construct(User $user)
    {
        $this->endpoint = 'https://api.github.com/graphql';
        $this->user = $user;
    }

    public function fetchRepos()
    {
        $username = $this->user->username;
        $query = <<<GQL
        query {
            user(login:"{$username}") {
                repositories(first:100, orderBy: {field: CREATED_AT, direction: DESC}) {
                    edges {
                        node {
                            id
                            nameWithOwner
                        }
                    }
                }
            }
        }
GQL;

        $response = Zttp::withHeaders([
            'Authorization' => 'Bearer ' . $this->user->access_token,
            'Content-Type' => 'application/json',
        ])->post($this->endpoint, [
            'query' => $query,
            'variables' => '',
        ]);

        if ($response->getStatusCode() == 401) {
            throw new InvalidAccessTokenException;
        }
        return $response->json()['data']['user']['repositories'];
    }
}
