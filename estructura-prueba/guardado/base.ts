import { EstudianteAttendance } from "../utils/types";

export abstract class GuardadoBase {
    abstract guardarEstudiantes(estudiantes: EstudianteAttendance[], courseId: number): void;
}