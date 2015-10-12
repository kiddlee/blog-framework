@extends('layout')

@section('content')

<section role="main" class="main page">
	<article class="post">
		<section class="post-content">
          	@if($page)
        		{!! $page !!}
          	@else
				404 error
			@endif
      	</section>
    </article>
</section>
@endsection
