<?php
// This file is part of SocialShare - https://github.com/sekharjaji/moodle-block_socialshare
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle. If not, see <http://www.gnu.org/licenses/>.

/**
 * SocialShare block class.
 *
 * @package   block_socialshare
 * @copyright 2015 onwards Sekhar Jajimoggala
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_socialshare_edit_form extends block_edit_form {

    /**
     * Adds configuration options for SocialShare block
     *
     * @param object $mform
     * @throws coding_exception
     */
    protected function specific_definition($mform) {

        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        $mform->addElement('advcheckbox', 'config_enablefacebook', get_string('enablefacebook', 'block_socialshare'));
        $mform->setDefault('config_enablefacebook', true);
        $mform->setType('config_enablefacebook', PARAM_BOOL);

        $mform->addElement('advcheckbox', 'config_enabletwitter', get_string('enabletwitter', 'block_socialshare'));
        $mform->setDefault('config_enabletwitter', true);
        $mform->setType('config_enabletwitter', PARAM_BOOL);

        $mform->addElement('advcheckbox', 'config_enablegoogleplus', get_string('enablegoogleplus', 'block_socialshare'));
        $mform->setDefault('config_enablegoogleplus', true);
        $mform->setType('config_enablegoogleplus', PARAM_BOOL);
    }
}
