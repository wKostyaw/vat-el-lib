
    
<?php
    $connection = mysqli_connect( 'vat', 'root',  '', 'vat');
    $connection->query ("SET NAMES 'utf8'");
    $select_db = mysqli_select_db ($connection, 'vat');
    $search_q=$_POST['SearchAll'];
    $search_q = trim($search_q);
    $search_q = strip_tags($search_q);
    $q= mysqli_query($l, "SELECT BookName FROM books WHERE BookName LIKE '%$search_q%'");
    $itog=mysqli_fetch_assoc($q);
      while ($itog = mysqli_fetch_assoc($q)) {
            printf("%s (%s)\n",$r["title_value"],$r["content"]);
        }
     mysqli_free_result($q);
      mysqli_close($l);
?>