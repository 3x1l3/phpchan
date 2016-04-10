$(document).ready(function() {

	$('a.webm').fancybox({
		'hideOnContentClick': true
	}).on('onComplete',function() {

		});

//	$('a.image').fancybox();


	$('a.popup-trigger').click(
		function() {

		var href = $(this).data('img');
		var width = $(this).data('width');

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






	});

});
