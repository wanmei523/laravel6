<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResourceWrite;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use stdClass;

class ResourceController extends Controller
{
    //列表
    public function index(Resource $resource,Request $request){
        $resource = $resource->with('adminUser');
        $search = new stdClass;
        $search->keyword = $request->input('keyword','');
        $search->adminuser_id = $request->input('adminuser_id','');
        $search->type = $request->input('type',null);
        if($search->keyword){
            $resource = $resource -> where('title','like',"%{$search->keyword}%");
        }
        if($search->adminuser_id){
            $resource = $resource-> where('adminuser_id',$search->adminuser_id);
        }
        if($search->type){
            $resource = $resource -> whereIn('type',$search->type);
        }
        $resources = $resource->orderBy('id', 'desc')->paginate(setting('page_resource'));
        $data = [
            'resources'=>$resources,
            'search'=>$search
        ];
        return view('admin.resource.index',$data);
    }
    //添加编辑
    public function add(Request $request ,Resource $resource){
        $type = $request->input('type');
        $data=[
            'type'=>$type,
        ];
        return view('admin.resource.add',$data);
    }
    //保存资源
    public function save(ResourceWrite $request ,Resource $resource){
        $data=$request->validated();
        $data['adminuser_id']=Auth::guard('admin')->id();
        DB::transaction(function()use($resource,$data){
            //根据资源类型，动态指定关联方法
            switch($data['type']){
                case \App\Models\Resource::VIDEO:
                    $relation = 'resourceVideo';
                break;
                case \App\Models\Resource::DOC:
                    $relation = 'resourceDoc';
                break;
                default:
                abort('403','无效的type类型');
            }
            $resource->create($data)->{$relation}()->create($data);
        });
        alert('添加成功');
        return redirect()->route('admin.resource');
    }
    //软删除移除资源
    public function remove(Request $request ,Resource $resource){

    }
    //上传图片
    public function up(Request $request){

    }
}
