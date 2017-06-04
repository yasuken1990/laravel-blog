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
                <div class="box-header with-border">
                    <h3 class="box-title">-</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                {{Form::open(['method' => 'put', 'action' => 'AdminBasicController@update'])}}
                {{Form::token()}}
                <div class="box-body">
                        <div class="form-group">
                            <label for="sitetitle">サイトタイトル</label>
                            <input type="text" name="sitetitle" class="form-control" id="sitetitle" placeholder="サイトタイトル" value="{{ old('sitetitle', $basics->sitetitle) }}">
                        </div>
                        <div class="form-group">
                            <label for="catchphrase">キャッチフレーズ</label>
                            <input type="text" name="catchphrase" class="form-control" id="catchphrase" placeholder="キャッチフレーズ" value="{{ old('catchphrase', $basics->catchphrase) }}">
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
