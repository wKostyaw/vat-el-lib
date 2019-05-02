$(document).ready(), function() {
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