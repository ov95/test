<?php

namespace Engine\Template;

class Builder
{
    protected $file;
    protected $values = array();

    public function __construct($file)
    {
        $this->file = VIEWS_DIR . $file;
    }

    public function set($key, $value)
    {
        $this->values[$key] = $value;
    }

    public function render()
    {
        if (!file_exists($this->file)) {
            return "Error loading template file ($this->file).";
        }
        $render = file_get_contents($this->file);

        foreach ($this->values as $key => $value) {
            $tagToReplace = "[ $key ]";
            $render = str_replace($tagToReplace, $value, $render);
        }

        return $render;
    }

    static public function merge($templates)
    {
        $render = "";

        foreach ($templates as $template) {
            $content = (get_class($template) !== "Engine\Template\Builder")
                ? "Error, incorrect type - expected Template."
                : $template->render();
            $render .= $content;
        }

        return $render;
    }
}
