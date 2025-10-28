# TaskGroup

Se trata de desarrollar una aplicación web denominada TaskGroup que implemente un sistema de gestión colaborativa de tareas en proyectos compartidos. La idea es facilitar que, por ejemplo, un grupo de personas que trabaja de forma conjunta en una actividad (como un proyecto académico) pueda crear un espacio común donde planificar tareas, asignarlas entre los miembros y controlar su progreso de forma clara y accesible.

La aplicación permitirá registrar usuarios, y cada usuario podrá crear un nuevo proyecto (como por ejemplo “Proyecto de TSW”) al que podrá invitar a otros usuarios. Dentro de cada proyecto, cualquier miembro podrá crear tareas, asignarlas a otros usuarios (o a sí mismo), marcarlas como resueltas, y consultar un resumen general con el progreso del equipo.

### Funcionalidades públicas:🟢 
### Requieren autenticación:🔴

Funcionalidades (F):

- 🟢 F1 — Registrarse: indicar un alias (sin espacios), una contraseña y un email. (Pública)
- 🟢 F2 — Autenticarse: comprobación de credenciales; una vez autenticado, accederá al listado de proyectos. (Pública)
- 🔴 F3 — Listar proyectos: ver listado de todos los proyectos donde el usuario está incluido. Al hacer clic en un proyecto, ir a F5. Desde aquí también se podrá:
- 🔴 F4 — Crear proyecto nuevo, indicando un nombre del proyecto.
- 🔴 F5 — Ver proyecto: en este panel se verá un listado de las tareas agrupadas en pendientes y resueltas. Además, desde este panel se podrá:
- 🔴 F6 — Añadir un usuario al proyecto, indicando el email del usuario que se quiere añadir.
- 🔴 F7 — Crear tarea nueva, indicando:
  - (i) Usuario asignado (por defecto, el usuario autenticado).
  - (ii) Nombre de la tarea.
  - (iii) Estado: puede ser resuelta o pendiente, por defecto pendiente. (El cambio de estado se hará en F8).
- 🔴 F8 — Editar una tarea existente: cambiar cualquier campo (nombre, estado, usuario asignado).
- 🔴 F9 — Eliminar una tarea.
- 🔴 F10 — Ver resumen del proyecto: mostrará (i) número de tareas totales; (ii) número de tareas pendientes; (iii) número de tareas resueltas; (iv) progreso global del proyecto (porcentaje).
- 🔴 F11 — Eliminar proyecto.

