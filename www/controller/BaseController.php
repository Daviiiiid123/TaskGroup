<?php
//require_once se usa para incluir y evaluar el archivo especificado durante la ejecucion del script (similar a include)
require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../core/I18n.php");

require_once(__DIR__."/../model/User.php");

class BaseController {

	protected $view;

	protected $currentUser;

	public function __construct() {

		$this->view = ViewManager::getInstance();

		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}

		if(isset($_SESSION["currentuser"])) {

			$this->currentUser = new User($_SESSION["currentuser"]);
			$this->view->setVariable("currentusername",
					$this->currentUser->getUsername());
		}
	}

	/**
	 * Verifica que el usuario esté autenticado
	 * Si no lo está, redirige al login y detiene la ejecución
	 */
	protected function checkAuthentication() {
		if (!isset($_SESSION["currentuser"])) {
			$this->view->redirect("user", "login");
			exit();
		}
	}

	/**
	 * Verifica que el usuario tenga permiso para acceder a un proyecto
	 * @param int $projectId ID del proyecto
	 * @param object $projectMapper Instancia de ProjectMapper
	 */
	protected function checkProjectPermission($projectId, $projectMapper) {
		if (!$projectMapper->userBelongsToProject($projectId, $_SESSION["currentuser"])) {
			$this->view->redirect("project", "index");
			exit();
		}
	}

	/**
	 * Verifica que un parámetro exista en GET o POST
	 * Si no existe, redirige y detiene la ejecución
	 * @param string $param Nombre del parámetro
	 * @param string $source 'GET' o 'POST'
	 * @return mixed Valor del parámetro
	 */
	protected function requireParameter($param, $source = 'GET') {
		$data = $source === 'GET' ? $_GET : $_POST;
		if (!isset($data[$param])) {
			$this->view->redirect("project", "index");
			exit();
		}
		return $data[$param];
	}
}
