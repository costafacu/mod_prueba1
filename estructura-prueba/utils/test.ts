interface Estudiante {
    grupo: 1 | 2 | 3;
    nombre: string;
}

const estudiantes: Estudiante[] = [
    {
        grupo: 1,
        nombre: 'Juan'
    },
    {
        grupo: 2,
        nombre: 'Pedro'
    },
    {
        grupo: 1,
        nombre: 'Maria'
    },
    {
        grupo: 2,
        nombre: 'Ana'
    },
    {
        grupo: 2,
        nombre: 'Jose'
    },
    {
        grupo: 2,
        nombre: 'Luis'
    },
    {
        grupo: 3,
        nombre: 'Luis'
    }
]

// group map of the students by group
const studentMap: Map<number, Estudiante[]> = new Map();

estudiantes.forEach(estudiante => {
    if (!studentMap.has(estudiante.grupo)) {
        studentMap.set(estudiante.grupo, []);
    }
    studentMap.get(estudiante.grupo)?.push(estudiante);
});

const attendance_session_logs = [];

for (const grupo of studentMap.keys()) {
    const estudiantesDelGrupo = studentMap.get(grupo) || [];
    // Traes la session dado el grupo + estudiantesDelGrupo[0].meetingStartTime + estudiantesDelGrupo[0].meetingEndTime
    // Corres la query "Query para dado un grupo y el horario de la reunion recibe su session de attendance"

    // Te da la session;
    for (const est of estudiantesDelGrupo) {
        // creas los models y setteas los valores

    }
}