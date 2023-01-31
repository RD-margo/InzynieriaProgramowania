<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <script type="text/javascript" src="./public/js/script.js" defer></script>
    <title>LOGIN PAGE</title>
</head>
<body>
    <div class="container">
        <img src="public/img/doge.jpg" style="width: 30vw; margin: 20px; border-radius: 2%;">
        <div class="form-container">
            <h2 style="font-size: 5vh;">HELPDESK</h2>
            <form action="login" method="POST">
                <div class="messages">
                    <?php if(isset($messages)) {
                        foreach ($messages as $message) {
                            echo $message;
                        }
                    }
                    ?>
                </div>
                <input id="email" name="email" type="text" placeholder="email@email.com">
                <input name="password" type="password" placeholder="password">
                <button type="submit">SIGN IN</button>
            </form>
            <a href="/itlogin"><button class="option-button">or sign in to IT guy account</button></a>
        </div>
    </div>
</body>