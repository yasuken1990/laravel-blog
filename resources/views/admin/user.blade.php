@extends('layouts.admin_main')
@section('h1', 'ユーザ管理')
@section('title', '管理画面 | ユーザ管理')
@section('description', '確認 / 編集')
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
                {{Form::open(['method' => 'put', 'action' => 'AdminUserController@update'])}}
                {{Form::token()}}
                <div class="box-body">
                        <div class="form-group">
                            <label for="name">ユーザ名</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="ユーザ名" value="{{ old('name', $user->name) }}">
                        </div>
                        <div class="form-group">
                            <label for="email">メールアドレス</label>
                            <input type="text" name="email" class="form-control" id="email" placeholder="メールアドレス" value="{{ old('email', $user->email) }}">
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">更新</button>
                        <a href="{{ url('admin/password') }}">パスワード変更</a>
                    </div>
                {{Form::close()}}
            </div>
            <!-- /.box -->

        </div>
        <!--/.col (right) -->
    </div>
@endsection
