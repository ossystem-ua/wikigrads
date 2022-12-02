<?php
phpinfo();
$list = get_loaded_extensions();
foreach($list as $l)
    echo $l."<br>";
//$function="imagecreate"; # имя функции, которую будем проверять
//if(function_exists($function))
//  {  echo "Функция ".$function."() - существует";  }
//else
//  {  echo "Функция ".$function."() - не существует";  }
?>
