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
                            <th>ステータス</th>
                            <th>タイトル</th>
                            <th>本文</th>
                            <th>日付</th>
                            <th>編集</th>
                            <th>削除</th>
                        </tr>
                        @forelse($posts as $post)
                            <td>{{ $post->id }}</td>
                            <td><span class="label label-primary">Approved</span></td>
                            <td>{{ $post->title }}</td>
                            <td>{{ mb_strimwidth(strip_tags($post->content), 0, 30, '...', 'UTF-8') }}</td>
                            <td>{{ $post->created_at }}</td>
                            <td><button type="button" class="btn btn-primary" value="top" onClick="location.href='{{ url('admin/posts/edit/' . $post->id) }}'">編集</button></td>
                            <td>
                                <form action="{{ action('AdminPostController@destroy', $post->id) }}" id="form_{{ $post->id }}" method="post">
                                    {{ method_field('delete') }}
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-danger">削除</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        @endforelse
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><button type="button" class="btn btn-primary" value="top" onClick="location.href='{{ url('admin/posts/create') }}'">作成</button></td>
                        </tr>
                        </tbody></table>
                </div>
            </div>

        </div>
    </div>
@endsection
