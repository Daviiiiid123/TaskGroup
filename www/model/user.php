<?php

require_once(__DIR__."/../core/ValidationException.php");

class User {

	private $username;

	private $passwd;

	//se añade el campo email
	private $email;

	public function __construct($username=NULL, $passwd=NULL) {
		$this->username = $username;
		$this->passwd = $passwd;
	}

	public function getUsername() {
		return $this->username;
	}

	public function setUsername($username) {
		$this->username = $username;
	}

	public function getPasswd() {
		return $this->passwd;
	}
	
	public function setPassword($passwd) {
		$this->passwd = $passwd;
	}

	// getter y setter del campo email
	public function getEmail() {
		return $this->email;
	}

	public function setEmail($email) {
		$this->email = $email;
	}

	public function checkIsValidForRegister() {
		$errors = array();
		//comprobacion de que el email tiene formato valido
		//FILTER_VALIDATE_EMAIL es una constante que define un filtro para validar emails
		//filter_var es una funcion que aplica un filtro a una variable
		if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) { 
			$errors["email"] = "Email is not valid";
		}

		if (strlen($this->username) < 5) {
			$errors["username"] = "Username must be at least 5 characters length";

		}
		if (strlen($this->passwd) < 5) {
			$errors["passwd"] = "Password must be at least 5 characters length";
		}
		if (sizeof($errors)>0){
			throw new ValidationException($errors, "user is not valid");
		}
	}
}
