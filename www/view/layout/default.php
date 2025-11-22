<?php
//file: view/layout/default.php

$view = ViewManager::getInstance();
$currentuser = $view->getVariable("currentusername");

?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= $view->getVariable("title", "no title") ?></title>
	<link rel="stylesheet" href="view/styles/style.css" type="text/css">
	<!-- enable ji18n() javascript function to translate inside your scripts -->
	<script src="index.php?controller=language&amp;action=i18njs"></script>
	<?= $view->getFragment("css") ?>
	<!-- ?= $view->getFragment("javascript") ? -->
</head>
<body>

	<header>
		<h1>TaskGroup</h1>
		<nav>
			<a class="button" href="index.php?controller=project&amp;action=index" title="<?= i18n("Index") ?>"><img src="view/resources/house.svg"></img></a>
			<?php if (isset($currentuser)): ?>
				<a class="button" href="index.php?controller=project&amp;action=create" title="<?= i18n("New project") ?>"><img src="view/resources/book-plus.svg"></img></a> 
				<a class="button" href="index.php?controller=user&amp;action=logout" title="<?= i18n("Log out") ?>"><img src="view/resources/log-out.svg"></img></a> 
			<?php else: ?>
				<a class="button" href="index.php?controller=user&amp;action=login" title="<?= i18n("Login") ?>"><img src="view/resources/log-in.svg"></img></a> 
			<?php endif ?>
			<?php include(__DIR__."/language_select_element.php"); ?>
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
