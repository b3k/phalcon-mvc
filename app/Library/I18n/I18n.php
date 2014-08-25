<?php

namespace App\Library\I18n;

use \Phalcon\Translate\AdapterInterface;

class I18n
{

    private $language = 'en_GB';
    private $config;
    private $translators = array();

    public function __construct($config)
    {
        $this->config = $config;
        if ($this->config->default) {
            $this->setLanguage($this->config->default);
        }
    }

    public function getTranslator($language)
    {
        return isset($this->translators[$language]) ?
                $this->translators[$language] :
                NULL;
    }

    public function setTranslator($language, AdapterInterface $Translator)
    {
        $this->translators[$language] = $Translator;
    }

    public function hasSupport($language)
    {
        return $this->getTranslator($language) ?
                TRUE :
                (is_readable(APP_CONFIG_DIR . DS . 'i18n' . DS . strtolower($language) . '.php'));
    }

    public function getLanguage()
    {
        return $this->language;
    }

    public function setLanguage($language)
    {
        $this->language = $language;
    }

    public function load($language)
    {
        $translation_path = APP_CONFIG_DIR . DS . 'i18n' . DS . strtolower($language) . '.php';
        if (!is_readable($translation_path)) {
            throw new \RuntimeException(sprintf('Not found translation file in %s', $translation_path));
        }
        $Translator = new \Phalcon\Translate\Adapter\NativeArray(['content' => require_once($translation_path)]);
        $this->setTranslator($language, $Translator);
        return $Translator;
    }

    function _($string, array $values = array())
    {
        if (!($Translator = $this->getTranslator($this->getLanguage()))) {
            $Translator = $this->load($this->getLanguage());
        }

        $string = $Translator->query($string, $values);
        return empty($values) ? $string : strtr($string, $values);
    }

}
