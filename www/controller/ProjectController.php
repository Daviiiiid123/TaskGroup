<?php
require_once(__DIR__ . "/BaseController.php"); // Se incluye la clase BaseController para heredar sus funcionalidades
require_once(__DIR__ . "/../model/Project.php");
require_once(__DIR__ . "/../model/ProjectMapper.php");
require_once(__DIR__ . "/../model/TaskMapper.php");
require_once(__DIR__ . "/../model/UserMapper.php");

class ProjectController extends BaseController
{
    private $projectMapper;
    private $taskMapper;

    public function __construct()
    {
        parent::__construct(); // Llama al constructor de la clase base para inicializar las propiedades heredadas
        $this->projectMapper = new ProjectMapper(); // Inicializa el mapeador de proyectos
        $this->taskMapper = new TaskMapper(); // Inicializa el mapeador de tareas
    }


    public function index() {
        
        if (isset($_SESSION["currentuser"])) {
            // Obtener proyectos del usuario actual
            $projects = $this->projectMapper->findByUser($this->currentUser->getUsername());
            $this->view->setVariable("projects", $projects); 
        }
        $this->view->render("project", "index");
    }

    public function view()
    {
        $this->checkAuthentication();

        // Obtener el ID del proyecto desde la URL
        if (!isset($_GET["id"])) { //isset comprueba si existe una variable
            $this->view->redirect("project", "index");
            return;
        }

        // Verificar que el usuario tiene permiso para ver el proyecto
        //userBelongsToProject recibe el id del proyecto y el nombre del usuario
        if (!$this->projectMapper->userBelongsToProject($_GET["id"], $this->currentUser->getUsername())) {
            $this->view->redirect("project", "index");
            return;
        }

        // Obtener el proyecto
        $project = $this->projectMapper->findById($_GET["id"]);
        if ($project == NULL) {
            $this->view->redirect("project", "index");
            return;
        }

        // Obtener las tareas del proyecto
        $tasks = $this->taskMapper->findByProject($_GET["id"]);
        if (is_null($tasks)) {
            $tasks = array();
        }

        // Pasar el proyecto a la vista
        $this->view->setVariable("project", $project);

        // Pasar las tareas del proyecto a la vista
        $this->view->setVariable("tasks", $tasks);

        // Renderizar la vista de detalles del proyecto
        $this->view->render("project", "view");
    }

    public function create()
    {
        $this->checkAuthentication();

        if (isset($_POST["title"])) {
            try {
                $project = new Project();
                $project->setTitle($_POST["title"]);
                $project->checkIsValidForCreate();
                $this->projectMapper->save($project);
                $this->projectMapper->addUserToProject($project->getId(), $this->currentUser->getUsername());
                $this->view->redirect("project", "index");
                return;
            } catch (ValidationException $ex) {
                $errors = $ex->getErrors();
				$this->view->setVariable("errors", $errors);
            }
        }
        //Si no se ha enviado el formulario, mostrar la vista de creación
        $this->view->render("project", "create");
        
    }

    public function edit()
    {
        $this->checkAuthentication();
        //Verifica si existe la clave "id" en el array $_POST
        if (isset($_POST["id"])) {
            $project = $this->projectMapper->findById($_POST["id"]);
            if ($project == NULL) { //Verifica si el valor de $project es nulo
                $this->view->redirect("project", "index");
                return;
            }
            $project->setTitle($_POST["title"]);
            $this->projectMapper->save($project);
            $this->view->redirect("project", "index");
        } else {
            //Si no se ha enviado el formulario, mostrar la vista de edición
            $this->view->render("project", "edit");
        }
    }

    public function delete()
    {
        $this->checkAuthentication();
        if (isset($_POST["id"])) {
            $project = $this->projectMapper->findById($_POST["id"]);
            if ($project !== null) {
                // Verificar que el usuario pertenece al proyecto
                if ($this->projectMapper->userBelongsToProject($_POST["id"], $this->currentUser->getUsername())) {
                    $this->projectMapper->delete($project);
                }
            }
        }
        $this->view->redirect("project", "index");
    }

    public function addUser()
    {
        $this->checkAuthentication();

        if (isset($_POST["project_id"]) && isset($_POST["email"])) {
            // Verificar que el usuario actual pertenece al proyecto
            if ($this->projectMapper->userBelongsToProject($_POST["project_id"], $this->currentUser->getUsername())) {
                // Buscar usuario por email
                $userMapper = new UserMapper();
                $user = $userMapper->findByEmail($_POST["email"]);
                
                if ($user !== null) {
                    // Agregar el usuario al proyecto
                    $this->projectMapper->addUserToProject($_POST["project_id"], $user->getUsername());
                }
            }
        }

        $this->view->redirect("project", "view", "id=" . $_POST["project_id"]);
    }

    public function removeUser()
    {
        $this->checkAuthentication();

        if (isset($_POST["project_id"]) && isset($_POST["username"])) {
            // Verificar que el usuario actual pertenece al proyecto
            if ($this->projectMapper->userBelongsToProject($_POST["project_id"], $this->currentUser->getUsername())) {
                // Remover el usuario del proyecto
                $this->projectMapper->removeUserFromProject($_POST["project_id"], $_POST["username"]);
            }
        }

        $this->view->redirect("project", "view", "id=" . $_POST["project_id"]);
    }

    // F10 - Resumen del proyecto
    public function summary() {
        $this->checkAuthentication();
        
        // Verificar que se proporciona el ID del proyecto
        if (!isset($_GET["id"])) {
            $this->view->redirect("project", "index");
            return;
        }
        
        $projectId = $_GET["id"];
        
        // Verificar que el usuario pertenece al proyecto
        if (!$this->projectMapper->userBelongsToProject($projectId, $this->currentUser->getUsername())) {
            $this->view->redirect("project", "index");
            return;
        }
        
        // Obtener el proyecto y sus tareas
        $project = $this->projectMapper->findById($projectId);
        $tasks = $this->taskMapper->findByProject($projectId);
        
        // Calcular estadísticas
        $totalTasks = count($tasks);
        $pendingTasks = count(array_filter($tasks, function($task) { 
            return !$task->getIsDone(); 
        }));
        $resolvedTasks = count(array_filter($tasks, function($task) { 
            return $task->getIsDone(); 
        }));
        $progress = $totalTasks > 0 ? round(($resolvedTasks / $totalTasks) * 100) : 0;
        
        // Pasar variables a la vista
        $this->view->setVariable("project", $project);
        $this->view->setVariable("totalTasks", $totalTasks);
        $this->view->setVariable("pendingTasks", $pendingTasks);
        $this->view->setVariable("resolvedTasks", $resolvedTasks);
        $this->view->setVariable("progress", $progress);
        
        // Renderizar vista
        $this->view->render("project", "summary");
    }
}
