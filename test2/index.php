<!DOCTYPE html>
<html>
<head>
    <title>Google Speech API</title>
</head>
<body>
    <h1>WAV to Text</h1>
    <hr>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        Select .wav to upload:
        <input type="file" name="upfile"><br><br>
        <button type="Submit">Upload</button>
    </form>

    <p>Less than 1 minute, MONO channel, .wav only.</p>
</body>
</html>