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
                    <nav id="admin_menu">
                        {!! $adminMenu->asUl( array('class' => 'nav navbar-nav') ) !!}
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection