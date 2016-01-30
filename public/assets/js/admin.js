/**
 * Created by Admin on 29/01/2016.
 */


$('.image_a_valider').click(function() {
    var imgIndice = parseInt($(this).attr('id'));
    $('#' + imgIndice).toggleClass('image_a_valider image_validee');

    if ($('#' + imgIndice).attr('class') == 'image_validee') {
        $('input[name="radio' + imgIndice + '"][value="envoi_non"]').prop('checked', false);
        $('input[name="radio' + imgIndice + '"][value="envoi_oui"]').prop('checked', true);
    } else {
        $('input[name="radio' + imgIndice + '"][value="envoi_non"]').prop('checked', true);
        $('input[name="radio' + imgIndice + '"][value="envoi_oui"]').prop('checked', false);
    }
});