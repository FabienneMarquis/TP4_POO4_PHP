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
    // Load les forums
    $forums = ForumDAO::getForums();
    //les choix de forums
    $forum_choixs = array();


    // Parcoure les forums et mettres leur titres dans les choix de forums
    foreach ($forums as $forum) {
        $forum_choixs[$forum->getForumID()] = $forum->getTitre();
    }
    // Creation du form de choix du forum.
    $menu_choix_forum_form = new Form('menu_choix_forum_form');// Form Get
    $menu_choix_forum_form->add('hidden', 'module')->value('forum');//module=forum
    $menu_choix_forum_form->add('hidden', 'action')->value('afficher_forum');//action=afficher_forum
    $menu_choix_forum_form->add('radio', 'forum_choix')->choices($forum_choixs);//forum_choix=$idForum
    $menu_choix_forum_form->add('Submit', 'submit')->value("Charger le forum");


    // Creation du form pour le bouton de reponse au forum.
    $repondre_forum_btn_form = new Form('repondre_forum_btn_form', 'POST');// Form POST
    $repondre_forum_btn_form->add('Submit', 'submit')->value('commenter');

    // Form pour la prise de texte pour repondre sois a un message ou au forum.
    $repondre_forum_form = new Form('repondre_forum_form', 'POST');
    $repondre_forum_form->add('hidden', 'ID_message')->value('NULL');
    $repondre_forum_form->add('Textarea', 'text');
    $repondre_forum_form->add('Submit', 'soumettre')->value('soumettre');
    $repondre_forum_form_annuler = new Form('repondre_forum_form_annuler', 'POST');
    $repondre_forum_form_annuler->add('Submit', 'annuler')->value('annuler');

    // Array de tout les boutons(forms) contenu dans le forum. (un form par message)
    $repondre_message_forms = array();

    // si on peu afficher le forum.
    $canDisplay = false;

    // array des messages du tableau.
    $messages = array();

    // array de membres
    $membres = array();

    // Si la reponse a un message ou au forum est valid
    if ($repondre_forum_form->is_valid($_POST)) {

        // Ressois le text et le ID du message de la reponse.
        list($text, $idMessage) = $repondre_forum_form->get_cleaned_data('text', 'ID_message');

        // Creation de un nouveau objet message
        $message = new Message('', $_SESSION['id'], $idMessage, '', $_GET['forum_choix'], $text);

        // Sauvegarde de ce message dans la BD.
        MessageDAO::createMessage($message);

        // On peu donc afficher le forum
        $canDisplay = true;

    }
    if (isset($_GET['forum_choix'])) {
        $ForumID = $_GET['forum_choix'];
        $messages = MessageDAO::getMessagesForForum($ForumID);
        if (!empty($messages))
            setupAllTheReplyBtn($messages, $repondre_message_forms, $membres);

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
            display_msgs($messages, $membres, $repondre_message_forms);
        else {
            include CHEMIN_VUE . 'aucunMsg.php';
        }
    }
}

function display_msgs(&$messages, &$membres, &$repondre_message_forms)
{
    foreach ($messages as $message) {
        $membre = $membres[$message->getMessageID()];
        $repondre_message_form = $repondre_message_forms[$message->getMessageID()];
        include CHEMIN_VUE . 'forum_affichage.php';

    }
}

function setupAllTheReplyBtn(&$messages, &$repondre_message_forms, &$membres)
{
    foreach ($messages as $message) {
        $membres[$message->getMessageID()] = membres::lire_infos_utilisateur($message->getMembresId());
        $repondre_message_form = new Form('reponseA' . $message->getMessageID(), 'POST');
        $repondre_message_form->add('submit', 'submit')->value('Repondre');
        $repondre_message_form->add('hidden', 'messageID')->value($message->getMessageID());
        $repondre_message_forms[$message->getMessageID()] = $repondre_message_form;
        if (false !== $childMsgs = MessageDAO::getMessagesForMessage($message->getMessageID())) {
            setupAllTheReplyBtn($childMsgs, $repondre_message_forms, $membres);
        }
    }
}