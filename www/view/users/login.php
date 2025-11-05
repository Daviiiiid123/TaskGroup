<?php
//file: view/users/login.php

require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$view->setVariable("title", "Login");
$errors = $view->getVariable("errors");
?>

<h2><?= i18n("Login") ?></h2>
<?= isset($errors["general"])?$errors["general"]:"" ?>
<form action="index.php?controller=users&amp;action=login" method="POST">
	<label for="usuario"><b><?= i18n("Username")?></b></label>
	<input type="text" name="usuario">

	<label for="constraseña"><b><?= i18n("Password")?></b></label>
	<input type="text" name="contraseña">

	<button type="submit"><?= i18n("Login")?></button>
</form>

<?php $view->moveToFragment("css");?>
<link rel="stylesheet" type="text/css" src="css/style.css">
<?php $view->moveToDefaultFragment(); ?>
