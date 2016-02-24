<div class="message-panel">
    <p class="message"><?php echo $message->getTexte() ?></p>

    <p> Par: <?php echo $membre['nom_utilisateur'] ?></p>
    <?php echo $repondre_message_form;
    if(false !== $childMsgs = MessageDAO::getMessagesForMessage($message->getMessageID())){
        display_msgs($childMsgs,$membres,$repondre_message_forms);
    }?>
</div>
