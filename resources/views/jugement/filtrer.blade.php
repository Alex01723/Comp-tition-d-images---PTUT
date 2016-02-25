@extends('app')

        <!-- Page d'accueil du système de jugement -->
@section('jugement_barre')
    <div class="navbar navbar-default" id="jugement_barre">
        <span id="admin_barre_texte">
            <strong>JUGEMENT</strong>. Choisissez les images que vous souhaitez classer.
        </span>
    </div>
@endsection

@section('content')
    @if (Session::has('msgFiltre'))
        <div class="message_flash">
            <div>
                {{ Session::get('msgFiltre') }}
            </div>
        </div>
    @endif

    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default" style="overflow: auto;">
                    <!-- Rappels et règles -->

                    {{-- Le formulaire est ouvert ici car on doit avoir un contrôle des images et du bouton en même temps --}}
                    {!! Form::open(array('class' => 'form_filtre')) !!}

                    <div class="panel panel-default filtrer_regles">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-custom" role="progressbar"
                                 aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:50%">
                                <span class="progress-msg"><span class="txt_gras">ÉTAPE 1</span>. Filtrer les images.</span>
                            </div>
                        </div>

                        <div class="panel panel-default filtrer_regles">
                            — Sélectionnez les images que vous souhaitez garder pour le classement à l'étape suivante.<br>
                            — Vous devez sélectionner deux images au minimum.
                        </div>
                        <div class="panel panel-default filtrer_regles" style="overflow: auto;">
                            <span class="txt_mini_bleu">CAMPAGNE</span> : {{ Auth::user()->getCampagne($idc)->nom_campagne }}<br>
                            <span class="txt_mini_bleu">DESCRIPTION</span> : {{ Auth::user()->getCampagne($idc)->description_campagne }}<br><br>
                            Sur un total de <span class="txt_bleu">{{ Auth::user()->getCampagne($idc)->getNombreImages() }}</span> images, vous en avez choisi <span class="txt_bleu"  id="nb_images_select">0</span>.<br>

                            <span class="bloc_bouton_choix" id="c_oui"><span class="txt_bouton_choix">Tout sélectionner</span></span>
                            <span class="bloc_bouton_choix" id="c_non"><span class="txt_bouton_choix">Tout déselectionner</span></span>

                            {!! Form::submit('Classer ces images', array('class' => 'txt_bouton_choix txt_confirmer_choix')) !!}
                        </div>
                    </div>

                    <!-- Contenu -->
                    <div class="filtrer_bloc_images">
                        <div class="clearfix mosaicflow" id="galerie">
                            @foreach (Auth::user()->getCampagne($idc)->retrieveImages() as $image)
                                <div class="mosaicflow__item">
                                    <img class="img_selectionnee"
                                         src="{{ URL::to('/') }}/assets/images/checkbox-checked.png" />

                                    <img width="100%;"
                                         class="image_filtre"
                                         alt="{{ $image->titre_image }}"
                                         style="border: 0 solid #6495ED;"
                                         id="i{{ $image->id_image }}"
                                         src="{{ URL::to('/') }}/uploads/{{ $image->lien_image }}"
                                         data-selected="false" />

                                    {!! Form::hidden('images[]', '', array('id' => 'fi' . $image->id_image)) !!}
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {!! Form::close() !!}
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

        .img_selectionnee {
            display: block !important;
            width: 26px !important;

            position: absolute;
            left: 34px !important;
            top: 0px !important;
            visibility: hidden;
        }
    </style>
@endsection

@section('scripts_supplementaires')
    {!! Html::script('assets/js/galerie/jquery.mosaicflow.min.js') !!}

    {{-- Galerie organisée --}}
    <script type="text/javascript">
        jQuery(document).ready(function(){
            $('#galerie').mosaicflow({
                itemSelector: '.item',
                minItemWidth: 100
            });

            /* Détection du clic sur une image */
            $("#galerie .image_filtre").on('click', function() {
                if ($(this).data('selected') == false) {
                    var mH = ((($(this).height() * 40) / ($(this).width())) / 2);

                    $(this).animate({
                        width: "-=40px",
                        marginLeft: "+=20px",
                        borderWidth: "4px",
                        marginTop: "+=" + mH + "px",
                        marginBottom: "+=" + mH + "px"
                    });

                    $(this).parent().find('.img_selectionnee').attr("style", "top: " + (mH + 14) + "px !important; visibility: visible;");

                    $("#nb_images_select").html(parseInt($("#nb_images_select").html(), 10) + 1);
                    $("#f" + $(this).attr('id')).prop('value', $(this).attr('id').substring(1));
                    $(this).data('selected', true);
                } else {
                    var mH = ((($(this).height() * 40) / ($(this).width())) / 2);

                    $(this).animate({
                        width: "+=40px",
                        marginLeft: "-=20px",
                        borderWidth: "0px",
                        marginTop: "-=" + mH + "px",
                        marginBottom: "-=" + mH + "px"
                    });

                    $(this).parent().find('.img_selectionnee').css({
                        'visibility': 'hidden'
                    });

                    $("#nb_images_select").html(parseInt($("#nb_images_select").html(), 10) - 1);
                    $("#f" + $(this).attr('id')).attr('value', '');
                    $(this).data('selected', false);
                }
            });

            /* Raccourci de sélection */
            $("#c_oui").on("click", function() {
                $( "#galerie .image_filtre" ).each(function() {
                    if (!$(this).data('selected')) {
                        $(this).trigger("click");
                    }
                });
            });

            $("#c_non").on("click", function() {
                $( "#galerie .image_filtre" ).each(function() {
                    if ($(this).data('selected')) {
                        $(this).trigger("click");
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function(){
            setTimeout(function() {
                $('.message_flash').fadeOut('slow');
            }, 1500); // <-- time in milliseconds
        });
    </script>
@endsection