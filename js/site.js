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
		$('#popup .modal-body').html('<video src="' + href + '" controls></video>');
		$('#popup').modal('show');


	}






	});

});
