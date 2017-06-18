@extends('layouts.admin_main')
@section('h1', 'パスワード管理')
@section('title', '管理画面 | パスワード管理')
@section('description', 'パスワード変更')
@section('content')
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                @if (session('success'))
                    <div class="alert alert-success" onclick="this.classList.add('hidden')">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger" onclick="this.classList.add('hidden')">
                        {{ session('error') }}
                    </div>
                @endif
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            <!-- /.box-header -->
                <!-- form start -->
                {{Form::open(['method' => 'put', 'action' => 'AdminPasswordController@update'])}}
                {{Form::token()}}
                <div class="box-body">
                    <div class="form-group">
                        <label for="password">パスワード</label>
                        <input type="password" name="password" class="form-control" id="password" placeholder="パスワード" value="{{ $user->passwords }}">
                    </div>
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">更新</button>
                    <a href="{{ url('admin/user') }}">ユーザ管理</a>
                </div>
                {{Form::close()}}
            </div>
            <!-- /.box -->

        </div>
        <!--/.col (right) -->
    </div>
@endsection
