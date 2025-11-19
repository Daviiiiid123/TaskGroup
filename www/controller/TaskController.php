<?php
require_once(__DIR__."/BaseController.php");
require_once(__DIR__."/../model/Task.php");
require_once(__DIR__."/../model/TaskMapper.php");
require_once(__DIR__."/../model/ProjectMapper.php");

class TaskController extends BaseController {
    private $taskMapper;
    private $projectMapper;

    public function __construct() {
        parent::__construct();
        $this->taskMapper = new TaskMapper();
        $this->projectMapper = new ProjectMapper();
    }

    public function create() {
        $this->checkAuthentication();

    }

    public function edit() {

    }

    public function delete() {

    }

    public function view() {

    }

    public function addUser() {

    }

    public function removeUser() {

    }
}
