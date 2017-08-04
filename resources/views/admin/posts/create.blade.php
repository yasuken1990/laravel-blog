@extends('layouts.admin_main')
@section('h1', '記事管理')
@section('title', '記事管理 | 登録')
@section('description', '記事登録')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                {{Form::open(['method' => 'post', 'files' => true, 'action' => 'AdminPostController@store'])}}
                {{Form::token()}}

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
                        公開ステータス
                        <label for="status">
                        </label>
                        {{Form::select('status', $status, 0)}}
                    </div>
                    <div class="form-group">
                        カテゴリ
                        <label for="category_id">
                        </label>
                        {{Form::select('category_id', $category, '1')}}
                    </div>
                    <div class="form-group">
                        タグ
                        @forelse($tags as $tag)
                            <label for="{{ 'tags_' . $tag->id }}">
                                {{ $tag->name }}
                            </label>
                            {{ Form::checkbox('tags[]', $tag->id, null, ['id' => 'tags_' . $tag->id]) }}
                        @empty
                        @endforelse
                    </div>
                    <div class="form-group">
                        <label for="title">記事タイトル</label>
                        <input type="text" name="title" class="form-control" id="title" placeholder="記事タイトル"
                               value="{{ old('title') }}">
                    </div>
                    <div class="form-group">
                        <label for="link">記事リンク</label>
                        <input type="text" name="link" class="form-control" id="link" placeholder="http://domain/[link]"
                               value="{{ old('link') }}">
                    </div>
                    <div class="form-group">
                        <label for="content">記事本文</label>
                        @if (session('imgId'))
                            <textarea id="mytextarea"
                                      name="content">{{ old('content') . '<img src="/images/' . \App\Image::find(session('imgId'))->name . '"data-mce-src="/images/' . \App\Image::find(session('imgId'))->name .'">'}}</textarea>
                        @else
                            <textarea id="mytextarea" name="content">{{ old('content') }}</textarea>
                        @endif

                    </div>
                </div>


                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">作成</button>
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
