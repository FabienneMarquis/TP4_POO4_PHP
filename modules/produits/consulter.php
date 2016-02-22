<?php
include CHEMIN_VUE . 'produit_entete_titre.php';
			
		$list = new SplDoublyLinkedList();
		$list = Produit::getProduits();
		//$ordre= "FIFO (First In First Out)";
		include CHEMIN_VUE . 'produit_entete_start.php';
		$list->setIteratorMode(SplDoublyLinkedList::IT_MODE_FIFO);
		for ($list->rewind(); $list->valid(); $list->next())
		 {
			$des = $list->current()->getDes ();
			$prix = $list->current()->getPrix ();
			$qtes = $list->current()->getQtes ();
			include CHEMIN_VUE . 'produit_start.php';
		}
		
 		$ordre="</br> LIFO (Last In First Out)";
 		include CHEMIN_VUE . 'produit_entete_start.php';
 		$list->setIteratorMode(SplDoublyLinkedList::IT_MODE_LIFO);
 		for ($list->rewind(); $list->valid(); $list->next())
 		{
 			$des = $list->current()->getDes ();
 			$prix = $list->current()->getPrix ();
 			$qtes = $list->current()->getQtes ();
 			include CHEMIN_VUE . 'produit_start.php';}
		
			include CHEMIN_VUE . 'produit_start_pied.php';
		
		


