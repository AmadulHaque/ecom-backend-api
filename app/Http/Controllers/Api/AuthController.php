<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Otp;
use App\Models\User;
use App\Services\SmsService;
use App\Traits\UserCheck;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Log;
use Message;

class AuthController extends Controller
{
    use UserCheck;
    public function sendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
        ], [
            'phone.exists' => 'The mobile number is not registered with us.',
        ]);

        if ($validator->fails()) {
            return validationError('Validation Error', $validator->errors());
        }

        $mobileNumber = $request->phone;

        // Check if OTP has expired or not after 2 minutes
        $otp = Otp::where('phone', $mobileNumber)->where('is_verified', 0)->first();
        if ($otp && !Carbon::now()->greaterThan($otp->expires_at)) {
            return failure('Please wait for some time before requesting a new OTP.');
        }

        // Start transaction
        DB::beginTransaction();
        try {
            // Generate OTP
            $code = rand(100000, 999999);
            // Set OTP expiration (2 minutes from now)
            $expiresAt = Carbon::now()->addMinutes(2);

            // Create or update OTP record
            $otp = Otp::updateOrCreate(
                ['phone' => $mobileNumber],
                [
                    'otp' => $code,
                    'expires_at' => $expiresAt,
                    'is_verified' => 0,
                ]
            );

            // Send OTP to user
            $smsService = new SmsService();
            $smsResponse = $smsService->sendMessage(
                $mobileNumber,
                "Welcome to Packly.com! Use OTP $code to complete your registration. Thanks NELYNyb29FL "
            );

            // Log SMS response
            Log::info("SMS Response: ", $smsResponse);

            // Commit the transaction
            DB::commit();

            return success('OTP sent successfully.', null);
        } catch (\Exception $e) {
            // If any exception occurs, rollback the transaction
            DB::rollBack();

            // Log the exception
            Log::error('Error sending OTP: ' . $e->getMessage());

            return failure($e->getMessage());
        }
    }

    // public function sendOtp(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'phone' => 'required',
    //     ], [
    //         'phone.exists' => 'The mobile number is not registered with us.',
    //     ]);

    //     if ($validator->fails()) {
    //         return validationError('Validation Error', $validator->errors());
    //     }

    //     $mobileNumber = $request->phone;

    //     // Check if OTP has expired or not after 2 minutes
    //     $opt = Otp::where('phone', $mobileNumber)->where('is_verified', 0)->first();
    //     if ($opt && ! Carbon::now()->greaterThan($opt->expires_at)) {
    //         return failure('Please wait for sometime before requesting a new OTP.');
    //     }

    //     // Start transaction
    //     DB::beginTransaction();
    //     try {
    //         // Generate OTP
    //         $code = rand(100000, 999999);
    //         // Set OTP expiration (2 minutes from now)
    //         $expiresAt = Carbon::now()->addMinutes(2);

    //         // Create or update OTP record
    //         $otp = Otp::updateOrCreate(
    //             ['phone' => $mobileNumber],
    //             [
    //                 'otp' => $code,
    //                 'expires_at' => $expiresAt,
    //                 'is_verified' => 0,
    //             ]
    //         );

    //         // Send OTP to user
    //         Message::sendMessage($mobileNumber, "Welcome to Packly.com! Use OTP $code" . ' to complete your registration. Thanks NELYNyb29FL');

    //         // Simulate sending OTP (Replace with actual SMS integration)
    //         Log::info("OTP sent to $mobileNumber: $otp");

    //         // Commit the transaction
    //         DB::commit();

    //         return success('OTP sent successfully.');
    //     } catch (\Exception $e) {
    //         // If any exception occurs, rollback the transaction
    //         DB::rollBack();

    //         // Log the exception
    //         Log::error('Error sending OTP: ' . $e->getMessage());

    //         return failure($e->getMessage());
    //     }
    // }

    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|exists:otps,phone',
            'otp' => 'required|exists:otps,otp',
        ], [
            'phone.exists' => 'Invalid phone number.',
            'otp.exists' => 'Invalid OTP.',
        ]);

        if ($validator->fails()) {
            return validationError('Validation Error', $validator->errors());
        }

        $mobileNumber = $request->phone;
        $code = $request->otp;

        $opt = Otp::where('phone', $mobileNumber)->where('otp', $code)->first();
        if (! $opt) {
            return failure('Invalid OTP.');
        }

        // Check if OTP has expired or not after 2 minutes
        if (Carbon::now()->greaterThan($opt->expires_at)) {
            return failure('OTP has expired. Please try again.');
        }

        // Start transaction
        DB::beginTransaction();
        try {
            // Clear OTP fields
            $opt->otp = '';
            $opt->expires_at = null;
            $opt->is_verified = 1;
            $opt->save();

            // Find user by mobile number
            $user = User::where('phone', $mobileNumber)->first();
            if ($user) {
                // Log the user in (generate token, etc.)
                $token = $user->createToken('authToken')->plainTextToken;
                DB::commit();

                return success('Logged in successfully.', ['user' => $user, 'token' => $token]);
            }

            // If user doesn't exist, handle account creation flow
            DB::commit();

            return success('Create account.', null);
        } catch (\Exception $e) {
            // If any exception occurs, rollback the transaction
            DB::rollBack();

            return failure($e->getMessage());
        }
    }

    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required|unique:users,phone',
            'date_of_birth' => 'nullable|date',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gender' => 'nullable',
        ]);

        if ($validator->fails()) {
            return validationError('Validation Error', $validator->errors());
        }

        try {
            DB::beginTransaction();
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'date_of_birth' => $request->date_of_birth,
                'password' => Hash::make($request->password),
                'gender' => $request->gender,
            ]);

            if ($request->hasFile('avatar')) {
                $user->addMedia($request->file('avatar'), 'avatar');
            }
            $token = $user->createToken('authToken')->plainTextToken;
            DB::commit();

            return success('User created successfully', ['user' => $user, 'token' => $token]);
        } catch (\Exception $e) {
            DB::rollBack();

            return error('Error creating user', $e->getMessage());
        }
    }

    public function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();

        return success('Logout successful');
    }
}
