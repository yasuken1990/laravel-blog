@extends('layouts.admin_main')
@section('h1', 'タグ管理')
@section('title', 'タグ管理 | 編集')
@section('description', 'タグ編集')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                {{Form::open(['method' => 'put', 'action' => ['Admin\TagController@update', $tag->id]])}}
                {{Form::token()}}

                <div class="box-body">
                    @if (session('success'))
                        <div class="alert alert-success" onclick="this.classList.add('hidden')">
                            {{ session('success') }}
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
                        <label for="name">タグ名</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="タグ名" value="{{ old('name', $tag->name) }}">
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
