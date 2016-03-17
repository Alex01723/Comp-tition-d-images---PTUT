@extends('app')

<!-- Page d'accueil du système de jugement -->
@section('jugement_barre')
    <div class="navbar navbar-default" id="jugement_barre">
        <span id="admin_barre_texte">
            <strong>JUGEMENT</strong>. Bienvenue, {{ Auth::user()->name }} : consultez vos campagnes de jugement.
        </span>
    </div>
@endsection

@section('content')
    @if (Session::has('msgJugement'))
        <div id="flash_no" class="message_flash">
            <div>
                {{ Session::get('msgJugement') }}
            </div>
        </div>
    @endif

    @if (Session::has('msgJugementOK'))
        <div id="flash_ok" class="message_flash">
            <div>
                {{ Session::get('msgJugementOK') }}
            </div>
        </div>
    @endif

    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default" style="overflow: auto;">
                    @if (Auth::user()->est_adm())
                        <div id="auth_jugement_no">
                            Être administrateur ne vous permet pas d'être juge.
                        </div>
                    @else
                        <div id="auth_jugement_ok">
                            Vous êtes éligible au jugement. Vos campagnes apparaissent ici.
                        </div>

                        <div id="recap_jugement">
                            <div class="sous_recap_jugement">
                                <h4>Mes campagnes de vote</h4>
                                <ul>
                                    @forelse (Auth::user()->getCampagnesJugement() as $campagne)
                                        {{--*/ $minuteur_num = "min" . $campagne->id_campagne /*--}}
                                        <li>
                                            @if ($campagne->estEnCoursDeJugement())
                                                <span class="bouton_voter bouton_voter_ok"><a style="color: #FFFFFF;" href="jugement/{{ $campagne->id_campagne }}/filtrer">Participer au jugement</a></span>
                                            @else
                                                <span class="bouton_voter bouton_voter_no" id="{{ $minuteur_num }}"></span>
                                            @endif

                                            {{-- On affiche l'icône de sauvegarde si besoin est --}}
                                            @if (!Auth::user()->getJugements($campagne->id_campagne)[0]->estNouveau())
                                                <img class="illustration" title="Vote sauvegardé" src="{{ URL::asset('assets/images/download.png') }}" alt="Vote sauvegardé" />
                                            @else
                                                <img class="illustration" title="Nouveau vote" src="{{ URL::asset('assets/images/file.png') }}" alt="Vote sauvegardé" />
                                            @endif

                                            {{ $campagne->nom_campagne }}
                                        </li>

                                        <script type="text/javascript">
                                            <?php include('assets/js/minuteur/js_tps_votant.php'); ?>
                                        </script>
                                    @empty
                                        <span class="txt_no_campagne txt_italique_gris">Vos campagnes de vote s'afficheront ici.</span>
                                    @endforelse
                                </ul>
                            </div>

                            <div class="sous_recap_jugement">
                                <h4>Mes anciennes campagne de vote</h4>
                                <ul>
                                    @forelse (Auth::user()->getCampagnesJugement(true) as $campagne)
                                        <li>{{ $campagne->nom_campagne }}</li>
                                    @empty
                                        <span class="txt_no_campagne txt_italique_gris">Vous n'avez encore jugé aucune campagne.</span>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    @endif
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

@section('scripts_supplementaires')
    <script>
        $(document).ready(function(){
            setTimeout(function() {
                $('.message_flash').fadeOut('slow');
            }, 1500); // <-- time in milliseconds
        });
    </script>
@endsection