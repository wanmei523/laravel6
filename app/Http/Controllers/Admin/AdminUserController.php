<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminUserRequest;
use App\Models\AdminUser;
use App\Models\Flight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    //列表
    public function index(AdminUser $adminuser)
    {
        $adminusers = $adminuser->orderBy('id', 'desc')->get();
        $data = [
            'adminusers' => $adminusers
        ];
        return view('admin.adminuser.index', $data);
    }
    //添加编辑
    public function add(AdminUser $adminuser)
    {
        $data = [
            'adminuser' => $adminuser
        ];
        return view('admin.adminuser.add', $data);
    }
    //保存
    public function save(AdminUserRequest $request, AdminUser $adminuser)
    {
        $this->authorizeForUser(Auth::guard('admin')->user(),'modify',$adminuser);
        $data = $request->validated();

        //添加和编辑模式的适配
        if ($adminuser->id) {
            //如果输入密码，就加密保存，否则略过
            if ($data['password']) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }
            $adminuser->update($data);
        } else {
            //添加模式，管理员的状态和密码必须有
            $data['password'] = Hash::make($data['password']);
            $data['state'] = AdminUser::NORMAL;
            $adminuser->create($data);
        }
        alert('管理员操作成功');
        return redirect()->route('admin.adminuser');
    }
    //软删除
    public function remove(AdminUser $adminuser)
    {
        $this->authorizeForUser(Auth::guard('admin')->user(),'remove',$adminuser);
        $adminuser->delete();
        //提示
        alert('操作成功');
        //跳转
        return back();
    }
    //用户状态切换
    public function state(AdminUser $adminuser)
    {
        /*         if($adminuser->state==AdminUser::NORMAL){
            $adminuser->state=0;
        }else{
            $adminuser->state=1;
        }; */
        $this->authorizeForUser(Auth::guard('admin')->user(),'remove',$adminuser);
        //填入反向
        $new_state = $adminuser->state == AdminUser::NORMAL ? AdminUser::BAN : AdminUser::NORMAL;
        //新状态赋值
        $adminuser->state = $new_state;
        //写入
        $adminuser->save();
        //提示
        alert('操作成功');
        //跳转
        return back();
    }
}
