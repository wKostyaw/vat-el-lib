$(document).ready(function() {
	$(document).on('click', '#openLoginForm', function () {
		$('.LoginForm').css("display", "block");
		$('.glass').css("display", "block");
	});
	$(document).on('click', '#closeLoginForm', function () {
		$('.LoginForm').css("display", "none");
		$('.glass').css("display", "none");
	});
	SummaryInfo();
	function SummaryInfo() {
		$.ajax ({
			url: 'Login.php',
			method: 'POST',
			data: {
				RequestSummaryInfo: 1
			},
			success: function (data) {
				var SummaryInfo = JSON.parse(data);
				$('#BookAmount').html(SummaryInfo['books']);
				$('#AuthorAmount').html(SummaryInfo['authors']);
				$('#CategoryAmount').html(SummaryInfo['categories']);
			},
			dataType: 'text'
		});
	};
});