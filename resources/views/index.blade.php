<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

       
    </head>
    <body>
    <input type="text" id="name" placeholder="ادخال اسمك">
        <hr>
        <input type="text" id="message" placeholder="ادخال الرسالة">
        <button> submit </button>
        <div class="messages">
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script>

        // var connection = new WebSocket('ws://127.0.0.1:8080');
        //     connection.onopen = function () {
        //         console.log('connections send successfully');
        //         // Send the message 'Ping' to the server
        //     };
        //     connection.onmessage = function(e){
        //         var result=JSON.parse(e.data);
        //         $(".messages").append('<h1>'+JSON.parse(result.message).message+'</h1><h6>'+'from '+JSON.parse(result.message).name+'</h6><hr><h6>'+'time '+result.date+'</h6><hr>');
        //         console.log(JSON.parse(result.message).message);
        //     }

        //     // Log errors
        //     connection.onerror = function (error) {
        //     console.log('WebSocket Error ' + error);
        //     };
        //     $("button").on("click",function(){
        //         var my_array    ={ 
        //             "message":$("#message").val(),
        //             "name":$("#name").val(),
        //         }
        //         var message = JSON.stringify( my_array );

        //     connection.send(message);
        // });


        </script>
    </body>
</html>
