<?
	include_once "auth.php";
	// сохранение книги 
	if (isset($_POST['BookIDajax'])) 
    {
		$BookIDabc = $_POST['BookIDajax'];
        /*echo $BookIDabc . " kjk" ;*/
        $username = $_SESSION['login'];
        $getUserID = $connection->query("SELECT id FROM loginparol WHERE login = '$username'");
        while ($rowUserID = $getUserID->fetch_assoc()) 
        {
            $UserID = $rowUserID["id"];
        }
        $isLinkExist = $connection->query("SELECT * FROM users_and_books WHERE id = '$UserID' and BookID = '$BookIDabc'");
        if ($isLinkExist->num_rows == 0 ) 
        {
            $addLinkBetweenUserAndBook = $connection->query("INSERT INTO users_and_books (id, BookID) VALUES ('$UserID', '$BookIDabc')");
        }
		exit($BookIDabc);
    }
	// Удаление книги 
    if (isset($_POST['DeleteBookID'])) 
    {
        $DeleteBookID = $_POST['DeleteBookID'];
        // echo $DeleteBookID . " kjk" ;
        $username = $_SESSION['login'];
        $getUserID = $connection->query("SELECT id FROM loginparol WHERE login = '$username'");
        while ($rowUserID = $getUserID->fetch_assoc()) 
        {
            $UserID = $rowUserID["id"];
        }
        $isLinkExist = $connection->query("SELECT * FROM users_and_books WHERE id = '$UserID' and BookID = '$DeleteBookID'");
        if ($isLinkExist->num_rows > 0 ) 
        {
            $deleteLinkBetweenUserAndBook = $connection->query("DELETE FROM users_and_books  WHERE id = '$UserID' and BookID = '$DeleteBookID'");
        }
        exit($DeleteBookID);
    }    

?>