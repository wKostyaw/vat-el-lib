jQuery(document).ready(function(){
	SliderRequest();
});


$(document).on('click', '.NewSliderButtonLeft', function() {
	var $NewItem = $(this).siblings('.NewSliderItemsContainer');
	$NewItem.animate( { scrollLeft: '-=476' }, 500);
});
$(document).on('click', '.NewSliderButtonRight', function() {
	var $NewItem = $(this).siblings('.NewSliderItemsContainer');
	$NewItem.animate( { scrollLeft: '+=476' }, 500);
});

function SliderRequest() {
	$.ajax ({
		url: 'Slider.php',
		method: 'POST',
		data: {
			SliderRequest: 1,
		},
		success: function (data) {
			var SlidersInfo = JSON.parse(data);
			$.each(SlidersInfo, function() {
				var SliderInfo = this;
					$SliderID = "Slider" + SliderInfo['sliderId'],
					$whatToDo = SliderInfo['whatToDo'],
					$amount = SliderInfo['amount'],
					$catOrAutId = SliderInfo['categoryOrAuthorID'],
					$catOrAutName = SliderInfo['catOrAutName'],
					$SliderTemplate = '<div class="NewSlider"id="' + $SliderID + '">\n'+
										  '<div class="NewSliderHeader">' + $catOrAutName + '</div>\n'+
										  '<div class="NewSliderItemsContainer"></div>\n'+
										  '<button class="NewSliderButton NewSliderButtonLeft">\n'+
											'<svg width="30" height="100" version="1.1" viewBox="0 0 13.229 26.458" xmlns="http://www.w3.org/2000/svg">\n'+
											  '<g transform="translate(0 -270.54)">\n'+
												'<path d="m11.9 271.86-10.583 11.906 10.583 11.906" fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.3229"/>\n'+
											  '</g>\n'+
											'</svg></button>\n'+
										  '<button class="NewSliderButton NewSliderButtonRight">\n'+
										  '<svg width="30" height="100" version="1.1" viewBox="0 0 13.229 26.458" xmlns="http://www.w3.org/2000/svg">\n'+
											'<g transform="translate(0 -270.54)">\n'+
											  '<path d="m1.3229 271.86 10.583 11.906-10.583 11.906" fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.3229"/>\n'+
											'</g>\n'+
										  '</svg></button>\n'+
									  '</div>\n';
					
					$('.SiteContent').append($SliderTemplate);
					$SliderID = '#' + $SliderID;
					
					if ($whatToDo == 0) {
						SliderWithLastBooks($SliderID, $amount)
					} else if ($whatToDo == 1) {
						SliderWithSelectedAuthor($SliderID ,$amount, $catOrAutId)
					} else if ($whatToDo == 2) {
						SliderWithSelectedCategory($SliderID ,$amount, $catOrAutId)
					}
			});
		},
		dataType: 'text'
	});
}
/* Функция выводящая последние добавленные книги */
function SliderWithLastBooks($SliderID, $RequestSliderItems) {
	$.ajax (
				{
					url: 'Slider.php',
					method: 'POST',
					data: {
						SliderLastItemRequest: $RequestSliderItems,
					},
					success: function (data) {
						var LastBooks = JSON.parse(data);
						$.each(LastBooks, function() {
							book = this;
							var	$SliderBookId = book['BookID'],
								$SliderBookName = book['BookName'],
								$SliderBookYear  = book['BookYear'],
								$PathToFile = book['PathToFile'],
								$Cover = book['PathToCover'],
								$SliderBookAuthors = book['BookAuthors'],
								$SliderBookCategories = book['BookCategories'];
								makeItem($SliderID, $SliderBookId, $SliderBookName, $SliderBookYear, $PathToFile, $Cover, $SliderBookAuthors, $SliderBookCategories);
						})
					},
					dataType: 'text'
				}
			);
};
// Функция, выводящая книги определенной категории
function SliderWithSelectedCategory($SliderID, $RequestSliderItems, $RequestSliderItemsCategory) {
	$.ajax (
				{
					url: 'Slider.php',
					method: 'POST',
					data: {
						SliderCategoryRequest: $RequestSliderItemsCategory,
						SliderAmountOfItems:$RequestSliderItems
					},
					success: function (data) {
						var LastBooks = JSON.parse(data);
						$.each(LastBooks, function() {
							book = this;
							var	$SliderBookId = book['BookID'],
								$SliderBookName = book['BookName'],
								$SliderBookYear  = book['BookYear'],
								$PathToFile = book['PathToFile'],
								$Cover = book['PathToCover'],
								$SliderBookAuthors = book['BookAuthors'],
								$SliderBookCategories = book['BookCategories'];
								makeItem($SliderID, $SliderBookId, $SliderBookName, $SliderBookYear, $PathToFile, $Cover, $SliderBookAuthors, $SliderBookCategories);
						})
					},
					dataType: 'text'
				}
			);
};
// Функция, выводящая книги определенного автора
function SliderWithSelectedAuthor($SliderID, $RequestSliderItems, $RequestSliderItemsAuthor) {
	$.ajax (
				{
					url: 'Slider.php',
					method: 'POST',
					data: {
						SliderAuthorRequest: $RequestSliderItemsAuthor,
						SliderAmountOfItems:$RequestSliderItems
					},
					success: function (data) {
						var LastBooks = JSON.parse(data);
						$.each(LastBooks, function() {
							book = this;
							var	$SliderBookId = book['BookID'],
								$SliderBookName = book['BookName'],
								$SliderBookYear  = book['BookYear'],
								$PathToFile = book['PathToFile'],
								$Cover = book['PathToCover'],
								$SliderBookAuthors = book['BookAuthors'],
								$SliderBookCategories = book['BookCategories'];
								makeItem($SliderID, $SliderBookId, $SliderBookName, $SliderBookYear, $PathToFile, $Cover, $SliderBookAuthors, $SliderBookCategories);
						})
					},
					dataType: 'text'
				}
			);
};
// Рисуем элементы в слайдер с указанным Id
function makeItem($SliderID, $SliderBookId, $SliderBookName, $SliderBookYear, $PathToFile, $Cover, $SliderBookAuthors, $SliderBookCategories) {
	var	$SliderItemTemplate = '<div class="NewSliderItem">\n' +
								'<div class="NewSliderItemImageContainer">\n' +
								  '<a href="book.php?BookInfo=' + $SliderBookId + '" title="' + $SliderBookName + '"><img class="NewSliderBookCover" src="' + $Cover + '"></a>\n' +
								'</div>\n' +
									'<a href="book.php?BookInfo=' + $SliderBookId + '" Class="NewSliderBookName">' + $SliderBookName + '</a>\n' +
								'</div>\n';
	$($SliderID).find('.NewSliderItemsContainer').append($SliderItemTemplate);
};