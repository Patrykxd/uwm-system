$(document).ready(function () {

    $('.child-li').click(function (e) {
        e.preventDefault();

        if ($(this).find('.child-menu').is(':visible')) {
            $(this).find('.child-menu').hide('fast');
        } else {
            $('.child-menu').hide('fast');
            $(this).find('.child-menu').show('fast');
        }
    });
    $('.child-menu').click(function (e) {
        e.stopPropagation();
    });
});

function copyClip(item) {
    item.select();
    var alert = document.querySelector('.alerts');
    if (alert != null) {
        alert.remove();
    }
    try {
        var successful = document.execCommand('copy');
        var msg = successful ? '' : 'nie';

        message = '<div class="alerts alerts-success" style="top:10px" onclick="this.remove()"><i class="fa fa-exclamation" aria-hidden="true"></i><strong>Link ' + msg + 'skopiowany do schowka!</strong>&nbsp;<b>&times;</b></div>';
        document.querySelector('.panel-view .container-fluid').innerHTML += (message);
    } catch (err) {
        message = '<div class="alerts alerts-danger" style="top:10px" onclick="this.remove()"><i class="fa fa-exclamation" aria-hidden="true"></i><strong>"nie udało się skopiować pola"</strong>&nbsp;<b>&times;</b></div>';
        document.querySelector('.panel-view .container-fluid').innerHTML += (message);
    }

}