<?php
if (!empty ($erreurs_connexion))
{
	echo '<ul>' . "\n";

	foreach ($erreurs_connexion as $e)
	{

		echo '  <li>' . $e . '</li>' . "\n";
	}

	echo '</ul>';
}


echo $form_forum;