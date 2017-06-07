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
                <div class="box-header with-border">
                    <h3 class="box-title">-</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->

                <div class="box-body">
                    <div class="form-group">
                        <h1>TinyMCE Quick Start Guide</h1>
                        <form method="post">
                            <textarea id="mytextarea">Hello, World!</textarea>
                        </form>
                    </div>
                    <div class="form-group">
                    </div>
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                </div>
            </div>
            <!-- /.box -->

        </div>
        <!--/.col (right) -->
    </div>
@endsection
