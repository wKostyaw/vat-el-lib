$(document).on('click', '.AddAutor', function(){
	$('<select name="BookAutor[]" class="Selector Autor">'+
		'<option>Пункт 1</option>'+
		'<option>Пункт 2</option>'+
		'</select>'
		).insertAfter('.Autor:last');
		$('.RemoveAutor').css('visibility', 'visible');
		if ($('.Autor').length == 8) {
			$('.AddAutor').css('visibility', 'hidden');
		}
});

$(document).on('click', '.RemoveAutor', function(){
		$('.Autor:last').remove();
		$('.AddAutor').css('visibility', 'visible');
		if ($('.Autor').length == 1) {
			$('.RemoveAutor').css('visibility', 'hidden');
		}
});

$(document).on('click', '.AddBookCategory', function(){
	$('<select name="BookCategory[]" class="Selector BookCategory">'+
		'<option>Пункт 1</option>'+
		'<option>Пункт 2</option>'+
		'</select>'
		).insertAfter('.BookCategory:last');
		$('.RemoveCategory').css('visibility', 'visible');
		if ($('.BookCategory').length == 8) {
			$('.AddBookCategory').css('visibility', 'hidden');
		}
});

$(document).on('click', '.RemoveCategory', function(){
	$('.BookCategory:last').remove();
	$('.AddBookCategory').css('visibility', 'visible');
	if ($('.BookCategory').length == 1) {
		$('.RemoveCategory').css('visibility', 'hidden');
	}
});
