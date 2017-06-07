@extends('layouts.admin_main')
@section('h1', '記事管理')
@section('title', '記事管理 | 一覧')
@section('description', '記事一覧')
@section('content')
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Content</th>
                            <th>編集</th>
                            <th>削除</th>
                        </tr>
                        @foreach($posts as $post)
                        <tr>
                            <td>{{ $post->id }}</td>
                            <td>{{ $post->name }}</td>
                            <td>{{ $post->created_at }}</td>
                            <td><span class="label label-primary">Approved</span></td>
                            <td>{{ $post->content }}</td>
                            <td><button type="button" class="btn btn-primary" value="top" onClick="location.href='{{ url('admin/posts/edit/' . $post->id) }}'">編集</button></td>
                            <td><button type="button" class="btn btn-danger">削除</button></td>
                        </tr>
                        @endforeach
                        <tr>
                            <td>{{ $post['id']+1 }}</td>
                            <td>Unknown</td>
                            <td>{{ 'now!' }}</td>
                            <td><span class="label label-{{ 'primary' }}">新規作成</span></td>
                            <td>New</td>
                            <td><button type="button" class="btn btn-primary" value="top" onClick="location.href='{{ url('admin/posts/create') }}'">作成</button></td>
                            <td></td>
                        </tr>
                        </tbody></table>
                </div>
            </div>

        </div>
    </div>
@endsection
