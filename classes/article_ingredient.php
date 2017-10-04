<?
class article_ingredient {
	var $id_ingredient = 		0;
	var $id_detail = 			0;
	var $mode_fonctionnement =	0;
	var $nom = 					'';
	var $prix = 				0;
	var $prix_ae = 				0;
	var $supplement = 			false;
	var $defaut = 				false;
	
	// Infos sur l'article
	var $type = '';
	
	// Charge un ingredient d'un article complexe
	function load( $id_ingredient=0 ) {
		$id_ingredient = intval($id_ingredient);
		if ($id_ingredient <= 0) return false;
		
		$requete = "SELECT * FROM ingredient";
		$requete .= " WHERE id_ingredient = '" . $id_ingredient . "'";
		//echo $requete . "<br>";
		$result = mysql_query($requete);
		
		if (!$result) return false;
		
		$data = mysql_fetch_assoc($result);
		if (empty($data)) return false;
		
		$this->id_ingredient = $data[ "id_ingredient" ];
		$this->id_detail = $data[ "id_detail" ];
		$this->mode_fonctionnement = $data[ "mode_fonctionnement" ];
		$this->nom = $data[ "nom" ];
		$this->prix = $data[ "prix" ];
		$this->prix_ae = $data[ "prix_ae" ];
		$this->supplement = $data[ "supplement" ];
		$this->defaut = $data[ "defaut" ];
		
		return true;
	}
	
	// Charge l'article a qui appartient l'ingredient
	function loadArticleByNumIngredient( $id_ingredient=0 ) {
		$id_ingredient = intval($id_ingredient);
		if ($id_ingredient <= 0) return false;
		
		$article = new article_produit();
		
		$requete = "SELECT detail_articles_V2.* FROM ingredient";
		$requete .= " INNER JOIN detail_articles_detail_V2 ON detail_articles_detail_V2.id = ingredient.id_detail";
		$requete .= " INNER JOIN detail_articles_V2 ON detail_articles_V2.id = detail_articles_detail_V2.id_detail_articles_V2";
		$requete .= " WHERE id_ingredient = '" . $id_ingredient . "'";
		//echo $requete . "<br>";
		$result = mysql_query($requete);
		
		if (!$result) return false;
		
		$data = mysql_fetch_assoc($result);
		if (empty($data)) return false;
		
		return ( $article->loadByParams( $data[ "id_resto" ], $data[ "id_cat" ], $data[ "id_art" ] ) ) ? $article : array();
	}
	
	// Charge un ingredient...
	function loadIngredient($id_detail=0, $num_parametre=0, $limit=-1) {
		
		// Ingredient servant de reference
		$ing = $this->getListeIngredientByArticle($id_detail, $num_parametre, $limit);
		
		if (mysql_num_rows($ing) != 0) {
			$data = mysql_fetch_assoc($ing);
			return $this->load( $data[ "id_ingredient" ] );
		}
		else
			return false;
	}
	
	// Ajoute un ingredient
	function ajouterIngredient( $debug=false ) {
		$this->id_detail = intval( $this->id_detail );
		if ( $this->id_detail <= 0 ) return false;
		
		//$mode_fonctionnement = ( $this->mode_fonctionnement == "" ) ? "" : trim( $this->mode_fonctionnement );
		//$nom = ( $this->nom == "" ) ? "" : addslashes(str_replace("\"", "", trim( $this->nom )));
		//$prix = ( $this->prix == "" ) ? 0 : trim( $this->prix );
		//$prix_ae = ( $this->prix_ae == "" ) ? 0 : trim( $this->prix_ae );
		$this->supplement = 0;
		if ( $this->defaut == '' ) $this->defaut = 0;
		
		$requete = "INSERT INTO ingredient( id_detail, mode_fonctionnement, nom, prix, prix_ae, supplement, defaut ) VALUES(";
		$requete .= $this->id_detail . ", " . $this->mode_fonctionnement . ", '" . ucfirst( traiter_champ_texte( $this->nom ) ) . "', ";
		$requete .= "'" . $this->prix . "', '" . $this->prix_ae . "', " . $this->supplement . ", " . $this->defaut . ")";
		if ( $debug ) echo "--> " . $requete . "<br>\n";
		if ( !$debug ) mysql_query( $requete );
		
		$num_ingredient = mysql_insert_id();
		
		return $num_ingredient;
	}
	
	// Mofifie un ingredient
	function modifierIngredient( $debug=false ) {
		if ( $this->defaut == '' ) $this->defaut = 0;
		
		$requete = "UPDATE ingredient SET";
		$requete .= " id_detail = '" . intval( $this->id_detail ) . "',";
		$requete .= " mode_fonctionnement = '" . intval( $this->mode_fonctionnement ) . "',";
		$requete .= " nom = '" . ucfirst( traiter_champ_texte( $this->nom ) ) . "',";
		$requete .= " prix = '" . $this->prix . "',";
		$requete .= " prix_ae = '" . $this->prix_ae . "',";
		$requete .= " supplement = '" . $this->supplement . "',";
		$requete .= " defaut = '" . $this->defaut . "'";
		$requete .= " WHERE id_ingredient = " . $this->id_ingredient;
		if ( $debug ) echo $requete . "<br>\n";
		else mysql_query( $requete );
	}
	
	// Interface entre le formulaire et la base
	function gererDonnee( $post=array(), $debug=false ) {
		//print_pre( $post );
		
		// Tentative de chargement...
		$modification = $this->load( intval( $post[ "id_ingredient" ] ) );
		
		$this->id_detail = 				intval( $post[ "id_detail" ] );
		$this->mode_fonctionnement =	intval( $post[ "mode_fonctionnement" ] );
		$this->nom = 					$this->traiter_champ( $post[ "nom" ] );
		$this->prix = 					intval( $post[ "prix" ] );
		$this->prix_ae = 				intval( $post[ "prix_ae" ] );
		$this->supplement = 			( $post[ "supplement" ] == 1 ) ? 1 : 0;
		$this->defaut = 				$post[ "defaut" ];
		
		// Ajout
		if ( !$modification ) {
			return $this->ajouterIngredient( $debug );
		}
		else
			return $this->modifierIngredient( $debug );
	}
	
	// Supprime un ingredient
	function supprimerIngredient() {
		$requete = "DELETE FROM ingredient";
		$requete .=  " WHERE id_ingredient = " . $this->id_ingredient;
		//echo "--> " . $requete . "<br>";
		mysql_query($requete);
	}
	
	function setChamp( $champ, $valeur=0, $debug=false ) {
		$requete = "UPDATE ingredient SET";
		$requete .= " " . $champ . " = '" . $this->traiter_champ( $valeur ) . "'";
		$requete .= " WHERE id_ingredient = " . $this->id_ingredient;
		if ( $debug ) echo $requete . "<br>";
		if ( !$debug ) $result = mysql_query($requete);
		
		return ( $result ) ? $this->id_ingredient : false;
	}
	
	function traiter_champ($texte='') {
		$texte = str_replace("\"", "", $texte);
		//$texte = utf8_decode( $texte );
		$texte = addslashes( $texte );
		
		return $texte;
	}
	
	// Supprime tous les ingredients associes a un article
	function supprimerIngredientByArticle($num_detail_article) {
		
		// Suppression de l'enregistrement
		$requete = "DELETE FROM ingredient";
		$requete .=  " WHERE id_detail = " . $num_detail_article;
		//echo "--> " . $requete . "<br>";
		mysql_query($requete);
	}
	
	// ---- Copie des ingredients d'un detail d'un article complexe
	function copierIngredient( $id_detail_original=0, $id_detail_nouveau=0, $tableau, $debug=false ) {
		if ( $debug ) echo "<br>--- Dans article_ingredient." . __function__ . "();<br>";
		$liste_ingredient = $this->getListeIngredientByDetail( $id_detail_original, $debug );
		
		if ( mysql_num_rows( $liste_ingredient ) != 0 ) {
			while( $data = mysql_fetch_assoc( $liste_ingredient ) ) {
				//print_pre( $data );
				$this->mode_fonctionnement =	$data[ "mode_fonctionnement" ];
				$this->id_detail = 				$id_detail_nouveau;
				$this->nom = 					utf8_encode( $data[ "nom" ] );
				$this->prix = 					( $tableau[ "raz_prix" ] == "oui" ) ? 0 : $data[ "prix" ];
				$this->prix_ae = 				( $tableau[ "raz_prix" ] == "oui" ) ? 0 : $data[ "prix_ae" ];
				$this->supplement = 			$data[ "supplement" ];
				$this->defaut = 				( $data[ "defaut" ] == 1 ) ? true : false;
				$this->ajouterIngredient( $debug );
			}
		}
	}
	
	// Recherche la presence d'un ingredient pour un produit et un parametre donnes
	function rechercherIngredient($id_detail=0, $num_parametre=0, $nom='') {
		$id_detail = intval( $id_detail );
		if ($id_detail <= 0) $id_detail = 0;
		
		$requete = "SELECT * FROM ingredient";
		$requete .= " INNER JOIN detail_articles_detail_V2 ON detail_articles_detail_V2.id = ingredient.id_detail";
		$requete .= " WHERE id_detail_articles_V2 = " . $id_detail;
		$requete .= " AND detail_articles_detail_V2.num_parametre = " . $num_parametre;
		$requete .= " AND nom = '" . addslashes( $nom ) . "'";
		//echo $requete . "<br>";
		$result = mysql_query($requete);
		
		$data = mysql_fetch_assoc($result);
		return ( !empty($data) ) ? $this->load( $data[ "id_ingredient" ] ) : false;
	}
	
	// Retourne la liste de tous les ingrédients compris dans les articles d'une catégorie
	function getListeIngredientByCategorie( $id_cat=0 ) {
		$article = new article_produit();
		$article_complexe = new article_produit_complexe();
		$article_produit_complexe_detail = new article_produit_complexe_detail();
		$ingredient = new article_ingredient();
		
		$liste = $article->getListeArticleByNumCategorie( $_SESSION[ "maj" ][ "restaurant" ][ "maj_num_restaurant" ], $id_cat, '', true );
		
		$tableau_liste_ingredient = array();
		if ( !empty( $liste ) ) {
			foreach( $liste as $_article ) {
				//echo "--- #" . $_article->id . " : " . $_article->nom . "<br>";
				
				/*echo "<pre>";
				print_r( $_article );
				echo "</pre>";*/
				
				// Recuperation de la complexite d'un article
				$data_complexe = $article_complexe->getArticleComplexeByIDs( $_SESSION[ "maj" ][ "restaurant" ][ "maj_num_restaurant" ], $_article->id );
				$nb_parametre = ( intval( $data_complexe[ "nb_parametre" ] ) <= 0) ? 1 : intval( $data_complexe[ "nb_parametre" ] );
				
				// Affichage des differents paramètres
				for ($index_parametre=1; $index_parametre<=$nb_parametre; $index_parametre++) {
					
					// Chargement des détails de cet article AVEC ce paramètre
					if ( $article_produit_complexe_detail->loadByParametre( $data_complexe[ "id" ], $index_parametre ) ) {
						//echo "---- #" . $data_complexe[ "id" ] . "<br>";
						//echo "------ #" . $article_produit_complexe_detail->id . "<br>";
						
						// Liste des ingredients deja presents pour cet article et ce parametre
						$liste_ingredient = $ingredient->getListeIngredientByArticle( $data_complexe[ "id" ], 
							$index_parametre, 
							-1, 
							$article_produit_complexe_detail->id 
						);
						
						// Affichage des ingrédients
						//if ( mysql_num_rows( $liste_ingredient ) != 0 ) {
						//	while($data = mysql_fetch_assoc($liste_ingredient)) {
						//		//echo "------ #" . $data[ "id_ingredient" ] . " : " . $data[ "nom" ] . "<br>";
						//		
						//		
						//	}
						//}
						$tableau_liste_ingredient[] = $this->getTableau( $liste_ingredient );
					}
				}
			}
		}
		
		//echo "<pre>";
		//print_r( $tableau_liste_ingredient );
		//echo "</pre>";
		
		return $tableau_liste_ingredient;
	}
	
	// Retourne tous les ingredients d'un article complexe par num_parametre
	function getListeIngredientByArticle( $id_detail=0, $num_parametre=0, $limit=-1, $id_parametre=0, $debug=false ) {
		if ( $debug ) echo "--- id_detail : " . $id_detail . "<br>";
		if ( $debug ) echo "--- num_parametre : " . $num_parametre . "<br>";
		if ( $debug ) echo "--- limit : " . $limit . "<br>";
		if ( $debug ) echo "--- id_parametre : " . $id_parametre . "<br><br>";
		$article_produit_complexe_detail = new article_produit_complexe_detail();
		
		// Chargement du paramètre afin de déterminer l'ordre d'affichage
		//$article_produit_complexe_detail->load( $id_parametre );
		//echo "-->" . $id_parametre . "<br>";
		
		$id_detail = intval( $id_detail );
		if ($id_detail <= 0) $id_detail = 0;
		
		$requete = "SELECT * FROM ingredient";
		$requete .= " INNER JOIN detail_articles_detail_V2 ON detail_articles_detail_V2.id = ingredient.id_detail";
		$requete .= " WHERE id_detail_articles_V2 = " . $id_detail;
		
		if ( $num_parametre > 0 )
			$requete .= " AND detail_articles_detail_V2.num_parametre = " . $num_parametre;
		
		$requete .= " ORDER BY id_ingredient";
		//$requete .= ( $article_produit_complexe_detail->ordre_affichage == 'alpha' ) ? " ORDER BY nom" : " ORDER BY id_ingredient";
		
		if ( $limit >= 0 )
			$requete .= " LIMIT " . $limit . ", 1";
		
		if ( $debug ) echo $requete . "<br>\n";
		$liste = mysql_query($requete); 
		
		return $liste;
	}
	
	// Retourne tous les ingredients d'un article complexe par num_parametre
	function getListeIngredientByDetail( $id_detail=0, $debug=false ) {
		$id_detail = intval( $id_detail );
		if ($id_detail <= 0) $id_detail = 0;
		
		$article_produit_complexe_detail = new article_produit_complexe_detail();
		
		// Chargement du paramètre afin de déterminer l'ordre d'affichage
		//$article_produit_complexe_detail->load( $id_detail );
		
		$requete = "SELECT * FROM ingredient";
		$requete .= " WHERE id_detail = " . $id_detail;
		$requete .= " ORDER BY id_ingredient";
		//$requete .= ( $article_produit_complexe_detail->ordre_affichage == 'alpha' ) ? " ORDER BY nom" : " ORDER BY id_ingredient";
		if ( $debug ) echo $requete . "<br><br>";
		$liste = mysql_query($requete);
		
		return $liste;
	}
	
	// Retourne les composants d'un article complexe (Par rapport aux id_resto, id_cat, id_art)
	function getArticleComplexeByIDs($num_restaurant, $num_article) {
		$article = new article_produit();
		
		// Donnees sur le produit selectionne
		$data = $article->getArticle($num_article);
		
		if ($num_restaurant == '')
			$num_restaurant = $data[ "id_resto" ];
		
		$requete = "SELECT * FROM detail_articles";
		$requete .= " WHERE id_resto = " . $num_restaurant;
		$requete .= " AND id_cat = " . $data[ "id_cat" ];
		$requete .= " AND id_art = " . $data[ "id_art" ];
		//echo $requete . "<br>";
		$liste = mysql_query($requete);
		
		if (mysql_num_rows($liste) != 0)
			$data = mysql_fetch_assoc($liste);
		else
			$data = "";
		return $data;
	}
	
	private function getTableau( $liste ) {
		$temp = new article_ingredient();
		$tableau = array();
		
		if (mysql_num_rows($liste) != 0) {
			$i = 0;
			while($data = mysql_fetch_assoc($liste)) {
				//echo "ici : " . $data[ "num_supplement" ] . ", " . $data[ "num_produit" ] . "<br>";
				
				// Tentative de chargement du commande
				if ( $temp->load( $data[ "id_ingredient" ] ) ) {
					$tableau[$i] = new article_ingredient();
					
					$tableau[$i]->id_ingredient = $temp->id_ingredient;
					$tableau[$i]->id_detail = $temp->id_detail;
					$tableau[$i]->mode_fonctionnement = $temp->mode_fonctionnement;
					$tableau[$i]->nom = $temp->nom;
					$tableau[$i]->prix = $temp->prix;
					$tableau[$i]->prix_ae = $temp->prix_ae;
					$tableau[$i]->supplement = $temp->supplement;
					$tableau[$i]->defaut = $temp->defaut;
					
					// Infos sur l'article
					$tableau[$i]->type = $temp->supplement;
					
					$tableau[$i]->id = $data[ "type" ];
					
					$i++;
				}
			}
		}
		
		return $tableau;
	}
	
	function getListe( $tab=array(), $debug=false ) {
		$article_produit_complexe_detail = new article_produit_complexe_detail();
		
		$requete = "SELECT * FROM `ingredient`";
		$requete .= " WHERE id_ingredient > 0";
		
		if ( $tab[ "id_detail" ] > 0 ) {
			$article_produit_complexe_detail->load( $tab[ "id_detail" ] );
			$requete .= " AND id_detail = '" . $tab[ "id_detail" ] . "'";
			$requete .= ( $article_produit_complexe_detail->ordre_affichage == 'alpha' ) ? " ORDER BY nom" : " ORDER BY id_ingredient";
		}

		if ( $debug ) echo $requete . "<br>";
		$liste = mysql_query($requete);
		
		return $this->getTableau( $liste );
	}
	
	// Retourne les composants dont le nom est donne en parametre ,dans la categorie donnee et pour un resto donne
	function getListeIngredientByNom( $texte='', $id_resto=0, $id_cat=0, $id_art=0 ) {
		$requete = "SELECT ingredient.* FROM `detail_articles_V2`";
		$requete .= " INNER JOIN detail_articles_detail_V2 ON detail_articles_detail_V2.id_detail_articles_V2 = detail_articles_V2.id";
		$requete .= " INNER JOIN ingredient ON ingredient.id_detail = detail_articles_detail_V2.id";
		$requete .= " WHERE id_resto = '" . $id_resto . "'";
		$requete .= " AND id_cat = '" . $id_cat . "'";
		if ( $id_art > 0 ) $requete .= " AND id_art = '" . $id_art . "'";
		$requete .= " AND ingredient.nom LIKE '" . $texte . "'";
		//echo $requete . "<br>";
		$liste = mysql_query($requete);
		
		return $this->getTableau( $liste );
	}
	
	function traiterChamp($champ, $longueur) {
		$tableau_retour;
		$tab = split("\|", $champ);
		
		for ($i=0; $i<$longueur; $i++) {
		
		if ($i < count($tab))
			$tableau_retour[] = $tab[$i];
		else
			$tableau_retour[] = "";
		}
		
		return $tableau_retour;
	}
	
	// Modification depuis le mode "plan" des tarifs de certains articles
	function modifier_prix_ingredient( $post=array() ) {
		//echo "Dans modifier_prix_ingredient...<br>";
		
		$tab = split( ",", $post[ "tab_detail_article" ] );
		
		foreach( $tab as $num_ingredient ) {
			
			if ( $num_ingredient != "" ) {
				//echo "--> Modif de #" . $num_ingredient . " : Nouveau prix a " . $post[ "prix_" . $num_ingredient] . "<br>";
				
				// ---- Chargement de l'ingredient et mise a jour du prix
				if ( $this->load( $num_ingredient ) ) {
					$this->nom =		utf8_encode( $this->nom );
					$this->prix =		$post[ "prix_" . $num_ingredient ];
					$this->prix_ae = 	$post[ "prix_" . $num_ingredient ];
					$this->modifierIngredient( false );
				}
			}
		}
	}
	
	// ---- VERSION API MOBILE --------------------------------------------------------------------------------- //
	
	// Charge un ingredient d'un article complexe
	function AppliMobile_load( $id_ingredient=0, $debug=false ) {
		$id_ingredient = intval( $id_ingredient );
		if ($id_ingredient <= 0) return false;
		
		$requete = "SELECT * FROM ingredient";
		$requete .= " WHERE id_ingredient = '" . $id_ingredient . "'";
		if ( $debug ) echo $requete . "<br>";
		$result = mysql_query($requete);
		
		if (!$result) return false;
		
		$data = mysql_fetch_assoc($result);
		if (empty($data)) return false;
		
		$this->id_ingredient = $data[ "id_ingredient" ];
		$this->id_detail = $data[ "id_detail" ];
		$this->mode_fonctionnement = $data[ "mode_fonctionnement" ];
		$this->nom = $data[ "nom" ];
		$this->prix = $data[ "prix" ];
		$this->prix_ae = $data[ "prix_ae" ];
		$this->supplement = $data[ "supplement" ];
		
		return true;
	}
	
	// Charge la liste des ingredients
	function AppliMobile_getIngredients( $id_resto, $id_cat, $id_art, $num_parametre=1, $debug = false ) {
		
		 // je cherche le id dans detail_articles_V2
		 $requete = "SELECT * FROM detail_articles_V2";
		 $requete .= " WHERE id_resto = " . $id_resto;
		 $requete .= " AND id_cat = " . $id_cat;
		 $requete .= " AND id_art = " . $id_art;
		 if ( $debug ) echo $requete . "<br>";

		 $info = mysql_query($requete);
		
		 $data = mysql_fetch_assoc($info);
		 $id_detail_articles_V2 = $data[ "id" ];
		 
		 // je cherche le id dans detail_articles_detail_V2
		 $requete = "SELECT * FROM detail_articles_detail_V2";
		 $requete .= " WHERE id_detail_articles_V2 = " . $id_detail_articles_V2;
		 $requete .= " AND num_parametre = " . $num_parametre;
		 if ( $debug ) echo $requete . "<br>";

		 $info = mysql_query($requete);
		
		 $data = mysql_fetch_assoc($info);
		 $id_detail = $data[ "id" ];
		 
		 
		 // je recupere la liste des ingredients
		 $requete = "SELECT * FROM ingredient";
		 $requete .= " WHERE id_detail = " . $id_detail;
		 if ( $_GET[ "mode_fonctionnement" ] == 'L' ) $mode = "'1','2'";
		 if ( $_GET[ "mode_fonctionnement" ] == 'AE' ) $mode = "'1','3'";
		 $requete .= " ORDER BY nom ASC";
		 
		 if ( $debug ) echo $requete . "<br><br>";
		 $liste = mysql_query($requete);
		
		return $liste;
		
	}
	
	private function AppliMobile_getTableau( $liste ) {
		if ( mysql_num_rows( $liste ) != 0 ) {
			$i = 0;
			while( $data = mysql_fetch_assoc($liste) ) {
				$tableau[$i] = new article_ingredient();
					
				foreach( $data as $key => $val ) {
					$tableau[ $i ]->$key = $val;
				}
				
				$i++;
			}
		}
		
		//print_pre( $tableau );
		return $tableau;
	}
	
	function AppliMobile_getListe( $tab=array(), $debug=false ) {
		$requete = "SELECT * FROM `ingredient`";
		
		if ( $tab[ "where" ] == '' ) {
			$requete .= " WHERE id_ingredient > 0";
			
			if ( !empty( $tab ) ) {
				foreach( $tab as $champ => $val ) {
					if ( $champ != "order_by" && $champ != "sens" )
						$requete .= " AND " . $champ . " = '" . addslashes( $val ) . "'";
				}
			}
			
			$order_by = ( $tab[ "order_by" ] != "" ) ? $tab[ "order_by" ] : "id_ingredient";
			$sens = ( $tab[ "sens" ] != "" ) ? $tab[ "sens" ] : "ASC";
			$requete .= " ORDER BY " . $order_by . " " . $sens;
		}
		else $requete .= $tab[ "where" ];

		if ( $debug ) echo $requete . "<br>";
		$liste = mysql_query($requete);
		
		return $this->AppliMobile_getTableau( $liste );
	}
	
}
?>