<?php
//file: view/project/view.php

require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$project = $view->getVariable("project");
$totalTasks = $view->getVariable("totalTasks");
$pendingTasks = $view->getVariable("pendingTasks");
$resolvedTasks = $view->getVariable("resolvedTasks");
$progressTasks = $view->getVariable("progressTasks");
$currentuser = $view->getVariable("currentusername");
$view->setVariable("title", htmlspecialchars($project->getTitle()));
?>

<h1><?= i18n("Project info") ?></h1>

<section>
    <div>
        <h3><?= i18n("Total tasks") ?>: </h3>
        <p><?= $totalTasks ?></p>
    </div>

    <div>
        <h3><?= i18n("Todo tasks") ?>: </h3>
        <p><?= $pendingTasks ?></p>
    </div>

    <div>
        <h3><?= i18n("Finished tasks") ?>: </h3>
        <p><?= $resolvedTasks ?></p>
    </div>

    <div>
        <h3><?= i18n("Progress") ?>: </h3>
        <p><?= $progressTasks ?></p>
    </div>
</section>

<?php $view->moveToFragment("css");?>
<link rel="stylesheet" href="view/styles/projectSummary.css" type="text/css">
<?php $view->moveToDefaultFragment(); ?>