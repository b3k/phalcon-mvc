<?php

namespace App\Library\Form2\Element;

use App\Library\Form2\Element\AbstractElement as BaseElement;

abstract class AbstractInput extends BaseElement
{

    /**
     * Get this input element type.
     *
     * @return string
     */
    abstract public function getInputType();

    /**
     * Get element default attribute.
     *
     * @return array
     */
    public function getDefaultAttributes()
    {
        return array_merge(parent::getDefaultAttributes(), ['type' => $this->getInputType()]);
    }

    /**
     * Get element html template.
     *
     * @return string
     */
    public function getHtmlTemplate()
    {
        return $this->getOption('htmlTemplate', '<input' . $this->_renderAttributes() . ' value="%s">');
    }

}
