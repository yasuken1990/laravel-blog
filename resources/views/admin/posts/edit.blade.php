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
                        カテゴリ
                        <label for="category_id">
                        </label>
                        @if ($post->category)
                            {{Form::select('category_id', $category, $post->category->id)}}
                        @else
                            {{Form::select('category_id', $category, 1) }}
                        @endif
                    </div>
                    <div class="form-group">
                        タグ
                        @forelse($tags as $tag)
                            <label for="{{ 'tags_' . $tag->id }}">
                                {{ $tag->name }}
                            </label>
                            @if(in_array($tag->id, $selectedTags))
                                {{ Form::checkbox('tags[]', $tag->id, true, ['id' => 'tags_' . $tag->id]) }}
                            @else
                                {{ Form::checkbox('tags[]', $tag->id, null, ['id' => 'tags_' . $tag->id]) }}
                            @endif
                        @empty
                        @endforelse
                    </div>
                    <div class="form-group">
                        公開ステータス
                        <label for="status">
                        </label>
                        @if ($post->status)
                            {{Form::select('status', $status, $post->status)}}
                        @else
                            {{Form::select('status', $status, 0) }}
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="title">記事タイトル</label>
                        <input type="text" name="title" class="form-control" id="title" placeholder="記事タイトル"
                               value="{{ old('title', $post->title) }}">
                    </div>
                    <div class="form-group">
                        <label for="link">記事リンク</label>
                        <input type="text" name="link" class="form-control" id="link" placeholder="http://domain/[link]"
                               value="{{ old('link', $post->link) }}">
                    </div>
                    <div class="form-group">
                        <label for="content">記事本文</label>
                        @if (session('uploadImagePath'))
                            <textarea id="mytextarea" name="content">{{ old('content', $post->content . session('uploadImagePath')) }}</textarea>
                        @else
                            <textarea id="mytextarea" name="content">{{ old('content', $post->content) }}</textarea>

                        @endif
                    </div>
                    <div class="form-group">

                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">更新</button>
                    <td>
                        <button type="button" class="btn btn-info" value="top"
                                onClick="location.href='{{ url('/' . $post->link) }}'">確認
                        </button>
                    </td>
                    {{Form::close()}}
                    <hr>
                    {{Form::open(['method' => 'post', 'action' => ['AdminImageController@store'], 'files' => true])}}
                    {{Form::token()}}
                    {!! Form::label('fileName', 'アップロード') !!}
                    {!! Form::file('fileName') !!}
                    {!! Form::submit('アップロードする') !!}
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>
@endsection
