<?php

include 'GoogleSpeechToText.php';

try {
    // Undefined | Multiple Files | $_FILES Corruption Attack
    if (
        !isset($_FILES['upfile']['error']) ||
        is_array($_FILES['upfile']['error'])
    ) {
        throw new RuntimeException('Invalid parameters.');
    }

    // Check $_FILES['upfile']['error'] value.
    switch ($_FILES['upfile']['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
            throw new RuntimeException('No file sent.');
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            throw new RuntimeException('Exceeded filesize limit.');
        default:
            throw new RuntimeException('Unknown errors.');
    }

    if ($_FILES['upfile']['size'] > 2000000) { // check SIZE
        throw new RuntimeException('Exceeded filesize limit.');
    }

    // check MIME
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    if (false === $ext = array_search(
        $finfo->file($_FILES['upfile']['tmp_name']),
        array(
            'wav' => 'audio/x-wav'
        ),
        true
    )) {
        throw new RuntimeException('Invalid file format.');
    }

    $file = $_FILES['upfile']['tmp_name'];
} catch (RuntimeException $e) {
    echo $e->getMessage();
}

$apiKey = '';
$speech = new GoogleSpeechToText($apiKey);
$bitRate = 44100; // The bit rate of the file.
$result = $speech->process($file, $bitRate, 'en-US');
var_dump($result);
