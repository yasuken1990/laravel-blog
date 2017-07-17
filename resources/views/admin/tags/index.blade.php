@extends('layouts.admin_main')
@section('h1', 'タグ管理')
@section('title', 'タグ管理 | 一覧')
@section('description', 'タグ一覧')
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
                            <th>タグ名</th>
                            <th>日付</th>
                            <th>編集</th>
                            <th>削除</th>
                        </tr>
                        @forelse($tags as $tag)
                            <td>{{ $tag->id }}</td>
                            <td>{{ $tag->name }}</td>
                            <td>{{ $tag->created_at }}</td>
                            <td>
                                <button type="button" class="btn btn-primary" value="top"
                                        onClick="location.href='{{ url('admin/tag/edit/' . $tag->id) }}'">編集
                                </button>
                            </td>
                            <td>
                                <form action="{{ action('AdminTagController@destroy', $tag->id) }}"
                                      id="form_{{ $tag->id }}" method="post">
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
                            @if(count($tags) === 0)
                            @else
                                {{ $tags->appends(['sort' => 'votes'])->links() }}
                            @endif
                        </div>
                    </div>
                    <button type="button" class="btn btn-success btn-lg btn-block" value="top"
                            onClick="location.href='{{ url('admin/tag/create') }}'">タグ作成
                    </button>

                </div>
            </div>

        </div>
    </div>
@endsection
