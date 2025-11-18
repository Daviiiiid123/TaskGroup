<?php
require_once(__DIR__."/BaseController.php"); // Se incluye la clase BaseController para heredar sus funcionalidades
require_once(__DIR__."/../model/Project.php");
require_once(__DIR__."/../model/ProjectMapper.php");

class ProjectController extends BaseController {
    private $projectMapper;

    public function __construct() {
        parent::__construct(); // Llama al constructor de la clase base para inicializar las propiedades heredadas
        $this->projectMapper = new ProjectMapper(); // Inicializa el mapeador de proyectos
    }


    public function index() {
        // Verificar autenticación
        $this->checkAuthentication();
        
        // Obtener proyectos del usuario actual
        $projects = $this->projectMapper->findByUser($this->currentUser->getUsername());
        $this->view->setVariable("projects", $projects); 
        $this->view->render("project", "index");
    }   

    public function view() {
        //Verificar autenticación y permisos ya que F3 requiere autenticación.
        if (!isset($_SESSION["currentuser"])) { // currentuser está en BaseController
            $this->view->redirect("user", "login"); // user es el controlador, login es la acción
            return;
        }

       // Obtener el ID del proyecto desde la URL
       if (!isset($_GET["id"])) { //isset comprueba si existe una variable
           $this->view->redirect("project", "index"); 
           return;
       }

       // Verificar que el usuario tiene permiso para ver el proyecto
       //userBelongsToProject recibe el id del proyecto y el nombre del usuario
       if(!$this->projectMapper->userBelongsToProject($_GET["id"], $_SESSION["currentuser"])) {
           $this->view->redirect("project", "index"); 
           return;
       }

         // Obtener el proyecto
         $project = $this->projectMapper->findById($_GET["id"]);
         if ($project == NULL) {
             $this->view->redirect("project", "index"); 
             return;
         }

         // Pasar el proyecto a la vista
            $this->view->setVariable("project", $project);
        // Renderizar la vista de detalles del proyecto
            $this->view->render("project", "view");


    }

    public function create() {

    }

    public function edit() {

    }

    public function delete() {

    }

    public function addUser() {

    }

    public function removeUser() {

    }














}
