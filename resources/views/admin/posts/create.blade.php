@extends('layouts.admin_main')
@section('h1', '記事管理')
@section('title', '記事管理 | 登録')
@section('description', '記事登録')
@section('content')
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                {{Form::open(['method' => 'post', 'action' => 'AdminPostController@store'])}}
                {{Form::token()}}
                <div class="box-header with-border">
                    <h3 class="box-title">-</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->

                <div class="box-body">
                    <div class="form-group">
                        <label for="sitetitle">記事タイトル</label>
                        <input type="text" name="title" class="form-control" id="title" placeholder="記事タイトル">
                    </div>
                    <div class="form-group">
                        <label for="link">記事リンク</label>
                        <input type="text" name="link" class="form-control" id="link" placeholder="http://domain/[link]">
                    </div>
                    <div class="form-group">
                        <label for="contents">記事本文</label>
                            <textarea id="mytextarea" name="contents">Hello, World!</textarea>
                    </div>
                    <div class="form-group">

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
