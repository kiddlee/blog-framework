@extends('layout')

@section('content')
<section role="main" class="main post">
  	<article class="post">
	  	<header>
	    	<h2 class="page-header"><a data-pjax="" href="{{ url('/post/'.$post->slug) }}">
	  {{ $post->title }}</a></h2>
	          	<div class="meta">
	                <ul class="tags">
	                	@foreach( $post->tags as $tag )
	                    <li><a class="tag" href="/tag/{{ $tag }}">{{ $tag }}</a></li>
	                    @endforeach
	                </ul>
	            </div>
	  	</header>

		<section class="post-content">
			{!! $post->body !!}
		</section>
	    <footer>
	      	<section class="meta-date">
	        	posted on
	        	<time datetime="{{ $post->posttime }}" pubdate="">
	          		<span>{{ $post->posttime }}</span>
	        	</time>
	      	</section>
	    </footer>
	</article>
</section>
@endsection
