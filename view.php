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

// Course module id.
$id = optional_param('id', 0, PARAM_INT);

// Activity instance id.
$p = optional_param('p', 0, PARAM_INT);

if ($id) {
    $cm = get_coursemodule_from_id('prueba1', $id, 0, false, MUST_EXIST);
    $course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
    $moduleinstance = $DB->get_record('prueba1', array('id' => $cm->instance), '*', MUST_EXIST);
} else {
    $moduleinstance = $DB->get_record('prueba1', array('id' => $p), '*', MUST_EXIST);
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

//SQL

global $DB;

$sql =
    "SELECT mas.* FROM {attendance_sessions} mas
        WHERE mas.sessdate BETWEEN (
        SELECT mzmd2.start_time - :mzmd3_time1
        FROM {zoom_meeting_details} mzmd2
        WHERE mzmd2.id = :mzmd_id1
        ) AND (
            SELECT mzmd3.end_time + :mzmd3_time2
        FROM {zoom_meeting_details} mzmd3
        WHERE mzmd3.id = :mzmd_id2
        )
        AND mas.attendanceid = (
        SELECT ma.id
        FROM {attendance} ma
        WHERE ma.course = (
        SELECT mz.course
        FROM {zoom} mz
        WHERE mz.id = (
            SELECT mzmd.zoomid
            FROM {zoom_meeting_details} mzmd
            WHERE mzmd.id = :mzmd_id3
        )
    )
)";

$params = [
    'mzmd3_time1'=> '3600',
    'mzmd_id1'=> '12299',
    'mzmd3_time2'=> '3600',
    'mzmd_id2'=> '12299',
    'mzmd_id3'=> '12299',
];

$attendance = array_values($DB->get_records_sql($sql,$params));

$sql1 =
    "SELECT
    mzmp.userid,
    mzmp.name,
    SUM(mzmp.duration) AS total_duration,
    (mzmd.end_time - mzmd.start_time) AS meeting_duration,
    (SUM(mzmp.duration) * 100.0 / (mzmd.end_time - mzmd.start_time)) AS attendance_percentage,
    MIN(mzmp.join_time),
    MAX(mzmp.leave_time)
    FROM
        {zoom_meeting_participants} mzmp
    JOIN
        {zoom_meeting_details} mzmd ON mzmp.detailsid = :mzmd_id
    WHERE
        mzmp.detailsid = :mzmp_detailsid
    GROUP BY
        mzmp.userid, mzmp.name, mzmd.start_time, mzmd.end_time";

$params1=['mzmd_id'=>'12299','mzmp_detailsid'=>'12299'];
$presentes = array_values($DB->get_records_sql($sql1,$params1));

foreach($presentes as $obj){
    $obj->min_join_time = $obj->{'min(mzmp.join_time)'};
    $obj->max_leave_time = $obj->{'max(mzmp.leave_time)'};
}

$templatecontext = (object)[
    'attendance'=> $attendance,
    'presentes'=> $presentes
];


echo $OUTPUT->header();

echo $OUTPUT->render_from_template('prueba1/getAttendance',$templatecontext);

echo $OUTPUT->footer();
