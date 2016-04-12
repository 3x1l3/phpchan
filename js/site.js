$(document).ready(function() {


//	$('a.image').fancybox();


	$('a.popup-trigger').click(
		function() {

		var href = $(this).data('img');
		var width = $(this).data('width');
		var type = $(this).data('type');


		if (type == 'image') {
			$('#popup i.fullscreen-icon').show();

		if (width > $('#popup .modal-dialog').width()) {
			var img = $('<a href="'+href+'" target="_blank"><img class="fade" src="'+ href  +'" /></a>');
			img.find('img').on('load', function() {
				$('#popup .modal-body').html(img);
				$('#popup').modal('show');
			});
		} else {

			var img = $('<img src="'+ href  +'" />');
			img.on('load', function() {
				$('#popup .modal-body').html(img);
				$('#popup').modal('show');
			});

		}
	} else {
$('#popup i.fullscreen-icon').hide();

		var video = $('<video src="' + href + '" controls style="display: none;"></video>'+'<div class="progress"><div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div></div>');

			$('#popup .modal-body').html(video);
			$('#popup').modal('show');
		//	$('#popup .modal-dialog').width();
		$('#popup .modal-body video').on('canplaythrough',function(){

			$(this).attr('style','');
			$('#popup').find('.fa-spinner').remove();

		});


$('#popup video').bind("progress",function(e){
	console.log(e);
	var percentComplete = e.loaded/e.total;
        console.log(e.total + ' ' + e.loaded + ' ' + e.lengthComputable );
					$('#popup .progress .progress-bar').width(percentComplete+'%')
    });


	}






	});

});
