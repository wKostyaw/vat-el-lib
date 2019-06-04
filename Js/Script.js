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
$(document).ready(function() {
	
	
	$("#SearchBox").keyup(function(au) {
		if (au.keyCode != 40 & au.keyCode != 38 & au.keyCode != 13) {
		var query = $("#SearchBox").val();							
		if (query.length > 0) {
			$.ajax (
				{
					url: 'MainPage.php',
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
		}
	});
	$(document).on('click', '#li0', function (){
		var author = $(this).text();
		$("#SearchBox").val(author);
		$("#SearchBox").focus();;
		$("#responseAuthors").html("");
	});
	
	
	// Перемещение по подсказкам при помощи стрелок 
	$(document).on('mouseenter', 'li.Hint', function() {
		$('li.Hint').removeClass('activeitm');
		$(this).addClass('activeitm');
		$(this).siblings().removeClass('activeitm');
	});
	/*$(document).on('mouseleave', 'li.Hint', function() {
		$(this).removeClass('activeitm');
	});*/
	$('div#responseAuthors').on('focus', 'li', function() {
		$this = $(this);
		$this.addClass('activeitm').siblings().removeClass('activeitm');
	}).on('keydown', 'li.activeitm', function(ev) {
		if (ev.keyCode == 40) {
			$this.next().find('a').focus()
			return false;
		} else if (ev.keyCode == 38) {
			$this.prev().find('a').focus();
			return false;
		} else if (ev.keyCode == 13) {
			$('li.hint.activeitm').click();
		}
	});
	$(".SearchForm").keydown(function (ev) {
		if (ev.keyCode == 40 || ev.keyCode == 38) {
			$('#responseAuthors li.Hint:nth-of-type(1)').addClass('activeitm');
			$('li.activeitm > a').focus();
			return false;
		}
	});
    
	$(document).on('click', '.deleteBook', function () {
		var DeleteBookID = $(this).attr('id');
			DeleteBookID = DeleteBookID.replace(/[^\d]/g, ''),
			$thisPage = window.location.pathname,
			DelBookBlock = $(this).parents(".BookBlock");
			
		$.ajax ({
			url: 'SaveAndDeleteBooksFromShelves.php',
			method: 'POST',
			data: {
				DeleteBookID: DeleteBookID
			},
			success: function (data) {
				if ($thisPage == "/Saved.php") {
					DelBookBlock.remove();
				}
				var notificationHeader = 'Удалено',
					notificationTime = 3000;
					notification(notificationTime, notificationHeader);
			},
			dataType: 'text'
		});
		$(this).parent().append("<input type='button' class='BookBlockButton bookButton saveBook' id='savebook" + DeleteBookID + "' name='savebook[]' value='Сохранить к себе' >");
		$(this).remove();
	});
	$(document).on('click', '.saveBook', function () {
		var SavedBookID = $(this).attr('id'),
			SavedBookID = SavedBookID.replace(/[^\d]/g, '');
				
		$.ajax ({
			url: 'SaveAndDeleteBooksFromShelves.php',
			method: 'POST',
			data: {
				BookIDajax: SavedBookID
			},
			success: function (data) {
				var notificationHeader = 'Сохранено',
					notificationTime = 3000;
					notification(notificationTime, notificationHeader);
			},
			dataType: 'text'
		});
		$(this).parent().append("<input type='button' class='BookBlockButton bookButton deleteBook' id='deletebook"+ SavedBookID +"' name='deletebook[]' value='Удалить из сохраненных' >");
		$(this).remove();
	});
	
	$(document).on('click', '.notificationCall', function() {
		var notificationHeader = 'Заголовок уведомления',
			notificationText = 'Текст уведомления (Супер важный текст, созданный только для того, чтобы посмотреть как он будет выглядеть, если строк много)',
			notificationTime = 6000;
		notification(notificationTime, notificationHeader, notificationText);
	});
	
	function notification(notificationTime, notificationHeader, notificationText) {
		var notificationText = notificationText || '';
			nWindow = '<div class="notificationWindow" style="animation: showNotification ' + notificationTime + 'ms 1;">\n'+
						'<span class="notificationHeader">' + notificationHeader + '</span>\n'+
						'<span class="notificationText">' + notificationText + '</span>\n'+
						'</div>\n',
		$('.notificationWindow').remove();	
		$('body').append(nWindow);
		setTimeout( function() {
			$('.notificationWindow').remove();
			clearTimeout();
		}, (notificationTime - 10));
	}
});
function insertShelf(shelfLink, shelfName) {
var shelfIconTemplate = '<div class="shelf">\n'+
	'<a href="'+ shelfLink +'">\n'+
		'<svg id="svg913" class="shelfIcon" width="100" height="100" version="1.1" viewBox="0 0 52.917 52.917" xmlns="http://www.w3.org/2000/svg">\n'+
			'<g id="g911" transform="matrix(.74415 0 0 .74415 -51.061 -25.419)">\n'+
				'<g id="g885" stroke-width=".50493">\n'+
					'<path id="path879" d="m68.822 91.855h70.693"/>\n'+
					'<path id="path881" d="m68.822 101.61h70.693"/>\n'+
					'<path id="path883" d="m68.822 104.28h70.693"/>\n'+
				'</g>\n'+
				'<g id="g907">\n'+
					'<g id="g895" stroke-width=".52917">\n'+
						'<path id="path887" d="m76.926 53.799c4.0091-0.67721 8.0183-0.56804 12.027 0v44.366c-4.0919 0.66228-8.1135 0.7617-12.027 0z"/>\n'+
						'<path id="path889" d="m91.316 42.841c1.9557-0.62107 4.1811-0.74432 6.6817 0v55.325c-2.6685 1.1663-4.7524 0.81637-6.6817 0z"/>\n'+
						'<path id="path891" d="m100.23 49.79c3.0759-0.65053 6.4846-1.0892 12.294 0v48.376c-4.9431 1.2096-8.8187 0.94908-12.294 0z"/>\n'+
						'<path id="path893" d="m114.51 38.565c4.9455-0.76066 10.228-0.99651 16.303 0v59.601c-5.5681 1.2025-10.987 1.0636-16.303 0z"/>\n'+
					'</g>\n'+
					'<g id="g903" stroke-width=".26458">\n'+
						'<path id="path897" d="m78.208 58.182c2.9179-0.27032 5.992-0.35118 9.3544 0v7.2163c-3.2246 0.30496-6.3066 0.22718-9.3544 0z"/>\n'+
						'<path id="path899" d="m92.943 55.388c1.1422-0.28609 2.1762-0.24788 3.1404 0v38.821c-0.7642 0.28261-1.6696 0.424-3.1404 0z"/>\n'+
						'<path id="path901" d="m101.7 53.668c2.9179-0.27032 5.992-0.35118 9.3544 0v7.2163c-3.2246 0.30496-6.3066 0.22718-9.3544 0z"/>\n'+
					'</g>\n'+
					'<path id="path905" d="m116.44 44.452c3.8886-0.37554 7.9853-0.48788 12.466 0v10.025c-4.2973 0.42367-8.4046 0.31561-12.466 0z" stroke-width=".36001"/>\n'+
				'</g>\n'+
			'</g>\n'+
		'</svg>\n'+
	'</a>\n'+
	'<span class="shelfName">'+ shelfName +'</span>\n'
'</div>\n'
}