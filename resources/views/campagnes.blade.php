@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Liste des campagnes</div>
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
                </div>
            </div>
        </div>
    </div>

@endsection