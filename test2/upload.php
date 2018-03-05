<?php

require __DIR__ . '/vendor/autoload.php';
use Google\Cloud\Speech\SpeechClient;

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
    return false;
}

// $apiKey = 'AIzaSyA54BrVHA2RVCcgDfsFEHqAs5qVRzkaJaY';

try {
    $speech = new SpeechClient([
        'keyFilePath' => __DIR__ . '/key.json',
        'languageCode' => 'en-US'
    ]);

    $results = $speech->recognize(
        file_get_contents($file)
    );
} catch (Exception $e) { var_dump($e->getMessage()); }

foreach ($results as $result) {
    echo $result->topAlternative()['transcript'] . PHP_EOL;
}
