<?php

namespace App\Http\Controllers\User;

use App\Model\UserRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserRoleController extends Controller
{
    /**
     * 登录验证
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
    public function index()
    {
        $userRoleList = UserRole::all()->toArray();
        return view('user.userRole', ['userRoleList' => $userRoleList]);
    }
    public function show(){
        $userRoleList = UserRole::all()->toArray();
        return view('user.userRole', ['userRoleList' => $userRoleList]);
    }
}
