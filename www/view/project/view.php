<?php
//file: view/project/view.php

require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$project = $view->getVariable("project");
$tasks = $view->getVariable("tasks");
$doneTasks = array_filter($tasks, function($task) { return $task->getIsDone();});
$notDoneTasks = array_filter($tasks, function($task) { return !$task->getIsDone();});
$currentuser = $view->getVariable("currentusername");
$view->setVariable("title", htmlspecialchars($project->getTitle()));
?>

<h1><?= htmlspecialchars($project->getTitle()) ?></h1>


<div class="trello-board">
    <div class="trello-column">
        <h2><?= i18n("Tasks done") ?></h2>
        <div class="trello-list">
            <?php foreach ($notDoneTasks as $task): ?>
                <div class="trello-card">
                    <h3><?php echo $task->getTitle(); ?></h3>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="trello-column">
        <p>Vista del proyecto</p>
    </div>
</div>

<?php $view->moveToFragment("css");?>
<link rel="stylesheet" href="view/styles/tasks.css" type="text/css">
<?php $view->moveToDefaultFragment(); ?>