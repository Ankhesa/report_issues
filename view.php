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

require_once('../../config.php');
require_once('report_issues_form.php');
require_once('lib.php');

global $DB, $OUTPUT, $PAGE, $USER;
$site = get_site();

$courseid = required_param('courseid', PARAM_INT);
$id = optional_param('id', 0, PARAM_INT);
$contextid = required_param('contextid', PARAM_INT);
$blockid = required_param('blockid', PARAM_INT);


$context = context_course::instance($courseid);
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');
$PAGE->set_heading(get_string('heading', 'block_report_issues'));
$PAGE->set_url($CFG->wwwroot . '/blocks/report_issues/view.php', array('contextid' => $contextid));


if (!$course = $DB->get_record('course', array('id' => $courseid))) {
    print_error('invalidcourse', 'block_report_issues', $courseid);
}

$PAGE->set_url('/blocks/report_issues/view.php', array('contextid' => $contextid, 'courseid' => $courseid));
$PAGE->set_heading(get_string('heading', 'block_report_issues'));

require_login($course);

$report_issues = new report_issues_form();

if ($report_issues->is_cancelled()) {
    // Cancelled forms redirect to the course main page.
    $courseurl = new moodle_url('/course/view.php', array('id' => $courseid));
    redirect($courseurl);
} else if ($fromform = $report_issues->get_data()) {

     
    if (!block_report_issues_add($fromform, $contextid)) {
        print_error('inserterror', 'block_report_issues');
    }
    

    $courseurl = new moodle_url('/course/view.php', array('id' => $courseid));
    redirect($courseurl,get_string('successmessage', 'block_report_issues'), null, \core\output\notification::NOTIFY_SUCCESS);

} else {
    // Form didn't validate or this is the first display.
    $site = get_site();
    echo $OUTPUT->header();

    $toform['blockid'] = $blockid;
    $toform['courseid'] = $courseid;
    $toform['userid'] = $USER->id;
    $toform['contextid'] = $contextid;

    $report_issues->set_data($toform);
    $report_issues->display();

    echo $OUTPUT->footer();
}
?>