<?php

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../core/I18n.php");

require_once(__DIR__."/../model/User.php");
require_once(__DIR__."/../model/UserMapper.php");

require_once(__DIR__."/../controller/BaseController.php");


class UsersController extends BaseController {

	private $userMapper;

	public function __construct() {
		parent::__construct();

		$this->userMapper = new UserMapper();

		$this->view->setLayout("welcome");
	}

	public function login() {
		if (isset($_POST["username"])){ // reaching via HTTP Post...
			//process login form
			if ($this->userMapper->isValidUser($_POST["username"], 					 $_POST["passwd"])) {

				$_SESSION["currentuser"]=$_POST["username"];

				// send user to the restricted area (HTTP 302 code)
				$this->view->redirect("posts", "index");

			}else{
				$errors = array();
				$errors["general"] = "Username is not valid";
				$this->view->setVariable("errors", $errors);
			}
		}

		// render the view (/view/users/login.php)
		$this->view->render("users", "login");
	}

	public function register() {

		$user = new User();

		if (isset($_POST["username"])){

			$user->setUsername($_POST["username"]);
			$user->setPassword($_POST["passwd"]);

			try{
				$user->checkIsValidForRegister();

				if (!$this->userMapper->usernameExists($_POST["username"])){

					$this->userMapper->save($user);

					$this->view->setFlash("Username ".$user->getUsername()." successfully added. Please login now");

					$this->view->redirect("users", "login");
				} else {
					$errors = array();
					$errors["username"] = "Username already exists";
					$this->view->setVariable("errors", $errors);
				}
			}catch(ValidationException $ex) {
				$errors = $ex->getErrors();
				$this->view->setVariable("errors", $errors);
			}
		}

		$this->view->setVariable("user", $user);

		$this->view->render("users", "register");

	}

	public function logout() {
		session_destroy();

		$this->view->redirect("users", "login");

	}

}
