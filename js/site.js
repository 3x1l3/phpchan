function removeGetVar(queryStr, name) {
    var chunks = queryStr.split('&');

    chunks.forEach(function(val, index) {
        var subchunk = val.split('=');
        if (subchunk[0] == name) {
            chunks.splice(index, 1);
        }



    });

    return chunks.join('&');
}

$(document).ready(function() {


    $('button.delete-button').click(function() {

        var threadID = $(this).val();

        $.ajax({
            method: 'POST',
            url: './requests/delete.php',
            data: {
                threadID: threadID
            },
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
            var ext = $(this).data('ext');

            if (ext == 'jpg')
                ext = 'jpeg';



            $.ajax({
                type: 'GET',
                url: href,
                //  dataType: "image/" + ext,
                procssData: false,
                success: function(data) {

                    if (type == 'image') {
                        $('#popup i.fullscreen-icon').show();

                        href = removeGetVar(href, 'base64');

                        console.log();

                        if (width > $('#popup .modal-dialog').width()) {
                            img = $('<a href="' + href + '" target="_blank"><img class="fade" src="data:image/' + ext + ';base64,' + data + '" /></a>');
                        } else {
                            img = $('<img src="' + data + '" />');

                        }
                        $('#popup .modal-body').html(img);
                        $('#popup').modal('show');
                    } else {

                        $('#popup i.fullscreen-icon').hide();

                        var video = $('<video id="vid" src="data:video/' + ext + ';base64,' + data + '" controls style="display: none;"></video>' + '<i class="fa fa-spin fa-spinner loading"></i>');

                        $('#popup .modal-body').html(video);
                        $('#popup').modal('show');
                        //	$('#popup .modal-dialog').width();
                        $('#popup .modal-body video').on('canplaythrough', function() {

                            $(this).attr('style', '');
                            $('#popup').find('.fa-spinner').remove();

                        });



                    }


                },
                error: function(e, textStatus, e2) {
                    console.log(e2);
                }
            });




        });

    $('#popup').on('hide.bs.modal', function() {
        $('#popup video').stop();
    });


});
