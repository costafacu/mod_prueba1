<?php

global $CFG;
require_once($CFG->dirroot . '/mod/prueba1/classes/services/prueba1_service.php');
class prueba1_controller {


    private static $instance = null;
    private $attendanceService;


    private function __construct() {
        $this->attendanceService = new prueba1_service();
    }


    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    public function getAttendancePercentage($meeting_id) {

        $paricipants = $this->attendanceService->calculateAttendance($meeting_id);

        foreach ($paricipants as $obj) {
            $obj->total_duration = gmdate("H:i:s", $obj->total_duration);
            $obj->meeting_duration = gmdate("H:i:s", $obj->meeting_duration);
            $obj->attendance_percentage = round($obj->attendance_percentage>100?100:$obj->attendance_percentage);
            $obj->min_join_time = date('Y-m-d H:i:s',$obj->{'min(mzmp.join_time)'});
            $obj->max_leave_time = date('Y-m-d H:i:s',$obj->{'max(mzmp.leave_time)'});
        }

        return $paricipants;
    }
    }