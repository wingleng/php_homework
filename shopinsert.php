<?php
require('conn.php');
if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $pnum = $_POST['pnum'];
    //$imgurl = $_POST['imgurl'];
    $shopname = $_POST['shopname'];
    // $file = $_FILES['pic'];
    var_dump($_FILES['pic']);
    if(is_uploaded_file($_FILES['pic']['tmp_name'])){
        echo "上传文件合法";
    }else{
        echo "上传文件不合法";
    }
    if(move_uploaded_file($_FILES['pic']['name'],"./".$_FILES['pic']['name'])){
        echo "文件移动完成";
    }else{
        echo "文件移动失败";
    }
    
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="jquery-3.6.0.js"></script>

    <title>Document</title>
</head>
<body>
    <h3> 这个界面用来上传商品</h3>
    <form method="post" action="shopinsert.php" enctype="multipart/form-data">
<input type="text" name="name" placeholder="输入商品名称"><br>
<input type="text" name="price" placeholder="输入商品价格"><br>
<input type="text" name="category" placeholder="输入商品分类"><br>
<input type="text" name="pnum" placeholder="输入商品数量"><br>
<!-- <input type="text" name="imgurl" placeholder="输入商品图片存储位置(服务器默认位置为compic)"><br> -->
<input type="text" name="shopname" placeholder="输入商品描述"><br>
<input type="file" name="pic" placeholder="上传图片文件"><br>
<input type="submit" name="submit" value="点击上传"><br>
    </form>
    
</body>
</html>