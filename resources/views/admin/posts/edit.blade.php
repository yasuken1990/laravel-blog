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
                {{Form::open(['method' => 'put', 'action' => ['AdminPostController@update', $post->id]])}}
                {{Form::token()}}
                <div class="box-header with-border">
                    <h3 class="box-title">記事ID: {{ $post->id }}</h3>
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
                        <label for="category_id">
                            カテゴリ
                        </label>
                        @if ($post->category)
                            {{Form::select('category_id', $category, $post->category->id)}}
                        @else
                            {{Form::select('category_id', $category, 1) }}
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="status">
                            公開ステータス
                        </label>
                        @if ($post->status)
                            {{Form::select('status', $status, $post->status)}}
                        @else
                            {{Form::select('status', $status, 0) }}
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="sitetitle">記事タイトル</label>
                        <input type="text" name="title" class="form-control" id="title" placeholder="記事タイトル" value="{{ old('title', $post->title) }}">
                    </div>
                    <div class="form-group">
                        <label for="link">記事リンク</label>
                        <input type="text" name="link" class="form-control" id="link" placeholder="http://domain/[link]" value="{{ old('link', $post->link) }}">
                    </div>
                    <div class="form-group">
                        <label for="content">記事本文</label>
                        <textarea id="mytextarea" name="content">{{ old('content', $post->content) }}</textarea>
                    </div>
                    <div class="form-group">

                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">更新</button>
                    <td><button type="button" class="btn btn-info" value="top" onClick="location.href='{{ url('/' . $post->link) }}'">確認</button></td>
                </div>
                {{Form::close()}}
            </div>
        </div>
    </div>
@endsection
