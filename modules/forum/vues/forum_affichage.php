<?php
/**
 * Created by PhpStorm.
 * User: 0940135
 * Date: 2016-02-23
 * Time: 14:37
 */
var_dump($messages);
foreach ($messages as $message) {
    ?>

        <p class="message"><?php echo $message->getTexte()?></p>

<?php }