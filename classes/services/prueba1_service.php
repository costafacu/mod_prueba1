<?php




class prueba1_service
{


    public function calculateAttendance($meetingId)
    {
        global $DB;
        $sql = "SELECT
                    mzmp.userid,
                    mzmp.name,
                    SUM(mzmp.duration) AS total_duration,
                    (mzmd.end_time - mzmd.start_time) AS meeting_duration,
                    (SUM(mzmp.duration) * 100 / (mzmd.end_time - mzmd.start_time)) AS attendance_percentage,
                    MIN(mzmp.join_time),
                    MAX(mzmp.leave_time)
                FROM
                    {zoom_meeting_participants} mzmp
                JOIN
                    {zoom_meeting_details} mzmd ON mzmp.detailsid = mzmd.id
                WHERE
                    mzmp.detailsid = :mzmp_detailsid
                GROUP BY
                    mzmp.userid, mzmp.name, mzmd.start_time, mzmd.end_time";

        $params = ['mzmp_detailsid' => $meetingId];
        $attendanceData = array_values($DB->get_records_sql($sql, $params));

        return $attendanceData;
    }
    public function markAttendance($attendanceData, $threshold){
        global $DB;
    }
}