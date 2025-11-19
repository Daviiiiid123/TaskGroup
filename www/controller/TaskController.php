<?php
require_once(__DIR__."/BaseController.php");
require_once(__DIR__."/../model/Task.php");
require_once(__DIR__."/../model/TaskMapper.php");
require_once(__DIR__."/../model/ProjectMapper.php");

class TaskController extends BaseController {
    private $taskMapper;
    private $projectMapper;

    public function __construct() {
        parent::__construct();
        $this->taskMapper = new TaskMapper();
        $this->projectMapper = new ProjectMapper();
    }

    public function create() {
        // Verificar que el usuario está autenticado
        $this->checkAuthentication();
        
        // Verificar que se proporciona el ID del proyecto (por GET o POST)
        if (!isset($_POST["project_id"]) && !isset($_GET["project_id"])) {
            $this->view->redirect("project", "index");
            return;
        }
           // Obtener el project_id
        if (isset($_POST["project_id"])) {
            $project_id = $_POST["project_id"];
        } else {
            $project_id = $_GET["project_id"];
        }

        // Verificar que el usuario pertenece al proyecto
        if (!$this->projectMapper->userBelongsToProject($project_id, $_SESSION["currentuser"])) {
            $this->view->redirect("project", "index");
            return;
        }
        
        // Si es POST, procesar el formulario
        if (isset($_POST["title"])) {
        
            // Crear la nueva tarea
            $task = new Task();
            $task->setTitle($_POST["title"]);
            $task->setContent($_POST["content"]);
            $task->setProjectId($project_id);
            $task->setAssignedUsers([]); // Inicialmente sin usuarios asignados
            $task->setStatus("pending"); // Estado inicial
            
            // Guardar la tarea en la base de datos
            $this->taskMapper->save($task);
            
            // Asignar el usuario actual a la tarea
            $this->taskMapper->addUserToTask($task->getId(), $_SESSION["currentuser"]);
            
            // Redirigir a la vista del proyecto
            $this->view->redirect("project", "view", ["id" => $project_id]);
            return;
        }
        // Si es GET, mostrar formulario de creación
        else {
            $this->view->render("task_create", ["project_id" => $project_id]);
        }
        
    }

    public function edit() {

    }

    public function delete() {

    }

    public function view() {

    }

    public function addUser() {

    }

    public function removeUser() {

    }
}
