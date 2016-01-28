@extends('app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default" style="overflow:auto;" >
                    <div class="panel-heading">{{ "Détail de la campagne " . $campagne->nom_campagne }}</div>
                    <a href="{{ $campagne->id_campagne .'/submit' }}">Lien</a>
                    <div style="text-align: left;">
                        @foreach ($images as $image)
                            <div style='background-image:url("/uploads/{{$image->lien_image}}");' class="miniaturesImages">gdfgd<br></div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection