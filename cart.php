<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="cart.css" />
    <script src="jquery-3.6.0.js"></script>
    <title>Document</title>
    <script>
        /**@field
         * 这个是用来记录用户商品的
         */
        var json; //这个是用来存后台发送过来的购物车数据	

        var id; //这个是商品的主键，暂时不知道有什么用，先放着吧
        var name; //商品名称
        var price; //商品单价
        var nums; //商品数量
        var imgurl; //商品图片
        var totalprice; //商品总价格
        var cartprice; //整个购物车界面的总价值



        /**@function
         * 这个方法是用来获取商品数据的。
         */
        function getshopdata() {
            $.ajax({
                url: "shopcarControer.php",
                data: {
                    "method": "getshopdata"
                },
                async: false,
                type: "POST",
                dataType: "JSON",
                success: function(res) {
                    alert(res);
                   json = res;
                  
                },
                fail: function(err) {
                    console.log(err);
                }
            })
        }



        /**@function
         * 添加商品项到页面当中
         */
        function rowsappend() {
            for (var j = 0; j < json.length; j++) {
                id = json[j].id;
                name = json[j].name;
                price = json[j].price;
                nums = json[j].nums;
                imgurl = json[j].imgurl;
                totalprice = json[j].totalprice;

                rowProduce();
            }
        }



        /**@function
         * 使用DOM生成单个商品项
         */
        function rowProduce() {
            //创建表格节点：
            var tb = document.getElementById("shoptable")

            //创建行节点
            var row = document.createElement("tr");
            //图片
            var imghtml = "<td id='img'><img src='" + imgurl + "' /></td>";
            //商品名称
            var namehtml = "<td id='name'>" + name + "</td>";
            //单价
            var pricehtml = "<td id='price'>" + price + "</td>";
            //购买数量
            var numshtml = "<td id='nums'>" + nums + "</td>";
            //总价格
            var totalhtml = "<td id='totalprice'>" + totalprice + "</td>";
            //操作，把每个商品的主键放在这里，应该会有用。
            var operatehtml = "<td id='operate' onClick='deleteshop(this)'>删除<input type='hidden' name='pkey' value='" + id + "'></td>";
            row.innerHTML = imghtml + namehtml + pricehtml + numshtml + totalhtml + operatehtml;
            tb.appendChild(row);

        }



        /**@function
         * 该节点是用来删除单个商品项的
         */
        function deleteshop(e) {
            var r = confirm("确认删除？");
            var pkey = e.lastElementChild.value;
            var tb = document.getElementById("shoptable");
            if (r == true) {
                //发送ajax到后台处理jsp，将购物车中对应的商品删除。。。
                $.ajax({
                    url: "shopcarControer.jsp",
                    data: "method=delete&pkey=" + pkey,
                    async: false,
                    type: "POST",
                    dataType: "text",
                    success: function(httpdata) {
                        //alert("已发送删除命令到后台");
                    }
                }); //这是ajax的括号	
                var tr = e.parentElement;
                tb.removeChild(tr);

                //最后刷新总价格
                calsum();
            }
        }



        /**@function
         * 这个节点是用来计算json中所有商品总值
         * 并且刷新界面的。
         */
        function calsum() {
            ajaxsender();
            cartprice = 0; //使用之前要进行归位
            for (var j = 0; j < json.length; j++) {
                cartprice = cartprice + json[j].totalprice;
            }
            var pele = document.getElementById("tpri");
            pele.innerHTML = "商品总价：" + cartprice + "元";
        }



        /**@function
         * 跳转到订单界面
         */
        function orders() {
            window.location.href = "orders.jsp?cartprice=" + cartprice;
        }



        /**@access
         * 入口
         */
        $(document).ready(function() {
            getshopdata();
            rowsappend();
            calsum();
        })
    </script>
</head>

<body>
    <div id="header">

    </div>
    <div id="main">
        <table id="shoptable" align="center" cellspacing="0">
            <tr id="table_head">
                <td style="width: 240px;height: 80px">图片</td>
                <td style="width: 240px;height: 80px">商品名称</td>
                <td style="width: 100px;height: 80px">单价</td>
                <td style="width: 150px;height: 80px">购买数量</td>
                <td style="width: 100px;height: 80px">总价格</td>
                <td style="width: 80px;height: 80px">操作</td>
            </tr>
        </table>

    </div>
    <div id="footer">
        <p id="tpri"></p>
        <input type="button" value="生成订单" onClick="orders()">

    </div>


</body>

</html>