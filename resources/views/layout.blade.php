<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>{{ config('my.title') }}</title>
  <meta name="description" content="{{ config('my.description') }}">
  <meta name="HandheldFriendly" content="true">
  <meta name="MobileOptimized" content="320">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="{{ asset('/css/screen.css') }}" rel="stylesheet">
  <link href="{{ asset('/css/icomoon.css') }}" rel="stylesheet">
  <link href="{{ asset('/css/prettify.css') }}" rel="stylesheet">
  <script src="{{ asset('/js/jquery.min-2.1.3.js') }}"></script>
  <link href="{{ url('feed') }}" rel="alternate" title="{{ config('my.title') }}" type="application/atom+xml">
</head>
<body>
  <header role="banner">
    <h1><a href="{{ config('my.url') }}" data-pjax>Shulei Lee</a></h1>
    <figure></figure>
    <nav role="navigation">
      <ul data-pjax>
        <li><a href="{{ url('/') }}">Blog</a></li>
        <li><a href="{{ url('about') }}">About</a></li>
        <li><a href="{{ url('archives') }}">Archives</a></li>
        <li><a href="{{ url('search') }}">Search</a></li>
      </ul>
    </nav>
  </header>
  <div class="wrap" id="pjax-container">
    <div class="bg-banner">blog</div>
      @yield('content')
  </div>
  <footer role="contentinfo">
  <!--
  <ul class="copyright">
    <li>&copy; <a href="{{ url('about') }}">Shulei Lee</a></li>
    <li><a href="http://github.com/ohida/pochika">Powered by</a>
  </ul>
  <ul class="footer-icons">
    <li><a data-pjax href="/"><span class="icon" data-icon="&#x21;"></span></a></li>
    <li><a data-pjax href="{{ url('search') }}"><span class="icon" data-icon="&#x22;"></span></a></li>
    <li><a href="{{ url('feed') }}"><span class="icon" data-icon="&#x23;"></span></a></li>
  </ul>
  -->
  <script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1257559371'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s11.cnzz.com/z_stat.php%3Fid%3D1257559371%26show%3Dpic2' type='text/javascript'%3E%3C/script%3E"));</script>
  <br />
</footer>
<script src="{{ asset('/js/jquery.highlight.js') }}"></script>
<script src="{{ asset('/js/jquery.pjax.js') }}"></script>
<script src="{{ asset('/js/prettify.js') }}"></script>
<div id="loading">
  LOADING
</div>

<script>
  $(function(){
    prettify();

    $(window).scroll(function() {
      var yPos = $(window).scrollTop();
      if (yPos > 240) {
        $("#subnav").fadeIn();
      } else {
        $("#subnav").fadeOut();
      }
    });

  });
</script>

<script>
  /**
   * pjax initialize
   */
  @if (!config('my.nopjax'))
    $(document).pjax('[data-pjax] a, a[data-pjax]', {
      container: '#pjax-container',
      fragment: '#pjax-container'
    })
    .on('pjax:send', function() {
      $('#loading').show();
    })
    .on('pjax:complete', function() {
      $('#loading').fadeOut('slow');
      prettify();
    })
    .on('pjax:end', function() {
    });
  @endif

  function prettify() {
    $('.post pre, .content pre, table code').addClass('prettyprint');
    prettyPrint();
  }

  function highlight(keyword) {
    $('article h2,.post-content,.tags').highlight(keyword, {element:'mark'});
  }

  /**
   * pjax for read more
   */
  function load_post(e) {
    var url = e.href + '?format=content';
    //todo
    var p = $(e).parent().parent();
    $.ajax({
      url: url,
      dataType: 'html',
      success: function(res) {
        p.html(res);
      },
      complete: function() {
        $('#loading').fadeOut('slow')
        prettify();
        @if (config('my.query'))
          highlight('{{ config('my.query') }}');
        @endif
      }
    });
    $('#loading').show()
    return false;
  }
</script>

@if (config('my.forkme'))
  <a href="https://github.com/kiddlee/blog" class="github-ribbon">
    <img style="position: absolute; top: 0; right: 0; border: 0;" src="https://s3.amazonaws.com/github/ribbons/forkme_right_red_aa0000.png" alt="Fork me on GitHub">
  </a>
@endif
  <aside id="subnav" data-pjax>
    <div class="wrap">
      <div class="site-title">
        <a href="{{ url('/') }}">{{ config('my.title') }}</a>
      </div>
      <ul class="nav">
        <li><a href="{{ url('about') }}">About</a></li>
        <li><a href="{{ url('archives') }}">Archives</a></li>
        <li><a href="{{ url('search') }}">Search</a></li>
      </ul>
    </div>
  </aside>
</body>
</html>
