<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware extends BaseMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
//            $user = JWTAuth::parseToken()->authenticate();
            //            $request->user = $user;
            $lastCreatedUser = User::all()->max('id');
            $request->user = User::find($lastCreatedUser);
//            dd($request->user);
        } catch (Exception $e) {
            if ($e instanceof TokenInvalidException){
                return response()->json([
                    "success" => false,
                    "message" => "Token is Invalid"], 401);
            } else if ($e instanceof TokenExpiredException){
                return response()->json([
                    "success" => false,
                    "message" => "Token is Expired"], 401);
            } else {
                return response()->json([
                    "success" => false,
                    "message" => "Authorization Token not found"], 401);
            }
        }
        return $next($request);
    }
}
