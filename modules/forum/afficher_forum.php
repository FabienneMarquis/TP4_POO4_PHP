<?php
/**
 * Created by PhpStorm.
 * User: 0940135
 * Date: 2016-02-23
 * Time: 11:48
 */
if (!utilisateur_est_connecte()) {

    // On affiche la page d'erreur comme quoi l'utilisateur doit être connecté pour voir la page
    include CHEMIN_VUE_GLOBALE.'erreur_non_connecte.php';

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

    $repondre_forum_form = new Form('repondre_forum_form','POST');
    $repondre_forum_form->add('Textarea','text');
    $repondre_forum_form->add('Submit','soumettre')->value('soumettre');
    $repondre_forum_form->add('Submit','annuler')->value('annuler');
    //var_dump($_POST) ;

    if ($repondre_forum_btn_form->is_valid($_POST)) {
        include CHEMIN_VUE."repondre_forum_affichage.php";
    }else if($repondre_forum_form->is_submited()){
        if(isset($_POST['soumettre'])){
            $text = $_POST['text'];
            $message = new Message('',$_SESSION['id'],'','',$_GET['forum_choix'],$text);
            MessageDAO::createMessage($message);
        }
        display_forum($menu_choix_forum_form,$repondre_forum_btn_form);
    } else{
        display_forum($menu_choix_forum_form,$repondre_forum_btn_form);
    }


}
function display_forum($menu_choix_forum_form,$repondre_forum_btn_form){
    include CHEMIN_VUE . "forum_menu.php";
    if(isset($_GET['forum_choix'])){
        include CHEMIN_VUE . 'repondre_forum_button.php';
        $ForumID = $_GET['forum_choix'];
        $messages = MessageDAO::getMessagesForForum($ForumID);
        include CHEMIN_VUE.'forum_affichage.php';
    }
}