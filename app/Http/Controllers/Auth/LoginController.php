<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

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
    protected function redirectTo()
    {
        $user = Auth::user();

        switch ($user->getUserType()) {
            case 'medecin':
                //dd("medecin");
                redirect()->route('talibe.index');
                //return route('talibe.index'); // ou route personnalisée
            break;
            case 'dieuw':
                //dd("dieuw");
                return route('dieuw.index');

                break;
          //  case 'admin':
            //    return route('admin.dashboard'); // adapte selon ton app
            default:
                //dd("default");
                return route('home');
        }
        }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
