<?php

namespace App\Library\Form;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text as FormElementText;
use Phalcon\Forms\Element\Password as FormElementPassword;
use Phalcon\Forms\Element\Select as FormElementSelect;
use Phalcon\Forms\Element\Check as FormElementCheck;
use Phalcon\Forms\Element\Textarea as FormElementTextarea;
use Phalcon\Forms\Element\Hidden as FormElementHidden;
use Phalcon\Forms\Element\File as FormElementFile;
use Phalcon\Forms\Element\Date as FormElementDate;
use Phalcon\Forms\Element\Numeric as FormElementNumeric;
use Phalcon\Forms\Element\Submit as FormElementSubmit;

abstract class FormBase extends Form
{

    public function __construct($Entity, Array $userOptions = array())
    {
        parent::__construct($Entity, $userOptions);
        return $this;
    }

    public function initialize(Array $UserOptions = array())
    {
        $this->definition();
        $this->validation();
    }

    public function add($name, $type = 'text', Array $attributes = array())
    {
        if (empty($name)) {
            throw new \RuntimeException('Name is required when creating new form element.');
        }

        $name = trim($name);
        $classname = 'FormElement' . ucfirst(strtolower($type));

        if (class_exists($classname)) {

            $FormElement = new $classname($name, $attributes);
            parent::add($FormElement);

            return $this;
        } else {
            throw new \RuntimeException('Undefined form element');
        }
    }

    public abstract function definition();

    public function validation()
    {
        return;
    }

}
