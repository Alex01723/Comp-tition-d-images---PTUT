@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">{{$image->nom_image}}</div>
                        <div style='background-image: url("../uploads/{{$image->lien_image}}")'></div>
                    <div class="panel-body">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection