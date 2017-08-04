@extends('layouts.admin_main')
@section('h1', 'コメント管理')
@section('title', 'コメント管理 | 一覧')
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
                            <th>名前</th>
                            <th>本文</th>
                            <th>日付</th>
                            <th>削除</th>
                        </tr>
                        @forelse($comments as $comment)
                            <td>{{ $comment->id }}</td>
                            <td>{{ $comment->name }}</td>
                            <td>{{ $comment->body }}</td>
                            <td>{{ $comment->created_at }}</td>
                            <td>
                                <form action="{{ action('AdminCommentController@destroy', $comment->id) }}" id="form_{{ $comment->id }}" method="post">
                                    {{ method_field('delete') }}
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-danger">削除</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        @endforelse
                        </tbody>
                    </table>
                    <div class="text-center">
                        <div>
                            {{ $comments->appends(['sort' => 'votes'])->links() }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
