@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Soumission d'une Image</div>

                    <div class="panel-body">
                        {!! Form::open(array('files' => true)) !!}

                        <div class="form-group {!! $errors->has('Image') ? 'has-error' : '' !!}">
                            {!! Form::text('titre_image', null, array('class' => 'form-control', 'placeholder' => 'Entrez le titre de l\'image')) !!}
                            {!! $errors->first('titre_image', '<small class="help-block">:message</small>') !!}
                        </div>
                        <div class="form-group {!! $errors->has('Image') ? 'has-error' : '' !!}">
                            {!! Form::textarea('description_image', null, array('class' => 'form-control', 'placeholder' => 'Entrez la description de l\'image')) !!}
                            {!! $errors->first('description_image', '<small class="help-block">:message</small>') !!}
                        </div>

                        <div class="form-group {!! $errors->has('Image') ? 'has-error' : '' !!}">
                            {!! Form::file('image') !!}
                            {!! $errors->first('image', '<small class="help-block">:message</small>') !!}
                        </div>

                        {!! Form::submit('Envoyer !', array('class' => 'btn btn-info pull-right')) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection