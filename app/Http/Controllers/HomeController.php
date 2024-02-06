<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;



class HomeController extends Controller
{


    public function index(){

        if(Auth::id())
        {
            $usertype = Auth()->user()->user_type;
            // dd(  $usertype );
            if( $usertype == 'user')
            {
                return view('dashboard');
            }
            elseif( $usertype == 'admin')
            {
                return view('admin.dashboard');
            }
            elseif( $usertype == 'manager')
            {
                return view('writer.dashboard');
            }
        }
    }

    public function post (){
        return view('admin.post');
    }
}
