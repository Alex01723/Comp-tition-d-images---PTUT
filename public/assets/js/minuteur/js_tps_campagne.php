

$('#campagne_car').countdown('<?php echo $campagne->getDateCompteARebours(); ?>', function(event) {
    if ((event.strftime('%D') == 0) && ((event.strftime('%H')) == 0) && ((event.strftime('%M')) == 0) && ((event.strftime('%S')) == 0)) {
        $(this).html('<span class="txt_campagne_date">Terminé</span>');

        if (<?php echo (!$campagne->estTerminee() == true) ? "1" : "0"; ?>)
            window.location.reload();
    } else if ((event.strftime('%D') == 0) && ((event.strftime('%H')) == 0) && ((event.strftime('%M')) == 0)) {
        $(this).html('<span class="txt_campagne_date">' + event.strftime('%S ' + ((event.strftime('%S') > 1) ? 'secondes' : 'seconde')) + "</span>");
    } else if ((event.strftime('%D') == 0) && ((event.strftime('%H')) == 0)) {
        $(this).html('<span class="txt_campagne__date">' + event.strftime('%M min %S s') + "</span>");
    } else if ((event.strftime('%D') == 0)) {
        $(this).html('<span class="txt_campagne_date">' + event.strftime('%H:%M:%S') + "</span>");
    } else {
        $(this).html('<span class="txt_campagne_date">' + event.strftime('%D ' + ((event.strftime('%D') > 1) ? 'jours' : 'jour') + ' %H:%M:%S') + "</span>");
    }
});