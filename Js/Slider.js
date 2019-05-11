$(document).ready(), function() {
	/*var i = 0;
	var SPosition = 0;
	var CPosition = 0;
	var EPosition = 0;
	var SliderItems = $(".ExampleSliderItem");
	var  width = $(".ExampleSliderItem").width();*/
	/*function LeftButtonClick() {
		if (EPosition < 0) {
			EPosition = SPosition + width*2;
			for (CPosition = SPosition; CPosition <= EPosition; CPosition++) {
				for (i=0; i<=SliderItems.length-1; i++) {
					SliderItems[i].style.left = CPosition + 'px';
				}
			}
			SPosition = EPosition;
		}
	}
	function RightButtonClick() {
		if (EPosition > -width*(SliderItems.length-3)) {
			EPosition = SPosition - width*2;
			for (CPosition = SPosition; CPosition >= EPosition; CPosition--) {
				for (i=0; i<=SliderItems.length-1; i++) {
					SliderItems[i].style.left = CPosition + 'px';
				}
			}
			SPosition = EPosition;
		}
	}*/
	
	// Последние добавленные книги
	
	
	/*var	$PathToFile = '',
		$SliderBookName = '',
		$SliderBookYear  = '',
		$SliderBookAuthors = '',
		$SliderBookCategories = '';*/
	
	//$(".SliderItems").html(data); //создание элемента внутри слайдера
	
	
	// Кнопки влево/вправо
	$('.SliderButtonLeft').on('click', function() {
		var $Item = $(this).siblings('.SliderItems').children('.SliderItem'),
			$Step = $Item.width() * 2;
			if(parseInt($Item.css('left')) < 0) {
				$Item.css('left', '+=' + $Step);
			};
	});
	$('.SliderButtonRight').on('click', function() {
		var $Item = $(this).siblings('.SliderItems').children('.SliderItem');
			$Step = $Item.width() * 2 /*+ 'px'*/,
			$SliderEnd = -(($Item.width() * $Item.length) - ($Step * 2));
			if(parseInt($Item.css('left')) >= $SliderEnd) {
				$Item.css('left', '-=' + $Step);
			};
	});
	
	
	
	SliderWithLastBooks();
	SliderWithSelectedCategory();
	SliderWithSelectedAuthor();
}();

/* Функция выводящая последние добавленные книги */
function SliderWithLastBooks() {
	$RequestSliderItems = 5; // количество выводимых книг
	//$SliderID = '#ListofLast';
	$.ajax (
				{
					url: 'SliderTest.php',
					method: 'POST',
					data: {
						SliderLastItemRequest: $RequestSliderItems,
					},
					success: function (data) {
						var LastBooks = JSON.parse(data);
						$.each(LastBooks, function() {
							book = this;
							var	$SliderID = '#ListofLast';
								$SliderBookName = book['BookName'];
								$SliderBookYear  = book['BookYear'],
								$PathToFile = book['PathToFile'],
								$SliderBookAuthors = book['BookAuthors'],
								$SliderBookCategories = book['BookCategories'];
								makeItem($SliderID, $SliderBookName, $SliderBookYear, $PathToFile, $SliderBookAuthors, $SliderBookCategories);
						})
					},
					dataType: 'text'
				}
			);
};
// Функция, выводящая книги определенной категории
function SliderWithSelectedCategory() {
	//$SliderID = '#Category1';
	$RequestSliderItemsCategory = 'Роман'; // категория выводимых книг
	$RequestSliderItems = 5; // количество выводимых книг
	$.ajax (
				{
					url: 'SliderTest.php',
					method: 'POST',
					data: {
						SliderCategoryRequest: $RequestSliderItemsCategory,
						SliderAmountOfItems:$RequestSliderItems
					},
					success: function (data) {
						var LastBooks = JSON.parse(data);
						$.each(LastBooks, function() {
							book = this;
							var	$SliderID = '#Category1';
								$SliderBookName = book['BookName'];
								$SliderBookYear  = book['BookYear'],
								$PathToFile = book['PathToFile'],
								$SliderBookAuthors = book['BookAuthors'],
								$SliderBookCategories = book['BookCategories'];
								makeItem($SliderID, $SliderBookName, $SliderBookYear, $PathToFile, $SliderBookAuthors, $SliderBookCategories);
						})
					},
					dataType: 'text'
				}
			);
};
// Функция, выводящая книги определенного автора
function SliderWithSelectedAuthor() {
	$RequestSliderItemsAuthor = 'Автор 13'; // категория выводимых книг
	$RequestSliderItems = 5; // количество выводимых книг
	$.ajax (
				{
					url: 'SliderTest.php',
					method: 'POST',
					data: {
						SliderAuthorRequest: $RequestSliderItemsAuthor,
						SliderAmountOfItems:$RequestSliderItems
					},
					success: function (data) {
						var LastBooks = JSON.parse(data);
						$.each(LastBooks, function() {
							book = this;
							var	$SliderID = '#Author1',
								$SliderBookName = book['BookName'],
								$SliderBookYear  = book['BookYear'],
								$PathToFile = book['PathToFile'],
								$SliderBookAuthors = book['BookAuthors'],
								$SliderBookCategories = book['BookCategories'];
								makeItem($SliderID, $SliderBookName, $SliderBookYear, $PathToFile, $SliderBookAuthors, $SliderBookCategories);
						})
					},
					dataType: 'text'
				}
			);
};

// Рисуем элементы в слайдер с указанным Id
function makeItem($SliderID, $SliderBookName, $SliderBookYear, $PathToFile, $SliderBookAuthors, $SliderBookCategories) {
	var $SliderItemTemplate = 
			'<div class="SliderItem">\n'+
				'<a href="' + $PathToFile + '" Class="SliderBookName">' + $SliderBookName + '</a>\n'+
				'<div class="SliderBookPreview"><img src="img/BookDefault.png"></div>\n'+
				'<div class="SliderBookInfo">\n'+
					'<p>Год: ' + $SliderBookYear + '</p>\n'+
					'<p>Авторы: ' + $SliderBookAuthors + '</p>\n'+
					'<p>Категории: ' + $SliderBookCategories + '</p>\n'
				'</div>\n'+
			'</div>\n';
	$($SliderID).children('.SliderItems').append($SliderItemTemplate);
};