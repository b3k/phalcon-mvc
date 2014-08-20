<?php

namespace App\Library\Form;

class BaseForm extends AbstractForm
{

    const
    /**
     * Default layout path.
     */
            LAYOUT_DEFAULT_PATH = 'partials/form/default';

    use EntityForm;

    /**
     * Get layout view path.
     *
     * @return string
     */
    public function getLayoutView()
    {
        return $this->_resolveView(self::LAYOUT_DEFAULT_PATH);
    }

    /**
     * Get element view path.
     *
     * @return string
     */
    public function getElementView()
    {
        return $this->getLayoutView() . '/element';
    }

    /**
     * Get errors view path.
     *
     * @return string
     */
    public function getErrorsView()
    {
        return $this->getLayoutView() . '/errors';
    }

    /**
     * Get notices view path.
     *
     * @return string
     */
    public function getNoticesView()
    {
        return $this->getLayoutView() . '/notices';
    }

    /**
     * Get fieldset view path.
     *
     * @return string
     */
    public function getFieldSetView()
    {
        return $this->getLayoutView() . '/fieldSet';
    }

    /**
     * Resolve view.
     *
     * @param string $view   View path.
     * @param string $module Module name (capitalized).
     *
     * @return string
     */
    protected function _resolveView($view, $module = 'Core')
    {
        return '../../' . $module . '/View/' . $view;
    }

}
