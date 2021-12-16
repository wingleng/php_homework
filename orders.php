<?php
$userid = $_SESSION['id'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="jquery-3.6.0.js"></script>
    <link rel="stylesheet" href="orders.css"/>
    <title>Document</title>
</head>
<body>
	<div id="main">
		<form>
			<h1>订单生成</h1>
			<p>订单编号：<%= ordersid %></p>
			<p>商品总价：<%= totalPrice %>元</p>
			<label>收件者姓名：</label><input id="name" type="text" value="<%= username %>"> <br><br>
			<label>电话号码：</label><input id="telephone" type="text" value="<%= telephone %>"><br><br>
			<label>收件地址：</label><input id="address" type="text" value="地址">
			<p>支付状态:</p><!-- 这个状态默认为0，支付成功后才更新为1 -->
			<p>下单时间:<%= ordertime.toString() %></p>
			<p>用户id：<%= userid %></p>
			<input id="subbtn" type="button" value="确认提交" onClick="finalinsert()">
		</form>
	</div>
</body>
</html>