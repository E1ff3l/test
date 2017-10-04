<?
class menu {
	
	// Ajoute un menu
	function ajouterMenu( $num_restaurant, $tableau, $debug=false ) {
		$menu = new menu();
		
		// Dernier élément "ordre_affichage"
		$dernier_ordre_affichage = $menu->getMaxiAffichage($num_restaurant);
		
		$requete = "INSERT INTO menus(id_resto, mode, nom, ref, description, image, prix, prix_ae, etat, ";
		$requete .= "ordre_affichage, affichage_prix_menu, affichage_prix_article, promotion, ";
		$requete .= "is_menu_vazee, nb_point_vazee) VALUES(";
		$requete .= $num_restaurant . ", '" . $tableau["mode"] . "', '" . traiter_champ_texte( $tableau["nouveau_nom_menu"] ) . "', '" . traiter_champ_texte( strtoupper( $tableau["ref"] ) ) . "', ";
		$requete .= "'" . traiter_champ_texte( $tableau["description"] ) . "', '" . $tableau["image"] . "', ";
		$requete .= str_replace(",", ".", $tableau["prix"]) . ", " . str_replace(",", ".", $tableau["prix_ae"]) . ", 0, ";
		$requete .= ($dernier_ordre_affichage + 1) . ", '" . $tableau["affichage_prix_menu"] . "', '" . $tableau["affichage_prix_article"] . "', " . $tableau["promotion"] . ", ";
		$requete .= "'" . $tableau["is_menu_vazee"] . "', " . intval( $tableau["nb_point_vazee"] ) . ")";
		if ( $debug ) echo $requete . "<br>";
		else mysql_query( $requete );
		
		$num_menu = mysql_insert_id();
		return $num_menu;
	}
	
	// Modifie un menu
	function modifierMenu( $num_menu, $tableau, $debug=false ) {
		$requete = "UPDATE menus SET";
		$requete .= " mode = '" . $tableau["mode"] . "', ";
		$requete .= " nom = '" . traiter_champ_texte( $tableau["nouveau_nom_menu"] ) . "', ";
		$requete .= " ref = '" . traiter_champ_texte( strtoupper($tableau["ref"] ) ) . "', ";
		$requete .= " description = '" . traiter_champ_texte( $tableau["description"] ) . "', ";
		$requete .= " image = '" . $tableau["image"] . "', ";
		$requete .= " prix = " . str_replace(",", ".", $tableau["prix"]) . ",";
		$requete .= " prix_ae = " . str_replace(",", ".", $tableau["prix_ae"]) . ",";
		$requete .= " affichage_prix_menu = '" . $tableau["affichage_prix_menu"] . "',";
		$requete .= " affichage_prix_article = '" . $tableau["affichage_prix_article"] . "',";
		$requete .= " promotion = " . intval( $tableau["promotion"] ) . ",";
		$requete .= " is_menu_vazee = '" . $tableau["is_menu_vazee"] . "',";
		$requete .= " nb_point_vazee = " . intval( $tableau["nb_point_vazee"] );
		$requete .= " WHERE id = " . $num_menu;
		if ( $debug ) echo $requete . "<br>";
		mysql_query( $requete );
	}
	
	// Supprime un menu
	function supprimerMenu($num_restaurant, $num_menu) {
		$menu = new menu();
		
		// Informations sur le menu
		$data = $menu->getMenu($num_menu);
		
		// Liste des menus dont l'ordre_affichage est supérieur
		$requete = "SELECT * FROM menus";
		$requete .= " WHERE ordre_affichage > " . $data["ordre_affichage"];
		$requete .= " AND id_resto = " . $num_restaurant;
		//echo $requete . "<br>";
		$liste = mysql_query($requete);
		
		// On déplace
		if (!empty($liste)) {
			while($data = mysql_fetch_assoc($liste)) {
				$requete = "UPDATE menus SET";
				$requete .= " ordre_affichage = (ordre_affichage-1)";
				$requete .= " WHERE id = " . $data["id"];
				//echo $requete . "<br>";
				mysql_query($requete);
			}
		}
		
		// Suppression des images associées au menu
		$menu->supprimerImageMenu($num_menu);
		
		// Suppression de l'enregistrement
		$requete = "DELETE FROM menus WHERE id = " . $num_menu;
		//echo "--> " . $requete . "<br>";
		mysql_query($requete);
	}
	
	// Fonction de traitement de l'image
	function ajouterImageMenu( $files, $largeur_maxi, $hauteur_maxi ) {
		//echo "Dans ajouterImageMenu : " . $fichier . "<br><br>";
		
		$largeur = 0;
		$hauteur = 0;
		$erreur = 0;
		$valeur_aleatoire = "";
		
		$chemin = "../../images/image_menu";
		$name = $files["fichier"]["name"];
		$ext = substr($name, strrpos($name, ".") + 1); 
		$nom_fichier = basename($name, "." . $ext);
		//$nom_fichier = $files["fichier"]["name"];
		
		// Pour éviter d'écraser l'ancien en cas de doublon
		$n = "";
		while(file_exists($chemin . "/" . $nom_fichier . $n . "." . $ext)) 
			$n++;
		
		$nom_fichier = $nom_fichier . $n . "." . $ext;

		//echo "nom fichier : " . $nom_fichier . "<br>";
		//echo "Lieu : " . $chemin . "/" . $nom_fichier . "<br>";
		
		$resultat = move_uploaded_file_custom($files["fichier"]["tmp_name"], $chemin . "/" . $nom_fichier);
		if ($resultat == true) {
			chmod($chemin . "/" . $nom_fichier, 0777);
			
			// ----- Dimensions de l'image ----- //
			// Changement du répertoire de destination
			/*$rep_destination = $_SERVER['DOCUMENT_ROOT'] . CHEMIN_SITE . "images/image_menu/";
			//echo $rep_destination . $$nom_fichier . "<br>";
			
			$fichier_a_retailler = $rep_destination . $nom_fichier;
			$size = GetImageSize($fichier_a_retailler); 
			$largeur = $size[0];
			$hauteur = $size[1];
			
			//echo "0 largeur : " . $largeur . "<br>";
			//echo "0 hauteur : " . $hauteur . "<br>";
			$fichier_a_retailler = $rep_destination . $nom_fichier;
			
			// Redimensionnement de l'image ET création d'une vignette
			if ( $erreur == 0 && ($largeur > $largeur_maxi)) {
				
				//echo "fichier a retailler : " . $fichier_a_retailler . "<br>";
				$i = new ImageManipulator($fichier_a_retailler);
				
				$nouvelle_largeur  = $largeur_maxi;
				$nouvelle_hauteur = ($nouvelle_largeur * $hauteur) / $largeur ; // hauteur proportionnelle
				
				$i->resample($largeur_maxi, $nouvelle_hauteur);
				$filename = $rep_destination . $nom_fichier;
				//echo "--> " . $filename . "<br>";
				$i->save_jpeg($filename);
				$i->end();
				
				$size = GetImageSize($filename); 
				//echo "TEST sur " . $filename . "<br>";
				$largeur = $size[0];
				$hauteur = $size[1];
				
				if ($hauteur > $hauteur_maxi) {
					//echo " Il faut retailler !!!<br>";
					$fichier_a_retailler = $filename;
				}
				
				//echo "1 largeur : " . $largeur . "<br>";
				//echo "1 hauteur : " . $hauteur . "<br>";
			}
			
			// Redimensionnement de l'image ET création d'une vignette
			if ( $erreur == 0 && ($hauteur > $hauteur_maxi)) {
				
				//echo "fichier a retailler : " . $fichier_a_retailler . "<br>";
				$i = new ImageManipulator($fichier_a_retailler);
				
				$nouvelle_hauteur  = $hauteur_maxi;
				$nouvelle_largeur = round(($nouvelle_hauteur * $largeur) / $hauteur) ;
				
				$i->resample($nouvelle_largeur, $nouvelle_hauteur);
				$filename2 = $rep_destination . $nom_fichier;
				//echo "--> " . $filename . "<br>";
				$i->save_jpeg($filename2);
				$i->end();
				
				$size = GetImageSize($filename2);
				//echo "TEST sur " . $filename . "<br>";
				$largeur = $size[0];
				$hauteur = $size[1];
				
				//echo "2 largeur : " . $largeur . "<br>";
				//echo "2 hauteur : " . $hauteur . "<br>";
			}*/
			
			$valeur_retour = "ok;" . $nom_fichier;
		}
		else
			$valeur_retour = "Erreur lors de la copie du fichier;";
		
		return $valeur_retour;
	}
	
	// Supprime l'image associée à un menu
	function supprimerImageMenu($num_menu) {
		$menu = new menu();
		
		// Suppression physique
		$menu->supprimerPhysiqueImageMenu($num_menu);
		
		// Suppression de la base
		$menu->supprimerBaseImageMenu($num_menu);
	}
	
	// Supprime physiquement l'image associée à un menu
	function supprimerPhysiqueImageMenu($num_menu) {
		$menu = new menu();
		
		// Informations sur le menu
		$data = $menu->getMenu($num_menu);
		
		// Ce menu a bien une image à supprimer
		if ($data["image"] != "") {
			$fichier_a_supprimer = $_SERVER['DOCUMENT_ROOT'] . CHEMIN_SITE . "images/image_menu/" . $data["image"];
			//echo "Fichier a supprimer : " . $fichier_a_supprimer . "<br>";
			
			if (file_exists($fichier_a_supprimer)) {
				//echo "Suppression du fichier<br>";
				unlink($fichier_a_supprimer);
			}
		}
	}
	
	// Supprime de la base l'image associée à un menu
	function supprimerBaseImageMenu($num_menu) {
		$requete = "UPDATE menus SET";
		$requete .= " image = ''";
		$requete .= " WHERE id = " . $num_menu;
		//echo $requete . "<br>";
		mysql_query($requete);
	}
	
	// Active / Désactive un menu
	function actionner($num_menu, $etat) {
		$requete = "UPDATE menus SET";
		$requete .= " etat = " . $etat;
		$requete .= " WHERE id = " . $num_menu;
		//echo $requete . "<br><br>";
		mysql_query($requete);
	}
	
	// Lister les catégories des menus
	function getListeMenuByNumRestaurant($num_restaurant) {
		$requete = "SELECT * FROM menus";
		$requete .= " WHERE id_resto = " . $num_restaurant;
		$requete .= " ORDER BY ordre_affichage";
		//echo $requete . "<br><br>";
		$liste = mysql_query($requete);
		
		return $liste;
	}
	
	// Retourne les composants d'un menu
	function getMenu($num_menu) {
		$requete = "SELECT * FROM menus";
		$requete .= " WHERE id = " . $num_menu;
		//echo $requete . "<br><br>";
		$liste = mysql_query($requete);
		
		if (mysql_num_rows($liste) != 0)
			$data = mysql_fetch_assoc($liste);
		else
			$data = "";
		return $data;
	}
	
	// Retourne le nombre d'article contenu dans la catégorie
	function getNombreArticleByNumCategorie($num_restaurant, $num_categorie, $article_complexe='') {
		$nombre_fichier = 0;
		
		$requete = "SELECT count(id) AS total FROM articles";
		$requete .= " WHERE id_resto = " . $num_restaurant;
		$requete .= " AND id_cat = " . $num_categorie;
		
		// On souhaite avoir le total d'articles complexes pour cette catégorie
		if ($article_complexe != '') 
			$requete .= " AND type = '" . $article_complexe . "'";
		
		//echo $requete . "<br>";
		$info = mysql_query($requete);
		
		if (mysql_num_rows($info) != 0) {
			$data = mysql_fetch_assoc($info);
			$nombre_fichier = $data["total"];
		}
		
		return $nombre_fichier;
	}
	
	function getMaxiAffichage($num_restaurant) {
		// Ordre maxi d'affichage
		$requete = "SELECT MAX(ordre_affichage) AS maxi FROM menus";
		$requete .= " WHERE id_resto = " . $num_restaurant;
		//echo $requete . "<br>";
		$ordre = mysql_query($requete);
		
		$data_count = mysql_fetch_assoc($ordre);
		$maxi = $data_count["maxi"];
		
		return $maxi;
	}
	
	// Fait monter dans la liste le menu spécifié
	function setPositionSuperieure($id_changement) {
		$menu = new menu();
		
		// Informations sur le menu
		$data = $menu->getMenu($id_changement);
		$ordre_affichage = $data["ordre_affichage"];
		//echo "--> Ordre affichage : " . $ordre_affichage . "<br>";
		
		// On ne peut effectuer l'opération QUE si on n'a pas atteint la limite mini
		if ($ordre_affichage > 1) {
			// Catégorie située avant la catégorie sélectionnée
			$requete = "SELECT id, ordre_affichage FROM menus";
			$requete .= " WHERE ordre_affichage < " . $ordre_affichage;
			$requete .= " AND id_resto = " . $data["id_resto"];
			$requete .= " ORDER BY ordre_affichage DESC";
			$requete .= " LIMIT 1";
			//echo "+++ " . $requete . "<br>";
			$liste_mouvement = mysql_query($requete);
			$data = mysql_fetch_assoc($liste_mouvement);
			
			// MAJ de la base
			$requete = "UPDATE menus SET";
			$requete .= " ordre_affichage = " . $ordre_affichage;
			$requete .= " WHERE id = " . $data["id"];
			//echo "+++ " . $requete . "<br>";
			mysql_query($requete);
			
			$requete = "UPDATE menus SET";
			$requete .= " ordre_affichage = " . $data["ordre_affichage"];
			$requete .= " WHERE id = " . $id_changement;
			//echo "+++ " . $requete . "<br>";
			mysql_query($requete);
		}
	}
	
	// Fait descendre dans la liste le menu spécifié
	function setPositionInferieure($num_restaurant, $id_changement) {
		$menu = new menu();
		
		// Nombre total d'enregistrements pour la rubrique en cours
		$total = $menu->getNombreMenuPourRestaurant($num_restaurant);
		//echo "--> Total : " . $total . "<br>";
		
		// Informations sur le menu
		$data = $menu->getMenu($id_changement);
		$ordre_affichage = $data["ordre_affichage"];
		//echo "--> Ordre affichage : " . $ordre_affichage . "<br>";
		
		// On ne peut effectuer l'opération QUE si on n'a pas atteint la limite maxi
		if ($ordre_affichage < $total) {
		
			// Catégorie située après la catégorie sélectionnée
			$requete = "SELECT id, ordre_affichage FROM menus";
			$requete .= " WHERE ordre_affichage > " . $ordre_affichage;
			$requete .= " AND id_resto = " . $num_restaurant;
			$requete .= " ORDER BY ordre_affichage";
			$requete .= " LIMIT 1";
			//echo "--- " . $requete . "<br>";
			$liste_mouvement = mysql_query($requete);
			$data = mysql_fetch_assoc($liste_mouvement);
			
			// MAJ de la base
			$requete = "UPDATE menus SET";
			$requete .= " ordre_affichage = " . $ordre_affichage;
			$requete .= " WHERE id = " . $data["id"];
			//echo "--- " . $requete . "<br>";
			mysql_query($requete);
			
			$requete = "UPDATE menus SET";
			$requete .= " ordre_affichage = " . $data["ordre_affichage"];
			$requete .= " WHERE id = " . $id_changement;
			//echo "--- " . $requete . "<br>";
			mysql_query($requete);
		}
	}
	
	// Retourne le nombre de menus pour un restaurant donné
	function getNombreMenuPourRestaurant($num_restaurant) {
		$requete = "SELECT COUNT(id) AS total FROM menus";
		$requete .= " WHERE id_resto = " . $num_restaurant;
		//echo $requete . "<br>";
		$info = mysql_query($requete);
			
		$data = mysql_fetch_assoc($info);
		$total = $data["total"];
		
		return $total;
	}
	
	// Retourne le prix final du menu (prix de base + options + suppléments)
	function getPrixMenuFinal( $id_menu, $key, $session=array(), $debug=false ) {
		if ( $debug ) echo "--> id_menu : " . $id_menu . "<br>";
		if ( $debug ) echo "--> key : " . $key . "<br>";
		//print_pre( $session[ "current_menu" ][ $key ] );
		
    	// ---- Informations sur le menu DIRECTEMENT dans la session (Version 2)
		if ( $session[ "current_menu" ][ $key ][ "prix_final" ] != '' ) {
			$prix_final = $session[ "current_menu" ][ $key ][ "prix_final" ];
			if ( $debug ) echo "--> prix_final (V2) : " . $prix_final . "<br>";
		}
		
		// ---- Chargement du menu via la BDD (Version 1)
    	else if ( $this->load( $id_menu, $debug ) ) {
			if ( $debug ) echo "--> Calcul (V1)...<br>";
			
			// Prix de base du menu
			$prix_menu =  $this->getPrixMenu( $id_menu, $key, $session, $debug );
			if ( $debug ) echo "-- Prix du menu : " . $prix_menu . "<br>";
			
			// Récupération du prix pour les options éventuelles
			$option = $this->getPrixOption( $id_menu, $key, $session, $debug );
	        if ( $debug ) echo "--- Options : " . $option . "<br>";
			
			// Récupération du prix pour les suppléments éventuels
			$supplement = $this->getSupOption( $key, $session, $debug );
	        if ( $debug ) echo "--- Sup : " . $supplement . "<br>";
	        
	        $prix_final = $prix_menu + $option + $supplement;
	        if ( $debug ) echo "--- FINAL : " . $prix_final . "<br>";
	    }
		
		// ---- Rien trouvé... :(
		else {
			if ( $debug ) echo "--> Rien trouvé!...<br>";
			$prix = "0";
		}
		
        return $prix_final;
	}
	
	// Retourne le prix du menu ainsi que les "plus" sur les différents articles composant ce menu
	function getPrixMenu( $id_menu, $key, $session=array(), $debug=false ) {
		//print_pre( $session[ "current_menu" ] );
		//echo "--- " . $session["fonctionnement"] . "<br>";
		
		$prix_base = ( $session[ "fonctionnement" ] == 'l' ) ? $this->prix : $this->prix_ae;
		//echo "-- Prix de base : " . $prix_base . "<br>";
		
		//print_pre( $_SESSION[ "current_menu" ][ $key ][ "order"] );
		//print_pre( $_SESSION["site"] );
		
		$tab_valeur = array();
		$prix_eventuel = 0;
		foreach( $session[ "current_menu" ][ $key ][ "order"] as $k => $_menu ) {
			//echo "ID MENU : " . $menu['menu_id'] . "<br>";
			$menu_temp = new menu();
			$menu_temp->load( $_menu['menu_id'] );
			
            if ( !is_array( $_menu[0]['article'] ) ) {
            	//echo "++ IF : " . $_menu['article']['name'] . " ++<br>";
            	//echo "++ IF _menu['menu_id'] : " . $_menu['menu_id'] . " ++<br>";
            	
            	// Il y a une majoration sur cet article
            	if ( $menu_temp->majoration != "" ) {
            		//echo "Majoration sur " . $_menu['article']['prix'] . "<br>";
            		$prix = $menu->getPrixMajoration( $_menu['article']['prix'], $menu_temp->majoration );
            		//echo "------>" . $prix . "<br>";
            		
            		$prix_eventuel += $prix;
            		$tab_valeur[] = $prix;
            	}
            	
            	// Pas de majoration
            	else {
                	$prix_eventuel += $_menu['article']['prix'];
                	$tab_valeur[] = $_menu['article']['prix'];
                }
            }
            else {
            	//echo "++ ELSE _menu['menu_id'] : " . $_menu['menu_id'] . " ++<br>";
            	
            	// Il y a une majoration sur cet article
            	if ( $menu_temp->majoration != "" ) {
            		//echo "Majoration sur " . $_menu['article']['prix'] . "<br>";
            		$prix = $menu->getPrixMajoration( $_menu['article']['prix'], $menu_temp->majoration );
            		//echo "------>" . $prix . "<br>";
            		
            		$prix_eventuel += $prix;
            		$tab_valeur[] = $prix;
            	}
            	
            	// Pas de majoration
            	else {
                	$prix_eventuel += $_menu['article']['prix'];
            		$tab_valeur[] = $_menu['article']['prix'];
                }
            }
        }
		
        // Promotion sur ce menu
        //echo "--- PROMO : " . $menu->promotion . " ---<br>";
        if ( $this->promotion > 0 ) {
        	$prix_eventuel = 0;
        	
			//print_pre( $tab_valeur );
			//echo "<br>---------------------<br>";
			
			// On tri le tableau
			sort( $tab_valeur, SORT_NUMERIC );
			//print_pre( $tab_valeur );
			//echo "<br>---------------------<br>";
			
			// On prend le 1ier élément et on lui applique la promotion
			//echo "-->" . $tab_valeur[ 0 ] . "<br>";
			$prix_eventuel = round( ( $tab_valeur[ 0 ] * ( 1 - ( $this->promotion / 100 ) ) ), 2);
			//echo "-->" . $price . "<br>";
			
			// On ajoute le reste des éléments
			for ( $i=1; $i<count( $tab_valeur ); $i++ ) {
				$prix_eventuel += $tab_valeur[ $i ];
			}
		}
		
		$prix = $prix_base + $prix_eventuel;
		//echo "----> PRIX : " . $prix . "<br>";
		
		return $prix;
	}
	
	// Retourne le prix des options pour un menu
	function getPrixOption( $num_menu, $key, $session=array(), $debug=false ) {
		//echo "--> KEY : " . $key . "<br>";
		$menu = new menu();
		$price = 0;
		
		//echo "--> num_menu : " . $num_menu . "<br>";
		/*echo '<pre>';
		print_r( $_SESSION['current_menu'][$key]['order'] );
		echo '</pre>';
		echo "<br>---------------------<br>";*/
		
    	// Chargement du menu
    	$menu->load( $num_menu, $debug );
    	//print_pre( $menu );
    	$tab_valeur = array();
    	
		foreach( $session[ "current_menu" ][ $key ][ "order"] as $k => $_menu ) {
			//print_pre( $_menu );
			//echo "\n<br>---------------------<br>\n";
			
            if ( !is_array( $_menu[0][ "article" ] ) ) {
            	//echo "++ IF (options) ++<br>";
            	$val = floatval( $menu->getOptionPrice( $num_menu, $_menu, $debug ) );
            	//echo "--> " . $val . "<br>";
                $price += $val;
                $tab_valeur[] = $val;
            }
            else {
            	//echo "++ ELSE (options) ++<br>";
            	
            	$u=0;
            	foreach( $_menu as $m ) {
            		//echo "------" . $m . "<br>";
            		if ( is_array( $m ) ) {
            			//echo "<br>----------------------<br>";
            			//print_pre( $m );
            			//echo "<br>----------------------<br>";
            			
            			$val = floatval( $menu->getOptionPrice( $m ) );
            			$price += $val;
            			$tab_valeur[] = $val;
            			
            			$u++;
            		}
            	}
            }
        }
        
        // Promotion sur ce menu
        //echo "--- PROMO : " . $menu->promotion . " ---<br>\n";
        if ( $menu->promotion > 0 ) {
        	$price = 0;
        	
			//print_pre( $tab_valeur );
			//echo "<br>---------------------<br>";
			
			// On tri le tableau
			//sort( $tab_valeur, SORT_NUMERIC );
			//print_pre( $tab_valeur );
			//echo "<br>---------------------<br>\n";
			
			// On prend le 1ier élément et on lui applique la promotion
			//echo "-->" . $tab_valeur[ 0 ] . "<br>";
			$price = round( ( $tab_valeur[ 0 ] * ( 1 - ( $menu->promotion / 100 ) ) ), 2);
			//echo "-->" . $price . "<br>\n";
			
			// On ajoute le reste des éléments
			for ( $i=1; $i<count( $tab_valeur ); $i++ ) {
				$price += $tab_valeur[ $i ];
			}
		}
		
		// echo "---> Prix option : " . $price . "<br>";
        return $price;
	}
	
	// Retourne le prix des suppléments pour un menu
	function getSupOption( $key, $session=array(), $debug=false ) {
		$article = new article_produit();
		$price = 0;
		
		foreach( $session['current_menu'][$key]['order'] as $k => $menu ) {
            if (!is_array($menu[0]['article'])) {
            	//echo "++ IF (Sup.) ++<br>";
                $price += floatval( $article->getSupPrice( $menu ) );
            }
            else {
            	//echo "++ ELSE (Sup.) ++<br>";
            	
            	$u=0;
            	foreach($menu as $m) {
            		//echo "------" . $m . "<br>";
            		if (is_array($m)) {
            			/*echo "<br>----------------------<br>";
            			print_r ($m);
            			echo "<br>----------------------<br>";*/
            			
            			$price += floatval( $article->getSupPrice( $m ) );
            			
            			$u++;
            		}
            	}
            }
        }
        
        return $price;
	}
	
	function getPrixMajoration( $prix_initial, $majoration ) {
		$prix_final = 0;
		
		// Traitement de la majoration
		$tab = split("\|", $majoration);
		
		// Cas 1 : Pourcentage
		if ($tab[0] == 1) {
			$prix_final = (round($prix_initial * $tab[1]) / 100);
		}
		
		// Cas 2 : Somme à ajouter
		else if ($tab[0] == 2) {
			$prix_final = $tab[1];
		}		
		// Cas 3 : Somme à soustraire
		else if ($tab[0] == 3) {
			$prix_final = $prix_initial - $tab[1];
		}		
		// Au pire des cas, on renvoit le prix initial
		else {
			$prix_final = $prix_initial;
		}
		
		return $prix_final;
	}

	function getOptionPrice( $num_menu, $options, $debug=false ) {
		//echo "--- Dans getOptionPrice()\n";
	    $optionPrice = 0;
	    
	    if( !empty( $options[ "items" ] ) ) {
	    	//echo "--> num_menu : " . $num_menu . "<br>";
			//print_pre( $options[ "items" ] );
			//echo "\n<br>---------------------<br>\n";
	    	
	        foreach( $options[ "items" ] as $opt ) {
	        	//echo "====>" . $opt[ "price" ] . "<br>\n";
	            $optionPrice = floatval( $optionPrice + $opt[ "price" ] );
	        }
	    }
	    
	    return $optionPrice;
	}	
	
	// --------------- Nouvelle gestion (partielle) --------------- //
	var $id = 0;
	var $id_resto = 0;
	var $mode = '1';
	var $nom = '';
	var $ref = '';
	var $description = '';
	var $image = '';
	var $prix = 0;
	var $prix_ae = 0;
	var $etat = 0;
	var $ordre_affichage = 0;
	var $affichage_prix_menu = '1';
	var $affichage_prix_article = '0';
	var $promotion = 0;
	var $is_menu_vazee = '0';
	var $nb_point_vazee = 0;
	
	// Chargement...
	function load( $id=0, $debug=false ) {
		$id = intval($id);
		if ($id <= 0) return false;
		
		$requete = "SELECT * FROM menus";
		$requete .= " WHERE id = '" . $id . "'";
		if ( $debug ) echo $requete . "<br>";
		$result = mysql_query($requete);
		
		if (!$result) return false;
		
		$data = mysql_fetch_assoc($result);
		if (empty($data)) return false;
		
		$this->id = $data["id"];
		$this->id_resto = $data["id_resto"];
		$this->mode = $data["mode"];
		$this->nom = $data["nom"];
		$this->ref = $data["ref"];
		$this->description = $data["description"];
		$this->image = $data["image"];
		$this->prix = $data["prix"];
		$this->prix_ae = $data["prix_ae"];
		$this->affichage_prix_menu = $data["affichage_prix_menu"];
		$this->affichage_prix_article = $data["affichage_prix_article"];
		$this->promotion = $data["promotion"];
		$this->etat = $data["etat"];
		$this->ordre_affichage = $data["ordre_affichage"];
		$this->affichage_prix_menu = $data["affichage_prix_menu"];
		$this->affichage_prix_article = $data["affichage_prix_article"];
		$this->promotion = $data["promotion"];
		$this->is_menu_vazee = $data["is_menu_vazee"];
		$this->nb_point_vazee = $data["nb_point_vazee"];
		
		return true;
	}
	
	function setChamp( $champ, $valeur=0, $debug=false ) {
		//echo "Traitement de : " . $champ . " (" . $valeur . ")<br>";
		$nouvelle_valeur = ( !is_null( $valeur ) ) ? "'" . $this->traiter_champ( $valeur ) . "'" : "NULL";
		//echo "-----> " . $nouvelle_valeur . "<br>";
		
		$requete = "UPDATE menus SET";
		$requete .= " " . $champ . " = " . $nouvelle_valeur;
		$requete .= " WHERE id = " . $this->id;
		if ( $debug ) echo $requete . "<br>";
		if ( !$debug ) $result = mysql_query($requete);
		
		return ( $result ) ? $this->id : false;
	}
	
	function traiter_champ($texte='') {
		//echo "...Dans traiter_champ...<br>";
		$texte = str_replace("\"", "", $texte);
		$texte = utf8_decode( $texte );
		$texte = addslashes( $texte );
		
		//echo "... Au final : " . $texte . " ...<br>";
		return $texte;
	}
	
	private function getTableau( $liste, $tab=array() ) {
		$tableau = array();
		
		if ( mysql_num_rows( $liste ) != 0 ) {
			$i = 0;
			
			// ---- Renvoi TOTAL des champs -------------------- //
			if ( !isset( $tab[ "renvoi" ] ) ) {
				while( $data = mysql_fetch_assoc($liste) ) {
					$tableau[$i] = new menu();
						
					foreach( $data as $key => $val ) {
						$tableau[ $i ]->$key = $val;
					}
					
					$i++;
				}
			}
			// ------------------------------------------------- //
			
			// ---- Renvoi PARTIEL des champs ------------------ //
			else {
				//print_pre( $tab[ "renvoi" ] );
				while( $data = mysql_fetch_assoc( $liste ) ) {
					$tableau[ $i ] = array();
						
					foreach( $data as $key => $val ) {
						$tableau[ $i ][ $key ] = $val;
					}
					
					$i++;
				}
			}
			// ------------------------------------------------- //
			
		}
		
		return $tableau;
	}
	
	// Retourne la liste des restos
	function getListe( $id= '', $tab_mode=array(), $liste_id='', $liste_exclusion='', $id_resto='', $tab=array(), $debug=false ) {
		
		/*echo "<pre>";
		print_r( $tab_mode );
		echo "</pre>";*/
		
		$requete = "SELECT * FROM menus";
		$requete .= " WHERE id > 0";
		if ( $id != '' ) $requete .= " AND id = '" . $id . "'"; 
		if ( $id_resto != '' ) $requete .= " AND id_resto = '" . $id_resto . "'"; 
		if ( $liste_id != '' ) $requete .= " AND id IN (" . $liste_id . ")";
		if ( $liste_exclusion != '' ) $requete .= " AND id NOT IN (" . $liste_exclusion . ")"; 
		if ( $tab[ "etat" ] != '' ) $requete .= " AND etat = '" . $tab[ "etat" ] . "'"; 
		if ( !empty( $tab_mode ) ) {
			$fin_requete = "";
			foreach( $tab_mode as $_mode ) {
				$fin_requete .= ( $fin_requete == "" ) ? " mode = '" . $_mode . "'" : " OR mode = '" . $_mode . "'";
			}
			$requete .= " AND ( " . $fin_requete . " )";
		}
		
		$requete .= " ORDER BY id";
		if ( $debug ) echo $requete . "<br>";
		$liste = mysql_query($requete);
		
		return $this->getTableau( $liste );
	}
	
	// Retourne la liste...
	function getListe_v2( $tab=array(), $debug=false) {
		$champ_souhaite = ( $tab[ "champ" ] != '' ) ? $tab[ "champ" ] : "*";
		$requete = "SELECT " . $champ_souhaite . " FROM menus";
		
		if ( $tab[ "where" ] == '' ) {
			$requete .= " WHERE id > 0";
			
			if ( !empty( $tab ) ) {
				foreach( $tab as $champ => $val ) {
					if ( $champ != "mode" && $champ != "champ" && $champ != "order_by" && $champ != "sens" )
						$requete .= " AND " . $champ . " = '" . addslashes( $val ) . "'";
				}
			}
			
			if ( !empty( $tab[ "mode" ] ) ) {
				$fin_requete = "";
				foreach( $tab[ "mode" ] as $_mode ) {
					$fin_requete .= ( $fin_requete == "" ) ? " mode = '" . $_mode . "'" : " OR mode = '" . $_mode . "'";
				}
				$requete .= " AND ( " . $fin_requete . " )";
			}
			
			$order_by = ( $tab[ "order_by" ] != "" ) ? $tab[ "order_by" ] : "id";
			$sens = ( $tab[ "sens" ] != "" ) ? $tab[ "sens" ] : "ASC";
			$requete .= " ORDER BY " . $order_by . " " . $sens;
		}
		else $requete .= $tab[ "where" ];
		
		if ( $debug ) echo $requete . "<br>";
		$liste = mysql_query($requete);
		
		return $this->getTableau( $liste, $tab );
	}
	
	function isDisponible( $num_menu=0 ) {
		$disponibilite = new menu_disponibilite();
		
		//echo "--> num_menu : " . $num_menu . "<br>";
		//echo "--> fonctionnement : " . $_SESSION["site"]["fonctionnement"] . "<br>";
		$mode = ( $_SESSION["site"]["fonctionnement"] == "emporter" ) ? 3 : 2;
		
		if ( $disponibilite->loadBy( $num_menu, $mode, date("N") ) ) {
			return ( $disponibilite->dispo != 0 ) ? true : false;
		}
		else return true;
	}
	
	// Charge la liste des menus d'1 resto
	function AppliMobile_getListeMenuByNumRestaurant( $num_restaurant, $mode_fonctionnement, $debug = false ) {
		
		if ( $mode_fonctionnement == 'L' ) $mode = "'1','2'";
		elseif ($mode_fonctionnement == 'AE' ) $mode = "'1','3'";

		$requete = "SELECT * FROM menus";
		$requete .= " WHERE id_resto = " . $num_restaurant;
		$requete .= " AND mode IN(" . $mode . ")";
		$requete .= " AND etat = '1'";
		$requete .= " ORDER BY ordre_affichage ASC";
		if ( $debug ) echo $requete . "<br><br>";
		$liste = mysql_query($requete);
		
		return $liste;
	}
	
	// Charge la liste des menus d'1 resto
	function AppliMobile_getListeEtape( $id_resto, $id_menu, $debug = false ) {
		
		$requete = "SELECT * FROM detail_menus";
		$requete .= " WHERE id_resto = " . $id_resto;
	  $requete .= " AND id_menu = " . $id_menu;
		$requete .= " ORDER BY ordre ASC";
		if ( $debug ) echo $requete . "<br><br>";
		$liste = mysql_query($requete);
		
		return $liste;
	}

	
	// ------------------------------------------------------------ //
}
?>
