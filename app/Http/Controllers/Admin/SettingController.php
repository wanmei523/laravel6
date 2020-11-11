<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    //系统设置表单
    public function index(Setting $setting)
    {
        $settings = $setting->orderBy('sort', 'asc')->get();
        $data = [
            'settings' => $settings
        ];
        return view('admin.setting.index', $data);
    }
    //保存配置
    public function save(Request $request, Setting $setting)
    {
        $settings = $request->input('settings');
        foreach ($settings as $key => $val) {
            $val = ($val === null) ? '' : $val;
            $setting->where('key', $key)->update(['value' => $val]);
        }
        alert('操作成功');
        return redirect()->route('admin.setting');
    }
}
