<?php
if($_POST['action'] == "getdata"){
        $responce = $_POST['responce'];
        echo json_encode($responce, JSON_PRETTY_PRINT) ;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
</head>
<body>
<div id='show_data'>

</div>
<script>
        var settings = {
                "url": "http://restapi.localhost/index.php/Users",
                "method": "GET",
                "timeout": 0,
        };
        
        $.ajax(settings).done(function(response) {
                $.ajax({
                type: 'POST',
                data: {
                        'action': "getdata",
                        'responce': response,
                },
                success: function(response) {
                    $("#show_data").html(`<pre> ${response} </pre>`);         
                }
                });
        });
</script>
</body>
</html>