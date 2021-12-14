<?php
header("Content-type: text/html; charset=utf8");
require('conn.php');
/**
 * 接收用户传递过来的主键
 * 然后进行sql数据查询，获取商品数据，
 * 再然后展示到web界面当中
 */
$row;
if (isset($_REQUEST['prikey'])) {
	$prikey = $_REQUEST['prikey'];
	$prestate = $conn->prepare("SELECT * FROM product WHERE id =?");
	$prestate->execute(array($prikey));
	$prestate->setFetchMode(PDO::FETCH_ASSOC);
	$result = $prestate->fetchAll();
	$row = $result[0];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="jquery.js"></script>
	<link type="text/css" rel="styleSheet" href="purchase.css" />
	<title>Document</title>
	<script>
		/**@field
		 * 商品的主键
		 */
		var shopkey = <?= $row["id"] ?>

		/**@function
		 * 该方法用来增加输入框中的数字
		 */
		function plus() {
			var bnum = document.getElementById("bnum");
			var currentvalue = bnum.value;
			if (currentvalue > 0) {
				bnum.setAttribute("value", parseInt(currentvalue) + 1);
			}
		}

		/**@function
		 * 该方法用来减少输入框中的数字
		 */
		function minus() {
			var bnum = document.getElementById("bnum");
			var currentvalue = bnum.value;
			if (currentvalue > 0)
				bnum.setAttribute("value", parseInt(currentvalue) - 1);
		}

		/**@function
		 * 该方法是用来将商品添加到购物车的方法
		 * 传递商品的主键，数量，价格
		 */
		function addtocart() {
			var buynum = document.getElementById("bnum").value;
			$.ajax({
				url: "shopcarControer.php",
				data: "id=" + shopkey + "&nums=" + buynum + "&method=add", //'name='+name+'&user='+user,
				async: false,
				type: "POST",
				dataType: "text",
				success: function(httpdata) {
					if (httpdata.trim() == "added")
						alert("已添加到购物车中！");
				}
			});
		}

		/**@function
		 * 该方法是跳转到购物车界面的方法
		 */
		function jumpto() {
			location.href = "cart.php";
		}

		/**@access
		 * 入口
		 */
		$(document).ready(function() {

		})
	</script>
</head>

<body>
	<div id="containter">
		<div id="imgctn">
			<img src="<?= $row["imgurl"] ?>">
		</div>
		<div id="descrctn">
			<p id="tit"><?= $row["name"] ?></p>
			<p id="descri"><?= $row["description"] ?></%>
			</p>
			<p id="pri" name="pri">
				<font>价格：</font><?= $row["price"] ?>元
			</p>
			<p id="pnum">库存量：<?= $row["pnum"] ?></%>
			</p>
			<div id="purNum">
				<div id="lastp" onClick="minus()">-</div>
				<input id="bnum" type="text" value="1" required="required" onkeyup="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}">
				<div id="nextp" onClick="plus()">+</div>
			</div>
			<input id="buynow" type="button" value="点击购买" />
			<input id="addtocar" type="button" value="加入购物车" onClick="addtocart()" />
			<input id="gotocar" type="button" value="查看当前购物车" onClick="jumpto()" />
		</div>
	</div>

</body>

</html>