
// tengo un curso
// este curso, usa Attendance y Zoom

const courseId = 19723;

import { AttendanceGuardado } from "../guardado/attendance";
import { ZoomRecoleccion } from "../recoleccion/zoom";

// ver la config de este curso, por ahi tiene un campo que dice que recolector usar y guardado tambien.

const recoleccion = new ZoomRecoleccion();
const guardado = new AttendanceGuardado();

const estudiantes = recoleccion.recolectarEstudiantes(courseId);

guardado.guardarEstudiantes(estudiantes, courseId);