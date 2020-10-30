<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLogin;
use App\Models\AdminUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Logincontroller extends Controller
{
    //    //
    public function login()
    {
        return view('admin.login');
    }

    public function check(AdminLogin $request)
    {
        $data = $request->validated();
        $data['state']=AdminUser::NORMAL;
        if (!(Auth::guard('admin')->attempt($data))) {
            return back()->withErrors(['username'=>'账号不可用']);
        }
        return redirect()->route('admin.index');

        //return 123;
        //dump($is);
    }



    public function logout(){
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
