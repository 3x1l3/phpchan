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


    $(document).on('click','div.back,div.forward',function() {

        var index = $(this).data('index');

        if (index < 0) {
          index = $(this).closest('.gallery').children('.thumb-cell').length-1;
          console.log(index);
        }
        else if (index >= $(this).closest('.gallery').children('.thumb-cell').length) {
          index = 0;
        }

        var info = $(this).closest('.gallery').children('.thumb-cell').eq(index).children('a');
        drawModal(info.data('img'),info.data('width'),info.data('type'),info.data('ext'),info.data('index'));
$('#popup').modal('handleUpdate');
    });


    $('a.popup-trigger').click(
        function() {



            var href = $(this).data('img');
            var width = $(this).data('width');
            var type = $(this).data('type');
            var ext = $(this).data('ext');
            var index = $(this).data('index');

            if (ext == 'jpg')
                ext = 'jpeg';

            drawModal(href, width, type, ext, index);





        });

    $('#popup').on('hide.bs.modal', function() {
        $('#popup video').stop();
    });


});


function drawModal(href, width, type, ext, index) {

    // $.ajax({
    //     type: 'POST',
    //     url: href,
    //     //  dataType: "image/" + ext,
    //     procssData: false,
    //     success: function(data) {

            if (type == 'image') {
                $('#popup i.fullscreen-icon').show();

                href = removeGetVar(href, 'base64');
                img = $('<div class="back" data-index="' + parseInt(index - 1) + '"><a href="#"><i class="fa fa-arrow-left"></i></a></div><div class="forward" data-index="' + parseInt(index +1) + '"><a href="#"><i class="fa fa-arrow-right"></i></a></div><a href="' + href + '" target="_blank"><img class="fade" src="'+ href + '" /></a>');

                $(img).find('img').on('load',function() {
                $('#popup .modal-body').html(img);
                  $('#popup').modal('show');
                });


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


    //     },
    //     error: function(e, textStatus, e2) {
    //         console.log(e2);
    //     }
    // });


}
