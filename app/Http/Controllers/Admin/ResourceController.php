<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResourceWrite;
use App\Models\File;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use stdClass;

class ResourceController extends Controller
{
    //列表
    public function index(Resource $resource, Request $request)
    {
        $resource = $resource->with('adminUser');
        $search = new stdClass;
        $search->keyword = $request->input('keyword', '');
        $search->adminuser_id = $request->input('adminuser_id', '');
        $search->type = $request->input('type', null);
        if ($search->keyword) {
            $resource = $resource->where('title', 'like', "%{$search->keyword}%");
        }
        if ($search->adminuser_id) {
            $resource = $resource->where('adminuser_id', $search->adminuser_id);
        }
        if ($search->type) {
            $resource = $resource->whereIn('type', $search->type);
        }
        $resources = $resource->orderBy('id', 'desc')->paginate(setting('page_resource'));
        $data = [
            'resources' => $resources,
            'search' => $search
        ];
        return view('admin.resource.index', $data);
    }
    //添加编辑
    public function add(Request $request, Resource $resource)
    {
        $type = $resource->id ? $resource->type : $request->input('type');
        $data = [
            'type' => $type,
            'resource' => $resource,
        ];
        return view('admin.resource.add', $data);
    }
    //保存资源
    public function save(ResourceWrite $request, Resource $resource)
    {
        $data = $request->validated();
        $data['adminuser_id'] = Auth::guard('admin')->id();
        DB::transaction(function () use ($resource, $data) {
            //根据资源类型，动态指定关联方法
            switch ($data['type']) {
                case \App\Models\Resource::VIDEO:
                    $relation = 'resourceVideo';
                    break;
                case \App\Models\Resource::DOC:
                    $relation = 'resourceDoc';
                    break;
                default:
                    abort('403', '无效的type类型');
            }
            if ($resource->id) {
                $resource->update($data);
                $resource->{$relation}->update($data);
            } else {
                $resource->create($data)->{$relation}()->create($data);
            }
        });
        alert('添加成功');
        return redirect()->route('admin.resource');
    }
    //软删除移除资源
    public function remove(Request $request, Resource $resource)
    { 
        //此处应该做一个判断，资源如果被使用，则禁止删除
        $resource->delete();
        alert('删除成功');
        return redirect()->route('admin.resource');
    }
    //上传图片
    public function up(Request $request, File $fileModel)
    {
        $result = [
            'success' => false,
            'msg' => '尚未实现上传',
            'file_path' => '',
        ];
        //检查是否上传了文件
        if (!$request->hasFile('image_file')) {
            $result['msg'] = '未选择文件';
            return response()->jsan($result);
        }
        //获取文件对象
        $file = $request->file('image_file');

        //检查文件有效性
        if (!$file->isValid()) {
            $result['msg'] = $file->getErrorMessage();
            return response()->jsan($result);
        }
        //检查文件类型
        if (!in_array($file->extension(), config('project.upload.image'))) {
            $result['msg'] = '不被允许的文件类型';
            return response()->jsan($result);
        }
        //保存图片
        $file_path = $file->store('doc', 'public');
        //插入数据库
        $fileModel = $fileModel->saveFile('doc_editor', $file_path, $file);
        //通知编辑器上传成功
        $result['success'] = true;
        $result['file_path'] = $fileModel->file_link;

        return $result;
    }
}
