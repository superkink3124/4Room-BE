<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Exception;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    /**
     * @throws Exception
     */
    public function register(Request $request): JsonResponse
    {
        //Validate data
        $data = $request->only('email', 'name_in_forum', 'password');
        $password = $request->input("password");
        $password_confirmation = $request->input("password_confirmation");
        if ($password != $password_confirmation) {
            return response()->json([
                'success' => false,
                'message' => 'Password does not match confirmed password.'
            ], 400);
        }
        $validator = Validator::make($data, [
            'email' => 'required|email|unique:users',
            'name_in_forum' => 'required|string',
            'password' => 'required|string|min:6|max:50'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid email or password.',
            ], 400);
        }

        //Request is valid, create new user
        $user = User::create([
            'name_in_forum' => $request->name_in_forum,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'avatar_id' => random_int(1, 10).".png"
        ]);

        //User created, return success response
        return response()->json([
            'success' => true,
            'message' => 'User created successfully.',
            'data' => new UserResource($user)
        ], Response::HTTP_OK);
    }

    public function authenticate(Request $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        //valid credential
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:50'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => "Invalid email or password."], 400);
        }

        //Request is validated, create jwt
        try {
            if (!$jwt = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Login credentials are invalid.',
                ], 400);
            }
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Could not create token.',
            ], 500);
        }

        //Token created, return with success response and jwt token
        return response()->json([
            'success' => true,
            'message' => "Login successfully.",
            'jwt' => $jwt,
            'data' => new UserResource(User::where('email', $credentials['email'])->first())
        ]);
    }

    public function jwtValidate(Request $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Token is valid.'
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        try {
            JWTAuth::invalidate($request->bearerToken());

            return response()->json([
                'success' => true,
                'message' => 'User has been logged out.'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, user cannot be logged out.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
