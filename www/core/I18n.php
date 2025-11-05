<?php
//file: /core/I18n.php

class I18n {

	private $messages;

	const DEFAULT_LANGUAGE="es";
	const CURRENT_LANGUAGE_SESSION_VAR="__currentlang__";

	public function __construct(){
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}

		if (isset($_SESSION[self::CURRENT_LANGUAGE_SESSION_VAR])) {
			$this->setLanguage(
			$_SESSION[self::CURRENT_LANGUAGE_SESSION_VAR]);
		} else{
			$this->setLanguage(self::DEFAULT_LANGUAGE);
		}
	}

	/**
	* Sets the language (and keeps it in the user session)
	*
	* @param string $language The language to be set. For example: "en"
	* @return void
	*/
	public function setLanguage($language) {
		//include language file
		include(__DIR__."/../view/messages/messages_$language.php");
		$this->messages = $i18n_messages;

		//save the language in session
		$_SESSION[self::CURRENT_LANGUAGE_SESSION_VAR] = $language;
	}

	/**
	* Finds the current language translation of a given key
	* @param string $key The key to tranlate
	* @return string The translation of the given key
	*/
	public function i18n($key) {
		if (isset($this->messages[$key])){
			return $this->messages[$key];
		}else{
			return $key;
		}
	}

	//singleton
	private static $i18n_singleton = null;

	/**
	* Gets the singleton instance of this class
	*
	* @return I18n The singleton instance
	*/
	public static function getInstance() {
		if (self::$i18n_singleton == NULL) {
			self::$i18n_singleton = new I18n();
		}
		return self::$i18n_singleton;
	}

	/**
	* Gets all the messages in the current language
	*
	* @return mixed Array of translations
	*/
	public function getAllMessages() {
		return $this->messages;
	}
}

/**
* Shortcut global i18n function for
* the @link I18n::i18n()
*
* @param string $key The key to translate
* @return string The translation of the given key
*/
function i18n($key) {
	return I18n::getInstance()->i18n($key);
}
