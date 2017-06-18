@extends('layouts.admin_main')
@section('h1', '記事管理')
@section('title', '記事管理 | 登録')
@section('description', '記事登録')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                {{Form::open(['method' => 'post', 'action' => 'AdminPostController@store'])}}
                {{Form::token()}}

                <div class="box-body">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="category_id">
                            カテゴリ
                        </label>
                        {{Form::select('category_id', $category, '1')}}
                    </div>
                    <div class="form-group">
                        <label for="sitetitle">記事タイトル</label>
                        <input type="text" name="title" class="form-control" id="title" placeholder="記事タイトル" value="{{ old('title') }}">
                    </div>
                    <div class="form-group">
                        <label for="link">記事リンク</label>
                        <input type="text" name="link" class="form-control" id="link" placeholder="http://domain/[link]" value="{{ old('link') }}">
                    </div>
                    <div class="form-group">
                        <label for="content">記事本文</label>
                            <textarea id="mytextarea" name="content" value="{{ old('content') }}"></textarea>
                    </div>
                    <div class="form-group">

                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">作成</button>
                </div>
                {{Form::close()}}
            </div>
        </div>
    </div>
@endsection
