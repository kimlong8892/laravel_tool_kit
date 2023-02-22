<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Rules\CaptchaGoogle;
use App\Rules\Email;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class LoginController extends Controller {
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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Validate the user login request.
     *
     * @param Request $request
     * @return void
     *
     */
    protected function validateLogin(Request $request): void {
        $request->validate([
            'email' => ['required', new Email()],
            $this->username() => 'required|string',
            'password' => 'required|string',
            'g-recaptcha-response' => ['required', new CaptchaGoogle()],
        ], [
            'required' => __('required error')
        ]);
    }

    /**
     * Log the user out of the application.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function logout(Request $request): RedirectResponse {
        $this->guard()->logout();

        return redirect()->route('web.login');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return StatefulGuard
     */
    protected function guard(): StatefulGuard {
        return Auth::guard('web');
    }

    /**
     * Handle a login request to the application.
     *
     * @param Request $request
     * @return RedirectResponse
     *
     */
    public function login(Request $request): RedirectResponse {
        $this->validateLogin($request);

        try {
            $credentials = $request->only('email', 'password');

            if ($this->guard()->attempt($credentials, true)) {
                return redirect()->route('web.home');
            }

            return redirect()->back()->with('error', __('login failed'));
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Show the application's login form.
     *
     * @return View
     */
    public function showLoginForm(): View {
        return view('web.auth.login');
    }
}
