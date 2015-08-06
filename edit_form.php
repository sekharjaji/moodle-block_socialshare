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

        $mform->addElement('advcheckbox', 'config_enablestumbleupon', get_string('enablestumbleupon', 'block_socialshare'));
        $mform->setDefault('config_enablestumbleupon', true);
        $mform->setType('config_enablestumbleupon', PARAM_BOOL);

        $options = $this->get_url_scope_options();
        $mform->addElement('select', 'config_urlscope', get_string('urlscope', 'block_socialshare'), $options);
    }

    /**
     * Gets configuration options for url scope
     *
     * @return array
     * @throws Exception
     * @throws coding_exception
     * @throws dml_exception
     */
    private function get_url_scope_options() {
        $options = array(1 => get_string('currentpage', 'block_socialshare'));
        $pagecontext = $this->page->context;
        $coursecontext = $pagecontext->get_course_context(IGNORE_MISSING);
        if (has_capability('block/socialshare:manageurl', context_system::instance())) {
            // Most probabily an admin.
            $options[2] = get_string('currentroot', 'block_socialshare');
        }
        if ($coursecontext && has_capability('block/socialshare:manageurl', $coursecontext)) {
            $options[3] = get_string('currentcourse', 'block_socialshare');
        }
        if ($pagecontext->contextlevel == CONTEXT_MODULE && has_capability('block/socialshare:manageurl', $pagecontext)) {
            $options[4] = get_string('currentmodule', 'block_socialshare', $pagecontext->get_context_name(false));
        }
        return $options;
    }

}
