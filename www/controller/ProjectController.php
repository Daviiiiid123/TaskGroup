<?php

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../core/I18n.php");

require_once(__DIR__."/../model/Project.php");
require_once(__DIR__."/../model/ProjectMapper.php");

require_once(__DIR__."/../controller/BaseController.php");


class ProjectController extends BaseController {
	private $projectMapper;

	public function __construct() {
		parent::__construct();

		$this->projectMapper = new ProjectMapper();

		// User controller operates in a "default" layout
		// different to the "default" layout where the internal
		// menu is displayed
		$this->view->setLayout("default");
	}

    public function index() {

    }
}
