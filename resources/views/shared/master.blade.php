<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>@yield('title')</title>

  <!-- Bootstrap core CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/3.3.6/flatly/bootstrap.css" rel="stylesheet">
  <link href="{{ url('algolia-autocomplete.css') }}" rel="stylesheet">

  {!! Analytics::render() !!}

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
    </head>

    <body>

      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand">onix-codelists.io</a>
          </div>

          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
              <li class="{{ active_class(if_uri(['codelist']), 'active') }}"><a href="/codelist">Codelists</a></li>
              <li class="{{ active_class(if_uri(['api-docs']), 'active') }}"><a href="/api-docs">API</a></li>
              <li class="{{ active_class(if_uri(['about']), 'active') }}"><a href="/about">About</a></li>
            </ul>
            <form class="navbar-form navbar-left" role="search" action="/search">
              <div class="form-group">
                  <input type="text" class="form-control" placeholder="Search" name="q" id="search-input">
              </div>
            </form>
          </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
      </nav>

      <a href="https://github.com/lasselehtinen/onix-codelist"><img style="position: absolute; top: 0; right: 0; border: 0;" src="https://camo.githubusercontent.com/652c5b9acfaddf3a9c326fa6bde407b87f7be0f4/68747470733a2f2f73332e616d617a6f6e6177732e636f6d2f6769746875622f726962626f6e732f666f726b6d655f72696768745f6f72616e67655f6666373630302e706e67" alt="Fork me on GitHub" data-canonical-src="https://s3.amazonaws.com/github/ribbons/forkme_right_orange_ff7600.png"></a>

      <div class="container">
        @yield('content')
      </div>

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>    
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
      <script src="//cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
      <script src="//cdn.jsdelivr.net/hogan.js/3.0/hogan.min.js"></script>
      <script src="//cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
      <script>
        var client = algoliasearch("0AX2Y3FFW8", "ed59fb1126ff48502e68207c0488c5ba");
        var codelists = client.initIndex('codelists');
        var codes = client.initIndex('codes');

        // Mustache templating by Hogan.js (http://mustache.github.io/)
        var templateCodelist = Hogan.compile('<div class="codelist">' +
          '<div class="name">@{{{ _highlightResult.description.value }}} <small>(@{{ codelist.description }})</small></div></div>');
        var templateCode = Hogan.compile('<div class="code">' +
          '<div class="name">@{{{ _highlightResult.description.value }}}</div></div>');

        // autocomplete.js initialization
        autocomplete('#search-input', {hint: true}, [
          {
            source: autocomplete.sources.hits(codelists, {hitsPerPage: 3}),
            displayKey: 'description',
            templates: {
              header: '<div class="category">Codelists</div>',
              suggestion: function(hit) {
                // render the hit using Hogan.js
                return templateCode.render(hit);
              }
            }
          },
          {
            source: autocomplete.sources.hits(codes, {hitsPerPage: 5}),
            displayKey: 'description',
            templates: {
              header: '<div class="category">Codes</div>',
              suggestion: function(hit) {
                // render the hit using Hogan.js
                return templateCodelist.render(hit);
              }
            }
          }

        ]).on('autocomplete:selected', function(event, suggestion, dataset) {
          window.location.href = '/codelist/' + suggestion.number;
        });
      </script>

    </body>
    </html>
