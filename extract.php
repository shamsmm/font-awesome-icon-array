<?php


require __DIR__ . '/SimpleFormatter.php';

// parse command line arguments into the $_GET
parse_str(implode('&', array_slice($argv, 1)), $_GET);

$all = true;

if (array_key_exists('style', $_GET) && is_string($_GET['style'])) {
    $all = false;
}

$path = '';
$output = __DIR__;
$filename = "output_" . date('m-d-Y-His_A_e');

if (array_key_exists('output', $_GET) && is_string($_GET['output']))
    $output = $_GET['output'];

if (array_key_exists('filename', $_GET) && is_string($_GET['filename']))
    $filename = $_GET['filename'];

if (array_key_exists('path', $_GET) && is_string($_GET['path']))
    $path = $_GET['path'];
else
    die("Error: path of the file is left empty.");

$jsonString = file_get_contents($path);
$jsonData = json_decode($jsonString, true);

$formatter = new SimpleFormatter($output, $filename);

foreach ($jsonData as $key => &$value) {
    if (array_key_exists('fancy', $_GET) && json_decode($_GET['fancy']))
	    echo "$key\n";
	
	if( $all
        || ( is_array($value['styles']) && in_array($_GET['style'], $value['styles']))) {

        $formatter->add($key);
    }
}


try {
    $formatter->save();
} catch (Exception $e) {
    die($e->getMessage());
}
