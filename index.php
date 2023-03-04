<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Парсер</title>
</head>
<body>
<?php
if (!file_exists("FILES")){
mkdir("FILES", 0700);
}
?>
    <h1>Детали</h1>
  <p>  Парсер</p>
  <li>----- </li>
</body>
</html>
<form action="/parser.php" method="post">
  <input type="text" name="name">
  <input type="submit" value="Почати">
</form>


<form action="" method="post">
  <input type="submit" name = "submit" value="Почистити базу">
</form>

<form action="" method="post">
  <input type="submit" name = "create_base" value="Створити базу">
</form>


<?php 







if (isset($_POST['create_base'])){
    echo "База створена";

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    $mysqli = mysqli_connect('localhost', 'strument_usr', 'Mqky4Crd', 'detali');
    
    /* Установите желаемую кодировку после установления соединения */
    mysqli_set_charset($mysqli, 'utf8mb4');
    
    printf("Успешно... %s\n", mysqli_get_host_info($mysqli));

    $sql = "CREATE TABLE products (
        id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
        name text NOT NULL,
        sku text NOT NULL,
        price int NOT NULL,
        picture text NOT NULL
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;";

if (mysqli_query($mysqli, $sql)) {
    echo "New database created successfully";
  } else {
    echo "Error: " . $mysqli . "<br>" . mysqli_error($mysqli);
  }
  
  
  mysqli_close($mysqli);
  
    
}








if (isset($_POST['submit'])){

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    $mysqli = mysqli_connect('localhost', 'strument_usr', 'Mqky4Crd', 'detali');
    
    /* Установите желаемую кодировку после установления соединения */
    mysqli_set_charset($mysqli, 'utf8mb4');
    
    printf("Успешно... %s\n", mysqli_get_host_info($mysqli));

    $sql = "TRUNCATE TABLE products";

if (mysqli_query($mysqli, $sql)) {
  echo "New record created successfully";
} else {
  echo "Error: " . $mysqli . "<br>" . mysqli_error($mysqli);
}


mysqli_close($mysqli);


echo "<h2>Ви повністю очистили базу</h2>";
}





