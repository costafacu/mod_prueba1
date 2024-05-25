import { EstudianteAttendance } from "../utils/types";
import { GuardadoBase } from "./base";


export class AttendanceGuardado extends GuardadoBase {
    guardarEstudiantes(estudiantes: EstudianteAttendance[], courseId: number): void {
        // this.courseId;
        // guardamos los estudiantes
        // Agarra su curso
        // lo inserta
        // calcula si está presente o no en base a 
    }

    calcularStatusAttendance(estudiante: EstudianteAttendance, courseId: number) {
        estudiante.isLate; // Si no pasó la tolerancia
        estudiante.attendancePercentage; // 0 - 100

        if (estudiante.attendancePercentage >= 75){ 
            if (estudiante.isLate) {
                // Tarde
            } else {
                // Presente
            }
        } else {
            // Ausente
        }
    }
}