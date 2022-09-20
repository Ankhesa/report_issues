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


function block_report_issues_add($issue, $contextid, $return = false) {
    global $CFG, $DB, $USER, $OUTPUT;
   
    $newissue = $DB->insert_record('block_report_issues', $issue);
            
    if($newissue) $return=true;
    
    // Trigger event for the report issue we performed.
    $event = \block_report_issues\event\report_issues::create_from_record($contextid);
    $event->trigger();

    return $return;
}