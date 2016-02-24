<?php
/**
 * Created by PhpStorm.
 * User: 0940135
 * Date: 2016-02-23
 * Time: 11:48
 */
if (!utilisateur_est_connecte()) {

    // On affiche la page d'erreur comme quoi l'utilisateur doit être connecté pour voir la page
    include CHEMIN_VUE_GLOBALE . 'erreur_non_connecte.php';

} else {
    $forums = ForumDAO::getForums();
    $menu_choix_forum_form = new Form('menu_choix_forum_form');
    $menu_choix_forum_form->add('hidden', 'module')->value('forum');
    $menu_choix_forum_form->add('hidden', 'action')->value('afficher_forum');
//var_dump($forums);
    $forum_choixs = array();
    $values = array();
    foreach ($forums as $forum) {
        $forum_choixs[$forum->getForumID()] = $forum->getTitre();
    }
    $menu_choix_forum_form->add('radio', 'forum_choix')->choices($forum_choixs);

    $menu_choix_forum_form->add('Submit', 'submit')
        ->value("Charger le forum");


    $repondre_forum_btn_form = new Form('repondre_forum_btn_form', 'POST');
    $repondre_forum_btn_form->add('Submit', 'submit')->value('commenter');

    $repondre_forum_form = new Form('repondre_forum_form', 'POST');
    //$repondre_forum_form->add('hidden', 'ID_forum')->value($_GET['forum_choix']);
    $repondre_forum_form->add('hidden', 'ID_message')->value('NULL');
    $repondre_forum_form->add('Textarea', 'text');
    $repondre_forum_form->add('Submit', 'soumettre')->value('soumettre');
    $repondre_forum_form_annuler = new Form('repondre_forum_form_annuler', 'POST');
    $repondre_forum_form_annuler->add('Submit', 'annuler')->value('annuler');
    //var_dump($_POST) ;
    $repondre_message_forms = array();
    $canDisplay = false;
    $messages = array();
    $membres = array();
    $messages = array();
    if ($repondre_forum_form->is_valid($_POST)) {

        list($text, $idMessage) = $repondre_forum_form->get_cleaned_data('text', 'ID_message');
        $message = new Message('', $_SESSION['id'], $idMessage, '', $_GET['forum_choix'], $text);
        MessageDAO::createMessage($message);
        $canDisplay = true;

    }
    if (isset($_GET['forum_choix'])) {
        $ForumID = $_GET['forum_choix'];
        $messages = MessageDAO::getMessagesForForum($ForumID);
        if (!empty($messages))
            setupAllTheReplyBtn($messages,$repondre_message_forms,$membres);

    }

    if (!empty($_POST)) {
        if ($repondre_forum_btn_form->is_valid($_POST)) {
            include CHEMIN_VUE . "repondre_forum_affichage.php";
        } else if ($repondre_forum_form_annuler->is_valid($_POST)) {
            $canDisplay = true;
        } else {
            foreach ($repondre_message_forms as $repondre_message_form) {
                if ($repondre_message_form->is_valid($_POST)) {
                    $data = $repondre_message_form->get_cleaned_data('messageID');
                    $repondre_forum_form->field('ID_message')->value($data);
                    include CHEMIN_VUE . "repondre_forum_affichage.php";
                }
            }
        }
    } else {
        $canDisplay = true;
    }
    if ($canDisplay) {
        display_forum($menu_choix_forum_form, $repondre_forum_btn_form, $repondre_message_forms, $membres, $messages);
    }
}
function display_forum($menu_choix_forum_form, $repondre_forum_btn_form, $repondre_message_forms, $membres, $messages)
{
    include CHEMIN_VUE . "forum_menu.php";
    if (isset($_GET['forum_choix'])) {
        include CHEMIN_VUE . 'repondre_forum_button.php';
        if (!empty($messages))
            display_msgs($messages,$membres,$repondre_message_forms);
        else {
            include CHEMIN_VUE.'aucunMsg.php';
        }
    }
}
function display_msgs(&$messages,&$membres,&$repondre_message_forms){
    foreach ($messages as $message) {
        $membre = $membres[$message->getMessageID()];
        $repondre_message_form = $repondre_message_forms[$message->getMessageID()];
        include CHEMIN_VUE . 'forum_affichage.php';

    }
}
function setupAllTheReplyBtn(&$messages,&$repondre_message_forms,&$membres){
    foreach ($messages as $message) {
        $membres[$message->getMessageID()] = membres::lire_infos_utilisateur($message->getMembresId());
        $repondre_message_form = new Form('reponseA' . $message->getMessageID(), 'POST');
        $repondre_message_form->add('submit', 'submit')->value('Repondre');
        $repondre_message_form->add('hidden', 'messageID')->value($message->getMessageID());
        $repondre_message_forms[$message->getMessageID()] = $repondre_message_form;
        if(false !== $childMsgs = MessageDAO::getMessagesForMessage($message->getMessageID())){
            setupAllTheReplyBtn($childMsgs,$repondre_message_forms,$membres);
                }
    }
}