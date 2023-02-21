<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Rules\CaptchaGoogle;
use App\Rules\Email;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ResetPasswordController extends Controller {
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected string $redirectTo = RouteServiceProvider::HOME;

    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param Request $request
     * @param string|null $token
     * @return Factory|View
     */
    public function showResetForm(Request $request, string $token = null) {
        return view('admin.auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->get('email')]
        );
    }

    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function rules(): array {
        return [
            'email' => ['required', new Email()],
            'password' => ['required'],
            'g-recaptcha-response' => ['required', new CaptchaGoogle()],
            'confirm_password' => 'required|same:password'
        ];
    }

    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function validationErrorMessages(): array {
        return [
            'required' => __('required error'),
            'confirm_password.same' => __('password confirmed error')
        ];
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return PasswordBroker
     */
    public function broker(): PasswordBroker {
        return Password::broker('admins');
    }

    /**
     * Reset the given user's password.
     *
     * @param Request $request
     * @return RedirectResponse|JsonResponse
     * @throws ValidationException
     */
    public function reset(Request $request) {
        $request->validate($this->rules(), $this->validationErrorMessages());

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $response = $this->broker()->reset(
            $this->credentials($request), function ($user, $password) {
            $this->resetPassword($user, $password);
        }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.

        if ($response == Password::PASSWORD_RESET) {
            Auth::guard('admin')->attempt($request->only('email', 'password'));

            return redirect()->route('admin.home');
        } else {
            return $this->sendResetFailedResponse($request, $response);
        }
    }
}
