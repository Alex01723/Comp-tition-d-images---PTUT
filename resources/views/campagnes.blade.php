@extends('app')

@section('content')
    <div>
        <ul>
        @foreach ($campagnes as $campagne)
            <li>
                <a href="{{ "campagne/" . $campagne->id_campagne }}">{{ $campagne->nom_campagne }}</a>
                <ul>
                    <li>{{ $campagne->description_campagne }}</li>
                    <li>{{ $campagne->date_fin }}</li>
                </ul>
            </li>
        @endforeach
        <ul>
    </div>
@endsection