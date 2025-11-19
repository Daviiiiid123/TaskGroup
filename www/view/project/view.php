<?php
//file: view/project/view.php

require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$project = $view->getVariable("project");
$currentuser = $view->getVariable("currentusername");

?><?php if (isset($currentuser)): 
    $view->setVariable("title", htmlspecialchars($project->getTitle()));
?>

<h1><?= htmlspecialchars($project->getTitle()) ?></h1>

<p>Vista del proyecto</p>


<?php endif; ?>
