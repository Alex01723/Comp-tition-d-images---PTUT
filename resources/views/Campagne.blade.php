@extends('app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default" style="overflow:auto;" >
                    <div class="panel-heading">{{ "Détail de la campagne " . $campagne->nom_campagne }}</div>
                    <div style="margin: 1%; margin-right: 5px;" >
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
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection