<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/ress.min.css">
        <link rel="stylesheet" href="css/style.css">
        <title>Working time recorder</title>
    </head>
    <header>
		<div class="headerLeft">
			<h1>Working time recorder</h1>
		</div>
    </header>
    <body>
        <form class="inputs" method="post">
            <label class="input_label">ID: </label><input class="text_box" name="id"><br>
            <input class="btn" type="submit" value="開始" name="start">
            <input class="btn" type="submit" value="終了"name="finish">
        </form>
        <div class="others">
            <button class="btn btn_register" onclick="location.href='registration.html'">利用登録</button>
        </div>
    </body>
</html>

<?php

?>