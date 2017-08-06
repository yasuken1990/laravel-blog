@extends('layouts.common')
@section('title', $site->title)
@section('head')
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{ $site->title }}</title>

{!! \File::get(public_path('css/main.css')) !!}

@endsection
@section('body')

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-custom navbar-fixed-top">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    Menu <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="/">Start Bootstrap</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="/">Home</a>
                    </li>
                    <li>
                        <a href="/">About</a>
                    </li>
                    <li>
                        <a href="/">Sample Post</a>
                    </li>
                    <li>
                        <a href="/">Contact</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Header -->
    <!-- Set your background image for this header on the line below. -->
    <header class="intro-header" style="background-image: url('startbootstrap-clean-blog-gh-pages/img/post-bg.jpg')">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <div class="post-heading">
                        <h1>{!! $post->title !!}</h1>
                        <h2 class="subheading">カテゴリ：{!! $post->category->name !!}</h2>
                        <h3 class="subheading">タグ：
                            @forelse($tags as $tag)
                                @if(in_array($tag->id, $selectedTags))
                                    {{ $tag->name . ' ' }}
                                @endif
                            @empty
                            @endforelse
                        </h3>
                        <span class="meta">Posted by <a href="#"></a>{{ $post->created_at }}</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Post Content -->
    <article>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    {!! $post->content !!}
                </div>
            </div>
        </div>
    </article>

    <hr>

    <!-- Post Comment -->

    <article>
        <div class="container">
            <h3>コメント</h3>
            <ul>
                @forelse ($post->comments as $comment)
                    <li>
                        {{ $comment->name }}: {{ $comment->body }}
                    </li>
                @empty
                    <li>No comment yet</li>
                @endforelse
            </ul>
            <form method="post" action="{{ action('CommentController@store', $post->id) }}">
                {{ csrf_field() }}
                <p>
                    <input type="text" name="name" placeholder="名前" value="{{ old('name') }}">
                    @if ($errors->has('name'))
                        <span class="error">{{ $errors->first('name') }}</span>
                    @endif
                </p>
                <p>
                    <input type="text" name="body" placeholder="コメント内容" value="{{ old('body') }}">
                    @if ($errors->has('body'))
                        <span class="error">{{ $errors->first('body') }}</span>
                    @endif
                </p>
                <p>
                    <input type="submit" value="投稿">
                </p>
            </form>
        </div>
    </article>

    <hr>


    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <ul class="list-inline text-center">
                        <li>
                            <a href="#">
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-github fa-stack-1x fa-inverse"></i>
                                </span>
                            </a>
                        </li>
                    </ul>
                    <p class="copyright text-muted">Copyright © Your Website 2016</p>
                </div>
            </div>
        </div>
    </footer>

{!! \File::get(public_path('js/main.js')) !!}

@endsection