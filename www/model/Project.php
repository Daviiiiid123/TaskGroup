<?php

class Project {

	private $id;
	private $title;
	private $content;

	public function __construct($id=NULL, $title=NULL, $content=NULL) {
		$this->id = $id;
		$this->title = $title;
		$this->content = $content;
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
}
