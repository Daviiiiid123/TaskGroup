<?php

require_once(__DIR__."/Project.php");
require_once(__DIR__."/User.php");
require_once(__DIR__."/ProjectMapper.php");

class Task {

    private $id;
    private $title;
    private $content;
    //Lista de usuarios asignados a la tarea
    private $assignedUsers;
    //Id del proyecto al que pertenece la tarea
    private $projectId;
    //Estado de la tarea (true = resuelta, false = pendiente)
    private $isDone;

    public function __construct($id=NULL, $title=NULL, $content=NULL, $projectId=NULL, $assignedUsers=array(), $isDone=false) {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
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

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
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
        if ($this->projectId != NULL && !empty($assignedUsers)) {
            // se crea un onjeto ProjectMapper para comprobar si el usuario pertenece al proyecto
            $projectMapper = new ProjectMapper();
            
            foreach ($assignedUsers as $username) {
                if (!$projectMapper->userBelongsToProject($this->projectId, $username)) {
                    throw new Exception("El usuario '$username' no pertenece al proyecto");
                }
            }
        }
        
        $this->assignedUsers = $assignedUsers;
    }

    public function addAssignedUser($username) {
        if ($this->projectId != NULL) {
            // se crea un onjeto ProjectMapper para comprobar si el usuario pertenece al proyecto
            $projectMapper = new ProjectMapper();
            
            if (!$projectMapper->userBelongsToProject($this->projectId, $username)) {
                throw new Exception("El usuario '$username' no pertenece al proyecto");
            }
        }
        
        array_push($this->assignedUsers, $username);
    }

    public function getIsDone() {
        return $this->isDone;
    }

    public function setIsDone($isDone) {
        $this->isDone = $isDone;
    }

}