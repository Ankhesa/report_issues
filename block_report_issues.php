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

defined('MOODLE_INTERNAL') || die();

class block_report_issues extends block_base {
    public function init() {
        $this->title = get_string('pluginname', __CLASS__);
    }

    public function get_content() {
        global $DB, $COURSE, $USER, $PAGE, $OUTPUT;
        $this->content = new stdClass();


        // Check to see if we have the capabilities
        $canreport = has_capability('block/report_issues:report', $this->context);
        

         $button = new single_button(
            new  moodle_url('/blocks/report_issues/view.php', array('blockid' => $this->instance->id, 'courseid' => $COURSE->id, 'userid' => $USER->id,'contextid' => $this->context->id)),
            get_string('heading', 'block_report_issues'), 'get', true,
            ['class' => 'buttons']);

            if ($canreport) {
                $this->content->text = html_writer::tag('div', $OUTPUT->render($button),
                ['class' => 'buttons']);
            }

    }

    function applicable_formats() {
        return array('mod' => true);
    }

    public function instance_delete() {
        global $DB;
        $DB->delete_records('block_report_issues', array('blockid' => $this->instance->id));
    }


}
