@extends('shared.master')

@section('title', 'Onix codelists - About')

@section('content')
<h1>About ONIX for Books codelists</h1>

<p>This is a hobby weekend project I did because I found myself quite often searching through the Onix codelists. The auto-complete search
is indexed with codelists and codelist code descriptions and notes. I hope you might find this service useful. The site is built on
<a href="http://laravel.com">Laravel</a> and the <a href="https://github.com/lasselehtinen/onix-codelist">source code is provided as open-source</a>
with MIT license in Github. So please <a href="https://github.com/lasselehtinen/onix-codelist/issues">create an issue</a> if you have any wishes.</p>

<a href="{{ URL::previous() }}">Back to Codelists</a>
@endsection