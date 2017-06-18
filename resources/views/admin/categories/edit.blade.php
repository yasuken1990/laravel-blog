@extends('layouts.admin_main')
@section('h1', '記事管理')
@section('title', '記事管理 | 編集')
@section('description', '記事編集')
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
                {{Form::open(['method' => 'put', 'action' => ['AdminCategoryController@update', $category->id]])}}
                {{Form::token()}}
                <div class="box-header with-border">
                    <h3 class="box-title">カテゴリID: {{ $category->id }}</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="name">カテゴリ名</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="カテゴリ名" value="{{ old('name', $category->name) }}">
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">更新</button>
                </div>
                {{Form::close()}}
            </div>
        </div>
    </div>
@endsection
