export interface EstudianteAttendance {
    studentId: number;
    groupId: number;
    attendancePercentage: number;
    isLate: boolean;
    meetingStartTime: Date; // del details/reunion
    meetingEndTime: Date; // del details/reunion
}