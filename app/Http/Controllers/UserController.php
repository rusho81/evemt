<?php

namespace App\Http\Controllers;

use view;
use Exception;
use App\Models\User;
use App\Mail\OTPMail;
use App\Helper\JWTToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    function LoginPage(){
        return view('pages.auth.login-page');
    }
    function RegistrationPage() {
        return view('pages.auth.registration-page');
    }
    function SendOtpPage(){
        return view('pages.auth.send-otp-page');
    }
    function VerifyOtpPage() {
        return view('pages.auth.verify-otp-page');
    }
    function ResetPasswordPage() {
        return view('pages.auth.reset-pass-page');
    }
    function ProfilePage() {
        return view('pages.dashboard.profile-page');
    }

    public function UserRegistration(Request $request)
    {

        try {
            User::create([
                'firstName' => $request->input('firstName'),
                'lastName' => $request->input('lastName'),
                'email' => $request->input('email'),
                'mobile' => $request->input('mobile'),
                'password' => $request->input('password'),
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'User Registration Successful!',
            ]);

        } catch (Exception $e) {

            return response()->json([
                'status' => 'failed',
                'message' => 'User Registration Failed!',
            ]);

        }

    }

    public function UserLogin(Request $request)
    {
        $count = User::where('email', $request->input('email'))
            ->where('password', $request->input('password'))
            ->select('id')->first();

        if ($count !== null) {
            $token = JWTToken::CreateToken($request->input('email'),$count->id);
            return response()->json([
                'status' => 'success',
                'message' => 'User Login Successful',
            ],)->cookie('token', $token, 60*60);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'unauthorised',
            ]);
        }
    }

    public function SendOTPCode(Request $request)
    {
        $email = $request->input('email');
        $otp = rand(1000, 9000);
        $count = User::where('email', $email)->count();
        if ($count == 1) {
            Mail::to($email)->send(new OTPMail($otp));
            User::where('email', $email)->update(['otp' => $otp]);

            return response()->json([
                'status' => 'success',
                'message' => '4 digit otp code has been send to your mail.',
            ]);

        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'unauthorised',
            ]);
        }
    }

    public function VerifyOTP(Request $request)
    {
        $email = $request->input('email');
        $otp = $request->input('otp');
        $count = User::where('email', $email)
            ->where('otp', $otp)
            ->count();

        if ($count == 1) {
            User::where('email', $email)->update(['otp' => '0']);

            $token = JWTToken::CreateTokenForSetPassword($request->input('email'));
            return response()->json([
                'status' => 'success',
                'message' => 'OTP varification Successful'
            ])->cookie('token', $token, 60*20);

        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'unauthorised',
            ]);
        }
    }

    public function ResetPassword(Request $request)
    {
        try {
            $email = $request->header('email');
            $password = $request->input('password');
            User::where('email', $email)->update(['password' => $password]);
            return response()->json([
                'status' => 'success',
                'message' => 'Request Successful',
            ]);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Something went wrong',
            ]);

        }

    }

    function UserLogout() {
        return redirect('/userLogin')->withoutCookie('token');
    }

    function UserProfile(Request $request) {
        $email=$request->header('email');
        $user = User::where('email',$email)->first();
        return response()->json([
            'status' => 'success',
            'messate' => 'Request successful',
            'data' => $user
        ]);
    }

    function UpdateProfile(Request $request) {
        try {
            $email = $request->header('email'); 
            $firstName = $request->input('firstName'); 
            $lastName = $request->input('lastName'); 
            $mobile = $request->input('mobile');
            $password = $request->input('password');
            User::where('email',$email)->update([
                'firstName'=>$firstName,
                'lastName'=>$lastName,
                'mobile'=>$mobile,
                'password'=>$password,
            ]);
            return response()->json([
            'status' => 'success',
            'messate' => 'Request successful'
            ]); 
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'fail',
                'messate' => 'Something went wrong'
                ]); 
        }
    }
}
