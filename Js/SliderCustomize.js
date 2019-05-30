$(document).ready(function () {
	
	$(document).on('click', '#AddSlider', function() {
		var whatToDo = $('.sliderOptField').val(),
			sliderName = $('.sliderName').val(),
			amount = $('.amount').val();
		
		$.ajax ({
			url: 'CustomizeSlider.php',
			method: 'POST',
			data: {
				addNewSlider: 1,
				whatToDo: whatToDo,
				sliderName: sliderName,
				amount: amount
			},
			success: function (data) {
				alert('Добавлено');
			},
			dataType: 'text'
		});
		//location.reload();
	});
	
	$(document).on('click', '.deleteSlider', function() {
		var SliderId = $(this).attr('id');
		$.ajax ({
			url: 'CustomizeSlider.php',
			method: 'POST',
			data: {
				delSlider: 1,
				SliderId: SliderId
			},
			success: function (data) {
				alert('Удалено');
			},
			dataType: 'text'
		});
		location.reload();
	});
	
	$('.whatToDo').change(function() {
		//alert($(this).val());
		var CatOrAutBlock = $(document).find('.SOHide'),
			CatOrAutName = CatOrAutBlock.find('p');
		if ($(this).val() == 0) {
			CatOrAutBlock.css("display", "none");
			CatOrAutName.html("");
			$(document).find('.sliderNameContainer').removeClass('BookAuthorContainer');
			$(document).find('.sliderNameContainer').removeClass('BookCategoryContainer');
			$(document).find('.sliderName').removeClass('BookAuthor');
			$(document).find('.sliderName').removeClass('BookCategory');
		} else if ($(this).val() == 1) {
			CatOrAutBlock.css("display", "block");
			CatOrAutName.html("Введите автора");
			$(document).find('.sliderNameContainer').addClass('BookAuthorContainer');
			$(document).find('.sliderNameContainer').removeClass('BookCategoryContainer');
			$(document).find('.sliderName').addClass('BookAuthor');
			$(document).find('.sliderName').removeClass('BookCategory');
		} else if ($(this).val() == 2) {
			CatOrAutBlock.css("display", "block");
			CatOrAutName.html("Введите категорию");
			$(document).find('.sliderNameContainer').removeClass('BookAuthorContainer');
			$(document).find('.sliderNameContainer').addClass('BookCategoryContainer');
			$(document).find('.sliderName').removeClass('BookAuthor');
			$(document).find('.sliderName').addClass('BookCategory');
		}
	});
	
});