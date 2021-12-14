<?php
session_start();
require('conn.php');
switch ($_POST['method']) {
    case 'check':
        check($conn);
        break;
}

/**@function
 * 该方法是用来验证用户的账号密码
 */
function check($conn)
{
    //在pass的同时，要在session中记录用户名和密码，以及一个在session中添加一个购物车
    $username = $_POST['username'];
    $password = $_POST['password'];


    //查询
    $prestat = $conn->prepare("SELECT * FROM user WHERE username=? AND password=?");
    $prestat->execute(array($username, $password));
    $prestat->setFetchMode(PDO::FETCH_ASSOC);
    $row = $prestat->fetchAll();


    //查不到肯定是参数错误啦~
    if ($row == null) {
        echo "wrong";
        return;
    }

    //正常情况下就返回一个pass，然后将用户名和密码保存到session中，并且为其分配一个购物车
    echo "pass";
    $_SESSION['username'] = $username;
    $_SESSION['password'] = $password;

    $_SESSION['shopcar'] = array();
}
