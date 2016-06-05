$(document).ready(function() {


    $('button.delete-button').click(function() {

        var threadID = $(this).val();

        $.ajax({
          method: 'POST',
          url: './requests/delete.php',
          data: {threadID: threadID},
          success: function(msg) {
            if (parseInt(msg) == 1)
                location.reload();
          }

        });

        return false;

    });

    $('a.popup-trigger').click(
        function() {
            var href = $(this).data('img');
            var width = $(this).data('width');
            var type = $(this).data('type');


            if (type == 'image') {

                $('#popup i.fullscreen-icon').show();

                if (width > $('#popup .modal-dialog').width()) {
                    var img = $('<a href="' + href + '" target="_blank"><img class="fade" src="' + href + '" /></a>');
                    $(img).find('img').on('load', function() {

                        $('#popup .modal-body').html(img);
                        $('#popup').modal('show');
                    });

                } else {

                    var img = $('<img src="' + href + '" />');

                    img.on('load', function() {

                        $('#popup .modal-body').html(img);
                        $('#popup').modal('show');
                    });

                }


            } else {
                $('#popup i.fullscreen-icon').hide();

                var video = $('<video id="vid" src="' + href + '" controls style="display: none;"></video>' + '<i class="fa fa-spin fa-spinner loading"></i>');

                $('#popup .modal-body').html(video);
                $('#popup').modal('show');
                //	$('#popup .modal-dialog').width();
                $('#popup .modal-body video').on('canplaythrough', function() {

                    $(this).attr('style', '');
                    $('#popup').find('.fa-spinner').remove();

                });



            }

        });

    $('#popup').on('hide.bs.modal', function() {
        $('#popup video').stop();
    });


});
