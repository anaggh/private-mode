<?php

class PrivateModePlugin extends Plugin
{

    public function init()
    {
        $this->dbFields = array(
            'enable' => true,
            'message' => 'Private Access Only'
        );
    }

    public function form()
    {
        global $Language;

        $html  = '<div>';
        $html .= '<label>' . $Language->get('enable-private-mode') . '</label>';
        $html .= '<select name="enable">';
        $html .= '<option value="true" ' . ($this->getValue('enable') === true ? 'selected' : '') . '>Enabled</option>';
        $html .= '<option value="false" ' . ($this->getValue('enable') === false ? 'selected' : '') . '>Disabled</option>';
        $html .= '</select>';
        $html .= '</div>';

        $html .= '<div>';
        $html .= '<label>' . $Language->get('message') . '</label>';
        $html .= '<input name="message" id="jsmessage" type="text" value="' . $this->getDbField('message') . '">';
        $html .= '</div>';

        return $html;
    }

    public function beforeAll()
    {
        if ($this->getDbField('enable')) {
            /**
             * Redirect to admin if not logged in.
             */
            global $Login;
            if (! $Login->isLogged()) {
                Alert::set($this->getDbField('message'));
                // 302 Redirect
                Redirect::url(DOMAIN_ADMIN);
            }
        }
    }
}
