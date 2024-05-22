import { AttendanceGuardado } from "../guardado/attendance";
import { EstudianteAttendance } from "../utils/types";
import { RecoleccionBase } from "./base";


export class MeetRecoleccion extends RecoleccionBase {
    recolectarEstudiantes(courseId: number): EstudianteAttendance[] {
        
        // mdl_meet (course)

        return [];
    }
}