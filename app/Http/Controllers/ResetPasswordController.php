<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use App\Notifications\ResetPasswordRequest;

class ResetPasswordController extends Controller
{
    /**
     * Create token password reset.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function send_mail_reset_password(Request $request): JsonResponse
    {
        $token = Str::random(60);
        try {
            $user = User::where('email', $request->email)->firstOrFail();
            $passwordReset = PasswordReset::updateOrCreate([
                'email' => $user->email,
            ], [
                'token' => $token,
            ]);
            if ($passwordReset) {
                $user->notify(new ResetPasswordRequest($passwordReset->token));
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid email!',
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'We have e-mailed your password reset link!',
        ]);
    }

    public function change_password(Request $request): JsonResponse
    {
        $user = $request->user;
        $passwords = $request->only('old_password', 'new_password', 'new_password_confirmation');
        $validator = Validator::make($passwords, [
            'old_password' => 'required|string|min:6|max:50',
            'new_password' => 'required|string|min:6|max:50'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'New password is weak (required 6 - 50 characters).',
            ], 400);
        }
        if (!Hash::check($passwords["old_password"], $user->password))
        {
            return response()->json([
                'success' => false,
                'message' => 'Old password is not correct.',
            ], 409);
        }
        if ($passwords["new_password"] != $passwords["new_password_confirmation"]) {
            return response()->json([
                'success' => false,
                'message' => 'New password does not match confirmed password.'
            ], 400);
        }
        $user->update(["password" => bcrypt($passwords["new_password"])]);
        return response()->json([
            'success' => true,
            'message' => 'Password reset successfully.'
        ]);
    }

    public function reset_password(Request $request): JsonResponse
    {
        $token = $request->query("token");
        try {
            $passwordReset = PasswordReset::where('token', $token)->firstOrFail();
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'This password reset token is invalid.',
            ], 404);
        }
        if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
            $passwordReset->delete();
            return response()->json([
                'success' => false,
                'message' => 'This password reset token is invalid.',
            ], 404);
        }
        $user = User::where('email', $passwordReset->email)->firstOrFail();
        $new_password = $request->only('password');
        $validator = Validator::make($new_password, [
            'password' => 'required|string|min:6|max:50'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'New password is weak (required 6 - 50 characters).',
            ], 400);
        }
        $user->update(["password" => bcrypt($new_password["password"])]);
        $passwordReset->delete();
        return response()->json([
            'success' => true,
            'message' => 'Password reset successfully.'
        ]);
    }
}
