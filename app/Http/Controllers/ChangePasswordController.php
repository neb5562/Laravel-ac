<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Events\PasswordChangedEvent;
use Illuminate\Support\Str;
use DB;

class ChangePasswordController extends Controller
{
    public function __construct()
    {
      $this->middleware(['auth']);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
          'current_password' => 'required',
          'password' => 'required|string|min:8|confirmed',
          'password_confirmation' => 'required',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
          \Session::flash('status', 'თქვენი ამჟამინდელი პაროლი არასწორია.');
            return back();
        }

        $user->password = Hash::make($request->password);
        $user->save();
        event(new PasswordChangedEvent($user));
        \Session::flash('status', 'პაროლი წარმატებით განახლდა.');
        
        return back();
    }

    public function verificationResend()
    {
      auth()->user()->email_verification_token = Str::random(33);
      auth()->user()->save();
      DB::table('email_verifications_to_send')->updateOrInsert(['user_id' => auth()->user()->id]);
      \Session::flash('status', 'ელ.ფოსტის ვერიფიკაციის შეტყობინება წარმატებით გამოიგზავნა.');
      return back();
    }
}
