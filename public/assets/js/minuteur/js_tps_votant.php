$('#<?php echo $minuteur_num; ?>').countdown('<?php echo $campagne->date_fin; ?>', function(event) {
    if ((event.strftime('%D') == 0) && ((event.strftime('%H')) == 0) && ((event.strftime('%M')) == 0) && ((event.strftime('%S')) == 0)) {
        $(this).html("<a style=\"color: #FFFFFF;\" href=\"jugement/" + <?php echo $campagne->id_campagne; ?> + "/filtrer\">Participer au jugement</a>");
        $(".bouton_voter").attr("class", "bouton_voter bouton_voter_ok");
    } else if ((event.strftime('%D') == 0) && ((event.strftime('%H')) == 0) && ((event.strftime('%M')) == 0)) {
        $(this).html('<span class="format_date"> Début dans ' + event.strftime('%S ' + ((event.strftime('%S') > 1) ? 'secondes' : 'seconde')) + "</span>");
    } else if ((event.strftime('%D') == 0) && ((event.strftime('%H')) == 0)) {
        $(this).html('<span class="format_date"> Début dans ' + event.strftime('%M min %S s') + "</span>");
    } else if ((event.strftime('%D') == 0)) {
        $(this).html('<span class="format_date"> Début dans ' + event.strftime('%H:%M:%S') + "</span>");
    } else {
        $(this).html('<span class="format_date"> Début dans ' + event.strftime('%D ' + ((event.strftime('%D') > 1) ? 'jours' : 'jour') + ' %H:%M:%S') + "</span>");
    }
});