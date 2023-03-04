// $servername = "localhost";
// $database = "detali";
// $username = "parseradmin";
// $password = "1234";
// //Создаем соединение
// $conn = mysqli_connect($servername, $username, $password, $database);
// mysqli_set_charset($conn, "utf8");
// //Проверяем соединение
// if (!$conn) {
//     die("Connection failed: " . mysqli_connect_error());
// }
// echo "Connected successfull". " ". $database. "<br>";

// // mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);





<!-- $arrayForCheck = $product_picture->stack();
    if(count($arrayForCheck)>0) {
      echo "TRUE</br>";
}
else {
  echo "FALSE</br>";
} -->




<?php
//функция форматування
function format ($expre) {
    echo "<pre>";
    print_r($expre);
    echo "</
    pre>";
  }

//Функція перводу першого символу в верхній регістр
function mb_ucfirst($str, $encoding='UTF-8')
  {
      $str = mb_ereg_replace('^[\ ]+', '', $str);
      $str = mb_strtoupper(mb_substr($str, 0, 1, $encoding), $encoding).
             mb_substr($str, 1, mb_strlen($str), $encoding);
      return $str;
  }


  //функція запроса
function requests ($url, $cookiefile = '/Applications/MAMP/bin/mamp/cookie.txt') {
$ch = curl_init();
 curl_setopt($ch, CURLOPT_URL, $url);
 curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 curl_setopt($ch, CURLOPT_COOKIEJAR, $cookiefile);
 curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.103 Safari/537.36');
$output = curl_exec($ch);
curl_close($ch);
return $output;
}


function parse_product($all_products_links_array){
  foreach ($all_products_links_array as $key => $value) {
    $request_all_product = requests($value);
    $output_all_product = phpQuery::newDocument($request_all_product);
    $product_name = $output_all_product->find('.product-title h1');
    $product_name = $product_name->html();
    $product_name = mb_ucfirst($product_name);
    echo $product_name.'<br>';
    $product_sku = $output_all_product->find('.editable');
    $product_sku = $product_sku->html();
    $product_price = $output_all_product->find('#our_price_display');
    $product_price = $product_price->text();
    $product_price = str_replace(' ₴', "", $product_price);
    $product_price = str_replace(' ', "", $product_price);
    $product_price = round($product_price);
    
    $product_picture = $output_all_product->find('.MagicToolboxContainer img');
    $arrayForCheck = $product_picture->stack();
    if(count($arrayForCheck)>0) {
      echo "TRUE</br>";
}
else {
  $product_picture = $output_all_product->find('.nopiclogo img');
}
    foreach ($product_picture as $link) {
      $pqlink = pq($link);
      echo $pqlink.'-------------'.'<br>';
      
      $product_picture_arr[] = $pqlink->attr("src");
      $product_picture_arr = str_replace('small_default', 'large_default', $product_picture_arr);
    
  }
    $product_picture = implode($product_picture_arr, ';');
  
    $product[$key]['sku'] = $product_sku;
    $product[$key]['name'] = $product_name;
    $product[$key]['price'] = $product_price;
    $product[$key]['picture'] = $product_picture;


  }
  return $product;
}


function pull_data_sheet ($result_product, $spreadsheet, $category_name, $writer, $category_name_mod) {
  $sheet = $spreadsheet->getActiveSheet();
  // $sheet->getStyle('B1')->getFill()->getStartColor()->setARGB('FFFF0000');
  
  $sheet->setCellValue('A1', 'Артикул'); 
  $sheet->setCellValue('B1' ,'Название'); 
  $sheet->setCellValue('C1', 'Цена');
  $sheet->setCellValue('D1', 'Наличие');
  $sheet->setCellValue('E1', 'Поставщик');
  $sheet->setCellValue('F1', 'Категория');
  $sheet->setCellValue('G1', 'Доп. категория');
  $sheet->setCellValue('H1', 'Описание');
  $sheet->setCellValue('I1', 'Картинка');
  
foreach ($result_product as $key => $value) {
  $product_sku_item = $result_product[$key]["sku"];
  $product_name_item = $result_product[$key]["name"];
  $product_price_item = $result_product[$key]["price"];
  $product_picture_item = $result_product[$key]["picture"];
  $inc = $key+2;
 

$sheet->setCellValue('A'. $inc, $product_sku_item); 
$sheet->setCellValue('B'. $inc, $product_name_item); 
$sheet->setCellValue('C'. $inc, $product_price_item);
$sheet->setCellValue('D'. $inc, "1");
$sheet->setCellValue('E'. $inc, "detali");
$sheet->setCellValue('F'. $inc, $category_name);
$sheet->setCellValue('G'. $inc, "");
$sheet->setCellValue('H'. $inc, "");
$sheet->setCellValue('I'. $inc, $product_picture_item);
}
$writer->save($category_name_mod.'.'.'xlsx');
}


















function parse_product($all_products_links_array) {
    foreach ($all_products_links_array as $key => $value) {
      $request_all_product = requests($value);
      $output_all_product = phpQuery::newDocument($request_all_product);
      $product_name = $output_all_product->find('.product-title h1');
      $product_name = $product_name->html();
      $product_name = mb_ucfirst($product_name);
      echo $product_name.'<br>';
      $product_sku = $output_all_product->find('.editable');
      $product_sku = $product_sku->html();
      $product_price = $output_all_product->find('#our_price_display');
      $product_price = $product_price->text();
      $product_price = str_replace(' ₴', "", $product_price);
      $product_price = str_replace(' ', "", $product_price);
      $product_price = round($product_price);
      
      $product_picture = $output_all_product->find('.MagicToolboxContainer img');
      $arrayForCheck = $product_picture->stack();
      if(count($arrayForCheck)>0) {
        foreach ($product_picture as $link) {
          $pqlink = pq($link);
          echo $pqlink.'-------------'.'<br>';
          
          $product_picture_arr[] = $pqlink->attr("src");
          $product_picture_arr[] = str_replace('small_default', 'large_default', $product_picture_arr);
        
      }
        $product_picture = implode($product_picture_arr, ';');
  
  }
  else {
    $product_picture = $output_all_product->find('.nopiclogo img');
    foreach ($product_picture as $link) 
    {
      $pqlink = pq($link);
      echo $pqlink.'-------------'.'<br>';
      $product_picture_arr[] = $pqlink->attr("src");
    }
  }
  
      $product[$key]['sku'] = $product_sku;
      $product[$key]['name'] = $product_name;
      $product[$key]['price'] = $product_price;
      $product[$key]['picture'] = $product_picture;
  
  
    }
    format ($product);
    return $product;
  }










  
function pull_data_sheet ($result_product, $spreadsheet, $category_name, $writer, $category_name_mod) {
    $sheet = $spreadsheet->getActiveSheet();  
    $sheet->setCellValue('A1', 'Артикул'); 
    $sheet->setCellValue('B1' ,'Название'); 
    $sheet->setCellValue('C1', 'Цена');
    $sheet->setCellValue('D1', 'Наличие');
    $sheet->setCellValue('E1', 'Поставщик');
    $sheet->setCellValue('F1', 'Категория');
    $sheet->setCellValue('G1', 'Доп. категория');
    $sheet->setCellValue('H1', 'Описание');
    $sheet->setCellValue('I1', 'Картинка');
    
  foreach ($result_product as $key => $value) {
    $product_sku_item = $result_product[$key]["sku"];
    $product_name_item = $result_product[$key]["name"];
    $product_price_item = $result_product[$key]["price"];
    $product_picture_item = $result_product[$key]["picture"];
    $inc = $key+2;
   
  
  $sheet->setCellValue('A'. $inc, $product_sku_item); 
  $sheet->setCellValue('B'. $inc, $product_name_item); 
  $sheet->setCellValue('C'. $inc, $product_price_item);
  $sheet->setCellValue('D'. $inc, "1");
  $sheet->setCellValue('E'. $inc, "detali");
  $sheet->setCellValue('F'. $inc, $category_name);
  $sheet->setCellValue('G'. $inc, "");
  $sheet->setCellValue('H'. $inc, "");
  $sheet->setCellValue('I'. $inc, $product_picture_item);
  }
  $writer->save($category_name_mod.'.'.'xlsx');
  }



















  
<?php

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$mysqli = mysqli_connect('localhost', 'strument_usr', 'Mqky4Crd', 'detali');

/* Установите желаемую кодировку после установления соединения */
mysqli_set_charset($mysqli, 'utf8mb4');

printf("Успешно... %s\n", mysqli_get_host_info($mysqli));


//функция форматування
function format ($expre) {
    echo "<pre>";
    print_r($expre);
    echo "</pre>";
  }

  function mb_ucfirst($str, $encoding='UTF-8')
  {
      $str = mb_ereg_replace('^[\ ]+', '', $str);
      $str = mb_strtoupper(mb_substr($str, 0, 1, $encoding), $encoding).
             mb_substr($str, 1, mb_strlen($str), $encoding);
      return $str;
  }


  //функція запроса
function requests ($url) {
$ch = curl_init();
 curl_setopt($ch, CURLOPT_URL, $url);
 curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.103 Safari/537.36');
$output = curl_exec($ch);
curl_close($ch);
return $output;
}


function parse_product($all_products_links_array){
  foreach ($all_products_links_array as $key => $value) {
    $request_all_product = requests($value);
    $output_all_product = phpQuery::newDocument($request_all_product);
    $product_name = $output_all_product->find('.product-title h1');
    $product_name = $product_name->text();  
    $product_name = mb_ucfirst($product_name);
    $product_sku = $output_all_product->find('.editable');
    $product_sku = $product_sku->html();
    $product_price = $output_all_product->find('#our_price_display');
    $product_price = $product_price->text();
    $product_price = str_replace(' ₴', "", $product_price);
    $product_price = str_replace(' ', "", $product_price);
    $product_price = round($product_price);
    $product_picture = $output_all_product->find('.MagicToolboxContainer img');

    $arrayForCheck = $product_picture->stack();
    if(count($arrayForCheck)>0) {
      echo "TRUE</br>";
      foreach ($product_picture as $key=>$link) {
        $pqlink = pq($link);
        $product_picture_arr[$key] = $pqlink->attr("src");  
  }
  $separator = ';';
   $product_picture_str = implode($product_picture_arr, $separator);
        $product_picture_str = str_replace('small_default', 'large_default', $product_picture_str);
}
else {
  echo 'NO IMAGE <br/>';
  continue;
}



      mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
      $mysqli = mysqli_connect('localhost', 'strument_usr', 'Mqky4Crd', 'detali');
      /* Установите желаемую кодировку после установления соединения */
      mysqli_set_charset($mysqli, 'utf8mb4');
      printf("Успешно... %s\n", mysqli_get_host_info($mysqli));
      $sql = "INSERT INTO products (id, name, sku, price, picture)
VALUES (NULL, '$product_name', '$product_sku', '$product_price', '$product_picture_str')";

if (mysqli_query($mysqli, $sql)) {
  echo "New record created successfully";
} else {
  echo "Error: " . $mysqli . "<br>" . mysqli_error($mysqli);
}


mysqli_close($mysqli);



  }
  return 0;
 
}

function pull_data_sheet ($result_product, $spreadsheet, $category_name, $writer, $category_name_mod) {
  $sheet = $spreadsheet->getActiveSheet();
     
  mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

  $mysqli = mysqli_connect('localhost', 'strument_usr', 'Mqky4Crd', 'detali');
  
  /* Установите желаемую кодировку после установления соединения */
  mysqli_set_charset($mysqli, 'utf8mb4');
  
  printf("Успешно... %s\n", mysqli_get_host_info($mysqli));

  $sql_select = "SELECT * FROM products";
  $result = mysqli_query($mysqli, $sql_select);

  if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
      format($row);
        echo "id: " .$row["id"].'цена'. $row["price"]. " - Name: " . $row["name"]. " " . $row["sku"]. $row["picture"]. "<br>";
        
        $sheet->setCellValue('A'. $row["id"], $row["sku"]); 
        $sheet->setCellValue('B'. $row["id"], $row["name"]); 
        $sheet->setCellValue('C'. $row["id"], $row["price"]);
        $sheet->setCellValue('D'. $row["id"], $row["picture"]);
        $sheet->setCellValue('E'. $row["id"], $category_name);
    }

} else {
    echo "0 results";
}

mysqli_close($mysqli);

$writer->save($category_name_mod.'.'.'xlsx');
}













  // if($result = mysqli_query($mysqli, $sql_select)){
  //   foreach($result as $row){
  //       // $product_sku_item = $row["sku"];
  //       // $product_name_item = $row["name"];
  //       // $product_price_item = $row["price"];
  //       // $product_picture_item = $row["picture"];


     
  //       // $inc = $row+1;
  //       // $sheet->setCellValue('A'. $inc, $product_sku_item); 
  //       // $sheet->setCellValue('B'. $inc, $product_name_item); 
  //       // $sheet->setCellValue('C'. $inc, $product_price_item);
  //       // $sheet->setCellValue('D'. $inc, $product_picture_item);
  //       // $sheet->setCellValue('E'. $inc, $category_name);
  //   }
   

// $writer->save($category_name_mod.'.'.'xlsx');
// }
