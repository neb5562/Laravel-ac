<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Address;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    public function store()
    {
      $user =  User::create([
        'name' => $data['name'],
        'username' => $data['username'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
    ]);
    
  }

    public function destroy(Address $address)
    {
      $this->authorize('delete', $address);

      $address->delete();

      return back();
    }

    public function user()
    {
      return $this->belongsTo(User::class);
    }


}

