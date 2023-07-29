<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'SimpleFormatter.php';

class SimpleExtractor
{
    private string $icons_json_file;
    private array $data;
    private bool $all;
    private bool $fancy;
    private string $style;
    private SimpleFormatter $formatter;

    public function __construct(
        $icons_json_file,
        $all,
        $formatter,
        $style = 'solid',
        $fancy = false
    )
    {
        $this->icons_json_file = $icons_json_file;
        $this->data = json_decode(file_get_contents($this->icons_json_file), true);
        $this->all = $all;
        $this->formatter = $formatter;
        $this->style = $style;
        $this->fancy = $fancy;
    }

    public function extract() {
        foreach ($this->data as $key => $value) {
            if ($this->fancy)
                echo "$key\n";

            if( $this->all
                || ( in_array($this->style, $value['styles']))) {

                $this->formatter->add($key);
            }
        }
    }

    /**
     * @return string
     */
    public function getIconsJsonFile(): string
    {
        return $this->icons_json_file;
    }

    /**
     * @param string $icons_json_file
     */
    public function setIconsJsonFile(string $icons_json_file): void
    {
        $this->icons_json_file = $icons_json_file;
    }

    /**
     * @return bool
     */
    public function isAll(): bool
    {
        return $this->all;
    }

    /**
     * @param bool $all
     */
    public function setAll(bool $all): void
    {
        $this->all = $all;
    }

    /**
     * @return string
     */
    public function getStyle(): string
    {
        return $this->style;
    }

    /**
     * @param string $style
     */
    public function setStyle(string $style): void
    {
        $this->style = $style;
    }

    /**
     * @return SimpleFormatter
     */
    public function getFormatter(): SimpleFormatter
    {
        return $this->formatter;
    }

    /**
     * @param SimpleFormatter $formatter
     */
    public function setFormatter(SimpleFormatter $formatter): void
    {
        $this->formatter = $formatter;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @return bool
     */
    public function isFancy(): bool
    {
        return $this->fancy;
    }

    /**
     * @param bool $fancy
     */
    public function setFancy(bool $fancy): void
    {
        $this->fancy = $fancy;
    }
}