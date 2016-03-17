@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default" style="overflow:auto;" >
                    <div class="panel-heading">
                        @if ($campagne->est_recente())
                            <img width="20" style="position: relative; bottom: 3px;"
                                 src="{{ URL::asset('assets/images/new.png') }}" title="Cette campagne est récente." />
                        @endif
                        <span class="titre_campagne">{{$campagne->nom_campagne}}</span>

                        <!-- Balise rapide de rappel de campagne -->
                        <span class="txt_encart_campagne"
                              style="background-color: {{ $campagne->getCouleur(true) }};
                                     border: 1px solid {{ $campagne->getCouleur(false) }};">{{ $campagne->getEtat() }}</span>
                    </div>

                    <div class="panel panel-default filtrer_regles">
                        {{$campagne->description_campagne}}
                    </div>

                    <div class="infos_campagne">
                        <!-- Compte à rebours avant le début de la participation -->
                        <div id="infos_campagne_car">
                            <!-- On doit gérer tous les états possibles de la campagne -->
                            <span id="campagne_car"></span>
                            <span id="campagne_car_txt">{{ $campagne->getTexteCompteARebours() }}</span>

                            <!-- Le bouton d'envoi d'image est adapté en conséquence -->
                            <div id="bloc_campagne-button">
                                @if ($campagne->estEnCours())
                                    <a class='campagne-button campagne-btn-blue' href="{{ $campagne->id_campagne .'/submit' }}">Participer à la campagne</a>
                                @else
                                    <a class='campagne-button campagne-btn-disabled'>Participer à la campagne</a>
                                @endif
                            </div>
                        </div>

                        <!-- Modalités de participation à la campagne -->
                        <div id="infos_campagne_modalites">
                            <div id="options_campagne">
                                <!-- La campagne doit-elle contenir des images validées ? -->
                                <img src="{{ ($campagne->choix_validation == 1) ? URL::asset('assets/images/checkmark.png')
                                                                                : URL::asset('assets/images/checkmark-disabled.png') }}"
                                     alt="Validation de la campagne"
                                     title="{{ ($campagne->choix_validation == 1) ? "Les images de cette campagne sont modérées avant publication."
                                                                                  : "Les images de cette campagne ne nécessitent pas de vérification préalable." }}"
                                     class="icone_options_campagne" />

                                <!-- Les utilisateurs participent-ils au vote ? -->
                                <img src="{{ ($campagne->choix_popularite > 0) ? URL::asset('assets/images/star.png')
                                                                               : URL::asset('assets/images/star-disabled.png')}}"
                                     alt="Part des utilisateurs"
                                     title="{{ ($campagne->choix_popularite > 0) ? "Vos mentions « J'aime » participent à hauteur de " . $campagne->choix_popularite . " %"
                                                                                 : "Seuls les jurés contribuent à l'élection du gagnant." }}"
                                     class="icone_options_campagne" />

                                <!-- Combien de jurés sont inscrits ? -->
                                <img src="{{ URL::asset('assets/images/people.png') }}"
                                     alt="Nombre de jurés"
                                     title="Il y a {{ $campagne->getNombreJures() }} juré(s) dans cette campagne."
                                     class="icone_options_campagne" />

                                <!-- Combien d'images ont déjà été proposées ? -->
                                <div class="chiffre_options_campagne"
                                     title="Il y a {{ $campagne->getNombreImages() }} images publiées dans cette campagne.">
                                    <span>{{ $campagne->getNombreImages() }}</span>
                                </div>
                            </div>
                            <div id="recherche_campagne">
                                {!! Form::open() !!}
                                    {!! Form::text('recherche', (isset($elementRecherche)) ? $elementRecherche : '',
                                                                array('placeholder' => 'Cherchez une image par titre ou par description…',
                                                                      'class' => 'champ_recherche')) !!}
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>


                    <div class="campagne_liste_images">
                        <div class="clearfix mosaicflow" id="galerie">
                            @forelse ($images as $image)
                                <div class="mosaicflow__item">
                                    <a href="../image/{{ $image->id_image }}">
                                        <img width="100%;" alt="{{ $image->titre_image }}" src="{{ URL::to('/') }}/uploads/{{ $image->lien_image }}" />
                                    </a>
                                </div>
                            @empty
                                {{--*/ $est_vide = true /*--}}
                            @endforelse
                        </div>

                        @if (isset($est_vide))
                            <span class="txt_no_campagne txt_italique_gris">Aucune image dans cette campagne.</span>
                        @endif
                    </div>

                    <!-- <div style="margin: 1%; margin-right: 5px;" >
                        <p>{{$campagne->description_campagne}}</p>
                        <button class="btn active" onclick="location.href='{{ $campagne->id_campagne .'/submit' }}'" style="float: right">Ajouter une image</button>
                        <?php if($campagne->choix_binaire) echo"<button class='btn' style='float:right'>Choix Binaire</button>" ?>
                        <?php echo"<button class='btn' style='float:right'>Poids des votes utilisateurs : $campagne->choix_popularite %</button>" ?>
                        <?php if($campagne->choix_validation) echo"<button class='btn' style='float:right'>Images soumises à validation</button>" ?>
                        <?php echo"<button class='btn' style='float:right'>Date de fin : ".date('d M Y',strtotime($campagne->date_fin_vote))." </button>" ?>
                    </div>
                    <div style="float:  right;display: block;">
                        @foreach ($images as $image)
                            <div style='background-image:url("../uploads/{{$image->lien_image}}");' class="miniaturesImages"></div>
                        @endforeach
                    </div> -->
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts_supplementaires_TOP')
    <style>
        .mosaicflow__column {
            float:left;
        }
        .mosaicflow__item img {
            display: block;
            width: 100%;
            height: auto;
        }

        .mosaicflow__item {
            padding: 5px;
            text-align: center;
            position: relative;
        }
    </style>
@endsection

@section('scripts_supplementaires')
    {!! Html::script('assets/js/minuteur/jquery.countdown.min.js') !!}
    {!! Html::script('assets/js/galerie/jquery.mosaicflow.min.js') !!}
    {!! Html::script('assets/js/infobulle/jquery.tooltipster.min.js') !!}

    {!! Html::style('assets/js/infobulle/tooltipster.css') !!}
    {!! Html::style('assets/js/infobulle/themes/tooltipster-shadow.css') !!}

    <script type="text/javascript">
        <?php include('assets/js/minuteur/js_tps_campagne.php'); ?>
    </script>

    {{-- Galerie organisée --}}
    <script type="text/javascript">
        jQuery(document).ready(function() {
            $('#galerie').mosaicflow({
                itemSelector: '.item',
                minItemWidth: 100
            });

            $(".icone_options_campagne, .chiffre_options_campagne").tooltipster({
                theme: "tooltipster-shadow"
            });
        });
    </script>
@endsection