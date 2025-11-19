<?php
//file: view/project/create.php

require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$view->setVariable("title", i18n("New project"));

$errors = $view->getVariable("errors");
?>

<div class="container">
	<h1><?= i18n("New project") ?></h1>
	<?= isset($errors["general"]) ? i18n($errors["general"]) : "" ?>
</div>

<form action="index.php?controller=project&amp;action=create" method="POST">
	<label for="title"><b><?= i18n("Project title")?></b></label>
	<input type="text" name="title">

	<button type="submit"><?= i18n("Create project")?></button>
</form>

<?php $view->moveToFragment("css");?>
<link rel="stylesheet" href="view/styles/login.css" type="text/css">
<?php $view->moveToDefaultFragment(); ?>