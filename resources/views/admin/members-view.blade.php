@extends('layouts.adminlte')

@section('title', 'View User')
@section('pageTitle', 'View User')
@section('pageDesc', 'sample desc')

@section('content')
<div class="box">
       
    <div class="box-body" style="padding:30px">     
       
      
        <div class="form-group">
            <label for="usertype">User type:</label>
            <span>{{ $userInfo->usertype }}</span>
        </div>
        <div class="form-group">
            <label for="name">Name:</label>
            <span>{{ $userInfo->name }}</span>
        </div>
        <div class="form-group">
            <label for="email">Email address:</label>
            <span>{{ $userInfo->email }}</span>
        </div>
           
    </div>
</div>
@endsection


