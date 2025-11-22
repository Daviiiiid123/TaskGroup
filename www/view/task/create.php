<?php
//file: view/user/login.php

require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$view->setVariable("title", i18n("Create task"));

$project = $view->getVariable("project");
$projectUsers = $view->getVariable("projectUsers");
$currentUsername = $view->getVariable("currentUsername");

$errors = $view->getVariable("errors");
?>

<div class="container">
	<h1><?= i18n("Create task") ?></h1>
	<?= isset($errors["general"]) ? i18n($errors["general"]) : "" ?>
</div>

<section>
	<form action="index.php?controller=task&amp;action=create&amp;projectId=<?= $project->getId() ?>" method="POST">
		<div class="container">
			<label for="title"><b><?= i18n("Task title")?></b></label>
			<input type="text" name="title">
			<?= isset($errors["title"])?i18n($errors["title"]):"" ?>
		</div>

		<div class="container">
			<label for="assignedUser"><b><?= i18n("User asigned to task")?></b></label>
			<select name="assignedUser">
                <?php foreach ($projectUsers as $user): ?>
                    <option <?php if ($user->getUsername() === $currentUsername) echo("selected"); else echo(""); ?> value="<?php echo($user->getUsername()); ?>"><?php echo($user->getUsername()); ?></option>
                <?php endforeach; ?>
                <option value=""><?= i18n("< No user >")?></option>
            </select>
			<?= isset($errors["assignedUser"])?i18n($errors["assignedUser"]):"" ?>
		</div>

		<div id="form-buttons">
			<button class="button" type="submit"><?= i18n("Create task")?></button>
		</div>
	</form>
</section>

<?php $view->moveToFragment("css");?>
<link rel="stylesheet" href="view/styles/form.css" type="text/css">
<?php $view->moveToDefaultFragment(); ?>
