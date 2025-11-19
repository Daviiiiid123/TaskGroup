<?php
// file: view/layout/language_select_element.php
?>

<div id="languagechooser" class="dropdown">
	<p><?= i18n("Language") ?></p>
	<div class="dropdown-content">
		<a href="index.php?controller=language&amp;action=change&amp;lang=es"><?= i18n("Spanish") ?></a>
		<a href="index.php?controller=language&amp;action=change&amp;lang=en"><?= i18n("English") ?></a>
	</div>
</div>