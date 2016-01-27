@extends('app')

@section('content')
<div>
    <ul>
    @foreach ($campagnes as $campagne)
        <li>{{ $campagne->nom_campagne }}</li>
    @endforeach
    <ul>
</div>
@endsection