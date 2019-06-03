jQuery(document).ready(function(){
	// Кнопки влево/вправо
	/*SliderWithLastBooks();
	SliderWithSelectedCategory();
	SliderWithSelectedAuthor();*/
	SliderRequest();
});
/*$(document).on('click', '.SliderButtonLeft', function() {
	var $Item = $(this).siblings('.SliderItems').children('.SliderItem');
		$Step = $Item.width() * 2;
		if(parseInt($Item.css('left')) < 0) {
			$Item.css('left', '+=' + $Step);
			console.log("work");
	};
});
$(document).on('click', '.SliderButtonRight', function() {
	var $Item = $(this).siblings('.SliderItems').children('.SliderItem');
		$Step = $Item.width() * 2;
		$SliderEnd = -(($Item.width() * $Item.length) - ($Step * 2));
		if(parseInt($Item.css('left')) >= $SliderEnd) {
			$Item.css('left', '-=' + $Step);
			console.log("work");
	};
});	*/

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
					/*$SliderTemplate = '<div class="Slider" id="' + $SliderID + '">\n'+
						'<div Class="SliderLogo">' + $catOrAutName + '</div>\n'+
						'<div class="SliderButton SliderButtonLeft"><img src="Img/ArrowL.png"></div>\n'+
						'<div class="SliderItems"></div>\n'+
						'<div class="SliderButton SliderButtonRight"><img src="Img/ArrowR.png"></div>\n'+
					'</div>\n';*/
					$SliderTemplate = '<div class="NewSlider"id="' + $SliderID + '">\n'+
										  '<div class="NewSliderHeader">' + $catOrAutName + '</div>\n'+
										  '<div class="NewSliderItemsContainer"></div>\n'+
										  '<button class="NewSliderButton NewSliderButtonLeft"><</button>\n'+
										  '<button class="NewSliderButton NewSliderButtonRight">></button>\n'+
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
	//$RequestSliderItems = 10; // количество выводимых книг
	//$SliderID = '#ListofLast';
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
							var	//$SliderID = '#SliderListofLast',
								$SliderBookId = book['BookID'],
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
	//$RequestSliderItemsCategory = 1; // категория выводимых книг
	//$RequestSliderItems = 20; // количество выводимых книг
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
							var	//$SliderID = '#SliderCategory1',
								$SliderBookId = book['BookID'],
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
	//$RequestSliderItemsAuthor = 1; // категория выводимых книг
	//$RequestSliderItems = 5; // количество выводимых книг
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
							var	//$SliderID = '#SliderAuthor1',
								$SliderBookId = book['BookID'],
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
	/*var $SliderItemTemplate = 
			'<div class="SliderItem">\n'+
				'<a href="book.php?BookInfo='+$SliderBookId+'" Class="SliderBookName">' + $SliderBookName + '</a>\n'+
				'<div class="SliderBookPreview"><img src="'+$Cover+'"></div>\n'+
				'<div class="SliderBookInfo">\n'+
					'<p>Год: ' + $SliderBookYear + '</p>\n'+
					'<p>Авторы: ' + $SliderBookAuthors + '</p>\n'+
					'<p>Категории: ' + $SliderBookCategories + '</p>\n'
				'</div>\n'+
			'</div>\n';
	$($SliderID).find('.SliderItems').append($SliderItemTemplate);*/
	var	$SliderItemTemplate = '<div class="NewSliderItem">\n' +
								'<a href="book.php?BookInfo=' + $SliderBookId + '" title="' + $SliderBookName + '"><img class="NewSliderBookCover" src="' + $Cover + '"></a>\n' +
									//'<span class="NewSliderBookName">\n' +
									'<a href="book.php?BookInfo=' + $SliderBookId + '" Class="NewSliderBookName">' + $SliderBookName + '</a>\n' +
									//'</span>\n' +
								'</div>\n';
	$($SliderID).find('.NewSliderItemsContainer').append($SliderItemTemplate);
	/*$($SliderID).find('.NewSliderButtonLeft').hide();*/
};