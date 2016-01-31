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
                    <div id="graphe_jures" style="width: 98%; height: 500px; margin: auto;">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts_supplementaires')
    {!! Html::script('assets/js/cytoscape.min.js') !!}
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
                        label: '{{ $campagne->nom_campagne }}'
                    },
                    style: {
                        'label': '{{ $campagne->nom_campagne }}',
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
                    console.log('{!! $jugement !!}');

                    // Si le noeud JURÉ n'existe pas encore
                    if (cy.filter("[id='j{{ $jugement->jure->id }}']").length < 1) {
                        cy.add({
                            group: "nodes",
                            data: {
                                id: 'j{{ $jugement->jure->id }}',
                                label: '{{ $jugement->jure->name }}'
                            },
                            style: {
                                'height': 40,
                                'width': 40,
                                'label': '{{ $jugement->jure->name }}',
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
        });
    </script>
@endsection