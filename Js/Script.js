function SearchVisible() {
	$('#SearchForm').css('display', 'block');
	$('.Navigation').css('display', 'none');
	$('.OpenSearch').css('display', 'none');
}
function SearchHide() {
	$('#SearchForm').css('display', 'none');
	$('.Navigation').css('display', 'flex');
	$('.OpenSearch').css('display', 'block');
}