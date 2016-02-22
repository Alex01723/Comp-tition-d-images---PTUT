$('#<?php echo $minuteur_num; ?>').countdown('<?php echo $campagne->date_fin; ?>', function(event) {
    if ((event.strftime('%D') == 0) && ((event.strftime('%H')) == 0) && ((event.strftime('%M')) == 0) && ((event.strftime('%S')) == 0)) {
        $(this).html("—");
    } else if ((event.strftime('%D') == 0) && ((event.strftime('%H')) == 0) && ((event.strftime('%M')) == 0)) {
        $(this).html('<span class="format_date">' + event.strftime('%S ' + ((event.strftime('%S') > 1) ? 'secondes' : 'seconde')) + "</span>");
    } else if ((event.strftime('%D') == 0) && ((event.strftime('%H')) == 0)) {
        $(this).html('<span class="format_date">' + event.strftime('%M min %S s') + "</span>");
    } else if ((event.strftime('%D') == 0)) {
        $(this).html('<span class="format_date">' + event.strftime('%H:%M:%S') + "</span>");
    } else {
        $(this).html('<span class="format_date">' + event.strftime('%D ' + ((event.strftime('%D') > 1) ? 'jours' : 'jour') + ' %H:%M:%S') + "</span>");
    }
});

$('#<?php echo $minuteur_num_fv; ?>').countdown('<?php echo $campagne->date_fin_vote; ?>', function(event) {
    if ((event.strftime('%D') == 0) && ((event.strftime('%H')) == 0) && ((event.strftime('%M')) == 0) && ((event.strftime('%S')) == 0)) {
        $(this).html("—");
    } else if ((event.strftime('%D') == 0) && ((event.strftime('%H')) == 0) && ((event.strftime('%M')) == 0)) {
        $(this).html('<span class="format_date">' + event.strftime('%S ' + ((event.strftime('%S') > 1) ? 'secondes' : 'seconde')) + "</span>");
    } else if ((event.strftime('%D') == 0) && ((event.strftime('%H')) == 0)) {
        $(this).html('<span class="format_date">' + event.strftime('%M min %S s') + "</span>");
    } else if ((event.strftime('%D') == 0)) {
        $(this).html('<span class="format_date">' + event.strftime('%H:%M:%S') + "</span>");
    } else {
        $(this).html('<span class="format_date">' + event.strftime('%D ' + ((event.strftime('%D') > 1) ? 'jours' : 'jour') + ' %H:%M:%S') + "</span>");
    }
});

$('#<?php echo $minuteur_num_db; ?>').countdown('<?php echo $campagne->date_debut; ?>', function(event) {
    if ((event.strftime('%D') == 0) && ((event.strftime('%H')) == 0) && ((event.strftime('%M')) == 0) && ((event.strftime('%S')) == 0)) {
        $(this).html("—");
    } else if ((event.strftime('%D') == 0) && ((event.strftime('%H')) == 0) && ((event.strftime('%M')) == 0)) {
        $(this).html('<span class="format_date">' + event.strftime('%S ' + ((event.strftime('%S') > 1) ? 'secondes' : 'seconde')) + "</span>");
    } else if ((event.strftime('%D') == 0) && ((event.strftime('%H')) == 0)) {
        $(this).html('<span class="format_date">' + event.strftime('%M min %S s') + "</span>");
    } else if ((event.strftime('%D') == 0)) {
        $(this).html('<span class="format_date">' + event.strftime('%H:%M:%S') + "</span>");
    } else {
        $(this).html('<span class="format_date">' + event.strftime('%D ' + ((event.strftime('%D') > 1) ? 'jours' : 'jour') + ' %H:%M:%S') + "</span>");
    }
});