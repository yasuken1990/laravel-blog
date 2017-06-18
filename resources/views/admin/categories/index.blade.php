@extends('layouts.admin_main')
@section('h1', 'カテゴリ管理')
@section('title', 'カテゴリ管理 | 一覧')
@section('description', 'カテゴリ一覧')
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
                            <th>カテゴリ名</th>
                            <th>日付</th>
                            <th>編集</th>
                            <th>削除</th>
                        </tr>
                        @forelse($categories as $category)
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->created_at }}</td>
                            <td><button type="button" class="btn btn-primary" value="top" onClick="location.href='{{ url('admin/category/edit/' . $category->id) }}'">編集</button></td>
                            <td>
                                <form action="{{ action('AdminCategoryController@destroy', $category->id) }}" id="form_{{ $category->id }}" method="post">
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
                            {{ $categories->appends(['sort' => 'votes'])->links() }}
                        </div>
                    </div>
                    <button type="button" class="btn btn-success btn-lg btn-block" value="top" onClick="location.href='{{ url('admin/category/create') }}'">カテゴリ作成</button>

                </div>
            </div>

        </div>
    </div>
@endsection
