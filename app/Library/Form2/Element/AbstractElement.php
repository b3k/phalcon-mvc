<?php

namespace App\Library\Form2\Element;

use Phalcon\Forms\Element as BaseElement;

abstract class AbstractElement extends BaseElement
{

    protected $_value;

    /**
     * Element constructor.
     *
     * @param string $name       Element name.
     * @param array  $options    Element options.
     * @param array  $attributes Element attributes.
     */
    public function __construct($name, array $options = [], array $attributes = [])
    {
        parent::__construct($name, $attributes);
        $this->setOptions($options);
    }

    /**
     * Sets the element option.
     *
     * @param string $value  Element value.
     * @param bool   $escape Try to escape html in value.
     *
     * @return $this
     */
    public function setValue($value, $escape = true)
    {
        $value = $this->_xssClean($value);
        $escape = ($this->getOption('escape') !== null ? $this->getOption('escape') : $escape);
        if ($escape && (is_string($value) && !empty($value))) {
            $value = htmlentities($value);
        }

        $this->_value = $value;
        return $this;
    }

    /**
     * Returns the element's value.
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->_value;
    }

    public function setOptions($options)
    {
        $this->setUserOptions($options);
        return $this;
    }

    public function getOptions()
    {
        return array_merge($this->getDefaultOptions(), $this->getUserOptions());
    }

    public function setOption($option, $value)
    {
        $allowedOptions = $this->getAllowedOptions();
        if (!in_array($option, $allowedOptions)) {
            throw new Exception(
            sprintf(
                    'Element "%s" has no option "%s". Allowed options: %s.', get_class($this), $option, (!empty($allowedOptions) ? implode(', ', $allowedOptions) : 'None')
            )
            );
        }

        $this->setUserOption($option, $value);
        return $this;
    }

    public function getOption($option, $default = null)
    {
        return $this->getUserOption($option, $default);
    }

    /**
     * Returns the attributes for the element.
     *
     * @return array
     */
    public function getAttributes()
    {
        return array_merge($this->getDefaultAttributes(), parent::getAttributes());
    }

    /**
     * Get allowed options for this element.
     *
     * @return array
     */
    public function getAllowedOptions()
    {
        return [
            'label',
            'description',
            'ignore',
            'htmlTemplate',
            'defaultValue',
        ];
    }

    /**
     * Get element default options.
     *
     * @return array
     */
    public function getDefaultOptions()
    {
        return [];
    }

    /**
     * Get element default attribute.
     *
     * @return array
     */
    public function getDefaultAttributes()
    {
        $default = [
            'id' => rtrim($this->getName(), '[]'),
            'name' => $this->getName(),
            'class' => 'form-element'
        ];
        return $default;
    }

    /**
     * Get element html template values
     *
     * @return array
     */
    public function getHtmlTemplateValues()
    {
        return [$this->getValue()];
    }

    /**
     * Render element.
     *
     * @return string
     */
    public function render()
    {
        return vsprintf(
                $this->getHtmlTemplate(), $this->getHtmlTemplateValues()
        );
    }

    /**
     * Get attributes as html.
     *
     * @return string
     */
    protected function _renderAttributes()
    {
        $html = '';
        foreach ($this->getAttributes() as $key => $attribute) {
            $html .= sprintf(' %s="%s"', $key, $attribute);
        }

        return $html;
    }

    /**
     * Clean string, preventing xss.
     * Thanks to PHP community for this function.
     *
     * @param string $data Data to filter.
     *
     * @return string
     */
    protected function _xssClean($data)
    {
        if (empty($data) || !is_string($data)) {
            return $data;
        }

        // Fix &entity\n;
        $data = str_replace(array('&amp;', '&lt;', '&gt;'), array('&amp;amp;', '&amp;lt;', '&amp;gt;'), $data);
        $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
        $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
        $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

        // Remove any attribute starting with "on" or xmlns.
        $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

        // Remove javascript: and vbscript: protocols.
        $data = preg_replace(
                '#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]
            *a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data
        );
        $data = preg_replace(
                '#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]
            *c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data
        );
        $data = preg_replace(
                '#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data
        );

        // Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
        $data = preg_replace(
                '#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data
        );
        $data = preg_replace(
                '#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data
        );
        $data = preg_replace(
                '#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]
            *c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data
        );

        // Remove namespaced elements (we do not need them).
        $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

        do {
            // Remove really unwanted tags.
            $old_data = $data;
            $data = preg_replace(
                    '#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)
                |l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data
            );
        } while ($old_data !== $data);

        return $data;
    }

}
