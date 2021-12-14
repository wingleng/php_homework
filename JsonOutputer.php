<?php
header("Content-type: text/html; charset=utf8");
require('conn.php');

if (($_POST['action']=="getProduct")){
    //查询数据库中的所有数据并且返回json
   $stat = $conn->query("select * from product");
   $stat->setFetchMode(PDO::FETCH_ASSOC);
   $result = $stat->fetchAll();

   $jsonStr = json_encode($result,JSON_UNESCAPED_UNICODE);
    echo $jsonStr;
}



?>
