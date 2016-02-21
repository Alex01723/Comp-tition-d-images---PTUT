@extends('app')

<!--
        C'est sur cette page que se fait l'affectation des jurés
-->

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
                    <div id="choix_jures" class="panel panel-default">
                            @if (!isset($id) || Auth::user()->adminCampagne($id) == null)
                                <span class="txt_italique_gris erreur_jures">Pour commencer, sélectionnez une campagne pour changer les jurés qui lui sont affectés.</span>
                            @elseif (Auth::user()->adminCampagne($id)->estTerminee())
                                <span class="txt_italique_rouge erreur_jures">Impossible de modifier les jurés d'une campagne terminée.</span>
                            @elseif (Auth::user()->adminCampagne($id)->estEnCoursDeJugement())
                                <span class="txt_italique_rouge erreur_jures">Impossible de modifier les jurés d'une campagne en cours de jugement.</span>
                            @else
                                {{--*/ $campagne_jures = Auth::user()->adminCampagne($id) /*--}}
                                <span class="titre_jures">Interface d'accrédition de « {{ $campagne_jures->nom_campagne }} » </span>
                                <span class="txt_italique_gris erreur_jures">Sélectionnez un utilisateur dans la barre de recherche ou dans la liste</span>

                                <!-- Formulaire caché d'envoi -->
                                <!-- On procède à l'aide de champs cachés -->
                                {!! Form::open(array('class' => 'form_envoi')) !!}
                                <div id="groupe_maintenance_jures">
                                    <div class="maintenance_jures" id="moins_jures">
                                        <ul id="liste_jures">
                                            @forelse (Auth::user()->adminInscrits($id) as $inscrit)
                                                <li>
                                                    <span class="txt_liste_jures">ID</span><span class="motif_id">{{ $inscrit->id }}</span> <span class="motif_name">{{ $inscrit->name }}</span> <span class="txt_italique_gris">(<span class="motif_email">{{ $inscrit->email }}</span>)</span>
                                                    {!! Form::hidden('jures[]', $inscrit->id) !!}
                                                </li>
                                            @empty
                                                <li><!-- Rien ici, on construit la zone si on clique dans la barre --></li>
                                            @endforelse
                                        </ul>
                                    </div>

                                    <div class="maintenance_jures" id="plus_jures">
                                        <input id="input_ajout_jures" />
                                    </div>
                                </div>
                                {!! Form::submit('Valider l\'affectation des jurés', array('class' => 'btn btn-info')) !!}
                                {!! Form::close() !!}

                                <span class="txt_gras">État de la campagne : </span> {{ $campagne_jures->getEtat() }}<br>
                            @endif
                    </div>

                    <!-- Canvas nécessaire à la création du graphe de jurés -->
                    <div id="graphe_jures" style="width: 98%; height: 500px; margin: auto;">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<!-- Zone des scripts supplémentaires -->
@section('scripts_supplementaires')
    {!! Html::script('assets/js/cytoscape.min.js') !!}
    {!! Html::script('assets/js/jquery.easy-autocomplete.min.js') !!}

    <!-- Script de création du graphe -->
    <script charset="utf8" type="text/javascript">
        $(document).ready(function() {
            var cy = cytoscape({
                container: $('#graphe_jures'),
                layout: {
                    name: 'circle',
                    rows: 1
                }
            });

            /* Affichage des noeuds CAMPAGNE */
            @foreach (Auth::user()->adminCampagnesEnCours() as $campagne)
                cy.add({
                    group: "nodes",
                    data: {
                        id: 'c{{ $campagne->id_campagne }}',
                        label: '{!! $campagne->nom_campagne !!}'
                    },
                    style: {
                        'label': '{!! $campagne->nom_campagne !!}',
                        'background-color': '#E0E0E0',
                        'border-color': '{{ $campagne->getCouleur() }}',
                        'border-width': 5,
                        'overlay-opacity': 0,
                    },
                    position: { x: 0, y: 0 }
                });
            @endforeach

            /* Affichage des noeuds JURÉS et des ARCS */
            @foreach (Auth::user()->adminJugements() as $jugement)
                @if (!$jugement->campagne->estTerminee())
                    // Si le noeud JURÉ n'existe pas encore
                    if (cy.filter("[id='j{{ $jugement->jure->id }}']").length < 1) {
                        cy.add({
                            group: "nodes",
                            data: {
                                id: 'j{{ $jugement->jure->id }}',
                                label: '{!! $jugement->jure->name !!}'
                            },
                            style: {
                                'height': 40,
                                'width': 40,
                                'label': '{!! $jugement->jure->name !!}',
                                'background-image': '{{ URL::asset('assets/images/man.png') }}',
                                'background-color': '#FFF',
                                'background-fit': 'contain',
                                'overlay-opacity': 0,
                            },
                            position: { x: 0, y: 0 }
                        })
                    }

                    // On le relie à la campagne correspondante
                    cy.add({
                        group: "edges",
                        data: {
                            id: 'c{{ $jugement->campagne->id_campagne }}-j{{ $jugement->jure->id }}',
                            source: 'j{{ $jugement->jure->id }}',
                            target: 'c{{ $jugement->campagne->id_campagne }}'
                        },
                        style: {
                            'line-color': '{{ $jugement->getCouleur() }}',
                            'width': 2,
                            'target-arrow-color': '{{ $jugement->getCouleur() }}',
                            'target-arrow-shape': 'triangle'
                        }
                    })
                @endif
            @endforeach

            cy.fit();
            cy.layout({ name: 'circle' });

            // Quand on clique sur une campagne
            cy.on('tap', function(evt){
                console.log(evt.cyTarget.id());
                if (evt.cyTarget != this && evt.cyTarget.id().substring(0,1) == 'c') {
                    @if (isset($id))
                        window.location.href = "../jures/" + evt.cyTarget.id().substring(1);
                    @else
                        window.location.href = "jures/" + evt.cyTarget.id().substring(1);
                    @endif
                }
            });
        });
    </script>

    @if(isset($id))
    <!-- Script d'autocomplétion des utilisateurs -->
    <script charset="utf8" type="text/javascript">
        // Gestion des nouveaux et des anciens membres membres
        var nvx_inscrits = [];
        var anc_inscrits = [];

        // Initialisation des anciens
        function init_anciens() {
            for (var i = 0; i < $("#liste_jures").children().length; i++) {
                var id_tmp = $("#liste_jures").children().eq(i).children(".motif_id").text();
                var name_tmp = $("#liste_jures").children().eq(i).children(".motif_name").text();
                var email_tmp = $("#liste_jures").children().eq(i).children(".txt_italique_gris").children(".motif_email").text();

                anc_inscrits.push(id_tmp);
            }
        }

        // Fonction de remplissage des membres
        function remplir(tab) {
            // On ajoute les utilisateurs qui ne sont pas des administrateurs
            @forelse (Auth::user()->adminLambdas() as $user)
                tab.push({
                    email: "{{ $user->email }}",
                    name: "{{ $user->name }}",
                    id: "{{ $user->id }}"
                });
            @empty
                tab.push("Aucun utilisateur disponible");
            @endforelse

            console.log(tab);

            // On enlève ceux qui sont déjà inscrits pour l'autocomplétion
            for (var i = tab.length - 1; i > -1; i--) {
                // Ceux qui sont déjà jurés avant le chargement de la page
                @foreach (Auth::user()->adminInscrits($id) as $inscrit)
                    if (tab[i].id == "{{ $inscrit->id }}") {
                        tab.splice(i, 1);
                        continue;
                    }
                @endforeach

                // Ceux qui ont proposé des images
                @foreach (Auth::user()->adminParticipants($id) as $participant)
                    if (tab[i].id == "{{ $participant->id }}") {
                        tab.splice(i, 1);
                        continue;
                    }
                @endforeach

                // Ceux qui viennent d'être rajoutés
                for (var j = 0; j < nvx_inscrits.length; j++) {
                    if ((typeof tab[i] != "undefined") && (tab[i].id == nvx_inscrits[j].id)) {
                        tab.splice(i, 1);
                    }
                }
            }

            console.log(tab);
        }

        // Création de l'option de remplissage des membres
        var parametres = {
            data: [],
            list: {
                match: {
                    enabled: true
                },
                onClickEvent: function() {
                    var item = $("#input_ajout_jures").getSelectedItemData();
                    $("#liste_jures").append("<li><span class=\"txt_liste_jures\">ID</span><span class=\"motif_id\">"
                                                + item.id + "</span> <span class=\"motif_name\">"
                                                + item.name+ "</span> <span class=\"txt_italique_gris\">(<span class=\"motif_email\">"
                                                + item.email + "</span>)</span><input name=\"jures[]\" type=\"hidden\" value=\"" + item.id + "\"></li>");

                    // Ajout du nouvel inscrit dans la liste
                    nvx_inscrits.push(item);

                    // Remplissage du tableau en fonction des données
                    parametres.data = [];
                    remplir(parametres.data);

                    // Reconstruction de la liste pour la prochaine insertion
                    $("#input_ajout_jures").easyAutocomplete(parametres);
                    $("#input_ajout_jures").val('');
                }
            },

            placeholder: "Chercher un utilisateur…",
            getValue: "name",

            template: {
                type: "custom",
                method: function(value, item) {
                    return value + " (" + item.email + ")";
                }
            }
        };

        // Suppression des membres et réactualisation de la barre de recherche
        $("#liste_jures").on("click", "li", function() {
            if ($("#liste_jures").children().length > 1) {
                var id_tmp = $(this).children(".motif_id").text();
                var name_tmp = $(this).children(".motif_name").text();
                var email_tmp = $(this).children(".txt_italique_gris").children(".motif_email").text();

                // On l'enlève des nouveaux inscrits s'il y est
                for (var i = nvx_inscrits.length - 1; i > -1; i--) {
                    if ((typeof nvx_inscrits[i] != "undefined" && nvx_inscrits[i].id == id_tmp)) {
                        nvx_inscrits.splice(i, 1);
                    }
                }

                // Si c'est un ancien inscrit, on doit l'ajouter manuellement à la liste des paramètres
                var estAncien = (anc_inscrits.indexOf(id_tmp) != -1);

                $(this).remove();
                parametres.data = [];
                remplir(parametres.data);

                if (estAncien)
                    parametres.data.push({
                        id: id_tmp,
                        name: name_tmp,
                        email: email_tmp
                    });

                // Reconstruction de la liste pour la prochaine insertion
                $("#input_ajout_jures").easyAutocomplete(parametres);
                $("#input_ajout_jures").val('');
            } else {
                alert("Impossible de supprimer le dernier juré !");
            }
        });

        // Affectation à la barre de recherche de membre
        init_anciens();
        remplir(parametres.data);
        $("#input_ajout_jures").easyAutocomplete(parametres);
    </script>
    @endif
@endsection