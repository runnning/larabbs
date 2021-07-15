@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="col-md-8 offset-md-2">

            <div class="card">
                <div class="card-header">
                   <h4>
                       <i class="glyphicon glyphicon-edit"></i>编辑个人资料
                   </h4>
                </div>
                <div class="card-body">
                    <form action="{{route('users.update',$user->id)}}" method="post" accept-charset="UTF-8">
                        @method('PUT')
                        @csrf
                        @include('shared._error')
                        <div class="form-group">
                            <label for="name">用户名</label>
                            <input type="text" id="name" class="form-control" name="name" value="{{old('name',$user->name)}}">
                        </div>
                        <div class="form-group">
                            <label for="email">邮箱</label>
                            <input type="email" id="email" class="form-control" name="email" value="{{old('email',$user->email)}}">
                        </div>
                        <div class="form-group">
                            <label for="introduction">个人简介</label>
                            <textarea id="introduction" name="introduction" class="form-control" rows="3">
                            {{old('introduction',$user->introduction)}}
                        </textarea>
                        </div>
                        <div class="well well-sm">
                            <button type="submit" class="btn btn-primary">
                                保存
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection