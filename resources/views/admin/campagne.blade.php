@extends('app')

<!-- Signalement de l'administration -->
@section('admin_barre')
    <div class="navbar navbar-default" id="admin_barre">
        <span id="admin_barre_texte">
            <strong><a href="{{ url('admin') }}">ADMINISTRATION</a></strong>.
            {{--*/ $nb_images_a_valider = count(Auth::user()->adminImagesAValider()) /*--}}
            Bienvenue, vous avez {{ $nb_images_a_valider }} image{{ ($nb_images_a_valider > 1) ? "s" : "" }} à valider.
        </span>
    </div>
@endsection

        <!-- Contenu de la page -->
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default" style="overflow: auto;">
                    @foreach (Auth::user()->adminCampagnes() as $campagne)
                        <p>
                            <strong>{{ $campagne->nom_campagne }}</strong><br>
                            <span>{{ "Nombre d'images : " . count($campagne->retrieveImages()) }}</span><br>
                            <span>{{ "Date de fin : " . $campagne->date_fin }}</span><br><br>

                            <span>Taux de vote actuel : 0.0%</span><br>
                            <span><a href="{{ "campagne/" . $campagne->id_campagne }}">Modifier les informations de {{ $campagne->nom_campagne }}</a></span>
                        </p>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection