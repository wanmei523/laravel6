@extends('admin.layouts.app')

@section('title')
课程管理-添加
@endsection

@section('sidebar')
@include('admin.course.menu')
@endsection

@section('content')
@page_title(['title' => '课程添加','comment'=>'添加您的课程'])
    这里是一个插槽
@endpage_title

<div class="row">
    <div class="col-12">
        <form action="{{route('admin.course.add',[$course->id])}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group row">
                <label class="col-2 col-form-label">标题</label>
                <div class="col-10">
                    <input type="text" class="form-control" name="title" value="{{old('title',$course->title)}}">
                    @error('title')
                    <small class="form-text text-danger">{{$message}}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-2 col-form-label">简介</label>
                <div class="col-10">
                    <textarea name="desc" class="form-control">{{old('desc',$course->desc)}}</textarea>
                    @error('desc')
                    <small class="form-text text-danger">{{$message}}</small>
                    @enderror
                </div>
            </div>
            
            <div class="form-group row">
                <label class="col-2 col-form-label">排序</label>
                <div class="col-10">
                    <input type="text" class="form-control" name="sort" value="{{old('sort',$course->sort)}}">
                    @error('sort')
                    <small class="form-text text-danger">{{$message}}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-2 col-form-label">头图</label>
                <div class="col-8">
                    <input type="file" name="image" class="form-control-file">
                    @error('image')
                    <small class="form-text text-danger">{{$message}}</small>
                    @else
                    <small class="form-text text-muted">可选上传，建议使用800*600大小的头图</small>
                    @enderror
                </div>
                <div class="col-2"><img src="{{$course->image_link}}" class="img-fluid"></div>
            </div>
            
            <div class="form-group row">
                <div class="offset-2"></div>
                <div class="col-10">
                    <button type="submit" class="btn btn-primary">保存</button>
                </div>
            </div>
            
        </form>
    </div>
</div>
@endsection