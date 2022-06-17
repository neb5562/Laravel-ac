<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Events\EmailVerifiedEvent;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */


    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('auth');
        //$this->middleware('signed')->only('verify');
       // $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function verifyEmail(Request $request, $slug)
    {
        if (! $request->hasValidSignature()) {
            abort(404);
        }
        $user = User::where('email_verification_token', '=',$slug)
        ->firstOrFail();

        $user->email_verified_at = date('Y-m-d H:i:s');
        $user->email_verification_token = null;
        $user->updated_at = date('Y-m-d H:i:s');

        event(new EmailVerifiedEvent($user));

        $user->save();

        \Session::flash('status', 'ელ.ფოსტა წარმატებით დადასტურდა.' );

        return redirect()->route('login');
    }

    public function verifyGuestEmail(Request $request, $slug)
    {
        if (! $request->hasValidSignature()) {
            abort(404);
        }
        $update = DB::table('email_subscribers')
                ->where('token','=',$slug)
                ->where('is_verified','=',FALSE)
                ->update(['is_verified' => TRUE]);

        if($update)
        {
            \Session::flash('status', 'ელ.ფოსტა წარმატებით დადასტურდა.' );
        }

        return redirect()->route('home');
    }

}
