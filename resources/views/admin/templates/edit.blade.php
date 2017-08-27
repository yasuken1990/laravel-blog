@extends('layouts.admin_main')
@section('h1', 'テンプレート管理')
@section('title', 'テンプレート管理 | 編集')
@section('description', 'テンプレート編集')
@section('content')
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                {{Form::open(['method' => 'put', 'action' => ['Admin\TemplateController@update', $template->id]])}}
                {{Form::token()}}
                <div class="box-header with-border">
                    <h3 class="box-title">テンプレートID: {{ $template->id }}</h3>
                </div>
                <div class="box-body">
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

                    <div class="form-group">
                        <label for="name">テンプレート名</label>
                        <input type="text" name="name" class="form-control" id="title" placeholder="テンプレート名"
                               value="{{ old('name', $template->name) }}">
                    </div>
                    <div class="form-group">
                        <label for="js">JavaScript</label>
                        <textarea class="form-control" rows="5" id="js" placeholder="JavaScript"
                                  name="js">{{ old('js', $template->js) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="css">CSS</label>
                        <textarea class="form-control" rows="5" id="css" placeholder="CSS"
                                  name="css">{{ old('css', $template->css) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="top">トップページ</label>
                        <textarea class="form-control" rows="10" id="top" placeholder="トップページ"
                                  name="top">{{ old('top', $template->top) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="detail">詳細ページ</label>
                        <textarea class="form-control" rows="10" id="detail" placeholder="詳細ページ"
                                  name="detail">{{ old('detail', $template->detail) }}</textarea>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">更新</button>
                {{Form::close()}}
            </div>
        </div>
    </div>
    </div>
@endsection
