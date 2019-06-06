@extends('layouts.adminlte')

@section('title', 'Edit User')
@section('pageTitle', 'Edit User')
@section('pageDesc', 'sample desc')

@section('content')
<div class="box">
       
    <div class="box-body" style="padding:30px">     
        {{-- display the success and error messages --}}
        @include('admin.includes.messages')
        
        <form action="{{ url('/admin/users/'.$userInfo->id) }}" method="POST" autocomplete="off">
            @csrf
            @method("PUT")
            <div class="form-group">
                <label for="usertype">User type:</label>
                <select class="form-control" name="usertype" id="usertype">
                    <option value="">Select</option>
                    <option value="admin" @if ($userInfo->usertype=="admin") selected  @endif>Admin</option>
                    <option value="user" @if ($userInfo->usertype=="user") selected  @endif>User</option>
                </select>
            </div>
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" name="name" id="name" value="{{ $userInfo->name }}">
            </div>
            <div class="form-group">
                <label for="email">Email address:</label>
                <input type="email" class="form-control" name="email" id="email" value="{{ $userInfo->email }}" autocomplete="nope">
            </div>
           <div class="form-group">
                <label for="status">Status:</label>
                <select class="form-control" name="status" id="status">
                    <option value="">Select</option>
                    <option value="1" @if ($userInfo->status=="1") selected  @endif>Active</option>
                    <option value="0" @if ($userInfo->status=="0") selected  @endif>Deactive</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary hvr-glow">Update</button>
        </form>
    </div>
</div>
@endsection


