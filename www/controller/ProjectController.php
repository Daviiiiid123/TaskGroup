<?php
require_once(__DIR__ . "/BaseController.php"); // Se incluye la clase BaseController para heredar sus funcionalidades
require_once(__DIR__ . "/../model/Project.php");
require_once(__DIR__ . "/../model/ProjectMapper.php");
require_once(__DIR__ . "/../model/TaskMapper.php");

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
            $project = new Project();
            $project->setTitle($_POST["title"]);
            $this->projectMapper->save($project);
            $this->projectMapper->addUserToProject($project->getId(), $_SESSION["currentuser"]);
            $this->view->redirect("project", "index");
        } else {
            //Si no se ha enviado el formulario, mostrar la vista de creación
            $this->view->render("project", "create");
        }
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
            $this->projectMapper->delete($_POST["id"]);
        }
        $this->view->redirect("project", "index");
    }

    public function addUser()
    {
        $this->checkAuthentication();

        if (isset($_POST["project_id"]) && isset($_POST["username"])) {
            // Verificar que el usuario actual pertenece al proyecto
            if ($this->projectMapper->userBelongsToProject($_POST["project_id"], $this->currentUser->getUsername())) {
                // Agregar el usuario al proyecto
                $this->projectMapper->addUserToProject($_POST["project_id"], $_POST["username"]);
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
    public function summary() {}
}
