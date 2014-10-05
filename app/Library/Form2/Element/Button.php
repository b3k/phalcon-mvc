<?php
/*
  +------------------------------------------------------------------------+
  | PhalconEye CMS                                                         |
  +------------------------------------------------------------------------+
  | Copyright (c) 2013-2014 PhalconEye Team (http://phalconeye.com/)       |
  +------------------------------------------------------------------------+
  | This source file is subject to the New BSD License that is bundled     |
  | with this package in the file LICENSE.txt.                             |
  |                                                                        |
  | If you did not receive a copy of the license and are unable to         |
  | obtain it through the world-wide-web, please send an email             |
  | to license@phalconeye.com so we can send you a copy immediately.       |
  +------------------------------------------------------------------------+
  | Author: Ivan Vorontsov <ivan.vorontsov@phalconeye.com>                 |
  | Author: Piotr Gasiorowski <p.gasiorowski@vipserv.org>                  |
  +------------------------------------------------------------------------+
*/

namespace App\Library\Form2\Element;

use App\Library\Form\AbstractElement;

/**
 * Form element - Button.
 *
 * @category  PhalconEye
 * @package   Engine\Form\Element
 * @author    Ivan Vorontsov <ivan.vorontsov@phalconeye.com>
 * @author    Piotr Gasiorowski <p.gasiorowski@vipserv.org>
 * @copyright 2013-2014 PhalconEye Team
 * @license   New BSD License
 * @link      http://phalconeye.com/
 */
class Button extends AbstractElement
{
    use TranslationBehaviour;

    /**
     * If element is need to be rendered in default layout.
     *
     * @return bool
     */
    public function useDefaultLayout()
    {
        return false;
    }

    /**
     * If element is need to be rendered in default layout.
     *
     * @return bool
     */
    public function isIgnored()
    {
        return true;
    }

    /**
     * Get allowed options for this element.
     *
     * @return array
     */
    public function getAllowedOptions()
    {
        return ['htmlTemplate', 'label', 'isSubmit'];
    }

    /**
     * Get element default options.
     *
     * @return array
     */
    public function getDefaultOptions()
    {
        return ['isSubmit' => true];
    }

    /**
     * Get element default attribute.
     *
     * @return array
     */
    public function getDefaultAttributes()
    {
        return array_merge(
            parent::getDefaultAttributes(),
            (
            $this->getOption('isSubmit') ?
                ['type' => 'submit', 'class' => 'btn btn-primary']
                :
                ['type' => 'button', 'class' => 'btn']
            )
        );
    }

    /**
     * Get element html template.
     *
     * @return string
     */
    public function getHtmlTemplate()
    {
        return $this->getOption('htmlTemplate', '<button' . $this->_renderAttributes() . '>%s</button>');
    }

    /**
     * Get element html template values
     *
     * @return array
     */
    public function getHtmlTemplateValues()
    {
        return [$this->_($this->getOption('label'))];
    }

    /**
     * Render element.
     *
     * @return string
     */
    public function render()
    {
        if (!$this->getAttribute('value') && $this->getValue()) {
            $this->setAttribute('value', $this->getValue());
        }

        return parent::render();
    }
}