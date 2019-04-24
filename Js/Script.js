$(document).ready(function(){
    $(".SAOButton").click(function () {
        if ($(".SAOOptions").is(":hidden")) {
            $(".SAOOptions").slideToggle(100);				
			$('.SAOButton').css('background-position', '95% -250%');
        } else {
            $(".SAOOptions").slideToggle(100);
			$('.SAOButton').css('background-position', '95% 350%');
        }
        return false;
    });
});

function SearchVisible() {
	document.getElementById('SearchForm').style.display = 'block';
	document.getElementById('Navigation').style.display = 'none';
}
function SearchHide() {
	document.getElementById('SearchForm').style.display = 'none';
	document.getElementById('Navigation').style.display = 'block';
}