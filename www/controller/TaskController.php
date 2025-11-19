<?php
require_once(__DIR__ . "/BaseController.php");
require_once(__DIR__ . "/../model/Task.php");
require_once(__DIR__ . "/../model/TaskMapper.php");
require_once(__DIR__ . "/../model/ProjectMapper.php");

class TaskController extends BaseController
{
    private $taskMapper;
    private $projectMapper;

    public function __construct()
    {
        parent::__construct();
        $this->taskMapper = new TaskMapper();
        $this->projectMapper = new ProjectMapper();
    }

    public function create()
    {
        // Verificar que el usuario está autenticado
        $this->checkAuthentication();

        // Verificar que se proporciona el ID del proyecto (por GET o POST)
        if (!isset($_POST["projectId"]) && !isset($_GET["projectId"])) {
            $this->view->redirect("project", "index");
            return;
        }
        // Obtener el projectId
        if (isset($_POST["projectId"])) {
            $projectId = $_POST["projectId"];
        } else {
            $projectId = $_GET["projectId"];
        }

        // Verificar que el usuario pertenece al proyecto
        if (!$this->projectMapper->userBelongsToProject($projectId, $this->currentUser->getUsername())) {
            $this->view->redirect("project", "index");
            return;
        }

        // Si es POST, procesar el formulario
        if (isset($_POST["title"])) {

            // Crear la nueva tarea
            $task = new Task();
            $task->setTitle($_POST["title"]);
            $task->setContent($_POST["content"]);
            $task->setProjectId($projectId);
            $task->setAssignedUsers([]); // Inicialmente sin usuarios asignados
            $task->setIsDone(false); // Inicialmente no completada

            // Guardar la tarea en la base de datos
            $this->taskMapper->save($task);

            // Asignar el usuario actual a la tarea
            $this->taskMapper->addUserToTask($task->getId(), $this->currentUser->getUsername());

            // Redirigir a la vista del proyecto
            $this->view->redirect("project", "view", "id=" . $projectId);
            return;
        } else {
            // Mostrar formulario de creación
            $project = $this->projectMapper->findById($projectId);
            $this->view->setVariable("project", $project);
            $this->view->render("task", "create");
        }
    }

    public function edit()
    {
        // Verificar que el usuario está autenticado
        $this->checkAuthentication();

        // Verificar que se proporciona el ID de la tarea
        if (!isset($_GET["id"])) {
            $this->view->redirect("project", "index");
            return;
        }


        // Obtener la tarea de la base de datos
        $taskId = $_GET["id"];
        $task = $this->taskMapper->findById($taskId);
        if ($task === null) {
            $this->view->redirect("project", "index");
            return;
        }

        // Verificar que el usuario pertenece al proyecto de la tarea
        $projectId = $task->getProjectId();
        if (!$this->projectMapper->userBelongsToProject($projectId, $this->currentUser->getUsername())) {
            $this->view->redirect("project", "index");
            return;
        }

        // Si es POST, procesar el formulario de edición
        if (isset($_POST["title"])) {
            $task->setTitle($_POST["title"]);
            $task->setContent($_POST["content"]);
            $task->setIsDone(isset($_POST["isDone"]) && $_POST["isDone"] === "on");

            $this->taskMapper->update($task);

            $this->view->redirect("project", "view", "id=" . $projectId);
            return;
        }
        
        // Si no es POST, mostrar el formulario de edición
        $this->view->setVariable("task", $task);
        $this->view->render("task", "edit");
    }

    public function delete()
    {
        // Verificar que el usuario está autenticado
        $this->checkAuthentication();

        // Verificar que se proporciona el ID de la tarea
        if (!isset($_GET["id"])) {
            $this->view->redirect("project", "index");
            return;
        }

        // Obtener la tarea de la base de datos
        $taskId = $_GET["id"];
        $task = $this->taskMapper->findById($taskId);
        if ($task === null) {
            $this->view->redirect("project", "index");
            return;
        }

        // Verificar que el usuario pertenece al proyecto de la tarea
        $projectId = $task->getProjectId();
        if (!$this->projectMapper->userBelongsToProject($projectId, $this->currentUser->getUsername())) {
            $this->view->redirect("project", "index");
            return;
        }

        // Eliminar la tarea
        $this->taskMapper->delete($taskId);

        // Redirigir a la vista del proyecto
        $this->view->redirect("project", "view", "id=" . $projectId);
    }

    public function view()
    {
        // Verificar que el usuario está autenticado
        $this->checkAuthentication();

        // Verificar que se proporciona el ID de la tarea
        if (!isset($_GET["id"])) {
            $this->view->redirect("project", "index");
            return;
        }

        // Obtener la tarea de la base de datos
        $taskId = $_GET["id"];
        $task = $this->taskMapper->findById($taskId);
        if ($task === null) {
            $this->view->redirect("project", "index");
            return;
        }

        // Verificar que el usuario pertenece al proyecto de la tarea
        $projectId = $task->getProjectId();
        if (!$this->projectMapper->userBelongsToProject($projectId, $this->currentUser->getUsername())) {
            $this->view->redirect("project", "index");
            return;
        }

        // Pasar datos a la vista
        $this->view->setVariable("task", $task);
        $this->view->render("task", "view");
    }

    public function addUser()
    {
        // Verificar que el usuario está autenticado
        $this->checkAuthentication();

        // Verificar que se proporcionan los parámetros necesarios
        if (!isset($_GET["taskId"]) || !isset($_GET["username"])) {
            $this->view->redirect("project", "index");
            return;
        }

        $taskId = $_GET["taskId"];
        $username = $_GET["username"];

        // Obtener la tarea
        $task = $this->taskMapper->findById($taskId);
        if ($task === null) {
            $this->view->redirect("project", "index");
            return;
        }

        // Verificar que el usuario actual pertenece al proyecto
        $projectId = $task->getProjectId();
        if (!$this->projectMapper->userBelongsToProject($projectId, $this->currentUser->getUsername())) {
            $this->view->redirect("project", "index");
            return;
        }

        // Verificar que el usuario a añadir también pertenece al proyecto
        if (!$this->projectMapper->userBelongsToProject($projectId, $username)) {
            $this->view->redirect("project", "view", "id=" . $projectId);
            return;
        }

        // Añadir el usuario a la tarea
        $this->taskMapper->addUserToTask($taskId, $username);

        // Redirigir a la vista del proyecto
        $this->view->redirect("project", "view", "id=" . $projectId);
    }

    public function removeUser()
    {
        // Verificar que el usuario está autenticado
        $this->checkAuthentication();

        // Verificar que se proporcionan los parámetros necesarios
        if (!isset($_GET["taskId"]) || !isset($_GET["username"])) {
            $this->view->redirect("project", "index");
            return;
        }

        $taskId = $_GET["taskId"];
        $username = $_GET["username"];

        // Obtener la tarea
        $task = $this->taskMapper->findById($taskId);
        if ($task === null) {
            $this->view->redirect("project", "index");
            return;
        }

        // Verificar que el usuario actual pertenece al proyecto
        $projectId = $task->getProjectId();
        if (!$this->projectMapper->userBelongsToProject($projectId, $this->currentUser->getUsername())) {
            $this->view->redirect("project", "index");
            return;
        }

        // Eliminar el usuario de la tarea
        $this->taskMapper->removeUserFromTask($taskId, $username);

        // Redirigir a la vista del proyecto
        $this->view->redirect("project", "view", "id=" . $projectId);
    }
}
