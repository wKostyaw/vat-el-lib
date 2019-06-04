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
            $getOldReadingAndTime = $connection->query("SELECT * FROM users_and_unsaved_books WHERE id = '$UserID' and BookID = '$BookIDabc'");
            while ($rowoldreadingandtime = $getOldReadingAndTime->fetch_assoc()) {
                $OldReading = $rowoldreadingandtime['reading_by_user'];
                $OldTime = $rowoldreadingandtime['last_time_reading'];
            }
            $addLinkBetweenUserAndBook = $connection->query("INSERT INTO users_and_books (id, BookID, reading_by_user, last_time_reading) VALUES ('$UserID', '$BookIDabc', '$OldReading', '$OldTime')");
            $deleteOldTimeAndReadings = $connection->query("DELETE FROM users_and_unsaved_books  WHERE id = '$UserID' and BookID = '$BookIDabc'");
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
            $getOldReadingAndTime = $connection->query("SELECT * FROM users_and_books WHERE id = '$UserID' and BookID = '$DeleteBookID'");
            while ($rowoldreadingandtime = $getOldReadingAndTime->fetch_assoc()) {
                $OldReading = $rowoldreadingandtime['reading_by_user'];
                $OldTime = $rowoldreadingandtime['last_time_reading'];
            }
            $deleteLinkBetweenUserAndBook = $connection->query("DELETE FROM users_and_books  WHERE id = '$UserID' and BookID = '$DeleteBookID'");
            $addLinkBetweenUserAndBook = $connection->query("INSERT INTO users_and_unsaved_books (id, BookID, reading_by_user, last_time_reading) VALUES ('$UserID', '$DeleteBookID', '$OldReading', '$OldTime')");
        }
        exit($DeleteBookID);
    }    

?>