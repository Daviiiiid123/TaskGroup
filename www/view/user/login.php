<?php
//file: view/user/login.php

require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$view->setVariable("title", i18n("Login"));

$errors = $view->getVariable("errors");
?>

<div class="container">
	<h1><?= i18n("Login") ?></h1>
</div>

<section>
	<form action="index.php?controller=user&amp;action=login" method="POST">
		<div class="container">
			<label for="username"><b><?= i18n("Username")?></b></label>
			<input type="text" name="username">
		</div>

		<div class="container">
			<label for="passwd"><b><?= i18n("Password")?></b></label>
			<input type="password" name="passwd">
			<?= isset($errors["general"]) ? i18n($errors["general"]) : "" ?>
		</div>

		<div id="form-buttons">
			<button class="button" type="submit"><?= i18n("Login")?></button>
			<a class="button" href="index.php?controller=user&amp;action=register"><?= i18n("I don't have an account")?></a>
		</div>
	</form>
</section>

<?php $view->moveToFragment("css");?>
<link rel="stylesheet" href="view/styles/form.css" type="text/css">
<?php $view->moveToDefaultFragment(); ?>
