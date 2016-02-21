@extends('app')

<!--
        C'est sur cette page que se fait la validation des images
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
                    <div>
                        <nav id="admin_menu">
                            {!! $adminMenu->asUl( array('class' => 'nav navbar-nav') ) !!}
                        </nav>
                    </div>

                    <!-- Validation des images -->
                    <div id="admin_bloc_validation_images">
                        <hr />
                        <h2>Modération des images</h2>
                        <p>Sélectionnez les images montrables pour chaque campagne.</p>

                        <div id="liste_images">
                            @if (count(Auth::user()->adminImagesAValider()) > 0)
                                {!! Form::open(array('class' => 'form_validation')) !!}
                                @foreach (Auth::user()->adminImagesAValider() as $key => $image)
                                    {!!  Form::radio("radio" . $image->id_image, 'envoi_oui') !!}
                                    {!!  Form::radio("radio" . $image->id_image, 'envoi_non', true) !!}
                                    <div class="image_a_valider" id="{{ $image->id_image }}">
                                        <a href="{{ "uploads/" . $image->lien_image }}" target="_blank">
                                            <div class="bloc_image" style="background: url('{{ "uploads/" . $image->lien_image }}'); background-size: 100%;">
                                                <img src="assets/images/zoom-in.png" alt="Zoomer" />
                                            </div>
                                        </a>
                                        <span class="txt_gras">Titre de l'image</span> : {{ $image->titre_image }}<br>
                                        <span class="txt_gras">Titre de la campagne associée</span> : {{ $image->campagne->nom_campagne }}<br>
                                        <span class="txt_italique_gris">Cette image a été postée par <span class="txt_gras">{{ $image->posteur->name }}</span> en date du {{ \Carbon\Carbon::parse($image->date_envoi)->format('d/m/Y à H:i:s') }}</span><br><br>

                                        <span class="txt_gras">Particularités de l'image</span> :
                                            {!! ($image->geo_image == NULL || strlen($image->geo_image) < 1) ? "<span class=\"txt_no_geol\">NON GÉOLOCALISÉE</span>" : "<span class=\"txt_geol\">LOCALISATION : " . $image->geo_image . "</span>" !!}
                                            {!! "<span class=\"txt_posteur\">" . $image->posteur->getGrade() . "</span>" !!}<br>
                                        <span class="txt_gras">Description de l'image</span> : {{ $image->description_image }}<br>
                                    </div>
                                @endforeach

                                {!! Form::submit('Mettre ces images en ligne', array('class' => 'btn btn-info pull-right')) !!}
                                {!! Form::close() !!}
                            @else
                                {{ "Aucune image à faire valider pour le moment"  }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection