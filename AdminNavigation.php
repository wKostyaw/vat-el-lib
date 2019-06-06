<?
function AdminNavigation() {
	echo '<div class="LogoContainer">';
		echo '<img src="Img/Logo.png" class="Logo">';
	echo '</div>';
	/*echo '<ul class="AdminLinks">';
		echo '<li class="AdminLinkBox"><a href="mainpage.php" class="AdminLink">На сайт</a></li>';
		echo '<li class="AdminLinkBox"><a href="AddUserForm.php" class="AdminLink">Добавить пользователя</a></li>';
		echo '<li class="AdminLinkBox"><a href="ChangeUser.php" class="AdminLink">Изменить/удалить пользователя</a></li>';
		echo '<li class="AdminLinkBox"><a href="AddBookForm.php" class="AdminLink">Добавить книгу</a></li>';
		echo '<li class="AdminLinkBox"><a href="ChangeBook.php" class="AdminLink">Изменить/удалить книгу</a></li>';
		echo '<li class="AdminLinkBox"><a href="InfoAboutUsers.php" class="AdminLink">Информация о пользователях</a></li>';
		echo '<li class="AdminLinkBox"><a href="InfoAboutBooks.php" class="AdminLink">Информация о книгах</a></li>';
		echo '<li class="AdminLinkBox"><a href="CustomizeSlider.php" class="AdminLink">Настройка главной страницы</a></li>';
		echo '<li class="AdminLinkBox"><a href="#" class="AdminLink" onclick="document.location.replace("?exit");">Выход</a></li>';
	echo '</ul>';*/
	
	echo '<ul class="AdminLinks">';
		echo '<li class="AdminLinkBox"><a href="mainpage.php" class="AdminLink">На сайт</a></li>';
		
		echo '<ul class="SecondaryLinksContainer">';
			echo '<li class="AdminLinkBox"><span class="SecondaryLinkHeader">Настройки пользователей</span></li>';
			echo '<li class="AdminLinkBox"><a href="AddUserForm.php" class="SecondaryAdminLink">Добавить</a></li>';
			echo '<li class="AdminLinkBox"><a href="ChangeUser.php" class="SecondaryAdminLink">Изменить/удалить</a></li>';
			echo '<li class="AdminLinkBox"><a href="InfoAboutUsers.php" class="SecondaryAdminLink">Информация о пользователях</a></li>';
		echo '</ul>';
		
		echo '<ul class="SecondaryLinksContainer">';
			echo '<li class="AdminLinkBox"><span class="SecondaryLinkHeader">Настройки книг</span></li>';
			echo '<li class="AdminLinkBox"><a href="AddBookForm.php" class="SecondaryAdminLink">Добавить</a></li>';
			echo '<li class="AdminLinkBox"><a href="ChangeBook.php" class="SecondaryAdminLink">Изменить/удалить</a></li>';
			echo '<li class="AdminLinkBox"><a href="InfoAboutBooks.php" class="SecondaryAdminLink">Информация о книгах</a></li>';
			echo '<li class="AdminLinkBox"><a href="InfoAboutCategories.php" class="SecondaryAdminLink">Информация о категориях</a></li>';
			echo '<li class="AdminLinkBox"><a href="InfoAboutAuthors.php" class="SecondaryAdminLink">Информация об авторах</a></li>';
		echo '</ul>';
		echo '<ul class="SecondaryLinksContainer">';
			echo '<li class="AdminLinkBox"><span class="SecondaryLinkHeader">Статистика</span></li>';
			echo '<li class="AdminLinkBox"><a href="visitstats.php" class="SecondaryAdminLink">Общая статистика посещений</a></li>';
		echo '</ul>';	
		echo '<ul class="SecondaryLinksContainer">';
			echo '<li class="AdminLinkBox"><span class="SecondaryLinkHeader">Настройки сайта</span></li>';
			echo '<li class="AdminLinkBox"><a href="CustomizeSlider.php" class="SecondaryAdminLink">Настройка главной страницы</a></li>';
		echo '</ul>';	
		echo '<li class="AdminLinkBox"><a href="#" class="AdminLink" onclick="document.location.replace(' . "'?exit'" . ');">Выход</a></li>';
	echo '</ul>';
}
AdminNavigation();
?>