@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <img src="../uploads/{{$image->lien_image}}" alt="{{$image->titre_image}}" />

                <div class="panel panel-default">
                    <div class="panel-heading">{{$image->titre_image}}</div>
                    <div class="panel-body">
                        <a href="{{ $precedente }}">Précédent</a>
                        <a href="{{ $suivante }}">Suivant</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection