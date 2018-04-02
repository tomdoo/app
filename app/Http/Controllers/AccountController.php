<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\User;

class AccountController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function informations(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'email' => 'bail|required|email',
                'firstname' => 'bail|nullable|alpha',
                'lastname' => 'bail|nullable|alpha',
                'password' => 'bail|nullable|confirmed',
                'birth_date' => 'bail|nullable|date_format:Y-m-d',
                'sex' => 'bail|nullable',
                'phone' => 'bail|nullable|min:10'
            ]);
            $user = User::find(Auth::user()->id);
            $user->email = $request->input('email');
            $user->firstname = $request->input('firstname');
            $user->lastname = $request->input('lastname');
            $user->name = trim($user->firstname.' '.$user->lastname);
            $user->birth_date = $request->input('birth_date');
            $user->sex = $request->input('sex');
            $user->phone = $request->input('phone');
            $user->newsletter = $request->input('newsletter');
            if (!empty($request->input('password'))) {
                $user->password = Hash::make($request->input('password'));
            }
            $user->save();
            return redirect('account/informations')
               ->with('status', 'Profil mis à jour');
        }
        return view('account/informations', [
            'user' => Auth::user(),
        ]);
    }

    public function subscriptions()
    {
        return view('account/subscriptions');
    }
}
