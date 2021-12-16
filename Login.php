<%@ page language="java" import="java.util.*" pageEncoding="GBK"%>


<!DOCTYPE html>
<html>

<head>
    <meta charset="gbk">
    <title>Login</title>
    <link rel="stylesheet" href="Login.css" />
    <script src="jquery-3.6.0.js"></script>
    <script type="text/javascript">
        /**@function
         * 发送请求，检查账号密码的方法
         */
        function show(){
            var $username = $("#inname").val();
            var $password = $("#inpass").val();
            if($username=="" || $password==""){
                alert("输入框不能为空！");
            }
            if(!$username=="" && !$password==""){
                $.ajax({
                    url:"LoginCheck.php",
                    method: "POST",
                    async:false,
                    data:{
                        "username": $username,
                        "password": $password,
                        "method":"check"
                    },
                    success: function(data){
                        console.log(data);
                        switch(data){
                            case "pass":
                                window.location="Main.php";
                                break;
                            case "wrong":
                                alert("用户名或密码错误");
                                break;
                        }
                    }
                    
                })
            }
        }

        /**@function
         * 该方法是用来注册用户的
         */
        function register(){

        }


        /**@access
         * 程序入口
         */
        $(document).ready(function() {

        })
    </script>
</head>

<body>
    <div id="login">
        <h1 id="title">登录</h1>
        <form name="Login" target="hidden" onsubmit="show()" action="LoginCheck.jsp">
            <input type="text" required="required" placeholder="用户名" name="iusername" id="inname">
            <input type="password" required="required" placeholder="密码" name="ipassword" id="inpass">
            <input type="button" value="登录" class="sub" onclick="show()">
        </form>

        <form action="Register.jsp">
            <input id="regis" type="submit" value="没有账号？点击注册">
        </form>

    </div>
</body>

</html>