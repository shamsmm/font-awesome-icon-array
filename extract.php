<?php


require_once __DIR__ . '/SimpleFormatter.php';
require_once __DIR__ . '/SimpleExtractor.php';

// parse command line arguments into the $_GET
parse_str(implode('&', array_slice($argv, 1)), $_GET);

$all = true;

if (array_key_exists('style', $_GET) && is_string($_GET['style'])) {
    $all = false;
}

$path = __DIR__ . DIRECTORY_SEPARATOR . 'font-awesome-5' . DIRECTORY_SEPARATOR . 'metadata' . DIRECTORY_SEPARATOR . 'icons.json';
$output = __DIR__;
$filename = "output_" . date('m-d-Y-H_i_s');

if (array_key_exists('output', $_GET) && is_string($_GET['output']))
    $output = $_GET['output'];

if (array_key_exists('filename', $_GET) && is_string($_GET['filename']))
    $filename = $_GET['filename'];

if (array_key_exists('path', $_GET) && is_string($_GET['path']))
    $path = $_GET['path'];
else
    echo "Warning: path of the file is left empty. Using fontawesome 5 icons.json file.\n";

$jsonString = file_get_contents($path);
$jsonData = json_decode($jsonString, true);

$formatter = new SimpleFormatter($output, $filename);
$extractor = new SimpleExtractor($path, $all, $formatter, 'solid', true);

if (array_key_exists('style', $_GET) && is_string($_GET['style']))
    $extractor->setStyle($_GET['style']);

$extractor->extract();

try {
    $extractor->getFormatter()->saveFile();
} catch (Exception $e) {
    die($e->getMessage());
}