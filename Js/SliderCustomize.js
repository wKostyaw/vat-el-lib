$(document).ready(function () {
	
	$(document).on('click', '#AddSlider', function() {
		$('#SliderPreview').html("");
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
				refreshSliderInfo();
			},
			dataType: 'text'
		});
		$('.sliderOptions input[type="text"]').val('');
	});
	
	$(document).on('click', '.deleteSlider', function() {
		$('#SliderPreview').html("");
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
				refreshSliderInfo();
			},
			dataType: 'text'
		});		
	});
	
	function refreshSliderInfo() {
		$.ajax ({
			url: 'CustomizeSlider.php',
			method: 'POST',
			data: {
				refreshSliderInfo: 1,
			},
			success: function (data) {
				var Sliders = JSON.parse(data);
				$.each(Sliders, function() {
					var SliderInfo = this,
					$SliderID = SliderInfo['sliderId'],
					$whatToDo = SliderInfo['whatToDo'],
					$amount = SliderInfo['amount'],
					$catOrAutId = SliderInfo['categoryOrAuthorID'],
					$catOrAutName = SliderInfo['catOrAutName'];
					$SliderType = "";
					
					if ($whatToDo == 0) {
						$SliderType = '<span class="SBText">Последние загруженные книги</span>\n'
	
					} else if ($whatToDo == 1) {
						$SliderType = '<span class="SBText">Книги автора: </span>\n' +
									  '<span class="SBText">' + $catOrAutName + '</span>\n'
					} else if ($whatToDo == 2) {
						$SliderType = '<span class="SBText">Книги категории: </span>\n' +
									  '<span class="SBText">' + $catOrAutName + '</span>\n'
					}
					
					var rowTemplate = '<div class="sliderBox flexContainer">\n' +
									'<span class="SBCell">\n' +
										$SliderType +
										'<span class="SBSpace"></span>\n' +
									'</span>\n' +
									'<span class="SBCell">\n' +
										'<span class="SBText">Максимальное количество элементов: </span>\n' +
										'<span class="SBText">' + $amount + '</span>\n' +
									'</span>\n' +
									'<button type="button" Class="deleteSlider" title="удалить" id="' + $SliderID + '">\n' +
										'<svg class="SButtonIcon" x="0px" y="0px" width="16" height="16" viewBox="0 0 192 192">\n' +
											'<path d="M45.65625,34.34375l-11.3125,11.3125l50.34375,50.34375l-50.34375,50.34375l11.3125,11.3125l50.34375,-50.34375l50.34375,50.34375l11.3125,-11.3125l-50.34375,-50.34375l50.34375,-50.34375l-11.3125,-11.3125l-50.34375,50.34375z"></path>\n' +
										'</svg>\n' +
									'</button>\n' +
								'</div>';
				$('#SliderPreview').append(rowTemplate);
				});
			},
			dataType: 'text'
		});
	}
	
	$('.whatToDo').change(function() {
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