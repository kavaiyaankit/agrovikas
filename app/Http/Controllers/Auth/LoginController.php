<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        try{
            $userData = User::where('email', $request->email)->first();

            if(!$userData)
            {
                return redirect()->route('login')->withInput($request->only('email'))->with('error', 'Email not found');
            }

            $otp = rand('111111', '999999');
            $userData->otp = $otp;
            $userData->save();
            $userId = encrypt($userData->id);
            Mail::send('emails.otp-email', ['otp' => $otp], function ($message) use ($userData) {
                $message->to($userData->email)->subject('Login OTP');
            });

            return redirect()->route('otp', compact('userId'))->with('sucess', 'OTP has been sent successfully.');
        }catch(\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function getOTP(Request $request, $userId)
    {
        try{
            $incryptUserId = $userId;
            $userId = decrypt($userId);
            $userData = User::where('id', $userId)->first();
            if($userData)
            {
                return view('auth.otp', compact('incryptUserId'));
            }

            return redirect()->route('login')->with('error', 'User not found');
        } catch(\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function verifyOTP(Request $request)
    {
        try{
            $userId = decrypt($request->userId);
            $userData = User::where('otp', $request->otp)->where('id', $userId)->first();
            if(!$userData)
            {
                return redirect()->back()->with('error', 'Invalid OTP. Please try again.');
            }

            $userData->otp = rand('111111', '999999');
            Auth::loginUsingId($userId);

            return redirect()->route('home')->with('success', 'OTP verification successful.');
        } catch(\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
