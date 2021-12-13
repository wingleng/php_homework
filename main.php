<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="jquery-3.6.0.js"></script>
    <script type="text/javascript">
        var $products;

        function getAllProducts(){
            $.ajax({
                url:"JsonOutputer.php",
                method:"POST",
                async:false,
                data:{'action' : 'getProduct'},
                success:function($data){
                  $products = $data;  
                  $("body").html($products); 
                },
                failure:function(err){
                    console.log("初始化请求失败");
                }
            });
        }
        
        $(document).ready(function(){
         getAllProducts();
         $("body").html($products); 
        });
    </script>
</head>
<body>
    <button id="additem" type="button"></button>
</body>
</html>