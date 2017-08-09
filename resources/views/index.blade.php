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
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    Menu <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="{{ url('/') }}">Start Bootstrap</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="{{ url('/') }}">Home</a>
                    </li>
                    <li>
                        <a href="{{ url('/') }}">About</a>
                    </li>
                    <li>
                        <a href="{{ url('/') }}">Sample Post</a>
                    </li>
                    <li>
                        <a href="{{ url('/') }}">Contact</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Header -->
    <!-- Set your background image for this header on the line below. -->
    <header class="intro-header" style="background-image: url('/startbootstrap-clean-blog-gh-pages/img/home-bg.jpg')">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <div class="site-heading">
                        <h1>{{ $site->title }}</h1>
                        <hr class="small">
                        <span class="subheading">{{ $site->phrase }}</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                @forelse($posts as $post)
                <div class="post-preview">
                    <a href="{{ url('/' . $post->link) }}">
                        <h2 class="post-title">
                            {{ $post->title }}
                        </h2>
                    </a>
                        <h3 class="post-subtitle">
                            {{ mb_strimwidth(strip_tags($post->content), 0, 200, '...', 'UTF-8') }}
                        </h3>
                    <p class="post-meta">投稿日時 : {{ $post->created_at }}</p>
                </div>
                <hr>
                @empty
                    none
                @endforelse
                <!-- Pager -->
                <ul class="pager">
                        {{ $posts->appends(['sort' => 'votes'])->links() }}
                </ul>
            </div>
        </div>
    </div>

    <hr>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <ul class="list-inline text-center">
                        <li>
                            <a href="https://twitter.com/yasuken1990" target="_blank">
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.facebook.com/yasuken1990" target="_blank">
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="https://github.com/yasuken1990" target="_blank">
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