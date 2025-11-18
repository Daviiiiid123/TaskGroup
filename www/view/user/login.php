<?php
//file: view/user/login.php

require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$view->setVariable("title", i18n("Login"));
$errors = $view->getVariable("errors");
?>

<h1><?= i18n("Login") ?></h1>
<?= isset($errors["general"])?$errors["general"]:"" ?>

<div id="login">
	<form action="index.php?controller=user&amp;action=login" method="POST">
	<label for="username"><b><?= i18n("Username")?></b></label>
	<input type="text" name="username">

	<label for="passwd"><b><?= i18n("Password")?></b></label>
	<input type="password" name="passwd">

	<button type="submit"><?= i18n("Login")?></button>
</form>
