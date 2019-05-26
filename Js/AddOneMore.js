$(document).ready(function(){
	// autocomplete для категорий
	// 1
	$("#SearchBoxCategory1").keyup(function() {
		var query5 = $("#SearchBoxCategory1").val();
		
		if (query5.length > 0) {
			$.ajax (
				{
					url: 'autocomplete.php',
					method: 'POST',
					data: {
						search5: 1,
						q5: query5
					},
					success: function (data) {
						$("#responseCategory1").html(data);
					},
					dataType: 'text'
				}
			);			
		}
	});

	$(document).on('click', '#li5', function (){
		var Category1 = $(this).text();
		$("#SearchBoxCategory1").val(Category1);
		$("#responseCategory1").html("");
	});


	// 2
	$("#SearchBoxCategory2").keyup(function() {
		var query6 = $("#SearchBoxCategory2").val();
		
		if (query6.length > 0) {
			$.ajax (
				{
					url: 'autocomplete.php',
					method: 'POST',
					data: {
						search6: 1,
						q6: query6
					},
					success: function (data) {
						$("#responseCategory2").html(data);
					},
					dataType: 'text'
				}
			);			
		}
	});

	$(document).on('click', '#li6', function (){
		var Category2 = $(this).text();
		$("#SearchBoxCategory2").val(Category2);
		$("#responseCategory2").html("");
	});


	// 3
	$("#SearchBoxCategory3").keyup(function() {
		var query7 = $("#SearchBoxCategory3").val();
		
		if (query7.length > 0) {
			$.ajax (
				{
					url: 'autocomplete.php',
					method: 'POST',
					data: {
						search7: 1,
						q7: query7
					},
					success: function (data) {
						$("#responseCategory3").html(data);
					},
					dataType: 'text'
				}
			);			
		}
	});

	$(document).on('click', '#li7', function (){
		var Category3 = $(this).text();
		$("#SearchBoxCategory3").val(Category3);
		$("#responseCategory3").html("");
	});


	// 4
	$("#SearchBoxCategory4").keyup(function() {
		var query8 = $("#SearchBoxCategory4").val();
		
		if (query8.length > 0) {
			$.ajax (
				{
					url: 'autocomplete.php',
					method: 'POST',
					data: {
						search8: 1,
						q8: query8
					},
					success: function (data) {
						$("#responseCategory4").html(data);
					},
					dataType: 'text'
				}
			);			
		}
	});

	$(document).on('click', '#li8', function (){
		var Category4 = $(this).text();
		$("#SearchBoxCategory4").val(Category4);
		$("#responseCategory4").html("");
	});


	// 5
	$("#SearchBoxCategory5").keyup(function() {
		var query9 = $("#SearchBoxCategory5").val();
		
		if (query9.length > 0) {
			$.ajax (
				{
					url: 'autocomplete.php',
					method: 'POST',
					data: {
						search9: 1,
						q9: query9
					},
					success: function (data) {
						$("#responseCategory5").html(data);
					},
					dataType: 'text'
				}
			);			
		}
	});

	$(document).on('click', '#li9', function (){
		var Category5 = $(this).text();
		$("#SearchBoxCategory5").val(Category5);
		$("#responseCategory5").html("");
	});


	// 6
	$("#SearchBoxCategory6").keyup(function() {
		var query10 = $("#SearchBoxCategory6").val();
		
		if (query10.length > 0) {
			$.ajax (
				{
					url: 'autocomplete.php',
					method: 'POST',
					data: {
						search10: 1,
						q10: query10
					},
					success: function (data) {
						$("#responseCategory6").html(data);
					},
					dataType: 'text'
				}
			);			
		}
	});

	$(document).on('click', '#li10', function (){
		var Category6 = $(this).text();
		$("#SearchBoxCategory6").val(Category6);
		$("#responseCategory6").html("");
	});



	// 7
	$("#SearchBoxCategory7").keyup(function() {
		var query11 = $("#SearchBoxCategory7").val();
		
		if (query11.length > 0) {
			$.ajax (
				{
					url: 'autocomplete.php',
					method: 'POST',
					data: {
						search11: 1,
						q11: query11
					},
					success: function (data) {
						$("#responseCategory7").html(data);
					},
					dataType: 'text'
				}
			);			
		}
	});

	$(document).on('click', '#li11', function (){
		var Category7 = $(this).text();
		$("#SearchBoxCategory7").val(Category7);
		$("#responseCategory7").html("");
	});



	// 8
	$("#SearchBoxCategory8").keyup(function() {
		var query12 = $("#SearchBoxCategory8").val();
		
		if (query12.length > 0) {
			$.ajax (
				{
					url: 'autocomplete.php',
					method: 'POST',
					data: {
						search12: 1,
						q12: query12
					},
					success: function (data) {
						$("#responseCategory8").html(data);
					},
					dataType: 'text'
				}
			);			
		}
	});

	$(document).on('click', '#li12', function (){
		var Category8 = $(this).text();
		$("#SearchBoxCategory8").val(Category8);
		$("#responseCategory8").html("");
	});




	// 9
	$("#SearchBoxCategory9").keyup(function() {
		var query13 = $("#SearchBoxCategory9").val();
		
		if (query13.length > 0) {
			$.ajax (
				{
					url: 'autocomplete.php',
					method: 'POST',
					data: {
						search13: 1,
						q13: query13
					},
					success: function (data) {
						$("#responseCategory9").html(data);
					},
					dataType: 'text'
				}
			);			
		}
	});

	$(document).on('click', '#li13', function (){
		var Category9 = $(this).text();
		$("#SearchBoxCategory9").val(Category9);
		$("#responseCategory9").html("");
	});
	// 10
	$("#SearchBoxCategory10").keyup(function() {
		var query14 = $("#SearchBoxCategory10").val();
		
		if (query14.length > 0) {
			$.ajax (
				{
					url: 'autocomplete.php',
					method: 'POST',
					data: {
						search14: 1,
						q14: query14
					},
					success: function (data) {
						$("#responseCategory10").html(data);
					},
					dataType: 'text'
				}
			);			
		}
	});

	$(document).on('click', '#li14', function (){
		var Category10 = $(this).text();
		$("#SearchBoxCategory10").val(Category10);
		$("#responseCategory10").html("");
	});


	// autocomplete для авторов
	$(".BookAuthor").keyup(function() {
		var query = $(".BookAuthor").val();
										
		if (query.length > 0) {
			$.ajax (
				{
					url: 'autocomplete.php',
					method: 'POST',
					data: {
						search: 1,
						q: query
					},
					success: function (data) {
					$(".responseAuthors").html(data);
				},
					dataType: 'text'
				}
			);			
		}
	});


	$(document).on('click', '#li0', function (){
		var author = $(this).text();
		$(".BookAuthor").val(author);
		$(".responseAuthors").html("");
	});
	// // №2
	// $("#SearchBox1").keyup(function() {
	// 	var query1 = $("#SearchBox1").val();
										
	// 	if (query1.length > 0) {
	// 		$.ajax (
	// 			{
	// 				url: 'autocomplete.php',
	// 				method: 'POST',
	// 				data: {
	// 					search1: 1,
	// 					q1: query1
	// 				},
	// 				success: function (data) {
	// 				$("#responseAuthors1").html(data);
	// 			},
	// 				dataType: 'text'
	// 			}
	// 		);			
	// 	}
	// });
	

	// $(document).on('click', '#li1', function (){
	// 	var author1 = $(this).text();
	// 	$("#SearchBox1").val(author1);
	// 	$("#responseAuthors1").html("");
	// });
	// // №3
	// $("#SearchBox2").keyup(function() {
	// 	var query2 = $("#SearchBox2").val();
										
	// 	if (query2.length > 0) {
	// 		$.ajax (
	// 			{
	// 				url: 'autocomplete.php',
	// 				method: 'POST',
	// 				data: {
	// 					search2: 1,
	// 					q2: query2
	// 				},
	// 				success: function (data) {
	// 				$("#responseAuthors2").html(data);
	// 			},
	// 				dataType: 'text'
	// 			}
	// 		);			
	// 	}
	// });
	

	// $(document).on('click', '#li2', function (){
	// 	var author2 = $(this).text();
	// 	$("#SearchBox2").val(author2);
	// 	$("#responseAuthors2").html("");
	// });
	// // №4
	// $("#SearchBox3").keyup(function() {
	// 	var query3 = $("#SearchBox3").val();
										
	// 	if (query3.length > 0) {
	// 		$.ajax (
	// 			{
	// 				url: 'autocomplete.php',
	// 				method: 'POST',
	// 				data: {
	// 					search3: 1,
	// 					q3: query3
	// 				},
	// 				success: function (data) {
	// 				$("#responseAuthors3").html(data);
	// 			},
	// 				dataType: 'text'
	// 			}
	// 		);			
	// 	}
	// });
	

	// $(document).on('click', '#li3', function (){
	// 	var author3 = $(this).text();
	// 	$("#SearchBox3").val(author3);
	// 	$("#responseAuthors3").html("");
	// });
	// // №5
	// $("#SearchBox4").keyup(function() {
	// 	var query4 = $("#SearchBox4").val();
										
	// 	if (query4.length > 0) {
	// 		$.ajax (
	// 			{
	// 				url: 'autocomplete.php',
	// 				method: 'POST',
	// 				data: {
	// 					search4: 1,
	// 					q4: query4
	// 				},
	// 				success: function (data) {
	// 				$("#responseAuthors4").html(data);
	// 			},
	// 				dataType: 'text'
	// 			}
	// 		);			
	// 	}
	// });
	

	// $(document).on('click', '#li4', function (){
	// 	var author4 = $(this).text();
	// 	$("#SearchBox4").val(author4);
	// 	$("#responseAuthors4").html("");
	// });
	
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
	
	// Проверка расширения загружаемого файла книги
	$('#BookFile').on('change', function checkFile() {
		var FileName = this.files.item(0).name,
			whiteList = /(\.pdf)$/i, // Какие файлы нам нужны?
			Container = $(this).next('.AddFileContainer');
			
		$('#submit').prop('disabled', !whiteList.test(FileName));
		if(!whiteList.test(FileName)) { 
			this.value = "";
			alert('Неверный тип файла, принимаются: pdf');
		}
	});
	
	// Проверка расширения загружаемой обложки
	$('#BookCover').on('change', function checkCover() {
		var FileName = this.files.item(0).name,
			whiteList = /(\.png|\.jpeg|\.jpg)$/i, // Какие файлы принимаются
			Container = $(this).next('.AddFileContainer');
			
		$('#submit').prop('disabled', !whiteList.test(FileName));
		if(!whiteList.test(FileName)) { 
			this.value = "";
			alert('Неверный тип файла, принимаются: png, jpeg');
		}
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