<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Prints an instance of mod_prueba1.
 *
 * @package     mod_prueba1
 * @copyright   2024 Your Name <you@example.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require(__DIR__.'/../../config.php');
require_once(__DIR__.'/lib.php');

//Para importar el form de input
require_once($CFG->dirroot . '/mod/prueba1/classes/form/input_details_form.php');
require_once($CFG->dirroot . '/mod/prueba1/classes/controllers/prueba1_controller.php');

// Course module id.
$id = optional_param('id', 0, PARAM_INT);

global $DB;

// este
if ($id) {
  $cm = get_coursemodule_from_id('prueba1', $id, 0, false, MUST_EXIST);
  $course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
  $moduleinstance = $DB->get_record('prueba1', array('id' => $cm->instance), '*', MUST_EXIST);
} else {
  $fromform = $mform->get_data();
  $moduleinstance = $DB->get_record('prueba1', array('id' => $fromform->id), '*', MUST_EXIST);
  $course = $DB->get_record('course', array('id' => $moduleinstance->course), '*', MUST_EXIST);
  $cm = get_coursemodule_from_instance('prueba1', $moduleinstance->id, $course->id, false, MUST_EXIST);
}

require_login($course, true, $cm);

$modulecontext = context_module::instance($cm->id);

$event = \mod_prueba1\event\course_module_viewed::create(array(
    'objectid' => $moduleinstance->id,
    'context' => $modulecontext
));
$event->add_record_snapshot('course', $course);
$event->add_record_snapshot('prueba1', $moduleinstance);
$event->trigger();

$PAGE->set_url('/mod/prueba1/view.php', array('id' => $cm->id));
$PAGE->set_title(format_string($moduleinstance->name));
$PAGE->set_heading(format_string($course->fullname));
$PAGE->set_context($modulecontext);

//form
$mform = new input_details_form($id);
//controller
$controller = prueba1_controller::getInstance();

echo $OUTPUT->header();

if ($fromform = $mform->get_data()) {
  // When the form is submitted, and the data is successfully validated,
  // the `get_data()` function will return the data posted in the form.
//  \core\notification::info("Info del Form <br>meeting_id ingresado - $fromform->meeting_id<br>");

  $templatecontext = (object)[
    'presentes'=> $controller->getAttendancePercentage($fromform->meeting_id)
  ];

  $mform->display();
  echo $OUTPUT->render_from_template('prueba1/getAttendance',$templatecontext);
  //$mform->display();
  
} else {
  // This branch is executed if the form is submitted but the data doesn't
  // validate and the form should be redisplayed or on the first display of the form.
  
  // Set anydefault data (if any).
  $mform->set_data($toform);
  $mform->display();
  
  // Display the form.
}


echo $OUTPUT->footer();
