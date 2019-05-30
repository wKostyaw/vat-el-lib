$(document).ready(function(){
	// autocomplete для категорий
	$(document).on('keyup' ,'.BookCategory', function() {
		var query5 = $(this).val(),
			hintBox = $(this).parents(".BookCategoryContainer").find(".responseCategory");
		if (query5.length > 0) {
			$.ajax (
				{
					url: 'autocomplete.php',
					method: 'POST',
					data: {
						searchCategory: 1,
						q5: query5
					},
					success: function (data) {
						hintBox.html(data);
					},
					dataType: 'text'
				}
			);			
		}
	});
	
	$(document).on('click', '.categoryHint', function (){
		var Category = $(this).text(),
			targetInput = $(this).parents(".BookCategoryContainer").find(".BookCategory");
		
		targetInput.val(Category);
		$(".responseCategory").html("");
	});
	
	// autocomplete для авторов
	$(document).on('keyup','.BookAuthor', function() {
		var query = $(this).val(),
			hintBox = $(this).parents(".BookAuthorContainer").find(".responseAuthors");
		if (query.length > 0) {
			$.ajax (
				{
					url: 'autocomplete.php',
					method: 'POST',
					data: {
						searchAuthor: 1,
						q: query
					},
					success: function (data) {
					hintBox.html(data);
				},
					dataType: 'text'
				}
			);			
		}
	});
	$(document).on('click', '.authorHint', function (){
		var author = $(this).text(),
			targetInput = $(this).parents(".BookAuthorContainer").find(".BookAuthor");
		
		targetInput.val(author);
		$(".responseAuthors").html("");
	});
	
	
	// Прячет автокомплит при клике вне границ его текстового поля
	$(".HintBox").each(function () {
		var hintbox = $(this),
			autocompletecontainer = hintbox.parents(".SBorder");
		
		$(document).mouseup(function (a) {
			if (autocompletecontainer.has(a.target).length === 0) {
				$(hintbox).html("");
			}
		});
	});
	
	// Поиск подходящих книг
	$("#BSearchName").keyup(function() {
		var searchValue = $("#BSearchName").val();
										
		if (searchValue.length > 0) {
			$.ajax (
				{
					url: 'ChangeBook.php',
					method: 'POST',
					data: {
						nameValue: searchValue
					},
					success: function (data) {
					$("#BookHints").html(data);
				},
					dataType: 'text'
				}
			);
		}
	});
	
	
	// Клик по названию книги
	$(document).on('click', '.bookHint', function (){
		var BookId = $(this).attr('id'),
			BookName = $('input[name="BookName"]'),
			BookYear = $('input[name="BookYear"]'),
			BookDescription = $('textarea[name="Description1"]'),
			BookAuthors = $('input[name="BookAuthor[]"]'),
			BookCategories = $('input[name="BookCategory[]"]');
			
			
		$.ajax (
				{
					url: 'ChangeBook.php',
					method: 'POST',
					data: {
						BookId: BookId
					},
					success: function (data) {
						var BookInfo = JSON.parse(data),
							i = 0;
						$('.AddBookForm').prepend("<input type='hidden' name='Id' value="+ BookInfo['BookID'] + ">")
						BookName.val(BookInfo['BookName']);
						BookYear.val(BookInfo['BookYear']);
						BookDescription.val(BookInfo['Description']);
						// Авторы
						BookInfo['BookAuthors'].forEach(function(Autor) {
							$(BookAuthors[i]).val(Autor);
							$(BookAuthors[i]).parents(".BookAuthorContainer").css('display', 'block');
							if (i != BookInfo['BookAuthors'].length-1) {
								$(BookAuthors[i]).next(".AddBookAuthor").css('display', 'none');
							}
							i++;
						});
						// Категории
						i = 0;
						BookInfo['BookCategories'].forEach(function(Category) {
							$(BookCategories[i]).val(Category);
							$(BookCategories[i]).parents(".BookCategoryContainer").css('display', 'block');
							if (i != BookInfo['BookCategories'].length-1) {
								$(BookCategories[i]).next(".AddBookCategory").css('display', 'none');
							}
							i++;
						});
					},
					dataType: 'text'
				}
			);
		$('.findBook').css('display', 'none');
		$('.AddBookForm').css('display', 'block');
	});
	
	// Отображение следующего автора/категории
	$('.AddBookAuthor').on('click', function() {
		$(this).css('display', 'none');
		$(this).parents(".BookAuthorContainer").next(".BookAuthorContainer").css('display', 'block');
	});
	$('.AddBookCategory').on('click', function() {
		$(this).css('display', 'none');
		$(this).parents(".BookCategoryContainer").next(".BookCategoryContainer").css('display', 'block');
	});
	
	// Проверка расширения загружаемого файла книги
	$('#BookFile').on('change', function checkFile() {
		var FileName = this.files.item(0).name,
			whiteList = /(\.pdf)$/i,
			Container = $(this).next('.AddFileContainer');
		if(!whiteList.test(FileName)) { 
			this.value = "";
			alert('Неверный тип файла, принимаются: pdf, txt');
		}
	});
	
	// Проверка расширения загружаемой обложки
	$('#BookCover').on('change', function checkCover() {
		var FileName = this.files.item(0).name,
			whiteList = /(\.png|\.jpeg|\.jpg)$/i,
			Container = $(this).next('.AddFileContainer');
		if(!whiteList.test(FileName)) { 
			this.value = "";
			alert('Неверный тип файла, принимаются: png, jpeg');
		}
	});
	
	// Отображение названия файла
	$('.File').each(function() {
		var $input = $(this),
			$Container = $input.next('.AddFileContainer'),
			Nothing = $Container.html();
		$input.on('change', function(e) {
			var FileName = '';
			if(this.files && this.files.length > 1)
				FileName = (this.getAttribute('data-multiple-caption') || '').replace('{count}', this.files.length);
			else if(e.target.value)
				FileName = e.target.value.split('\\').pop();

			if(FileName)
				$Container.find('.LFName').html(FileName);
			else
				$Container.html(Nothing);
		});
	});
});
