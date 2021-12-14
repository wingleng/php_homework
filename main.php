<?php
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link type="text/css" rel="styleSheet" href="main.css" />
    <script src="jquery-3.6.0.js"></script>
    <script type="text/javascript">
        /**@field
         * 所有商品的数据
         */
        var json;

        /**@field
         * 以下的几个数据都是构成每个商品的变量
         */
        var id; //隐藏域使用
        var name; //DOM节点生成的时候需要使用
        var jprice; //DOM节点生成的时候需要使用
        var category; //隐藏域使用
        var pnum; //隐藏域使用
        var imgurl; //DOM节点生成的时候需要使用
        var description; //隐藏域使用
        var pagNo = 1; //默认一开始的页面为1

        var loid = 1; //用来为商品定位的虚拟id


        /**@function
         * 该方法用来获取初始化界面的时候的json数据。
         */
        function getAllProducts() {
            $.ajax({
                url: "JsonOutputer.php",
                method: "POST",
                async: false,
                data: {
                    'action': 'getProduct'
                },
                success: function($data) {
                    json = JSON.parse($data);
                },
                failure: function(err) {
                    console.log("初始化请求失败");
                }
            });
        }

        /**@function
         * 该方法用来生成每一个单独的商品页
         */
        function pageProduce(page) {
            var pagenums = Math.ceil(json.length / 60); //页数
            var jsonindex = (page - 1) * 60 + 1; //每一页的数据的开始下标
            var restshop = json.length - jsonindex; //确认每一页的剩余数量

            //生成每一页的数量
            if (restshop >= 60) {
                for (var i = 0; i < 60; i++) {
                    id = json[jsonindex].id;
                    name = json[jsonindex].name;
                    jprice = json[jsonindex].price;
                    category = json[jsonindex].category;
                    pnum = json[jsonindex].pnum;
                    imgurl = json[jsonindex].imgurl;
                    description = json[jsonindex].description;
                    jsonindex = jsonindex + 1;
                    loid = i; //定位的虚拟id
                    itemProduct();
                }
            }

            //处理最后一页的特殊情况：
            if (restshop < 60) {
                for (var i = 0; i < restshop; i++) {
                    id = json[jsonindex].id;
                    name = json[jsonindex].name;
                    jprice = json[jsonindex].price;
                    category = json[jsonindex].category;
                    pnum = json[jsonindex].pnum;
                    imgurl = json[jsonindex].imgurl;
                    description = json[jsonindex].description;
                    jsonindex = jsonindex + 1;
                    loid = i; //定位的虚拟id
                    itemProduct();
                }
            }

            jsonindex = 0; //归零，不然下一次可能会出问题
        }

        /**@function
         * 该方法用来生成一个单独的商品
         */
        function itemProduct() {
            var newp = document.createElement("div");

            //图片节点的添加
            var img = document.createElement("img");
            img.setAttribute("src", imgurl);
            img.style.position = "relative";
            img.style.left = "22px";
            img.style.top = "22px";
            img.style.width = "200px";
            img.style.height = "200px";

            //p节点的添加，做成方形的吧
            var title = document.createElement("p");
            var htext = document.createTextNode(name);
            title.append(htext);
            title.setAttribute("align", "center");
            title.style.position = "relative";
            title.style.width = "200px";
            title.style.font = "20px";
            title.style.height = "40px";
            title.style.overflowX = "hidden";
            title.style.overflowY = "hidden";
            title.style.top = "10px";
            title.style.left = "22px";

            //创建商品的价格文字。。。
            var price = document.createElement("p");
            var ptext = document.createTextNode(jprice + "元");
            price.append(ptext);
            price.setAttribute("align", "center");
            price.style.fontFamily = "'黑体'";
            price.style.fontSize = "20px";
            price.style.color = "red";
            price.style.position = "relative";
            price.style.top = "5px";
            price.style.left = "0px";

            //创建隐藏值，在点击商品跳转到购物页面时使用
            var shopkey = document.createElement("input");
            shopkey.setAttribute("type", "hidden");

            shopkey.setAttribute("name", "pkey");
            shopkey.setAttribute("value", id); //这个值是商品的主键，点击发送
            shopkey.value = id;


            //以下内容是div的设置
            newp.style.float = "left";
            newp.style.border = "1px soild transparent";
            newp.style.margin = "8px 10px";
            newp.style.width = "240px";
            newp.style.height = "328px";
            newp.setAttribute("onClick", "jump(this)"); //设置跳转方法
            newp.setAttribute("id", loid); //为商品设置虚拟id

            //按顺序添加各个已经设置好的节点
            //添加图片
            newp.append(img);
            //添加title
            newp.append(title);
            //添加价格price
            newp.append(price);
            //添加隐藏值input
            newp.append(shopkey);

            var contain = document.getElementById("containter");
            contain.append(newp);

        }

        /**@function
         * 这个方法用来清空当前界面
         */
        function cleardiv() {
            //思路应该是清除容器内的div子节点
            var contaiin = document.getElementById("containter");
            var chilNum = contaiin.childElementCount;
            for (var i = 0; i < chilNum; i++) {
                contaiin.removeChild(contaiin.childNodes[0].nextSibling);
            }
        }

        /**@function
         * 这个方法是用来翻到上一页的
         */
        function last() {
            //首先清除界面
            //然后将新的数据显示在界面当中
            var No = document.getElementById("PageNo");
            if (pagNo > 1) {
                cleardiv();
                pagNo = pagNo - 1;
                pageProduce(pagNo);
                No.setAttribute("value", pagNo);
            }
        }

        /**@function
         * 当前的方法是用来翻到下一页的。
         */
        function nextpag() {
            //首先得知道当前的json数据总共有多少页
            var pagenums = Math.ceil(json.length / 60);
            var Noo = document.getElementById("PageNo");
            //设置条件，不能使数据越界
            if (pagNo < pagenums) {
                //老规矩，先清空界面，再填进新的数据
                cleardiv();
                pagNo = pagNo + 1;

                pageProduce(pagNo);

                Noo.setAttribute("value", pagNo);
            }
        }

        /**@function
         * 该方法是用来点击跳转到购买页面的。
         */
        function jump(shopdiv) {
            var shopid = shopdiv.id;
            var shop = document.getElementById(shopid);
            var chil = shop.lastChild;
            var prikey = chil.value;
            alert("prikey=" + prikey);
            location.href = "purchase.jsp?prikey=" + prikey;//将商品的主键传递过去，方便其他界面进行查找
        }

        /**@access
         * 网页入口
         */
        $(document).ready(function() {
            getAllProducts();
            pageProduce(1);

        });
    </script>
</head>

<body>
    <input type="button" value="点击清空当前页面" id="btn" onClick="cleardiv()" style="position: fixed">
    <div id="containter">
    </div>
    <div id="footer">
        <div id="lastpage" onClick="last()">上一页</div>
        <input type="text" id="PageNo" name="pgno" readonly="readonly" value="1" />
        <div id="nextpage" onClick="nextpag()">下一页</div>
    </div>
</body>

</html>