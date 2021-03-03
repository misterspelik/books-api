<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Resources\User\UserResource;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use App\Traits\ResponseTrait;
use Auth;

class AuthController extends Controller
{
    use AuthenticatesUsers, ResponseTrait;

    /**
     * Get a JWT token via given credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if ($token = $this->guard()->attempt($credentials)) {
            return $this->respondWithToken($token);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $user = $this->guard()->user();

        return new UserResource($user);
    }

    /**
    * Refresh a token.
    *
    * @return \Illuminate\Http\JsonResponse
    * @throws TokenInvalidException
    */
    protected function refreshToken()
    {
        $token = Auth::getToken();

        if (!$token) {
            throw new TokenInvalidException('Token not provided');
        }

        try {
            $new_token = Auth::refresh($token);
            $user = Auth::authenticate($new_token);
        } catch (TokenInvalidException $e) {
            throw new AccessDeniedHttpException('The token is invalid');
        }

        return $this->respondWithToken($new_token);
    }
}
