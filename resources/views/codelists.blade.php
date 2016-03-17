
@extends('shared.master')

@section('title', 'Onix codelists')

@section('content')
<h1>Onix codelists</h1>

<table class="table table-condensed table-hover">
  <thead>
    <tr>
      <th>Number</th>
      <th>Description</th>
      <th>Issue number</th>
      <th>Code values</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($codelists as $codelist)
    <tr>
      <td>{{ $codelist->number }}</td>
      <td>{{ $codelist->description }}</td>
      <td>{{ $codelist->issue_number }}</td>
      <td><a href="{{ route('codelist.show', ['number' => $codelist->number]) }}">Link</a></td>
    </tr>
    @endforeach            
  </tbody>
</table>

{!! $codelists->render() !!}
@endsection