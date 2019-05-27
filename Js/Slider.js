jQuery(document).ready(function(){
	// Кнопки влево/вправо
	SliderWithLastBooks();
	SliderWithSelectedCategory();
	SliderWithSelectedAuthor();
	
	
	$('.SliderButtonLeft').on('click', function() {
		var $Item = $(this).siblings('.SliderItems').children('.SliderItem');
			$Step = $Item.width() * 2;
			if(parseInt($Item.css('left')) < 0) {
				$Item.css('left', '+=' + $Step);
				console.log("work");
			};
	});
	$('.SliderButtonRight').on('click', function() {
		var $Item = $(this).siblings('.SliderItems').children('.SliderItem');
			$Step = $Item.width() * 2;
			$SliderEnd = -(($Item.width() * $Item.length) - ($Step * 2));
			if(parseInt($Item.css('left')) >= $SliderEnd) {
				$Item.css('left', '-=' + $Step);
				console.log("work");
			};
	});	
});

/* Функция выводящая последние добавленные книги */
function SliderWithLastBooks() {
	$RequestSliderItems = 10; // количество выводимых книг
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
							var	$SliderID = '#SliderListofLast',
								$SliderBookId = book['BookID'],
								$SliderBookName = book['BookName'],
								$SliderBookYear  = book['BookYear'],
								$PathToFile = book['PathToFile'],
								$Cover = book['PathToСover'],
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
function SliderWithSelectedCategory() {
	$RequestSliderItemsCategory = 'Роман'; // категория выводимых книг
	$RequestSliderItems = 20; // количество выводимых книг
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
							var	$SliderID = '#SliderCategory1',
								$SliderBookId = book['BookID'],
								$SliderBookName = book['BookName'],
								$SliderBookYear  = book['BookYear'],
								$PathToFile = book['PathToFile'],
								$Cover = book['PathToСover'],
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
function SliderWithSelectedAuthor() {
	$RequestSliderItemsAuthor = 'Пушкин А. С.'; // категория выводимых книг
	$RequestSliderItems = 5; // количество выводимых книг
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
							var	$SliderID = '#SliderAuthor1',
								$SliderBookId = book['BookID'],
								$SliderBookName = book['BookName'],
								$SliderBookYear  = book['BookYear'],
								$PathToFile = book['PathToFile'],
								$Cover = book['PathToСover'],
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
	var $SliderItemTemplate = 
			'<div class="SliderItem">\n'+
				'<a href="book.php?BookInfo='+$SliderBookId+'" Class="SliderBookName">' + $SliderBookName + '</a>\n'+
				'<div class="SliderBookPreview"><img src="'+$Cover+'"></div>\n'+
				'<div class="SliderBookInfo">\n'+
					'<p>Год: ' + $SliderBookYear + '</p>\n'+
					'<p>Авторы: ' + $SliderBookAuthors + '</p>\n'+
					'<p>Категории: ' + $SliderBookCategories + '</p>\n'
				'</div>\n'+
			'</div>\n';
	$($SliderID).children('.SliderItems').append($SliderItemTemplate);
};