<?php

namespace App\Http\Controllers\Auth;

use Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use DB;
use App\Models\User;
use Illuminate\Support\Str;
use App\Events\PasswordChangedEvent;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
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

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function showPasswordRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function send(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
          ]);

        $checIfTimePassed = DB::table('password_resets')
          ->where('email', '=', $request->email)
          ->whereRaw('created_at > DATE_SUB(NOW(), INTERVAL '.config('settings.verification_links_expire_time').' MINUTE)')
          ->get();

        if($checIfTimePassed->count() === 1)
        {
            return back()->withErrors([
                'email' => 'ახალი პაროლის აღდგენის მოთხოვნა შესაძლებელია მხოლოდ წინა მოთხოვნიდან '.Config::get('settings.verification_links_expire_time').' წუთის გასვლის შემდეგ.',
            ]);
        }

        $userEmailExists = User::where('email', $request->email)
             ->whereNotNull('email_verified_at')
             ->take(1)
             ->get();

        if($userEmailExists->count() === 1)
        {
            DB::table('password_resets')->updateOrInsert(['email' => $request->email],
        ['token' => Str::random(33), 'created_at' => date('Y-m-d H:i:s')]);
        }

        \Session::flash('status', 'თქვენ მიიღებთ პაროლის აღსადგენ შეტყობინებას თუ კი ელ.ფოსტა მოიძებნა ბაზაში.');
        return back();
    }

    public function showResetForm(Request $request, $token)
    {
        if (! $request->hasValidSignature()) {
            abort(404);
        }

        $checIfTimePassed = DB::table('password_resets')
            ->where('token', '=', $token)
            ->where('is_send', '=', TRUE)
            ->get();

        if($checIfTimePassed->count() !== 1)
        {
            abort('404');
        }
        return view('auth.passwords.reset',['token' => $token]);
    }

    public function store(Request $request)
    {
        $checIfTimePassed = DB::table('password_resets')
            ->where('token', '=', $request->token)
            ->where('is_send', '=', TRUE)
            ->whereRaw('created_at > DATE_SUB(NOW(), INTERVAL 20 MINUTE)')
            ->get();

        if($checIfTimePassed->count() !== 1)
        {
            return redirect()->back();
        }

        $request->validate([
            'token' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::where('email', $checIfTimePassed[0]->email)->firstOrFail();

            $user->forceFill([
                'password' => Hash::make($request->password)
            ])->save();

            $user->setRememberToken(Str::random(60));

            event(new PasswordChangedEvent($user));

            DB::table('password_resets')->where('email','=',$user->email)->delete();
            $request->session()->regenerate();
            $request->session()->invalidate();
            return redirect()->route('login')->with('status','თქვენი პაროლი წარმატებით შეიცვალა.');

    }



}
