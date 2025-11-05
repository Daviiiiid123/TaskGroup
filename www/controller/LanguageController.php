<?php

require_once(__DIR__."/../core/I18n.php");

class LanguageController {
	const LANGUAGE_SETTING = "__language__";

	public function change() {
		if(!isset($_GET["lang"])) {
			throw new Exception("no lang parameter was provided");
		}
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}
		I18n::getInstance()->setLanguage($_GET["lang"]);

		header("Location: ".$_SERVER["HTTP_REFERER"]);
		die();
	}

	public function i18njs() {
		header('Content-type: application/javascript');
		echo "var i18nMessages = [];\n";
		echo "function ji18n(key) { if (key in i18nMessages) return i18nMessages[key]; else return key;}\n";
		foreach (I18n::getInstance()->getAllMessages() as $key=>$value) {
			echo "i18nMessages['$key'] = '$value';\n";
		}
}
}
