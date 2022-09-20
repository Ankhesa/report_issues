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
 * Report Issues Block
 * @package    block_report_issues
 * @author     Johana Requena <jha.requena@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once("{$CFG->libdir}/formslib.php");

class report_issues_form extends moodleform {

    function definition() {

        $mform =& $this->_form;
        $mform->addElement('header', 'displayinfo', get_string('reportheader', 'block_report_issues'));

        // Add textarea issue description
        $mform->addElement('textarea', 'description', get_string('issuedescription', 'block_report_issues'), 'wrap="virtual" rows="10" cols="50"'); 

        $this->add_action_buttons();

        // Hidden elements.
        $mform->addElement('hidden', 'blockid');
        $mform->setType('blockid', PARAM_RAW);
        $mform->addElement('hidden', 'courseid');
        $mform->setType('courseid', PARAM_RAW);
        $mform->addElement('hidden', 'userid', '0');
        $mform->setType('userid', PARAM_RAW);
        $mform->addElement('hidden', 'contextid');
        $mform->setType('contextid', PARAM_RAW);

    }
}