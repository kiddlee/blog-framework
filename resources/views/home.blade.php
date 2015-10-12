@extends('layout')

@section('content')

<section role="main" class="main index">
@if ( !count($posts) )
There is no post till now. Login and write a new post now!!!
@else
<ul class="posts">
  @foreach( $posts as $post )
  <li>
      <article class="post">
        <header>
          <h2 class="page-header"><a data-pjax="" href="{{ url('/post/'.$post->slug) }}">{{ $post->title }}</a></h2>
        </header>
        <section class="post-content">
          {!! $post->body !!}
        </section>
    </article>
  </li>   
  @endforeach
</ul>
@endif

<div class="paginator" data-pjax="">
@if ($currentPage > 1)
    <a class="prev" href="/page/{{ ($currentPage-1) }}">←  Newer</a>
@else
    &nbsp;
@endif
    <a href="{{ url('archives') }}">– Archives –</a>
@if ($currentPage < $pageCount)
    <a class="next" href="/page/{{ ($currentPage+1) }}">Older →</a>
@else
    &nbsp;
@endif
</div>
</section>
@endsection
