<?php

require_once(__DIR__."/../core/PDOConnection.php");

require_once(__DIR__."/../model/User.php");
require_once(__DIR__."/../model/Project.php");

class ProjectMapper {

	private $db;

	public function __construct() {
		$this->db = PDOConnection::getInstance();
	}

	public function findAll() {
		$stmt = $this->db->query("SELECT * FROM projects");
		$projects_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$projects = array();

		foreach ($projects_db as $project) {
			array_push($projects, new Project($project["id"], $project["title"]));
		}

		return $projects;
	}

	public function findByUser($username) {
		$stmt = $this->db->prepare(
			"SELECT P.* FROM projects P 
			INNER JOIN project_users PU ON P.id = PU.project_id 
			WHERE PU.username = ?"
		);
		$stmt->execute(array($username));
		$projects_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$projects = array();

		foreach ($projects_db as $project) {
			array_push($projects, new Project($project["id"], $project["title"]));
		}

		return $projects;
	}

	public function findById($projectid){
		$stmt = $this->db->prepare("SELECT * FROM projects WHERE id=?");
		$stmt->execute(array($projectid));
		$project = $stmt->fetch(PDO::FETCH_ASSOC);

		if($project != null) {
			return new Project(
				$project["id"],
				$project["title"],
			);
		} else {
			return NULL;
		}
	}

	public function save(Project $project) {
		$stmt = $this->db->prepare("INSERT INTO projects(title) values (?)");
		$stmt->execute(array($project->getTitle()));
		return $this->db->lastInsertId();
	}

	public function addUserToProject($projectId, $username) {
		$stmt = $this->db->prepare("INSERT INTO project_users(project_id, username) values (?,?)");
		$stmt->execute(array($projectId, $username));
	}

	public function removeUserFromProject($projectId, $username) {
		$stmt = $this->db->prepare("DELETE FROM project_users WHERE project_id=? AND username=?");
		$stmt->execute(array($projectId, $username));
	}

	public function update(Project $project) {
		$stmt = $this->db->prepare("UPDATE projects set title=? where id=?");
		$stmt->execute(array($project->getTitle(), $project->getId()));
	}

	public function delete(Project $project) {
		$stmt = $this->db->prepare("DELETE from projects WHERE id=?");
		$stmt->execute(array($project->getId()));
	}

	public function userBelongsToProject($projectId, $username) {
		$stmt = $this->db->prepare("SELECT * FROM project_users WHERE project_id=? AND username=?");
		$stmt->execute(array($projectId, $username));
		return $stmt->fetch(PDO::FETCH_ASSOC) != null;
	}

	public function getUsersByProject($projectId) {
		$stmt = $this->db->prepare(
			"SELECT U.* FROM users U 
			INNER JOIN project_users PU ON U.username = PU.username 
			WHERE PU.project_id = ?"
		);
		$stmt->execute(array($projectId));
		$users_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$users = array();

		foreach ($users_db as $user) {
			array_push($users, new User($user["username"], $user["passwd"], $user["email"]));
		}

		return $users;
	}
}
