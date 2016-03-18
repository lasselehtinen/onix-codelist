@extends('shared.master')

@section('title', 'Onix codelist')

@section('content')
<h1>Whoops!</h1>

<p>That page could not be found.</p>

<a href="{{ URL::previous() }}">Go back</a>
@endsection