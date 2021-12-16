<?php
session_start();
require('conn.php');

switch ($_POST['method']){
    case "add":
        echo add2session();
        break;
    case "getshopdata":
        echo (getshopdata($conn));
        break;
    case "delete":
        deleteItem();
        break;
}



/**@function
 *该方法是用来将商品信息添加到session的购物车当中的。 
 */
function add2session(){
  $id = (string)$_POST['id'];
  $nums = $_POST["nums"];

  //如果shopcar中没有这个id的商品，那就直接赋值，如果有，那么就直接将数量相加。
  if(!isset($_SESSION["shopcar"][$id])){
    $_SESSION["shopcar"][$id] = array("id"=>$id,"nums"=>$nums);
  }
  else if(isset($_SESSION["shopcar"][$id])){
    $_SESSION["shopcar"][$id]["nums"] +=$nums;
  }

  return "added";
}



/**@function
 * 该方法是用来获取购物车中的商品信息的，并且还要计算每个商品的总价。。
 */
function getshopdata($conn){
  //从session中取出数据
  $shops = $_SESSION["shopcar"];
  $sql = "SELECT id,name,price,imgurl FROM product WHERE id=?";
  $prestate = $conn->prepare($sql);

  //依次查询出商品数据，以及计算出每种类型商品的总价。
  $allProduct = array();
  foreach($shops as $singleItem){
    $prestate->execute(array($singleItem["id"]));
    $prestate->setFetchMode(PDO::FETCH_ASSOC);
    $result = $prestate->fetch();

    $buff=array();
    $buff["id"] = $result["id"];
    $buff["name"] = $result["name"];
    $buff["price"] = $result["price"];
    $buff["imgurl"] = $result["imgurl"];
    $buff["nums"] = $singleItem["nums"];
    $buff["totalprice"] = $singleItem["nums"] * $result["price"];

    array_push($allProduct,$buff);
  }

  //对数据处理完毕之后，就可以将其返回到页面当中。
  return json_encode($allProduct,JSON_UNESCAPED_UNICODE);
}



/**@function
 * 将session中的商品项删除
 */
function deleteItem(){
  $sid =  (string)$_POST['pkey'];
  unset($_SESSION["shopcar"][$sid]);
}
?>