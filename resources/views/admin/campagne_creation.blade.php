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

<!-- Contenu de la page de création d'une campagne -->
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Création d'une campagne</div>

                    <div class="panel-body">
                        {!! Form::open() !!}

                        <div class="form-group {!! $errors->has('Campagne') ? 'has-error' : '' !!}">
                            {!! Form::text('nom_campagne', null, array('class' => 'form-control', 'placeholder' => 'Entrez le nom de la campagne')) !!}
                            {!! $errors->first('nom_campagne', '<small class="help-block">:message</small>') !!}
                        </div>
                        <div class="form-group {!! $errors->has('Campagne') ? 'has-error' : '' !!}">
                            {!! Form::textarea('description_campagne', null, array('class' => 'form-control', 'placeholder' => 'Entrez la description de la campagne')) !!}
                            {!! $errors->first('description_campagne', '<small class="help-block">:message</small>') !!}
                        </div>
                        <div class="form-group {!! $errors->has('Campagne') ? 'has-error' : '' !!}">
                            {!! Form::label('date_debut', 'Date de debut de la campagne:') !!}
                            {!! Form::input('date','date_debut',\Carbon\Carbon::tomorrow()->format('d/m/Y')) !!}
                            {!! $errors->first('date_debut', '<small class="help-block">:message</small>') !!}
                        </div>
                        <div class="form-group {!! $errors->has('Campagne') ? 'has-error' : '' !!}">
                            {!! Form::label('date_fin', 'Date de fin de la campagne:') !!}
                            {!! Form::input('date','date_fin', \Carbon\Carbon::tomorrow()->addWeek(2)->format('d/m/Y')) !!}

                            {!! $errors->first('date_fin', '<small class="help-block">:message</small>') !!}
                        </div>
                        <div class="form-group {!! $errors->has('Campagne') ? 'has-error' : '' !!}">
                            {!! Form::label('choix_binaire', 'Choix binaire :') !!}
                            {!!  Form::checkbox('choix_binaire', '1') !!}
                            {!! $errors->first('choix_binaire', '<small class="help-block">:message</small>') !!}
                        </div>
                        <div class="form-group {!! $errors->has('Campagne') ? 'has-error' : '' !!}">
                            {!! Form::label('choix_validation', 'Validation des images du contribueur :') !!}
                            {!!  Form::checkbox('choix_validation', '1') !!}
                            {!! $errors->first('choix_validation', '<small class="help-block">:message</small>') !!}
                        </div>
                        <div class="form-group {!! $errors->has('Campagne') ? 'has-error' : '' !!}">
                            {!! Form::label('choix_popularite', 'Part de l\'importance des vote des utilisateurs :') !!}
                            {!! Form::input('number','choix_popularite', 50, ['max' => '50','min'=>'0']) !!}
                            {!! $errors->first('choix_popularite', '<small class="help-block">:message</small>') !!}
                        </div>


                        {!! Form::submit('Envoyer !', array('class' => 'btn btn-info pull-right')) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection