<?php

class Project {

	private $id;
	private $title;
	private $content;
    //Lista de usuarios asignados al proyecto
    private $assignedUsers;

	public function __construct($id=NULL, $title=NULL, $content=NULL, $assignedUsers=array()) {
		$this->id = $id;
		$this->title = $title;
		$this->content = $content;
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

	public function getContent() {
		return $this->content;
	}

	public function setContent($content) {
		$this->content = $content;
	}
    public function getAssignedUsers() {
        return $this->assignedUsers;
    }
    public function setAssignedUsers($assignedUsers) {
        $this->assignedUsers = $assignedUsers;
    }
}
