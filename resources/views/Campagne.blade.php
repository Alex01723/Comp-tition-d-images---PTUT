@extends('app')

@section('content')
    {{ "Je suis la campagne " . $campagne->id_campagne }}
@endsection