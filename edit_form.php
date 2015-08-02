<?php
/**
 * socialshare block class.
 *
 * @package   block_socialshare
 * @copyright 2015 onwards Sekhar Jajimoggala
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class block_socialshare_edit_form extends block_edit_form {

    protected function specific_definition($m_form){

        $m_form->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        $m_form->addElement('advcheckbox', 'config_enablefacebook', get_string('enablefacebook', 'block_socialshare'));
        $m_form->setDefault('config_enablefacebook', true);
        $m_form->setType('config_enablefacebook', PARAM_BOOL);

        $m_form->addElement('advcheckbox', 'config_enabletwitter', get_string('enabletwitter', 'block_socialshare'));
        $m_form->setDefault('config_enabletwitter', true);
        $m_form->setType('config_enabletwitter', PARAM_BOOL);

        $m_form->addElement('advcheckbox', 'config_enablegoogleplus', get_string('enablegoogleplus', 'block_socialshare'));
        $m_form->setDefault('config_enablegoogleplus', true);
        $m_form->setType('config_enablegoogleplus', PARAM_BOOL);
    }
}
