<?php

namespace Tests;

use App\Models\User;
use JWTAuth;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function login(User $user = null)
    {
        $user = $user ? : create('App\Models\User');
        $token = JWTAuth::fromUser($user);
        JWTAuth::setToken($token);
        $this->headers['Authorization'] = 'Bearer ' . $token;
        auth()->login($user);

        return $this;
    }
}
