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

    public function checkIsValidForCreate() {
		$errors = array();

		if (strlen(trim($this->getTitle())) < 1 ) {
			$errors["title"] = "Title is mandatory";
		}

		if (sizeof($errors) > 0){
			throw new ValidationException($errors, "Project is not valid");
		}
    }
}
