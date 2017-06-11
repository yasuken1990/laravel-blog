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
                            <label for="sitetitle">ユーザ名</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="サイトタイトル" value="{{ old('name', $user->name) }}">
                        </div>
                        <div class="form-group">
                            <label for="catchphrase">メールアドレス</label>
                            <input type="text" name="email" class="form-control" id="email" placeholder="キャッチフレーズ" value="{{ old('catchphrase', $user->email) }}">
                        </div>
                        <div class="form-group">
                            <label for="password">パスワード</label>
                            <input type="password" name="password" class="form-control" id="email" placeholder="キャッチフレーズ" value="{{ old('password', $user->password) }}">
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                {{Form::close()}}
            </div>
            <!-- /.box -->

        </div>
        <!--/.col (right) -->
    </div>
@endsection
