<?php
//file: view/users/register.php

require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$errors = $view->getVariable("errors");
$user = $view->getVariable("user");
$view->setVariable("title", "Register");
?>

<h1><?= i18n("Register")?></h1>

<h2>Registrarse</h2>
<form action="index.php?controller=users&amp;action=register" method="POST">
	<label for="username"><b><?= i18n("Username")?></b></label>
	<input type="text" name="username" value="<?= $user->getUsername() ?>">
	<?= isset($errors["username"])?i18n($errors["username"]):"" ?>

	<label for="passwd"><b>C<?= i18n("Password")?></b></label>
	<input type="text" name="passwd" value="">
	<?= isset($errors["passwd"])?i18n($errors["passwd"]):"" ?>

	<label for="email"><b><?= i18n("Email")?></b></label>
	<input type="text" name="email" value="<?= $user->getEmail() ?>">
	<?= isset($errors["email"])?i18n($errors["email"]):"" ?>

	<button type="submit"><?= i18n("Register")?></button>
</form>
