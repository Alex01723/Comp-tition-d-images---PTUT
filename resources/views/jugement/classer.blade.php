@extends('app')

<!-- Page d'accueil du système de jugement -->
@section('jugement_barre')
    <div class="navbar navbar-default" id="jugement_barre">
        <span id="admin_barre_texte">
            <strong>JUGEMENT</strong>. Classez les images en les faisant glisser dans votre ordre de préférence.
        </span>
    </div>
@endsection

<!-- Contenu du site -->
@section('content')
    @if (Session::has('msgClasse'))
        <div id="flash_ok" class="message_flash">
            <div>
                {{ Session::get('msgClasse') }}
            </div>
        </div>
    @endif

    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default" style="overflow: auto;">

                    {{-- Le formulaire est ouvert ici car on doit avoir un contrôle des images et du bouton en même temps --}}
                    {!! Form::open(array('class' => 'form_filtre')) !!}
                    <div class="panel panel-default classer_regles">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-custom" role="progressbar"
                                 aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">
                                <span class="progress-msg"><span class="txt_gras">ÉTAPE 2</span>. Classer les images.</span>
                            </div>
                        </div>

                        <div class="panel panel-default filtrer_regles">
                            — Faites glisser les images dans l'ordre dans lequel vous souhaitez les classer.<br>
                            — Le classement de chaque image s'affiche en bas à droite.<br>
                            — Passez votre souris sur les médaillons pour plus de détails.
                        </div>

                        <div class="panel panel-default filtrer_regles">
                            <input type="submit" name="sauvegarder" value="Sauvegarder votre vote" class="txt_bouton_choix txt_confirmer_choix">
                            <input type="submit" name="valider" value="Valider définitivement votre vote" class="txt_bouton_choix txt_confirmer_choix"><br><br>

                            — Sauvegarder votre vote vous permet d'y revenir plus tard.<br>
                            — Une fois le vote validé, il n'est plus possible de le modifier.
                        </div>
                    </div>

                    <!-- Contenu -->
                    <div id="classement">
                        <div class="gridster">
                            <ul>
                                @foreach ($liste as $indice=>$image)
                                    <li data-row="{{ floor($indice / 4 + 1) }}" data-col="{{ ($indice % 4) + 1 }}" data-sizex="1" data-sizey="1">
                                        <img src="{{ URL::to('/') }}/uploads/{{ $image->lien_image }}"
                                             alt="{{ $image->titre_image }}"
                                             data-desc="{{ $image->description_image }}" />
                                        <span id="indice{{ $indice }}" class="position">0</span>
                                        <input id="hidden{{ $indice }}" type="hidden" name="{{ $image->id_image }}" value="0"/>
                                    </li>
                                @endforeach
                            </ul>
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
        .gridster ul {
            list-style-type: none;
            padding: 0;
            margin: 10px;
        }

        .gridster ul li {
            background-color: #888888;
            margin: 0;
            padding: 0;

            overflow: hidden;
            position: absolute;
            cursor: move;
        }

        .gridster ul li img {
            width: 100%;
        }

        .gridster .preview-holder {
            border: 6px dashed #6495ED;
            background: none;

            background-color: #F5F5F5;
            z-index: 0 !important;
        }

        .gridster .dragging {
            z-index: 1000 !important;
        }

        .gridster .position {
            position: absolute;
            bottom: 10px;
            right: 10px;

            text-transform: uppercase;
            color: #6495ED;
            font-size: 18px;

            background-color: #FFFFFF;
            border-radius: 150px;
            padding-top: 6px;

            width: 35px;
            height: 35px;
            text-align: center;

            box-shadow: 2px 2px 10px #6495ED;
        }
    </style>
@endsection

<!-- Liste des scripts supplémentaires -->
@section('scripts_supplementaires')
    {!! Html::script('assets/js/galerie/jquery.gridster2.min.js') !!}
    {!! Html::script('assets/js/infobulle/jquery.tooltipster.min.js') !!}

    {!! Html::style('assets/js/infobulle/tooltipster.css') !!}
    {!! Html::style('assets/js/infobulle/themes/tooltipster-shadow.css') !!}

    <script type="text/javascript">
        $(document).ready(function() {

            // Adaptation des images selon leurs dimensions
            $(".gridster img").each(function() {
                if ($(this).height() < $(this).width())
                    $(this).css('height', '100%');
                    $(this).css('width', '');
            });

            // Fonction de calcul et de réactualisation des positions selon la grille
            function calcPositions() {
                var classement = [];
                $(".position").each(function() {
                    classement.push({
                        id: $(this).attr('id'),
                        nb: (parseInt($(this).parent().attr('data-col')) + parseInt($(this).parent().attr('data-row')) * 10000)
                    })

                    console.log(classement[classement.length - 1]);
                });

                function compare(a,b) {
                    return a.nb - b.nb;
                }

                classement.sort(compare);
                Array.prototype.indexOfObject = function arrayObjectIndexOf(property, value) {
                    for (var i = 0, len = this.length; i < len; i++) {
                        if (this[i][property] === value) return i;
                    }
                    return -1;
                }

                $(".position").each(function() {
                    $(this).html(classement.indexOfObject('id', $(this).attr('id')) + 1);
                    $(this).next().attr('value', classement.indexOfObject('id', $(this).attr('id')) + 1);
                })
            }

            // Initialisation de la grille de déplacement
            var gridster;
            calcPositions();

            $(function () { //DOM Ready
                gridster = $(".gridster > ul").gridster({
                    widget_margins: [10, 10],
                    widget_base_dimensions: [210, 210],
                    shift_larger_widgets_down: false,
                    max_rows: 0{{ ceil(count($liste) / 4) }},
                    draggable: {
                        stop: function(event, ui) {
                            calcPositions();
                        }
                    }
                });
            });
            console.log($(".gridster .position").prev());
            // Mise en place des infobulles
            $(".gridster .position").each(function() {
                $(this).tooltipster({
                    content: $("<div><span class=\"txt_ibulle\">Titre</span> : " + $(this).prev().attr('alt') +
                               "<br><span class=\"txt_ibulle\">Description</span> : " + $(this).prev().data('desc') +
                               "<br><br><a class=\"lien_ibulle\" target=\"_blank\" href=\"" + $(this).prev().attr('src') + "\">" +
                               "<span class=\"bloc_ibulle\">Cliquez ici pour voir l'image en taille réelle</span></a>" + "</div>"),
                    theme: "tooltipster-shadow",
                    interactive: "true"
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