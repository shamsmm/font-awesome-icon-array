<?php /** @noinspection DuplicatedCode */


require_once __DIR__ . '/SimpleFormatter.php';
require_once __DIR__ . '/SimpleExtractor.php';

$path = __DIR__ . DIRECTORY_SEPARATOR . 'font-awesome-5' . DIRECTORY_SEPARATOR . 'metadata' . DIRECTORY_SEPARATOR . 'icons.json';

$output_dir_php = __DIR__ . DIRECTORY_SEPARATOR . 'extracted' . DIRECTORY_SEPARATOR . 'font-awesome-5' . DIRECTORY_SEPARATOR . 'php';

if (!file_exists($output_dir_php)) {
    echo "Creating $output_dir_php\n";
    mkdir($output_dir_php, 0777, true);
}

$iterations = [
    0 => [
        'output_filename' => "solids_key_icon_value_icon_label",
        'style' => 'solid',
        'mode' => SimpleFormatter::MODE_KEY_ICON_VALUE_LABEL,
    ],
    1 => [
        'output_filename' => "brands_key_icon_value_icon_label",
        'style' => 'brands',
        'mode' => SimpleFormatter::MODE_KEY_ICON_VALUE_LABEL,
    ],
    2 => [
        'output_filename' => "regulars_key_icon_value_icon_label",
        'style' => 'regular',
        'mode' => SimpleFormatter::MODE_KEY_ICON_VALUE_LABEL,
    ],
    3 => [
        'output_filename' => "solids_just_an_array",
        'style' => 'solid',
        'mode' => SimpleFormatter::MODE_JUST_AN_ARRAY,
    ],
    4 => [
        'output_filename' => "brands_just_an_array",
        'style' => 'brands',
        'mode' => SimpleFormatter::MODE_JUST_AN_ARRAY,
    ],
    5 => [
        'output_filename' => "regulars_just_an_array",
        'style' => 'regular',
        'mode' => SimpleFormatter::MODE_JUST_AN_ARRAY,
    ],
];

foreach ($iterations as $iteration) {
    $formatter = new SimpleFormatter(
        $output_dir_php,
        $iteration['output_filename'],
        $iteration['mode']
    );
    $extractor = new SimpleExtractor($path, false, $formatter, $iteration['style'], false);
    $extractor->extract();

    try {
        $extractor->getFormatter()->saveFile();
    } catch (Exception $e) {
        die($e->getMessage());
    }
}