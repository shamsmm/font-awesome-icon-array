<?php /** @noinspection DuplicatedCode */


require_once __DIR__ . '/SimpleFormatter.php';
require_once __DIR__ . '/SimpleExtractor.php';

$path = __DIR__ . DIRECTORY_SEPARATOR . 'font-awesome-6' . DIRECTORY_SEPARATOR . 'metadata' . DIRECTORY_SEPARATOR . 'icons.json';

$output_dir_php = __DIR__ . DIRECTORY_SEPARATOR . 'extracted' . DIRECTORY_SEPARATOR . 'font-awesome-6' . DIRECTORY_SEPARATOR . 'php';

if (!file_exists($output_dir_php)) {
    echo "Creating $output_dir_php\n";
    mkdir($output_dir_php, 0777, true);
}

$formatter = new SimpleFormatter(
    $output_dir_php,
    "solids_key_icon_value_icon_label"
);
$extractor = new SimpleExtractor($path, false, $formatter, 'solid', false);
$extractor->extract();

try {
    $extractor->getFormatter()->saveFile();
} catch (Exception $e) {
    die($e->getMessage());
}

$formatter = new SimpleFormatter(
    $output_dir_php,
    "brands_key_icon_value_icon_label"
);
$extractor = new SimpleExtractor($path, false, $formatter, 'brands', false);
$extractor->extract();

try {
    $extractor->getFormatter()->saveFile();
} catch (Exception $e) {
    die($e->getMessage());
}

$formatter = new SimpleFormatter(
    $output_dir_php,
    "regulars_key_icon_value_icon_label"
);
$extractor = new SimpleExtractor($path, false, $formatter, 'regular', false);
$extractor->extract();

try {
    $extractor->getFormatter()->saveFile();
} catch (Exception $e) {
    die($e->getMessage());
}
