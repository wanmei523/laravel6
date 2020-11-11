@extends('admin.layouts.app')

@section('title')
管理员管理
@endsection

@section('sidebar')
@include('admin.adminuser.menu')
@endsection

@section('content')
@page_title(['title' => '管理员','comment'=>'管理员管理'])
    这里是一个插槽
@endpage_title

<table class="table table-sm">
  <thead class="thead-light">
    <tr>
      <th scope="col">#</th>
      <th scope="col">用户名</th>
      <th scope="col">状态</th>
      <th scope="col">时间</th>
      <th scope="col">管理</th>
    </tr>
  </thead>
  <tbody>
  @foreach($adminusers as $adminuser)
    <tr>
      <th scope="row">{{$adminuser->id}}</th>
      <td>{{$adminuser['username']}}</td>
      <td><a onclick='return confirm("确认切换吗?")' href="{{route('admin.adminuser.state',[$adminuser->id])}}">{!!$adminuser->statetext!!}</a></td>
      <td>{{$adminuser->created_at}}</td>
      <td>
      <a href="{{route('admin.adminuser.add',[$adminuser->id])}}" class="btn btn-sm btn-secondary">编辑</a>
      <a onclick='return confirm("确认删除吗?")' href="{{route('admin.adminuser.remove',[$adminuser->id])}}" class="btn btn-sm btn-danger">删除</a>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
@endsection