<?php

require_once(__DIR__."/../core/PDOConnection.php");

require_once(__DIR__."/../model/User.php");
require_once(__DIR__."/../model/Task.php");
require_once(__DIR__."/../model/Project.php");

class TaskMapper {

	private $db;

	public function __construct() {
		$this->db = PDOConnection::getInstance();
	}

	public function findAll() {
		$stmt = $this->db->query("SELECT * FROM tasks");
		$tasks_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$tasks = array();

		foreach ($tasks_db as $task) {
			$assignedUsers = $this->getUsersByTask($task["id"]);
			array_push($tasks, new Task(
				$task["id"], 
				$task["title"], 
				$task["content"], 
				$task["project"], 
				$assignedUsers
			));
		}

		return $tasks;
	}

	public function findByProject($projectId) {
		$stmt = $this->db->prepare("SELECT * FROM tasks WHERE project = ?");
		$stmt->execute(array($projectId));
		$tasks_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$tasks = array();

		foreach ($tasks_db as $task) {
			$assignedUsers = $this->getUsersByTask($task["id"]);
			array_push($tasks, new Task(
				$task["id"], 
				$task["title"], 
				$task["content"], 
				$task["project"], 
				$assignedUsers
			));
		}

		return $tasks;
	}

	public function findByUser($username) {
		$stmt = $this->db->prepare(
			"SELECT T.* FROM tasks T 
			INNER JOIN task_users TU ON T.id = TU.task_id 
			WHERE TU.username = ?"
		);
		$stmt->execute(array($username));
		$tasks_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$tasks = array();

		foreach ($tasks_db as $task) {
			$assignedUsers = $this->getUsersByTask($task["id"]);
			array_push($tasks, new Task(
				$task["id"], 
				$task["title"], 
				$task["content"], 
				$task["project"], 
				$assignedUsers
			));
		}

		return $tasks;
	}

	public function findById($taskId){
		$stmt = $this->db->prepare("SELECT * FROM tasks WHERE id=?");
		$stmt->execute(array($taskId));
		$task = $stmt->fetch(PDO::FETCH_ASSOC);

		if($task != null) {
			$assignedUsers = $this->getUsersByTask($task["id"]);
			return new Task(
				$task["id"],
				$task["title"],
				$task["content"],
				$task["project"],
				$assignedUsers
			);
		} else {
			return NULL;
		}
	}

	public function save(Task $task) {
		$stmt = $this->db->prepare("INSERT INTO tasks(title, content, project) values (?,?,?)");
		$stmt->execute(array($task->getTitle(), $task->getContent(), $task->getProjectId()));
		$taskId = $this->db->lastInsertId();
		
		foreach ($task->getAssignedUsers() as $username) {
			$this->addUserToTask($taskId, $username);
		}
		
		return $taskId;
	}

	public function addUserToTask($taskId, $username) {
		$stmt = $this->db->prepare("INSERT INTO task_users(task_id, username) values (?,?)");
		$stmt->execute(array($taskId, $username));
	}

	public function removeUserFromTask($taskId, $username) {
		$stmt = $this->db->prepare("DELETE FROM task_users WHERE task_id=? AND username=?");
		$stmt->execute(array($taskId, $username));
	}

	public function update(Task $task) {
		$stmt = $this->db->prepare("UPDATE tasks set title=?, content=? where id=?");
		$stmt->execute(array($task->getTitle(), $task->getContent(), $task->getId()));
		
		$stmt = $this->db->prepare("DELETE FROM task_users WHERE task_id=?");
		$stmt->execute(array($task->getId()));
		
		foreach ($task->getAssignedUsers() as $username) {
			$this->addUserToTask($task->getId(), $username);
		}
	}

	public function delete(Task $task) {
		$stmt = $this->db->prepare("DELETE from tasks WHERE id=?");
		$stmt->execute(array($task->getId()));
	}

	public function userBelongsToTask($taskId, $username) {
		$stmt = $this->db->prepare("SELECT * FROM task_users WHERE task_id=? AND username=?");
		$stmt->execute(array($taskId, $username));
		return $stmt->fetch(PDO::FETCH_ASSOC) != null;
	}

	public function getUsersByTask($taskId) {
		$stmt = $this->db->prepare("SELECT username FROM task_users WHERE task_id = ?");
		$stmt->execute(array($taskId));
		$users_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$usernames = array();

		foreach ($users_db as $user) {
			array_push($usernames, $user["username"]);
		}

		return $usernames;
	}
}
