<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <script type="text/javascript" src="./public/js/script.js" defer></script>
    <title>SUBMIT TICKET</title>
</head>
<body>
    <div class="container">
        <?php if(isset($image)): ?>
            <img src="public/img/<?php echo $image ?>" style="width: 25%; margin: 20px; border-radius: 2%;">
        <?php endif; ?>
        <div class="form-container">
            <h2 style="font-size: 5vh;">CREATE TICKET</h2>
            <form action="createTicket" method="POST">
                <div class="messages">
                    <?php if(isset($messages)) {
                        foreach ($messages as $message) {
                            echo $message;
                        }
                    }
                    ?>
                </div>
                <textarea name="desc" placeholder="description" style="width: 300px; height: 100px; margin-bottom: 10px; border-radius: 5px;"></textarea>
                <input name="category" type="text" placeholder="category">
                <form>
                    <select name="priority" id="priority" style="width: 300px; margin-bottom: 10px;">
                    <option value="">select priority</option>
                    <option value="low">low</option>
                    <option value="medium">medium</option>
                    <option value="high">high</option>
                </select>
                <input id="email" name="contact" type="text" placeholder="contact">
                <button type="submit">SUBMIT</button>
            </form>
                <a href="/logout"><button class="logout-button">LOG OUT</button></a>
        </div>
    </div>
</body>