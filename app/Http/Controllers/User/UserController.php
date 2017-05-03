<?php

namespace App\Http\Controllers\User;

use App\Model\User;
use App\Model\UserRole;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * 登录验证
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 用户列表
     * @return view
     */
    public function index()
    {
        $userList = User::with('userRole')->get()->toArray();
        return view('user.user', ['userList' => $userList]);
    }
    /**
     * 添加用户
     *
     * @param Request $request
     * @return json
     */
    public function add(Request $request)
    {
        if($request->isMethod('get')){      //跳转页面
            $userRoleList = UserRole::where('disabled','<>',1)->get();
            return view('user.userAdd', ['userRoleList' => $userRoleList]);
        }elseif($request->isMethod('post')){        //表单请求
            $userInfo = new User;;
            $userInfo->name = $request->input('name');
            $userInfo->roleid = $request->input('roleid');
            $userInfo->email = $request->input('email');
            $userInfo->password = bcrypt($request->input('password'));
            $userInfo->save();
            $data['status'] = 'success';
            $data['msg'] = '添加成功';
            return json_encode($data);
        }
    }
    /**
     * 更新指定用户
     *
     * @param Request $request
     * @param int $id
     * @return json
     */
    public function update(Request $request,$id)
    {
        if($request->isMethod('get')){      //跳转页面
            $userInfo = User::with('userRole')->find($id);
            $userRoleList = UserRole::where('disabled','<>',1)->get();
            return view('user.userUpdate',['userInfo' => $userInfo,'userRoleList' => $userRoleList]);
        }elseif($request->isMethod('post')){        //表单请求
            $userInfo = User::find($id);
            $userInfo->name = $request->input('name');
            $userInfo->roleid = $request->input('roleid');
            $userInfo->save();
            $data['status'] = 'success';
            $data['msg'] = '修改成功';
            return json_encode($data);
        }
    }
}
