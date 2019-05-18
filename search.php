<?php   
    include_once "auth.php";
 ?>
<?php
    // поиск соответствий в БД
    if (isset($_POST['search'])) {
        $connection = new mysqli('vat', 'root', '', 'vat');
        $q = $connection->real_escape_string($_POST['q']);
        $sql = $connection->query("SELECT Name FROM authors WHERE Name LIKE '%$q%'");
        $sql1 = $connection->query("SELECT BookName FROM books WHERE BookName LIKE '%$q%'");
        $sql2 = $connection->query("SELECT Category FROM categories WHERE Category LIKE '%$q%'");
        if ($sql->num_rows > 0 or  $sql1->num_rows > 0 or  $sql2->num_rows > 0) {
            $responseAuthors = "<ul class='HintList'>";
				
                while ($data = $sql->fetch_array())
                    
                    $responseAuthors .= "<li id='li0' class='Hint'>" . $data['Name'] . "</li>";
                while ($data = $sql1->fetch_array())
                    
                    $responseAuthors .= "<li id='li0' class='Hint'>" . $data['BookName'] . "</li>";
				
                while ($data = $sql2->fetch_array())
                    
                    $responseAuthors .= "<li id='li0' class='Hint'>" . $data['Category'] . "</li>";
            $responseAuthors .= "</ul>";
        }
        exit($responseAuthors);
    }
?>
<!doctype HTML>
<html>
    <meta charset="utf-8">
    <head>
        <title>Поиск</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" type="text/css" href="css/BooksList.css">
        <link rel="stylesheet" type="text/css" href="css/PageNavigation.css">
        <script src="js/JQuerry.js" type="text/javascript"></script>
        <script src="js/Script.js" type="text/javascript"></script>
    </head>
    <body>
        <div class="SiteHeader">
            <div class="HeaderContent">
                <img src="img/WorkInProgress.png" class="Logo">
                <p class="SiteName">Электронная библиотека ВАТ имени В. П. Чкалова</p>
            </div>
        </div>
            <div class="SecondHeader" id="SecondHeader">
            <div class="NCentered">
                <button class="exitButton" onclick="document.location.replace('?exit');">Выход</button>
                
                <div id="Navigation">
                    <ul class="Navigation">
                        <li class="NButton"><a href="MainPage.php" class="NBLink">Главная</a></li>
                        <li class="NButton"><a href="#" class="NBLink">Сохраненное</a></li>
                        <li class="NButton"><a href="#" class="NBLink">Авторы</a></li>
                        <li class="NButton"><a href="#" class="NBLink">Категории</a></li>
                        <?php 
                            $username = $_SESSION['login'];
                            $admin = ("SELECT admin FROM loginparol WHERE login='$username'");
                            $result = $connection->query ($admin);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $kek = $row["admin"] ;
                                }
                            }
                            if ($kek == 1) {
                                echo "<li class='NButton'><a href='adminpage2.php' class='NBLink'>&#128081 Панель администрирования &#128081</a></li>";
                            }
                        ?> 
                    </ul>
                    <button type="button" Class="OpenSearch SButton" onclick="SearchVisible()">
                        <svg class="SButtonIcon" x="0px" y="0px" width="24" height="24" viewBox="0 0 210 210">
                            <path d="M88.2,12.6c-39.47344,0 -71.4,31.92656 -71.4,71.4c0,39.47344 31.92656,71.4 71.4,71.4c14.09297,0 27.13594,-4.13438 38.19375,-11.15625l51.58125,51.58125l17.85,-17.85l-50.925,-50.79375c9.15469,-12.00938 14.7,-26.88984 14.7,-43.18125c0,-39.47344 -31.92656,-71.4 -71.4,-71.4zM88.2,29.4c30.23672,0 54.6,24.36328 54.6,54.6c0,30.23672 -24.36328,54.6 -54.6,54.6c-30.23672,0 -54.6,-24.36328 -54.6,-54.6c0,-30.23672 24.36328,-54.6 54.6,-54.6z"></path>
                        </svg>
                        </button>
                </div>
                <form class="SearchForm" id="SearchForm" name="Search" method="GET"  style="display: none;">
				<div class="SBorder">
                    <div class="SearchBook">
                        <button type="submit" Class="StartSearch SButton">
                            <svg class="SButtonIcon" x="0px" y="0px" width="24" height="24" viewBox="0 0 210 210">
                                <path d="M88.2,12.6c-39.47344,0 -71.4,31.92656 -71.4,71.4c0,39.47344 31.92656,71.4 71.4,71.4c14.09297,0 27.13594,-4.13438 38.19375,-11.15625l51.58125,51.58125l17.85,-17.85l-50.925,-50.79375c9.15469,-12.00938 14.7,-26.88984 14.7,-43.18125c0,-39.47344 -31.92656,-71.4 -71.4,-71.4zM88.2,29.4c30.23672,0 54.6,24.36328 54.6,54.6c0,30.23672 -24.36328,54.6 -54.6,54.6c-30.23672,0 -54.6,-24.36328 -54.6,-54.6c0,-30.23672 24.36328,-54.6 54.6,-54.6z"></path>
                            </svg>
                        </button>
                        <input type="search" class="SearchBookName" id="SearchBox" name="SearchAll" placeholder="Введите название книги">
                            <script type="text/javascript">
                                $(document).ready(),function () {
                                    $("#SearchBox").keyup(function() {
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
                                    });


                                    $(document).on('click', '#li0', function (){
                                        var author = $(this).text();
                                        $("#SearchBox").val(author);
                                        $("#responseAuthors").html("");
                                    });
                                }();
                            </script>
                            
                        <button type="button" Class="CloseSearch SButton" onclick="SearchHide()">
                            <svg class="SButtonIcon" x="0px" y="0px" width="24" height="24" viewBox="0 0 192 192">
                                <path d="M45.65625,34.34375l-11.3125,11.3125l50.34375,50.34375l-50.34375,50.34375l11.3125,11.3125l50.34375,-50.34375l50.34375,50.34375l11.3125,-11.3125l-50.34375,-50.34375l50.34375,-50.34375l-11.3125,-11.3125l-50.34375,50.34375z"></path>
                            </svg>
                        </button>
                    </div>
					<div id="responseAuthors" class="HintBox"></div>
				</div>
					
                        <button class="SAOButton SButton" onclick="SAOButtonclick()">
                            <svg class="SButtonIcon" x="0px" y="0px" width="24" height="24" viewBox="0 0 192 192">
                            <path d="M116,92h-40l-48,-56h136z"></path>
                            <path d="M116,152l-40,24v-84h40z"></path>
                            <path d="M166,36h-140c-3.20312,0 -6,-2.79688 -6,-6c0,-3.20312 2.79688,-6 6,-6h140c3.20312,0 6,2.79688 6,6c0,3.20312 -2.79688,6 -6,6z"></path>
                            </svg>
                        </button>
                    <div class="SAOOptions" id="SAOOptions" style="display: none;">
                        <div class="SAOOption SAOAutor">
                            <label class="SAOLabel">Авторы (указать через запятую):
                                <input class="SAOInput" type="text">
                            </label>
                        </div>  
                        <div class="SAOOption SAOYear">
                            <label class="SAOLabel">Года (пример: 2019/2005-2009/2012, 2014):
                                <input class="SAOInput" type="text">
                            </label>
                        </div>
                        <div class="SAOOption SAOGenre">
                            <label class="SAOLabel">Жанры (указать через запятую):
                                <input class="SAOInput" type="text">
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            </div>
            <div class="SiteWrapper">
                <div class="SiteContent">
                    <div class="BookBlock">
                        <?php
                            $search_q = $_GET['SearchAll'];
                            $search_q = trim($search_q); 
                            $search_q = mysqli_real_escape_string($connection, $search_q);
                            $search_q = htmlspecialchars($search_q);
                            if ($search_q == '') 
                            {   
                                echo "Введите поисковой запрос!";
                            } 
                            else if (strlen($search_q) < 3)
                            { 
                                echo "Слишком короткий поисковый запрос";
                            } 
                            else if (strlen($search_q) > 128) 
                            {
                                echo "Слишком длинный поисковый запрос";
                            }
                            else
                            {
                                $sql = $connection->query("SELECT * FROM books WHERE bookName LIKE '%$search_q%'");
                                $rows = mysqli_num_rows($sql);
                                echo "<span class='BookInfoItem'>" . "Книги, содержащие в названии \"" . $search_q . "\", по вашему запросу: " . "</span>";
                                if ($rows > 0 )
                                {
                                    for ($i = 0 ; $i < $rows ; ++$i) 
                                    {
                                        $row = mysqli_fetch_row($sql);
                                        echo "<form action='book.php' method='GET'>";
                                            echo "<div class='BookBlockItem'>";
                                                echo "<div class='BookPreview'>";
                                                    echo "<input type='image' class='BookPreview' src='img/BookDefault.png'>";
                                                echo "</div>";
                                                echo "<div class='BookInfo'>";
                                                    //название книги
                                                    echo "<span hidden=''>" . "<input type='text' value='$row[0]' name='BookInfo'> " . "</span>";
                                                    echo "<span class='BookInfoItem'>" . "Название: " . "<input type='submit' value='$row[1]' >  </input>" . "</span>";
                                                    $AuthorName = array();
                                                    $whoisauthor = ("SELECT AuthorID FROM books_and_authors WHERE BookID LIKE '$row[0]'");
                                                    $result = $connection->query ($whoisauthor);
                                                    if ($result->num_rows > 0) 
                                                    {
                                                        while ($rowauthor = $result->fetch_assoc())
                                                        {
                                                            $AuthorID = $rowauthor["AuthorID"];
                                                            $whoisauthor2 = ("SELECT Name FROM authors WHERE AuthorID LIKE '$AuthorID'");
                                                            $result2 = $connection->query ($whoisauthor2);
                                                            if ($result2->num_rows > 0) 
                                                            {
                                                                while ($rowauthor2 = $result2->fetch_assoc())
                                                                {
                                                                    array_push($AuthorName, $rowauthor2["Name"]);
                                                                }
                                                            } else 
                                                            {
                                                                $AuthorName = 'Авторов нет';
                                                            }
                                                        }
                                                    } else 
                                                    {
                                                        $AuthorID = 'Авторов нет';
                                                    }
                                                    echo "<span class='BookInfoItem'>" . "Авторы: ";
                                                    foreach ($AuthorName as $key => $value) 
                                                    { 
                                                        if($value == end($AuthorName)) 
                                                        {
                                                            echo $value;
                                                        }
                                                          else 
                                                        {
                                                            echo $value . ", ";
                                                        }
                                                    }
                                                    unset($key);
                                                    echo "</span>";
                                                    echo "<span class='BookInfoItem'>" . "Год: " . $row[2] . "</span>";
                                                    echo "<span class='BookInfoItem'>" . "Описание: " . $row[3] . "</span>";
                                                    $Categories = array();
                                                    $whatiscategory = ("SELECT CategoryID FROM books_and_categories WHERE BookID LIKE '$row[0]'");
                                                    $result = $connection->query ($whatiscategory);
                                                    if ($result->num_rows > 0) 
                                                    {
                                                        while ($rowcategory = $result->fetch_assoc())
                                                        {
                                                            $CategoryID = $rowcategory["CategoryID"];
                                                            $whatiscategory2 = ("SELECT Category FROM categories WHERE CategoryID LIKE '$CategoryID'");
                                                            $result2 = $connection->query ($whatiscategory2);
                                                            if ($result2->num_rows > 0) 
                                                            {
                                                                while ($rowcategory2 = $result2->fetch_assoc())
                                                                {
                                                                    array_push($Categories, $rowcategory2["Category"]);
                                                                }
                                                            } else 
                                                            {
                                                                $Categories = 'Авторов нет';
                                                            }
                                                        }
                                                    } else 
                                                    {
                                                        $CategoryID = 'Авторов нет';
                                                    }
                                                    echo "<span class='BookInfoItem'>" . "Категории: ";
                                                    foreach ($Categories as $key => $value) 
                                                    { 
                                                        if($value == end($Categories)) 
                                                        {
                                                            echo $value;
                                                        }
                                                          else 
                                                        {
                                                            echo $value . ", ";
                                                        }
                                                    }
                                                    unset($key);
                                                    echo "</span>";
                                                echo "</div>";
                                            echo "</div>";
                                            echo "<div class='BookBlockButtons'>";
                                                echo "<button class='BookBlockButton'>" . 'Читать' . '</button>';
                                                echo "<button class='BookBlockButton'>" . 'Сохранить к себе' . '</button>';
                                            echo "</div>";
                                        echo "</form>";
                                    }       
                                } else 
                                {   
                                    echo "Не найдено" . "<br>";
                                }
                                // поиск книги по автору
                                $sql = $connection->query("SELECT * FROM authors WHERE Name LIKE '%$search_q%'");
                                $rows = mysqli_num_rows($sql);
                                if ($rows > 0 )
                                {
                                    echo "<span class='BookInfoItem'>" . "Книги автора \"" . $search_q . "\", по вашему запросу: " . "</span>";
                                    $GetAuthorID = ("SELECT AuthorID FROM authors WHERE Name LIKE '%$search_q%'");
                                    $result1 = $connection->query ($GetAuthorID);
                                    $authorslist = array();
                                    if ($result1->num_rows > 0) {
                                        while ($row = $result1->fetch_assoc()) 
                                        {
                                            $AuthorID = $row["AuthorID"];
                                            array_push($authorslist, $AuthorID);
                                        }
                                    }
                                    foreach ($authorslist as $key => $valueAuthorID) 
                                    {
                                        $AuthorBooks = ("SELECT BookID FROM books_and_authors WHERE AuthorID LIKE '$valueAuthorID'");
                                        $result2 = $connection->query ($AuthorBooks);
                                        $bookslist = array();
                                        if ($result2->num_rows > 0) 
                                        {
                                            while ($row = $result2->fetch_assoc())
                                            {
                                                $BookID = $row['BookID'];
                                                array_push($bookslist, $BookID);
                                            }
                                        }
                                        foreach ($bookslist as $key => $valueBookID) 
                                        {
                                            $book = $connection->query("SELECT * FROM books WHERE BookID LIKE '$valueBookID'");
                                            $rows = mysqli_num_rows($book);
                                            for ($i = 0 ; $i < $rows ; ++$i) 
                                            {
                                                $row = mysqli_fetch_row($book);
                                                echo "<form action='book.php' method='GET'>";
                                                    echo "<div class='BookBlockItem'>";
                                                        echo "<div class='BookPreview'>";
                                                            echo "<input type='image' class='BookPreview' src='img/BookDefault.png'>";
                                                        echo "</div>";
                                                        echo "<div class='BookInfo'>";
                                                            echo "<span hidden=''>" . "<input type='text' value='$row[0]' name='BookInfo'> " . "</span>";
                                                            echo "<span class='BookInfoItem'>" . "Название: " . "<input type='submit' value='$row[1]' >  </input>" . "</span>";
                                                            $AuthorName = array();
                                                            $whoisauthor = ("SELECT AuthorID FROM books_and_authors WHERE BookID LIKE '$row[0]'");
                                                            $result = $connection->query ($whoisauthor);
                                                            if ($result->num_rows > 0) 
                                                            {
                                                                while ($rowauthor = $result->fetch_assoc())
                                                                {
                                                                    $AuthorID = $rowauthor["AuthorID"];
                                                                    $whoisauthor2 = ("SELECT Name FROM authors WHERE AuthorID LIKE '$AuthorID'");
                                                                    $result2 = $connection->query ($whoisauthor2);
                                                                    if ($result2->num_rows > 0) 
                                                                    {
                                                                        while ($rowauthor2 = $result2->fetch_assoc())
                                                                        {
                                                                            array_push($AuthorName, $rowauthor2["Name"]);
                                                                        }
                                                                    } else 
                                                                    {
                                                                        $AuthorName = 'Авторов нет';
                                                                    }
                                                                }
                                                            } else 
                                                            {
                                                                $AuthorID = 'Авторов нет';
                                                            }
                                                            echo "<span class='BookInfoItem'>" . "Авторы: ";
                                                            foreach ($AuthorName as $key => $value) 
                                                            { 
                                                                if($value == end($AuthorName)) 
                                                                {
                                                                    echo $value;
                                                                }
                                                                  else 
                                                                {
                                                                    echo $value . ", ";
                                                                }
                                                            }
                                                            unset($key);
                                                            echo "</span>";
                                                            echo "<span class='BookInfoItem'>" . "Год: " . $row[2] . "</span>";
                                                            echo "<span class='BookInfoItem'>" . "Описание: " . $row[3] . "</span>";
                                                            $Categories = array();
                                                            $whatiscategory = ("SELECT CategoryID FROM books_and_categories WHERE BookID LIKE '$row[0]'");
                                                            $result = $connection->query ($whatiscategory);
                                                            if ($result->num_rows > 0) 
                                                            {
                                                                while ($rowcategory = $result->fetch_assoc())
                                                                {
                                                                    $CategoryID = $rowcategory["CategoryID"];
                                                                    $whatiscategory2 = ("SELECT Category FROM categories WHERE CategoryID LIKE '$CategoryID'");
                                                                    $result2 = $connection->query ($whatiscategory2);
                                                                    if ($result2->num_rows > 0) 
                                                                    {
                                                                        while ($rowcategory2 = $result2->fetch_assoc())
                                                                        {
                                                                            array_push($Categories, $rowcategory2["Category"]);
                                                                        }
                                                                    } else 
                                                                    {
                                                                        $Categories = 'Авторов нет';
                                                                    }
                                                                }
                                                            } else 
                                                            {
                                                                $CategoryID = 'Авторов нет';
                                                            }
                                                            echo "<span class='BookInfoItem'>" . "Категории: ";
                                                            foreach ($Categories as $key => $value) 
                                                            { 
                                                                if($value == end($Categories)) 
                                                                {
                                                                    echo $value;
                                                                }
                                                                  else 
                                                                {
                                                                    echo $value . ", ";
                                                                }
                                                            }
                                                            unset($key);
                                                            echo "</span>";
                                                        echo "</div>";
                                                    echo "</div>";
                                                    echo "<div class='BookBlockButtons'>";
                                                        echo "<button class='BookBlockButton'>" . 'Читать' . '</button>';
                                                        echo "<button class='BookBlockButton'>" . 'Сохранить к себе' . '</button>';
                                                    echo "</div>";
                                                echo "</form>";
                                            } 
                                        }
                                    } 
                                }
                                // поиск книг по категории
                                $sql = $connection->query("SELECT * FROM categories WHERE Category LIKE '%$search_q%'");
                                $rows = mysqli_num_rows($sql);
                                if ($rows > 0 )
                                {
                                    echo "<span class='BookInfoItem'>" . "Книги в категори \"" . $search_q . "\", по вашему запросу: " . "</span>";
                                    $GetCategoryID = ("SELECT CategoryID FROM categories WHERE Category LIKE '%$search_q%'");
                                    $result1 = $connection->query ($GetCategoryID);
                                    $categorieslist = array();
                                    if ($result1->num_rows > 0) {
                                        while ($row = $result1->fetch_assoc()) 
                                        {
                                            $CategoryID = $row["CategoryID"];
                                            array_push($categorieslist, $CategoryID);
                                        }
                                    }
                                    foreach ($categorieslist as $key => $valueCategoryID) 
                                    {
                                        $CategoryBooks = ("SELECT BookID FROM books_and_categories WHERE CategoryID LIKE '$valueCategoryID'");
                                        $result2 = $connection->query ($CategoryBooks);
                                        $bookslist = array();
                                        if ($result2->num_rows > 0) 
                                        {
                                            while ($row = $result2->fetch_assoc())
                                            {
                                                $BookID = $row['BookID'];
                                                array_push($bookslist, $BookID);
                                            }
                                        }
                                        foreach ($bookslist as $key => $valueBookID) 
                                        {
                                            $book = $connection->query("SELECT * FROM books WHERE BookID LIKE '$valueBookID'");
                                            $rows = mysqli_num_rows($book);
                                            for ($i = 0 ; $i < $rows ; ++$i) 
                                            {
                                                $row = mysqli_fetch_row($book);
                                                echo "<form action='book.php' method='GET'>";
                                                    echo "<div class='BookBlockItem'>";
                                                        echo "<div class='BookPreview'>";
                                                            echo "<input type='image' class='BookPreview' src='img/BookDefault.png'>";
                                                        echo "</div>";
                                                        echo "<div class='BookInfo'>";
                                                            echo "<span hidden=''>" . "<input type='text' value='$row[0]' name='BookInfo'> " . "</span>";
                                                            echo "<span class='BookInfoItem'>" . "Название: " . "<input type='submit' value='$row[1]' >  </input>" . "</span>";
                                                            $AuthorName = array();
                                                            $whoisauthor = ("SELECT AuthorID FROM books_and_authors WHERE BookID LIKE '$row[0]'");
                                                            $result = $connection->query ($whoisauthor);
                                                            if ($result->num_rows > 0) 
                                                            {
                                                                while ($rowauthor = $result->fetch_assoc())
                                                                {
                                                                    $AuthorID = $rowauthor["AuthorID"];
                                                                    $whoisauthor2 = ("SELECT Name FROM authors WHERE AuthorID LIKE '$AuthorID'");
                                                                    $result2 = $connection->query ($whoisauthor2);
                                                                    if ($result2->num_rows > 0) 
                                                                    {
                                                                        while ($rowauthor2 = $result2->fetch_assoc())
                                                                        {
                                                                            array_push($AuthorName, $rowauthor2["Name"]);
                                                                        }
                                                                    } else 
                                                                    {
                                                                        $AuthorName = 'Авторов нет';
                                                                    }
                                                                }
                                                            } else 
                                                            {
                                                                $AuthorID = 'Авторов нет';
                                                            }
                                                            echo "<span class='BookInfoItem'>" . "Авторы: ";
                                                            foreach ($AuthorName as $key => $value) 
                                                            { 
                                                                if($value == end($AuthorName)) 
                                                                {
                                                                    echo $value;
                                                                }
                                                                  else 
                                                                {
                                                                    echo $value . ", ";
                                                                }
                                                            }
                                                            unset($key);
                                                            echo "</span>";
                                                            echo "<span class='BookInfoItem'>" . "Год: " . $row[2] . "</span>";
                                                            echo "<span class='BookInfoItem'>" . "Описание: " . $row[3] . "</span>";
                                                            $Categories = array();
                                                            $whatiscategory = ("SELECT CategoryID FROM books_and_categories WHERE BookID LIKE '$row[0]'");
                                                            $result = $connection->query ($whatiscategory);
                                                            if ($result->num_rows > 0) 
                                                            {
                                                                while ($rowcategory = $result->fetch_assoc())
                                                                {
                                                                    $CategoryID = $rowcategory["CategoryID"];
                                                                    $whatiscategory2 = ("SELECT Category FROM categories WHERE CategoryID LIKE '$CategoryID'");
                                                                    $result2 = $connection->query ($whatiscategory2);
                                                                    if ($result2->num_rows > 0) 
                                                                    {
                                                                        while ($rowcategory2 = $result2->fetch_assoc())
                                                                        {
                                                                            array_push($Categories, $rowcategory2["Category"]);
                                                                        }
                                                                    } else 
                                                                    {
                                                                        $Categories = 'Авторов нет';
                                                                    }
                                                                }
                                                            } else 
                                                            {
                                                                $CategoryID = 'Авторов нет';
                                                            }
                                                            echo "<span class='BookInfoItem'>" . "Категории: ";
                                                            foreach ($Categories as $key => $value) 
                                                            { 
                                                                if($value == end($Categories)) 
                                                                {
                                                                    echo $value;
                                                                }
                                                                  else 
                                                                {
                                                                    echo $value . ", ";
                                                                }
                                                            }
                                                            unset($key);
                                                            echo "</span>";
                                                        echo "</div>";
                                                    echo "</div>";
                                                    echo "<div class='BookBlockButtons'>";
                                                        echo "<button class='BookBlockButton'>" . 'Читать' . '</button>';
                                                        echo "<button class='BookBlockButton'>" . 'Сохранить к себе' . '</button>';
                                                    echo "</div>";
                                                echo "</form>";
                                            } 
                                        }
                                    } 
                                }
                            }
                        ?>
                    </div>
                    <!-- <ul class="PageNavigation">
                        <li class="Page PreviousPage"><a href="#">◀</a></li>
                        <li class="Page FirstPage"><a href="#">1</a></li>
                        <li class="PageEmptySpace"></li>
                        <li class="Page"><a href="#">11</a></li>
                        <li class="Page"><a href="#">12</a></li>
                        <li class="Page"><a href="#">13</a></li>
                        <li class="Page"><a href="#">14</a></li>
                        <li class="Page"><a href="#">15</a></li>
                        <li class="PageEmptySpace"></li>
                        <li class="Page LastPage"><a href="#">999</a></li>
                        <li class="Page NextPage"><a href="#">▶</a></li>
                    </ul> -->
                </div>
            </div>
        <div class="SiteFooter">
            <div class="FooterContent">
                <p class="Copyright">Сайт разработан в качестве дипломной работы студентами ВАТ имени В. П. Чкалова</p>
            </div>
        </div>
    </body>
</html>