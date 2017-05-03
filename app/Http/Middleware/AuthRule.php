<?php

namespace App\Http\Middleware;

use App\Model\User;
use App\Model\Route;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route as RouteName;

class AuthRule
{
    protected $button = [];
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //验证权限
        $id = Auth::id();
        $user = User::with('userRole')->find($id)->toArray();
        $rule = $user['user_role']['rule'];
        $path = RouteName::currentRouteName();       //路由名称
        if($rule != 'all'){
            $route = Route::where('route',$path)->first();
            $ruleArray = explode(',',$rule);
            if(!in_array($route->id,$ruleArray)){
                return redirect('/');
            }
        }
        //返回页面按钮
        view()->share('buttonList', $this->getButton($rule,$path));
        return $next($request);
    }

    private function getButton($rule,$path){
        $parentid = Route::where('route',$path)->first(['id']);
        if($rule == 'all'){
            $buttons = Route::where('parentid',$parentid->id)->get();
        }else{
            $ruleArray = explode(',',$rule);
            $buttons = Route::where('parentid',$parentid->id)->whereIn('id',$ruleArray)->get();
        }
        foreach ($buttons as $button) {
            $this->button[$button->id]['name'] = $button->name;
            $this->button[$button->id]['route'] = $button->route;
        }
        return $this->button;
    }
}
