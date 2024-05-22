import { GuardadoBase } from "../guardado/base";
import { EstudianteAttendance } from "../utils/types";

export abstract class RecoleccionBase {
    abstract recolectarEstudiantes(courseId: number): EstudianteAttendance[]
};