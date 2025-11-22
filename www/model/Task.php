<?php

require_once(__DIR__."/Project.php");
require_once(__DIR__."/User.php");
require_once(__DIR__."/ProjectMapper.php");

class Task {

    private $id;
    private $title;
    //Lista de usuarios asignados a la tarea
    private $assignedUsers;
    //Id del proyecto al que pertenece la tarea
    private $projectId;
    //Estado de la tarea (true = resuelta, false = pendiente)
    private $isDone;

    public function __construct($id=NULL, $title=NULL, $projectId=NULL, $assignedUsers=array(), $isDone=false) {
        $this->id = $id;
        $this->title = $title;
        $this->projectId = $projectId;
        $this->assignedUsers = $assignedUsers;
        $this->isDone = $isDone;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getProjectId() {
        return $this->projectId;
    }

    public function setProjectId($projectId) {
        $this->projectId = $projectId;
    }

    public function getAssignedUsers() {
        return $this->assignedUsers;
    }
    
    public function setAssignedUsers($assignedUsers) {
        $this->assignedUsers = $assignedUsers;
    }

    public function addAssignedUser($username) {
        if (this->getAssignedUsers() == NULL) {
            this->setAssignedUsers([]);
        }
        array_push($this->assignedUsers, $username);
    }

    public function getIsDone() {
        return $this->isDone;
    }

    public function setIsDone($isDone) {
        $this->isDone = $isDone;
    }

    public function checkIsValidForCreate() {
		$errors = array();

		if (strlen(trim($this->getTitle())) < 1 ) {
			$errors["title"] = "Title is mandatory";
		}
		if ($this->getProjectId() == NULL ) {
			$errors["projectId"] = "Project is mandatory";
		}
        // se crea un onjeto ProjectMapper para comprobar si el usuario pertenece al proyecto
        $projectMapper = new ProjectMapper();
        foreach ($this->getAssignedUsers() as $username) {
            if (!$projectMapper->userBelongsToProject($this->projectId, $username)) {
                $errors["assignedUser"] = "Assigned user is not part of the project";
            }
        }

		if (sizeof($errors) > 0){
			throw new ValidationException($errors, "Task is not valid");
		}
    }
}