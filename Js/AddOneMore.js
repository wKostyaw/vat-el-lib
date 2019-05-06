$(document).ready(), function() {
	// autocomplete для категорий
	$("#SearchBoxCategory").keyup(function() {
		var query1 = $("#SearchBoxCategory").val();
		
		if (query1.length > 0) {
			$.ajax (
				{
					url: 'AddBookForm.php',
					method: 'POST',
					data: {
						search1: 1,
						q1: query1
					},
					success: function (data) {
						$("#responseCategory").html(data);
					},
					dataType: 'text'
				}
			);			
		}
	});

	$(document).on('click', '#li2', function (){
		var Category = $(this).text();
		$("#SearchBoxCategory").val(Category);
		$("#responseCategory").html("");
	});


	// autocomplete для авторов
	$("#SearchBox").keyup(function() {
		var query = $("#SearchBox").val();
										
		if (query.length > 0) {
			$.ajax (
				{
					url: 'AddBookForm.php',
					method: 'POST',
					data: {
						search: 1,
						q: query
					},
					success: function (data) {
					$("#responseAuthors").html(data);
				},
					dataType: 'text'
				}
			);			
		}
	});

	$(document).on('click', '#li1', function (){
		var author = $(this).text();
		$("#SearchBox").val(author);
		$("#responseAuthors").html("");
	});

	// Добавление тега на страницу 
	$(document).on('click', '.Add', function () {
		var tagVal = $(this).prev(".TagSearch").val();
			$tagBox = $(this).parents('.Testik').next('.tagPreview');
			tagName = '';
			id = $(this).prev(".TagSearch").attr("id");
			console.log(id);
		
			if (id == "SearchBox") { 
				tagName = "name='BookAutor[]'";
			};
			if (id == "SearchBoxCategory") {
				tagName = "name='BookCategory[]'";
			};
			
		if (tagVal != '') {
			$tag = "<span class='tag'><span  " + tagName + ">" + tagVal +
						"</span><button type='button' class='removeTag'>" +
							"<svg width='10px' height='10px' viewBox='0 0 192 192'><path d='M37.65625,26.34375l-11.3125,11.3125l58.34375,58.34375l-58.34375,58.34375l11.3125,11.3125l58.34375,-58.34375l58.34375,58.34375l11.3125,-11.3125l-58.34375,-58.34375l58.34375,-58.34375l-11.3125,-11.3125l-58.34375,58.34375z'></path></svg>" +
						"</button>" +
					"</span>";
			console.log($tag);
			$tagBox.append($tag);
		}
	});
	// Удаление тега со страницы
	$(document).on('click', '.removeTag', function () {
		$(this).parent().remove();
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
}();