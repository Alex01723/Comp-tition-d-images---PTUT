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
                    <ul id="liste_campagnes">
                    @foreach ($campagnes as $campagne)
                        {{--*/ $minuteur_num_db = "mindb" . $campagne->id_campagne /*--}}
                        {{--*/ $minuteur_num = "min" . $campagne->id_campagne /*--}}
                        {{--*/ $minuteur_num_fv = "minfv" . $campagne->id_campagne /*--}}

                        <li style="background-color: {{ $campagne->getCouleur(true) }}; border-color: {{ $campagne->getCouleur(false) }}">
                            <span class="txt_plaque_id_campagne">ID{{ $campagne->id_campagne }}</span>
                            <span class="txt_titre_campagne">{{ $campagne->nom_campagne }}</span>

                            <p>
                                <span class="txt_italique">{!! $campagne->getEtat() !!}.</span><br>
                                <span>Nombre d'images :</span> {{ $campagne->getNombreImages() }}.<br>
                                <span>Nombre de participants :</span> {{ $campagne->getNombreParticipants() }}.<br>
                                <span>Nombre de jurés : </span> {{ $campagne->getNombreJures() }}.<br>
                            </p>

                            <p>
                                <img class="illustration" src="{{ URL::asset('assets/images/stopwatch.png') }}" alt="TPS_DEBUT" />
                                    <span>Temps restant avant le début : </span><span id="{{ $minuteur_num_db }}"></span><br>

                                <img class="illustration" src="{{ URL::asset('assets/images/stopwatch.png') }}" alt="TPS_FIN" />
                                    <span>Temps restant avant la fin : </span><span id="{{ $minuteur_num }}"></span><br>

                                <img class="illustration" src="{{ URL::asset('assets/images/stopwatch.png') }}" alt="TPS_FIN_VOTE" />
                                    <span>Temps restant avant la fin des votes : </span><span id="{{ $minuteur_num_fv }}"></span>

                                <script type="text/javascript">
                                    <?php include('assets/js/minuteur/js_tps_restant.php'); ?>
                                </script>
                            </p>
                            <!-- <strong>{{ "(" . $campagne->id_campagne . ") " . $campagne->nom_campagne }}</strong><br>
                            <span>{{ "Nombre d'images : " . $campagne->getNombreImages() }}</span><br>
                            <span>{{ "Date de fin : " . $campagne->date_fin }}</span><br><br>

                            <span>Taux de vote actuel : 0.0%</span><br>
                            <span><a href="{{ "campagne/" . $campagne->id_campagne }}">Modifier les informations de {{ $campagne->nom_campagne }}</a></span> -->
                        </li>
                    @endforeach
                    </ul>

                    <!-- Mécanisme de pagination -->
                    {!! $campagnes->render() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

<!-- Zone des scripts supplémentaires qui doivent apparaître en haut -->
@section('scripts_supplementaires_TOP')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>
    {!! Html::script('assets/js/minuteur/jquery.countdown.min.js') !!}
@endsection