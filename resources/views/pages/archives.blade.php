@extends('layout')

@section('content')

<section role="main" class="main page">
	<article class="post">
  		<header>
    		<h2 class="page-header"><a data-pjax="" href="{{ url('/about') }}">Archives</a></h2>
  		</header>
		<section class="post-content">
            <ul>
            @foreach( $posts as $post )
                <li><a href="{{ url('/post/'.$post->slug) }}">{{ $post->title }}</a></li>
            @endforeach
            </ul>
        </section>
    </article>
</section>
@endsection
