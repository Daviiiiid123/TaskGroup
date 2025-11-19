<?php

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../core/I18n.php");

require_once(__DIR__."/../model/User.php");
require_once(__DIR__."/../model/UserMapper.php");

require_once(__DIR__."/../controller/BaseController.php");


class UserController extends BaseController {

	
	private $userMapper;

	public function __construct() {
		parent::__construct();

		$this->userMapper = new UserMapper();

		// User controller operates in a "default" layout
		// different to the "default" layout where the internal
		// menu is displayed
		$this->view->setLayout("default");
	}

	
	public function login() {
		if (isset($_POST["username"])){ // reaching via HTTP Post...
			//process login form
			if ($this->userMapper->isValidUser($_POST["username"], $_POST["passwd"])) {

				$_SESSION["currentuser"]=$_POST["username"];

				// send user to the restricted area (HTTP 302 code)
				$this->view->redirect("project", "index");

			} else {
				$errors = array();
				$errors["general"] = "User or password is incorrect";
				$this->view->setVariable("errors", $errors);
			}
		}

		// render the view (/view/user/login.php)
		$this->view->render("user", "login");
	}

	
	public function register() {

		$user = new User();
		//Comprueba que existe el parametro username en el POST
		if (isset($_POST["username"])){ // reaching via HTTP Post...

			// populate the User object with data form the form
			$user->setUsername($_POST["username"]);
			$user->setPassword($_POST["passwd"]);
			// añadir un campo email
			$user->setEmail($_POST["email"]);


			try{
				$user->checkIsValidForRegister(); // if it fails, ValidationException

				// check if user exists in the database
				if (!$this->userMapper->usernameExists($_POST["username"])){

					// save the User object into the database
					$this->userMapper->save($user);

					// POST-REDIRECT-GET
					// Everything OK, we will redirect the user to the list of posts
					// We want to see a message after redirection, so we establish
					// a "flash" message (which is simply a Session variable) to be
					// get in the view after redirection.
					$this->view->setFlash("Username ".$user->getUsername()." successfully added. Please login now");

					// perform the redirection. More or less:
					// header("Location: index.php?controller=user&action=login")
					// die();
					$this->view->redirect("user", "login");
				} else {
					$errors = array();
					$errors["username"] = "Username already exists";
					$this->view->setVariable("errors", $errors);
				}
			}catch(ValidationException $ex) {
				// Get the errors array inside the exepction...
				$errors = $ex->getErrors();
				// And put it to the view as "errors" variable
				$this->view->setVariable("errors", $errors);
			}
		}

		// Put the User object visible to the view
		$this->view->setVariable("user", $user);

		// render the view (/view/user/register.php)
		$this->view->render("user", "register");

	}

	public function logout() {
		session_destroy();

		// perform a redirection. More or less:
		// header("Location: index.php?controller=user&action=login")
		// die();
		$this->view->redirect("user", "login");

	}

}
