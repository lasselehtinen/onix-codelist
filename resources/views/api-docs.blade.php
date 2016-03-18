
@extends('shared.master')

@section('title', 'API documentation')

@section('content')
<h1>API documentation</h1>

<p>The REST API documentation can be found in <a href="http://docs.onixcodelists.apiary.io/#">Apiary</a>. There is no need for
authentication. Below you can also find a link to a Postman collection.
</p>

<div class="postman-run-button"
data-postman-action="collection/import"
data-postman-var-1="3423f7fc9107d61ea3e7"></div>
<script type="text/javascript">
  (function (p,o,s,t,m,a,n) {
    !p[s] && (p[s] = function () { (p[t] || (p[t] = [])).push(arguments); });
    !o.getElementById(s+t) && o.getElementsByTagName("head")[0].appendChild((
      (n = o.createElement("script")),
      (n.id = s+t), (n.async = 1), (n.src = m), n
    ));
  }(window, document, "_pm", "PostmanRunObject", "https://run.pstmn.io/button.js"));
</script>

@endsection