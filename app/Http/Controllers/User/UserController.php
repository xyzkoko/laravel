<?php

namespace App\Http\Controllers\User;

use App\Model\User;
use App\Model\UserRole;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;

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
            $userRoleList = UserRole::where('disabled','<>',1)->orderBy('listorder','desc')->get();
            return view('user.userAdd', ['userRoleList' => $userRoleList]);
        }elseif($request->isMethod('post')){        //表单请求
            return $this->addPost($request);
        }
    }
    private function addPost($request){
        $this->validate($request, [
            'name' => 'bail|required|unique:users|max:255',
            'email' => 'bail|required|unique:users|max:255|email',
            'password' => 'bail|required|max:255'
        ],[
            'name.required' => '姓名不能为空',
            'name.unique' => '姓名不能重复',
            'name.max' => '姓名最大长度为255',
            'email.required' => '邮箱不能为空',
            'email.unique' => '邮箱不能重复',
            'email.max' => '邮箱最大长度为255',
            'email.email' => '邮箱格式不对',
            'password.required' => '密码不能为空',
            'password.max' => '密码最大长度为255'
        ]);
        $data = ['status' => 'success','msg' => '添加成功'];
        $userInfo = new User;
        $userInfo->name = $request->input('name');
        $userInfo->roleid = $request->input('roleid');
        $userInfo->email = $request->input('email');
        $userInfo->password = bcrypt($request->input('password'));
        $result = $userInfo->save();
        if(!$result){
            $data['status'] = 'fail';
            $data['msg'] = '添加失败';
        }
        return json_encode($data);
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
            $userRoleList = UserRole::where('disabled','<>',1)->orderBy('listorder','desc')->get();
            return view('user.userUpdate',['userInfo' => $userInfo,'userRoleList' => $userRoleList]);
        }elseif($request->isMethod('post')){        //表单请求
            return $this->updatePost($request,$id);
        }
    }
    private function updatePost($request,$id){
        $this->validate($request, [
            'name' => ['required',Rule::unique('users')->ignore($id),'max:255']
        ],[
            'name.required' => '姓名不能为空',
            'name.unique' => '姓名不能重复',
            'name.max' => '姓名最大长度为255'
        ]);
        $data = ['status' => 'success','msg' => '修改成功'];
        $userInfo = User::find($id);
        $userInfo->name = $request->input('name');
        $userInfo->roleid = $request->input('roleid');
        $result = $userInfo->save();
        if(!$result){
            $data['status'] = 'fail';
            $data['msg'] = '修改失败';
        }
        return json_encode($data);
    }
    /**
     * 删除指定用户
     *
     * @param int $id
     * @return json
     */
    public function delete($id)
    {
        $result = User::destroy($id);
        if($result){
            return Redirect::back()->with('message', '删除成功！');
        }
    }
}
