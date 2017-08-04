@extends('layouts.admin_main')
@section('h1', 'タグ管理')
@section('title', 'タグ管理 | 登録')
@section('description', 'タグ登録')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                {{Form::open(['method' => 'post', 'action' => 'AdminTagController@store'])}}
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
                        <label for="name">タグ名</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="タグ名" value="{{ old('name') }}">
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
