<?php
// This file is part of Moodle - http://moodle.org/
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
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Contains class mod_attendance_add_notification_form
 *
 * @package   mod_attendance
 * @copyright 2017 Dan Marsden
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Class mod_attendance_add_notification_form
 *
 * @package   mod_attendance
 * @copyright 2017 Dan Marsden
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class mod_attendance_add_notification_form extends moodleform {
    /**
     * Form definition
     */
    public function definition() {
        $mform = $this->_form;

        // Load global defaults.
        $config = get_config('attendance');

        $options = array();
        for ($i = 1; $i <= 100; $i++) {
            $options[$i] = "$i%";
        }
        $mform->addElement('select', 'warningpercent', get_string('warningpercent', 'mod_attendance'), $options);
        $mform->addHelpButton('warningpercent', 'warningpercent', 'mod_attendance');
        $mform->setType('warningpercent', PARAM_INT);
        $mform->setDefault('warningpercent', $config->warningpercent);

        $options = array();
        for ($i = 1; $i <= 50; $i++) {
            $options[$i] = "$i";
        }
        $mform->addElement('select', 'warnafter', get_string('warnafter', 'mod_attendance'), $options);
        $mform->addHelpButton('warnafter', 'warnafter', 'mod_attendance');
        $mform->setType('warnafter', PARAM_INT);
        $mform->setDefault('warnafter', $config->warnafter);

        $mform->addElement('checkbox', 'emailuser', get_string('emailuser', 'mod_attendance'));
        $mform->addHelpButton('emailuser', 'emailuser', 'mod_attendance');
        $mform->setDefault('emailuser', $config->emailuser);

        $mform->addElement('text', 'emailsubject', get_string('emailsubject', 'mod_attendance'), array('size' => '64'));
        $mform->setType('emailsubject', PARAM_TEXT);
        $mform->addRule('emailsubject', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');
        $mform->addHelpButton('emailsubject', 'emailsubject', 'mod_attendance');
        $mform->setDefault('emailsubject', $config->emailsubject);

        $mform->addElement('editor', 'emailcontent', get_string('emailcontent', 'mod_attendance'), null, null);
        $mform->setDefault('emailcontent', array('text' => format_text($config->emailcontent)));
        $mform->setType('emailcontent', PARAM_RAW);

        // Need to set hidden elements when adding default options.
        $mform->addElement('hidden', 'notifylevel', ATTENDANCE_NOTIFYLEVEL_ATTENDANCE);
        $mform->setType('notifylevel', PARAM_INT);

        $mform->addElement('hidden', 'idnumber', 0); // Default options use 0 as the idnumber.
        $mform->setType('idnumber', PARAM_INT);

        $mform->addElement('hidden', 'notid', 0); // id of notification record.
        $mform->setType('notid', PARAM_INT);

        $mform->addElement('hidden', 'id', $this->_customdata['id']); // id of course module record if setting attendance level.
        $mform->setType('id', PARAM_INT);

        if (!empty($this->_customdata['notid'])) {
            $btnstring = get_string('update', 'attendance');
        } else {
            $btnstring = get_string('add', 'attendance');
        }
        $this->add_action_buttons(true, $btnstring);

    }

    /**
     * Perform validation on the form
     * @param array $data
     * @param array $files
     */
    public function validation($data, $files) {
        $errors = parent::validation($data, $files);

        return $errors;
    }
}