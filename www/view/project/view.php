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

<div id="project-header">
    <span></span>
    <h1><?= htmlspecialchars($project->getTitle()) ?></h1>
    <span id="project-buttons">
        <a class="button" href="index.php?controller=task&amp;action=create&amp;projectId=<?= $project->getId() ?>" title="<?= i18n("Create task") ?>"><img src="view/resources/clipboard-plus.svg"></img></a> 
        <a class="button" href="index.php?controller=project&amp;action=create" title="<?= i18n("Project users") ?>"><img src="view/resources/user-pen.svg"></img></a>
        <a class="button" href="index.php?controller=project&amp;action=summary&amp;id=<?= $project->getId() ?>" title="<?= i18n("Project info") ?>"><img src="view/resources/info.svg"></img></a> 
    </span>
</div>

<div class="trello-board">
    <div class="trello-column">
        <h2><?= i18n("Todo tasks") ?></h2>
        <div class="trello-list">
            <?php foreach ($notDoneTasks as $task): ?>
                <div class="trello-card">
                    <h3><?php echo $task->getTitle(); ?></h3>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="trello-column">
        <h2><?= i18n("Finished tasks") ?></h2>
        <div class="trello-list">
            <?php foreach ($doneTasks as $task): ?>
                <div class="trello-card">
                    <h3><?php echo $task->getTitle(); ?></h3>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php $view->moveToFragment("css");?>
<link rel="stylesheet" href="view/styles/tasks.css" type="text/css">
<?php $view->moveToDefaultFragment(); ?>