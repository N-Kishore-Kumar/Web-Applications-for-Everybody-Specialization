<?php
$md5 = "Not computed";
$salt='XyZzy12*_';
if ( isset($_GET['decode']) ) {
    $md5 = hash('md5', $salt.$_GET['decode']);
    echo $md5;
}
?>
<!DOCTYPE html>
<head><title>N Kishore Kumar MD5</title></head>
<body>
<h1>MD5 Decoder</h1>
<p>MD5: <?= htmlentities($md5); ?></p>
<form>
<input type="text" name="decode" size="40" />
<input type="submit" value="Decode MD5"/>
</form>
<p><a href="decoder.php">Reset</a></p>
<p><a href="index.php">Back to Cracking</a></p>
</body>
</html>
