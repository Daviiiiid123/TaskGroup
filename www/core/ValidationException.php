<?php
//file: core/ValidationException.php

class ValidationException extends Exception {

	/**
	* Array of errors
	* @var mixed
	*/
	private $errors = array();

	public function __construct(array $errors, $msg=NULL){
		parent::__construct($msg);
		$this->errors = $errors;
	}

	/**
	* Gets the validation errors
	*
	* @return mixed The validation errors
	*/
	public function getErrors() {
		return $this->errors;
	}
}
