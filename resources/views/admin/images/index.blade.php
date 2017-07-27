@extends('layouts.admin_main')
@section('h1', '画像管理')
@section('title', '画像管理 | 一覧')
@section('description', '画像一覧')
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
                            <th>画像</th>
                            <th>画像名</th>
                            <th>日付</th>
                            <th>削除</th>
                        </tr>
                        @forelse($images as $image)
                            <td><img src="/images/{{ $image->name }}" style="width:100px;"></td>
                            <td>{{ $image->id }}</td>
                            <td>{{ $image->name }}</td>
                            <td>{{ $image->created_at }}</td>
                            <td>
                                <form action="{{ action('AdminImageController@destroy', $image->id) }}" id="form_{{ $image->id }}" method="post">
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
                            {{ $images->appends(['sort' => 'votes'])->links() }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
