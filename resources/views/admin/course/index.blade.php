@extends('admin.layouts.app')

@section('title')
课程管理
@endsection

@section('sidebar')
@include('admin.course.menu')
@endsection

@section('content')
@page_title(['title' => '课程管理','comment'=>'管理你的课程'])
    这里是一个插槽
@endpage_title

@endsection