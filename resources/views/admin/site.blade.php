@extends('layouts.admin_main')
@section('h1', 'サイト管理')
@section('title', '管理画面 | サイト管理')
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
                {{Form::open(['method' => 'put', 'action' => 'AdminSiteController@update'])}}
                {{Form::token()}}
                <div class="box-body">
                        <div class="form-group">
                            <label for="title">サイトタイトル</label>
                            <input type="text" name="title" class="form-control" id="sitetitle" placeholder="サイトタイトル" value="{{ old('title', $site->title) }}">
                        </div>
                        <div class="form-group">
                            <label for="catchphrase">キャッチフレーズ</label>
                            <input type="text" name="phrase" class="form-control" id="phrase" placeholder="キャッチフレーズ" value="{{ old('phrase', $site->phrase) }}">
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">更新</button>
                    </div>
                {{Form::close()}}
            </div>
            <!-- /.box -->

        </div>
        <!--/.col (right) -->
    </div>
@endsection
