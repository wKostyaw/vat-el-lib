$(document).on('click', '.AddAutor', function(){
	$('<select class="Selector Autor">\n'+
		'<option>Пункт 1</option>\n'+
		'<option>Пункт 2</option>\n'+
		'</select>\n'
    ).insertBefore(this);
});
$(document).on('click', '.AddBookCategory', function(){
	$('<select class="Selector BookCategory">\n'+
		'<option>Пункт 1</option>\n'+
		'<option>Пункт 2</option>\n'+
		'</select>\n'
    ).insertBefore(this);
});