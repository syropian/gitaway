<?php

namespace App\Http\Controllers;

use JWTAuth;
use Socialite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['redirectToProvider', 'handleProviderCallback']]);
    }

    public function redirectToProvider()
    {
        return Socialite::driver('github')
            ->setScopes(['read:user', 'write:repo_hook'])
            ->redirect();
    }

    public function handleProviderCallback(Request $request)
    {
        if (isset($request['error'])) {
            return redirect('/?authError=true');
        }
        $githubUser = Socialite::driver('github')->user();
        $id = $githubUser->getId();
        $user = User::where('github_id', $id)->first();
        // If the user exists, just update fields that they may have changed in their Github settings
        if (is_null($user)) {
            $user = new User();
        } // If no user was found, create a new one
        $user->mapGitHubUser($githubUser);
        $jwt = JWTAuth::fromUser($user);
        $jwtExpiry = $this->guard()->factory()->getTTL() * 60;
        return redirect('/?token=' . $jwt . '&token_expiry=' . $jwtExpiry);
    }

    public function me(Request $request)
    {
        return response()->json($this->guard()->user());
    }
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }
    public function logout()
    {
        $this->guard()->logout();
        return response()->json([], 205);
    }
    public function guard()
    {
        return Auth::guard();
    }
}
