<?php

class Project {

	private $id;
	private $title;
    //Lista de usuarios asignados al proyecto
    private $assignedUsers;

	public function __construct($id=NULL, $title=NULL, $assignedUsers=array()) {
		$this->id = $id;
		$this->title = $title;
        $this->assignedUsers = $assignedUsers;
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

    public function getAssignedUsers() {
        return $this->assignedUsers;
    }
	
    public function setAssignedUsers($assignedUsers) {
        $this->assignedUsers = $assignedUsers;
    }
}
