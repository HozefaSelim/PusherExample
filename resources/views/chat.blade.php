<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- jQuery and Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <style>
        body {
            background-color: #f0f2f5;
        }
        .container {
            max-width: 400px;
            margin-top: 50px;
        }
        .card {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .adiv {
            background-color: #28a745;
            color: white;
            padding: 15px;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
        }
        .chat {
            background-color: #e7f3ea;
            border-radius: 20px;
            padding: 10px 15px;
            margin: 5px 0;
            color: #333;
            font-size: 14px;
            display: inline-block;
            max-width: 80%;
        }
        .d-flex.flex-row-reverse .sender-message {
            border-top-right-radius: 0;
        }
        .bg-white {
            background-color: #fff;
            border-radius: 20px;
            padding: 10px 15px;
            color: #333;
            font-size: 14px;
            display: inline-block;
            max-width: 80%;
        }
        #message {
            border-radius: 20px;
            padding: 10px;
            font-size: 14px;
            width: 100%;
            resize: none;
        }
        #send {
            width: 100%;
            border-radius: 20px;
            font-size: 16px;
            padding: 10px;
        }
        .sender-message {
            background-color: #d1f7c4;
            color: #333;
            border-radius: 20px;
            max-width: 80%;
            padding: 10px 15px;
            display: inline-block;
        }
    </style>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
</head>
<body class="antialiased">
    <div class="container d-flex justify-content-center">
        <div class="card mt-5">
            <div class="d-flex justify-content-between p-3 adiv text-white">
                <i class="fas fa-chevron-left"></i>
                <span class="p-3">Live chat with  {{  $receiver->name }}</span>
                <i class="fas fa-times"></i>
            </div>
            <div id="chat_area">

                
            </div>
            <div class="form-group px-3">
                <textarea class="form-control" rows="5" id="message" placeholder="Type your message"></textarea>
                <button class="btn btn-success my-2" id="send">Send</button>
            </div>
        </div>
    </div>




    <script>
        

        $("#send").click(function () {
        let messageText = $("#message").val(); // Declare messageText here

       

        $.post("/chat/{{ $receiver->id }}", {
            message: messageText
        }).done(function(data) {
            let senderMessage = `
                <div class="d-flex flex-row p-3">
                    <img src="https://img.icons8.com/color/48/000000/circled-user-male-skin-type-7.png" width="30" height="30" class="chat-avatar">
                    <div class="bg-white ml-2 p-3"><span class="text-muted">${messageText}</span></div>
                </div>`;

            $("#chat_area").append(senderMessage);
            $("#message").val('');
        }).fail(function(xhr) {
            console.error('Error:', xhr.responseText); // Log the error response
        });

        });


        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;
    
        var pusher = new Pusher('7a4349fd6ff149de372b', {
            cluster: 'eu'
            });

    
        var channel = pusher.subscribe('chat{{ auth()->user()->id }}');
        channel.bind('chatMessage', function(data) {
            let receiverrMessage = `
        <div class="d-flex flex-row-reverse p-3">
            <img src="https://img.icons8.com/color/48/000000/circled-user-male-skin-type-7.png" width="30" height="30" class="chat-avatar">
            <div class="bg-white ml-2 p-3"><span class="text-muted">${data.message}</span></div>
        </div>`;

        $("#chat_area").append(receiverrMessage);
       
        });
      </script>
</body>
</html>
