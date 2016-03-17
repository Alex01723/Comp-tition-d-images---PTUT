@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div id="focus_image">
                    {{-- Image et mention de la source en bas à droite --}}
                    <img src="../uploads/{{$image->lien_image}}" alt="{{$image->titre_image}}" />
                    <span id="focus_source">© {{ $image->getPosteur()->name }}
                        <br><span class="txt_mention">Ne pas reproduire</span>
                    </span>
                </div>

                {{-- Éléments de navigation --}}
                <div id="navigation_image">
                    @if ($precedente == null)
                        <span class="pas_dimage">Image précédente</span>
                        <img width="35" class="navig_icon" src="{{ URL::asset('assets/images/chevron-left-no.png') }}" alt="Image précédente" />
                    @else
                        <a href="{{ $precedente }}">
                            <span>Image précédente</span>
                            <img width="35" class="navig_icon" src="{{ URL::asset('assets/images/chevron-left.png') }}" alt="Image précédente" />
                        </a>
                    @endif

                    @if ($suivante == null)
                        <img width="35" class="navig_icon" src="{{ URL::asset('assets/images/chevron-right-no.png') }}" alt="Image suivante" />
                        <span class="pas_dimage">Image suivante</span>
                    @else
                        <a href="{{ $suivante }}">
                            <img width="35" class="navig_icon" src="{{ URL::asset('assets/images/chevron-right.png') }}" alt="Image suivante" />
                            <span>Image suivante</span>
                        </a>
                    @endif
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        @if ($image->est_recente())
                            <img width="20" style="position: relative; bottom: 3px;"
                                 src="{{ URL::asset('assets/images/new.png') }}" title="Cette image est récente." />
                        @endif
                        <span class="titre_image">{{$image->titre_image}}</span>

                        {{-- Appréciation par les utilisateurs --}}
                        <div id="like_image">
                            <span>{{ $image->getAppreciations() }}</span>

                            @if (!Auth::check())
                                <img src="{{ URL::asset('assets/images/star-no.png') }}" alt="Apprécier cette image" data-act="false"
                                     title="Connectez-vous pour apprécier cette image." />
                            @else
                                @if (Auth::user()->aime($image->id_image))
                                    <img src="{{ URL::asset('assets/images/star.png') }}" alt="Apprécier cette image" data-act="true" />
                                @else
                                    <img src="{{ URL::asset('assets/images/star-no.png') }}" alt="Apprécier cette image" data-act="false" />
                                @endif
                            @endif

                            {{-- Envoi du formulaire fictif avec AJAX --}}
                            {!! Form::open(['id' => 'formLike', 'method' => 'POST']) !!}
                                <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
                                {!! Form::submit('Connexion', ['id' => 'connexionLike', 'class' => 'hidden']) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>

                    <div class="panel-body">
                        {{-- Description de l'image dans un encart --}}
                        <div class="panel panel-default filtrer_regles">
                            {{ $image->description_image }}
                        </div>

                        {{-- Posteur, récompenses, libellés --}}
                        <div class="infos_image">
                            <div class="infos_image_posteur">
                                <img width="50" src="{{ URL::asset('assets/images/pictures.png') }}" alt="Posteur" />
                                — Image proposée par <span class="txt_gras">{{ $image->getPosteur()->name }}</span><br>
                                — Inscrit depuis le <span class="txt_gras">{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $image->getPosteur()->created_at)->format('d/m/Y') }}</span><br>
                                — Grade : <span class="txt_posteur">{{ $image->getPosteur()->getGrade() }}</span>
                            </div>
                            <div class="infos_image_libelle">
                                <img width="50" src="{{ URL::asset('assets/images/price-tags.png') }}" alt="Posteur" />
                                <div id="bloc_libelles">
                                    @forelse ($image->libelles as $libelle)
                                        <span class="txt_libelle"><a href="{{"../search/" . $libelle->texte_libelle}}">#{{$libelle->texte_libelle}}</a></span>
                                    @empty
                                        <span class="txt_no_libelle txt_italique_gris">Cette image ne possède aucun libellé.</span>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        {{-- Géolocalisation de l'image --}}
                        @if ($image->est_geolocalisee())
                            <div class="panel panel-default filtrer_regles">
                                <div id="map" style="height: 400px;"></div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts_supplementaires')
    {!! Html::script('assets/js/infobulle/jquery.tooltipster.min.js') !!}
    {!! Html::style('assets/js/infobulle/tooltipster.css') !!}
    {!! Html::style('assets/js/infobulle/themes/tooltipster-shadow.css') !!}

    <script type="text/javascript">
        $(document).ready(function() {
            @if (Auth::check())
                /* $('#like_image img').on({
                    mouseenter: function() {
                        $(this).attr('src', "{{ URL::asset('assets/images/star.png') }}");
                    },

                    mouseleave: function() {
                        @if (Auth::user()->aime($image->id_image))
                            $(this).attr('src', "{{ URL::asset('assets/images/star.png') }}");
                        @else
                            $(this).attr('src', "{{ URL::asset('assets/images/star-no.png') }}");
                        @endif
                    }
                }); */

                $("#like_image img").on("click", function() {
                    $("#connexionLike").trigger("click");
                });

                $("#formLike").submit(function(e) {
                    e.preventDefault();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    var posting = $.post($(this).attr('action'), 'aj');
                    posting.done(function(data) {
                        if (data.response == "doitLike") {
                            $("#like_image img").attr('src', "{{ URL::asset('assets/images/star.png') }}");
                            $("#like_image span").text(Number($("#like_image span").text()) + 1);
                        } else if (data.response == "doitUnlike") {
                            $("#like_image img").attr('src', "{{ URL::asset('assets/images/star-no.png') }}");
                            $("#like_image span").text(Number($("#like_image span").text()) - 1);
                        }
                    });
                });
            @else
                $('#like_image img').tooltipster({
                    theme: "tooltipster-shadow"
                });
            @endif
        });
    </script>

    <!-- Liaison de Google Maps, appel de l'API et bibliothèques supplémentaires -->
    @if ($image->est_geolocalisee())
        <script type="text/javascript">
            var map;
            function initMap() {
                map = new google.maps.Map(document.getElementById('map'), {
                    center: {lat: {{ floatval(explode(',', $image->geo_image)[0]) }}0,
                             lng: {{ floatval(explode(',', $image->geo_image)[1]) }}0},
                    zoom: 8
                });

                var marker = new google.maps.Marker({
                    position: {lat: {{ floatval(explode(',', $image->geo_image)[0]) }}0,
                               lng: {{ floatval(explode(',', $image->geo_image)[1]) }}0},
                    map: map,
                    titre: '{{ $image->titre_image }}'
                });

                var infowindow = new google.maps.InfoWindow({
                    content: "<strong>{{ $image->titre_image }}</strong><br>{{ $image->description_image }}"
                });

                google.maps.event.addListener(marker,'click',function() {
                    map.setZoom(9);
                    map.setCenter(marker.getPosition());
                    infowindow.open(map,marker);
                });
            }
        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA65SNWlBHJKRDEB1qcVAOL4IK9E00UJuo&callback=initMap"async defer></script>
    @endif
@endsection