<?php

class SimpleFormatter
{
    private array $array;
    private $output_dir;
    private string $output_filename;
    private $mode;
    private $lang;
    private array $config;


    const LANG_PHP = 'php';
    const LANG_JS = 'js';


    const MODE_JUST_AN_ARRAY = 0;
    const MODE_KEY_ICON_VALUE_STRING = 1;
    const MODE_KEY_ICON_VALUE_LABEL = 2;

    const CONFIG_PHP_OUTPUT = 'php-output';
    const CONFIG_VALUE_PHP_OUTPUT_RETURN = 'php-output-return';
    const CONFIG_VALUE_PHP_OUTPUT_VARIABLE = 'php-output-variable';

    public function __construct($output_dir, $output_filename, $mode = self::MODE_KEY_ICON_VALUE_LABEL, $lang = self::LANG_PHP)
    {
        $this->array = [];
        $this->output_dir = $output_dir;
        $this->output_filename = $output_filename;
        $this->mode = $mode;
        $this->lang = $lang;
        $this->config = [
            self::CONFIG_PHP_OUTPUT => self::CONFIG_VALUE_PHP_OUTPUT_RETURN,
        ];
    }

    public function add($key, $value)
    {
        switch ($this->mode) {
            case self::MODE_JUST_AN_ARRAY:
                $this->array[] = $key;
                break;

            case self::MODE_KEY_ICON_VALUE_STRING:
                $this->array[$key] = str_replace("-", " ", mb_convert_case($key, MB_CASE_TITLE));
                break;
            case self::MODE_KEY_ICON_VALUE_LABEL:
            default:
                $this->array[$key] = $value['label'];
                break;
        }
    }

    /**
     * @throws Exception
     */
    public function saveFile()
    {
        switch ($this->lang) {
            case self::LANG_JS:
                break;

            case self::LANG_PHP:
            default:
                $data = '';

                if($this->config[self::CONFIG_PHP_OUTPUT] == self::CONFIG_VALUE_PHP_OUTPUT_RETURN)
                    $data .= "<?php \n\nreturn " . var_export($this->array, true) . ";";
                else if($this->config[self::CONFIG_PHP_OUTPUT] == self::CONFIG_VALUE_PHP_OUTPUT_VARIABLE)
                    $data .= '<?php \n$icons = ' . var_export($this->array, true) . ";";
                else
                    throw new Exception("Invalid Configuration.");

                file_put_contents(
                    $this->output_dir . "/$this->output_filename.php",
                    $data
                );
                break;
        }
    }

    /**
     * @return array
     */
    public function getArray()
    {
        return $this->array;
    }

    /**
     * @return mixed
     */
    public function getOutputDir()
    {
        return $this->output_dir;
    }

    /**
     * @return int|mixed
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * @return mixed|string
     */
    public function getLang()
    {
        return $this->lang;
    }
}