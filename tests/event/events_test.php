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
 * Events tests.
 *
 * Report Issues Block
 * @package    block_report_issues
 * @author     Johana Requena <jha.requena@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace block_report_issues\event;

/**
 * Events tests class.
 *
 * Report Issues Block
 * @package    block_report_issues
 * @author     Johana Requena <jha.requena@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class events_test extends \advanced_testcase {
    /** @var stdClass Keeps course object */
    private $course;

    /** @var stdClass Keeps page object */
    private $page;

    /**
     * Setup test data.
     */
    public function setUp(): void {
        $this->resetAfterTest();
        $this->setAdminUser();

        // Create course and page.
        $this->course = $this->getDataGenerator()->create_course();
        $this->page = $this->getDataGenerator()->create_module('page', array('course' => $this->course->id));
    }

    /**
     * Test comment_created event.
     */
    public function test_report_issues() {
        global $CFG,$USER;

        require_once($CFG->dirroot . '/blocks/report_issues/lib.php');

        // Issue when block is on module (page) page.
        $context = \context_module::instance($this->page->cmid);
        $args = new \stdClass;
        $args->contextid   = $context->id;
        $args->userid    = $USER->id;
        $args->description      = 'description';

        // Triggering and capturing the event.
        $sink = $this->redirectEvents();
        block_report_issues_add($args,$context->id);
        $events = $sink->get_events();
        $this->assertCount(1, $events);
        $event = reset($events);

        // Checking that the event contains the expected values.
        $this->assertInstanceOf('\block_report_issues\event\report_issues', $event);
        $this->assertEquals($context, $event->get_context());

        $this->assertEventContextNotUsed($event);
    }

    
}
