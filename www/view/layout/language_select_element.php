<?php
// file: view/layout/language_select_element.php
?>

<div class="button dropdown" id="languagechooser">
	<a title="<?= i18n("Language") ?>"><img src="view/resources/languages.svg"></img></a>
	<div class="dropdown-content">
		<a class="button" href="index.php?controller=language&amp;action=change&amp;lang=es"><?= i18n("Spanish") ?></a>
		<a class="button" href="index.php?controller=language&amp;action=change&amp;lang=en"><?= i18n("English") ?></a>
	</div>
</div>