<?php

namespace App\Library\Form2;

use Phalcon\Forms\Form as BaseForm;
use App\Library\Form2\Element\AbstractElement;
use App\Library\Form2\Element\Checkbox  as CheckboxElement;
use App\Library\Form2\Element\Date      as DateElement;
use App\Library\Form2\Element\Email     as EmailElement;
use App\Library\Form2\Element\File      as FileElement;
use App\Library\Form2\Element\Hidden    as HiddenElement;
use App\Library\Form2\Element\Numeric   as NumericElement;
use App\Library\Form2\Element\Password  as PasswordElement;
use App\Library\Form2\Element\Radio     as RadioElement;
use App\Library\Form2\Element\Select    as SelectElement;
use App\Library\Form2\Element\Button    as ButtonElement;
use App\Library\Form2\Element\Text      as TextElement;
use App\Library\Form2\Element\Textarea  as TextareaElement;

abstract class Form extends BaseForm
{

    public function __construct($entity = null, Array $options = Array())
    {
        parent::__construct($entity, $options);
    }

    public function add(AbstractElement $element, $order = null) {
        parent::add($element, $order);
    }

    public function addCheckbox(
    $name, $label = null, $value = null, $isChecked = false, $defaultValue = null, array $options = [], array $attributes = []
    )
    {
        $element = new CheckboxElement($name, $options, $attributes);

        if (!$label) {
            $label = self::convertStringToLabel($name);
        }

        $element
                ->setOption('label', $label)
                ->setOption('checked', $isChecked)
                ->setOption('defaultValue', $defaultValue)
                ->setAttribute('value', $value);
        $this->add($element);

        return $this;
    }

    public function addRadio(
    $name, $label = null, $elementOptions = [], $value = null, array $options = [], array $attributes = []
    )
    {
        $element = new RadioElement($name, $options, $attributes);

        if (!$label) {
            $label = convertStringToLabel($name);
        }

        $element
                ->setOption('label', $label)
                ->setOption('elementOptions', $elementOptions)
                ->setValue($value);
        $this->add($element);

        return $this;
    }
    
    /**
     * Text element.
     *
     * @param string      $name        Element name.
     * @param string|null $label       Element label.
     * @param string|null $description Element description.
     * @param mixed|null  $value       Element value.
     * @param array       $options     Element options.
     * @param array       $attributes  Element attributes.
     *
     * @return $this
     */
    public function addDate(
    $name, $label = null, $value = null, array $options = [], array $attributes = []
    )
    {
        $element = new DateElement($name, $options, $attributes);

        if (!$label) {
            $label = self::convertStringToLabel($name);
        }

        $element
                ->setOption('label', $label)
                ->setValue($value);

        $this->add($element);

        return $this;
    }

    /**
     * Text element.
     *
     * @param string      $name        Element name.
     * @param string|null $label       Element label.
     * @param string|null $description Element description.
     * @param mixed|null  $value       Element value.
     * @param array       $options     Element options.
     * @param array       $attributes  Element attributes.
     *
     * @return $this
     */
    public function addText(
    $name, $label = null, $value = null, array $options = [], array $attributes = []
    )
    {
        $element = new TextElement($name, $options, $attributes);

        if (!$label) {
            $label = self::convertStringToLabel($name);
        }

        $element
                ->setOption('label', $label)
                ->setValue($value);

        $this->add($element);

        return $this;
    }

    /**
     * Password element.
     *
     * @param string      $name        Element name.
     * @param string|null $label       Element label.
     * @param string|null $description Element description.
     * @param array       $options     Element options.
     * @param array       $attributes  Element attributes.
     *
     * @return $this
     */
    public function addPassword($name, $label = null, array $options = [], array $attributes = [])
    {
        $element = new PasswordElement($name, $options, $attributes);

        if (!$label) {
            $label = self::convertStringToLabel($name);
        }

        $element
                ->setOption('label', $label);
        $this->add($element);

        return $this;
    }

    /**
     * Select element.
     *
     * @param string      $name           Element name.
     * @param string|null $label          Element label.
     * @param string|null $description    Element description.
     * @param array       $elementOptions Element value options.
     * @param mixed|null  $value          Element value.
     * @param array       $options        Element options.
     * @param array       $attributes     Element attributes.
     *
     * @return $this
     */
    public function addSelect(
    $name, $label = null, $elementOptions = [], $value = null, array $options = [], array $attributes = []
    )
    {
        $element = new SelectElement($name, $options, $attributes);

        if (!$label) {
            $label = self::convertStringToLabel($name);
        }

        $element
                ->setOption('label', $label)
                ->setOption('elementOptions', $elementOptions)
                ->setValue($value);
        $this->add($element);

        return $this;
    }

    /**
     * TextArea element.
     *
     * @param string      $name        Element name.
     * @param string|null $label       Element label.
     * @param string|null $description Element description.
     * @param mixed|null  $value       Element value.
     * @param array       $options     Element options.
     * @param array       $attributes  Element attributes.
     *
     * @return $this
     */
    public function addTextArea(
    $name, $label = null, $description = null, $value = null, array $options = [], array $attributes = []
    )
    {
        $element = new TextareaElement($name, $options, $attributes);

        if (!$label) {
            $label = self::convertStringToLabel($name);
        }

        $element
                ->setOption('label', $label)
                ->setOption('description', $description)
                ->setValue($value);

        $this->add($element);

        return $this;
    }

    /**
     * Hidden element.
     *
     * @param string     $name       Element name.
     * @param mixed|null $value      Element value.
     * @param array      $options    Element options.
     * @param array      $attributes Element attributes.
     *
     * @return $this
     */
    public function addHidden($name, $value = null, array $options = [], array $attributes = [])
    {
        $element = new HiddenElement($name, $options, $attributes);
        $element->setValue($value);
        $this->add($element);

        return $this;
    }

    public function addFile(
    $name, $label = null, $isImage = false, $value = null, array $options = [], array $attributes = []
    )
    {
        $element = new FileElement($name, $options, $attributes);

        if (!$label) {
            $label = self::convertStringToLabel($name);
        }

        $element
                ->setOption('label', $label)
                ->setOption('isImage', $isImage)
                ->setValue($value);

        $this->add($element);

        return $this;
    }

    public function addNumeric(
    $name, $label = null, $value = null, array $options = [], array $attributes = []
    )
    {
        $element = new NumericElement($name, $options, $attributes);

        if (!$label) {
            $label = self::convertStringToLabel($name);
        }

        $element
                ->setOption('label', $label)
                ->setValue($value);

        $this->add($element);

        return $this;
    }

    public function addButton(
    $name, $label = null, $isSubmit = true, $value = null, array $options = [], array $attributes = []
    )
    {
        $element = new ButtonElement($name, $options, $attributes);

        if (!$label) {
            $label = self::convertStringToLabel($name);
        }

        $element
                ->setOption('label', $label)
                ->setOption('isSubmit', $isSubmit)
                ->setValue($value);

        $this->add($element);

        return $this;
    }


    public static function convertStringToLabel($string)
    {
        return ucfirst($string);
    }
    
}
