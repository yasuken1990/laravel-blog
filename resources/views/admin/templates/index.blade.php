@extends('layouts.admin_main')
@section('h1', 'テンプレート管理')
@section('title', 'テンプレート管理 | 一覧')
@section('description', 'テンプレート一覧')
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
                            <th>日付</th>
                            <th>編集</th>
                            <th>削除</th>
                        </tr>
                        @forelse($templates as $template)
                            <td>{{ $template->id }}</td>
                            <td>{{ $template->name }}</td>
                            <td>{{ $template->created_at }}</td>
                            <td><button type="button" class="btn btn-primary" value="top" onClick="location.href='{{ url('admin/template/' . $template->id . '/edit') }}'">編集</button></td>
                            <td>
                                <form action="{{ action('AdminTemplateController@destroy', $template->id) }}" method="post">
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
                            {{ $templates->appends(['sort' => 'votes'])->links() }}
                        </div>
                    </div>
                    <button type="button" class="btn btn-success btn-lg btn-block" value="top" onClick="location.href='{{ url('admin/template/create') }}'">テンプレート作成</button>

                </div>
            </div>

        </div>
    </div>
@endsection
