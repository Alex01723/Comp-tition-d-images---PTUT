@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ "Détail de la campagne " . $campagne->nom_campagne }}</div>
                    <a href="{{ $campagne->id_campagne .'/submit' }}">Lien</a>
                    @foreach ($images as $image)
                        {{ var_dump($image->id_campagne) }}
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@endsection