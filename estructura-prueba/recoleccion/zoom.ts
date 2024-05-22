import { AttendanceGuardado } from "../guardado/attendance";
import { EstudianteAttendance } from "../utils/types";
import { RecoleccionBase } from "./base";

export class ZoomRecoleccion extends RecoleccionBase {
    recolectarEstudiantes(courseId: number): EstudianteAttendance[] {
        // corremos las querys magicas
        // mdl_zoom (course) -> mdl_zoom_meeting_details (de hoy)

        return [];
    }
}