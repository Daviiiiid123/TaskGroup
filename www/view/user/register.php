<?php
//file: view/user/register.php

require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$errors = $view->getVariable("errors");
$user = $view->getVariable("user");
$view->setVariable("title", i18n("Register"));
?>

<div class="container">
	<h1><?= i18n("Register")?></h1>
</div>

<form action="index.php?controller=user&amp;action=register" method="POST">
	<div class="container">
		<label for="username"><b><?= i18n("Username")?></b></label>
		<input type="text" name="username" value="<?= $user->getUsername() ?>">
		<?= isset($errors["username"])?i18n($errors["username"]):"" ?>
	</div>

	<div class="container">
		<label for="passwd"><b><?= i18n("Password")?></b></label>
		<input type="text" name="passwd" value="">
		<?= isset($errors["passwd"])?i18n($errors["passwd"]):"" ?>
	</div>

	<div class="container">
		<label for="email"><b><?= i18n("Email")?></b></label>
		<input type="text" name="email" value="<?= $user->getEmail() ?>">
		<?= isset($errors["email"])?i18n($errors["email"]):"" ?>
	</div>

	<button class="button" type="submit"><?= i18n("Register")?></button>
</form>

<?php $view->moveToFragment("css");?>
<link rel="stylesheet" href="view/styles/login.css" type="text/css">
<?php $view->moveToDefaultFragment(); ?>
