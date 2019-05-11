<?php   
    include_once "auth.php";
 ?>
<?php
    // $search_q = $_POST['SearchAll'];
    $search_q = $connection->real_escape_string($_POST['SearchAll']);
    $sql = $connection->query("SELECT * FROM books WHERE bookName LIKE '$search_q'");
    $rows = mysqli_num_rows($sql);
    echo "<form action='book.php' method='POST'>";
    for ($i = 0 ; $i < $rows ; ++$i) 
    {
        $row = mysqli_fetch_row($sql);
        echo "<input type='submit' value='".$row[1]."'>"  ;
    }
    echo "</form>";
    // echo "<table><tr><th>Id</th><th>Название</th><th>Год</th><th>Описание</th></tr>";
    // for ($i = 0 ; $i < $rows ; ++$i)
    // {
    //     $row = mysqli_fetch_row($sql);
    //     echo "<tr>";
    //         for ($j = 0 ; $j < 4 ; ++$j) echo "<td>$row[$j]</td>";
    //     echo "</tr>";
    // }
    // echo "</table>";
?>