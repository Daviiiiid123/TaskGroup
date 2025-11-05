<?php
//file: view/layouts/default.php

$view = ViewManager::getInstance();
$currentuser = $view->getVariable("currentusername");

?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= $view->getVariable("title", "no title") ?></title>
	<link rel="stylesheet" href="styles/style.css" type="text/css">
	<!-- enable ji18n() javascript function to translate inside your scripts -->
	<script src="index.php?controller=language&amp;action=i18njs"></script>
	<!-- ?= $view->getFragment("css") ? -->
	<!-- ?= $view->getFragment("javascript") ? -->
</head>
<body>

	<header>
		<h1>TaskGroup</h1>
		<?php include(__DIR__."/language_select_element.php"); ?>
		<nav>
			<?php if (isset($currentuser)): ?>
				<a href="index.php?controller=users&amp;action=logout"><?= i18n("Log out") ?></a> 
			<?php else: ?>
				<a href="index.php?controller=projects&amp;action=index"><?= i18n("Index") ?></a>
				<a href="index.php?controller=users&amp;action=login"><?= i18n("Login") ?></a> 
				<a href="index.php?controller=users&amp;action=register"><?= i18n("Register") ?></a> 
			<?php endif ?>
		</nav>
	</header>

	<main>
		<div id="flash">
			<?= $view->popFlash() ?>
		</div>
		<?= $view->getFragment(ViewManager::DEFAULT_FRAGMENT) ?>
	</main>

</body>
</html>
