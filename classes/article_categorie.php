<?
class article_categorie {
	
	// Ajoute une catégorie
	function ajouterCategorie($num_restaurant, $tableau) {
		$categorie = new article_categorie();
		
		// Dernier élément "id_cat"
		$dernier_id_cat = $categorie->getMaxiAffichageByIDcat($num_restaurant);
		
		// Dernier élément "ordre_affichage"
		$dernier_ordre_affichage = $categorie->getMaxiAffichage($num_restaurant);
		
		//echo "Statut : " . $tableau[ "statut" ] . "<br>";
		if ($tableau[ "statut" ] == "") $tableau[ "statut" ] = 0;
		
		$requete = "INSERT INTO categories(id_cat, id_resto, nom, texte_sup, texte_inf, statut, mode, ordre_affichage) VALUES(";
		$requete .= ($dernier_id_cat + 1) . ", " . $num_restaurant . ", ";
		$requete .= "'" . traiter_champ_texte( $tableau[ "nouveau_nom_categorie" ] ) . "', ";
		$requete .= "'" . traiter_champ_texte( $tableau[ "texte_sup" ] ) . "', '" . traiter_champ_texte( $tableau[ "texte_inf" ] ) . "',";
		$requete .= "'" . $tableau[ "statut" ] . "', '" . $tableau[ "mode" ] . "', " . ($dernier_ordre_affichage + 1) . ")";
		//echo "--- " . $requete . "<br>";
		mysql_query($requete);
		
		$num_categorie = mysql_insert_id();
		return $num_categorie;
	}
	
	// Modifie une catégorie
	function modifierCategorie($num_categorie, $tableau) {
		$requete = "UPDATE categories SET";
		$requete .= " nom = '" . traiter_champ_texte( $tableau[ "nouveau_nom_categorie" ] ) . "', ";
		$requete .= " texte_sup = '" . traiter_champ_texte( $tableau[ "texte_sup" ] ) . "', ";
		$requete .= " texte_inf = '" . traiter_champ_texte( $tableau[ "texte_inf" ] ) . "', ";
		$requete .= " statut = '" . $tableau[ "statut" ] . "',";
		$requete .= " mode = '" . $tableau[ "mode" ] . "'";
		$requete .= " WHERE id = " . $num_categorie;
		//echo $requete . "<br>";
		mysql_query($requete);
	}
	
	// Copie une catégorie
	function copierCategorie( $num_restaurant, $tableau, $debug=false ) {
		$categorie =		new article_categorie();
		$article = 			new article_produit();
		$liste_article = 	array();
		
		// ---- COPIE TOTALE (On copie toute la catégorie) -------------------------------- //
		if ( $tableau[ "methode_copie" ] == "totale" ) {
			if ( $debug ) echo "--- COPIE TOTALE<br>";
			$classement = 	( $tableau[ "num_categorie_finale" ] != "" ) ? "DESC" : "ASC";
			$liste = 		$article->getListeArticleByNumCategorie($tableau[ "num_restaurant" ], $tableau[ "num_categorie" ], $classement);
			
			if (mysql_num_rows($liste) != 0) {
				while($data = mysql_fetch_assoc($liste)) {
					$liste_article[] = $data;
				}
			}
		}
		
		// ---- COPIE PARTIELLE (On copie la liste des articles sélectionnés) ------------- //
		else {
			if ( $debug ) echo "--- COPIE PARTIELLE : " . $tableau[ "tab_article" ] . "<br>";
			$tab_article = explode( ";", $tableau[ "tab_article" ] );
			
			foreach($tab_article as $num_article) {
				if (intval($num_article) > 0)
					$liste_article[] = $article->getArticle(trim($num_article));
			}
		}
		
		if ( $debug ) print_pre( $liste_article );
		
		// ---- Création d'une nouvelle catégorie ----------------------------------------- //
		if ( $tableau[ "num_categorie_finale" ] == "" ) {
			if ( $debug ) echo "- Nouvelle catégorie<br>";
			
			// Informations sur la catégorie à copier
			$data = $categorie->getCategorieByIdCat($tableau[ "num_categorie" ], $tableau[ "num_restaurant" ]);
			$tab = array(
				'nouveau_nom_categorie' =>	utf8_encode( $data[ "nom" ] ),
				'statut' => 				$data[ "statut" ],
				'mode' => 					$data[ "mode" ]
			);
			
			$num_nouvelle_categorie = 		$categorie->ajouterCategorie($num_restaurant, $tab);
		}
		
		// ---- Enregistrement dans une catégorie déjà existante -------------------------- //
		else {
			if ( $debug ) echo "- Catégorie déjà existante (#" . $tableau[ "num_categorie_finale" ] . ")<br>";
			$num_nouvelle_categorie = 		$tableau[ "num_categorie_finale" ];
		}
		
		// ---- Informations sur la nouvelle catégorie ------------------------------------ //
		$data_categorie = $categorie->getCategorie( $num_nouvelle_categorie );
		
		// ---- On crée les articles pour cette nouvelle catégorie ------------------------ //
		foreach( $liste_article as $detail_article ) {
			//echo "num_restaurant : " . $num_restaurant . " ; ";
			//echo "num_categorie : " . $num_nouvelle_categorie . " ; ";
			//echo "num_article : " . $detail_article[ "id" ] . "<br>";
			
			$article->copierArticle( 
				$num_restaurant, 
				$num_nouvelle_categorie, 
				$detail_article[ "id" ], 
				$tableau,
				$debug 
			);
			$indice++;
		}
	}
	
	// Supprime une catégorie
	function supprimerCategorie( $num_restaurant, $num_categorie, $suppr_cat = true ) {
		$categorie = 	new article_categorie();
		$article = 		new article_produit();
		
		// ---- Informations sur la catégorie --------------------------------------------- //
		$data = 		$categorie->getCategorie( $num_categorie );
		
		// ---- Liste de tous les articles à supprimer ------------------------------------ //
		$liste = 		$article->getListeArticleByNumCategorie( $num_restaurant, $data[ "id_cat" ] );
		
		// ---- Pour tous les enregistrements trouvés, on les supprime -------------------- //
		if ( $liste != "" ) {
			
			if ( mysql_num_rows( $liste ) != 0 ) {
				while( $data_article = mysql_fetch_assoc( $liste ) ) {
					$article->supprimerArticle( $data_article[ "id" ] );
				}	
			}
		}
		
		// ---- On souhaite suprimer la catégorie ----------------------------------------- //
		if ( $suppr_cat ) {
			
			// ---- Liste des catégories dont l'ordre_affichage est supérieur ------------- //
			$requete = 		"SELECT * FROM categories";
			$requete .= 	" WHERE ordre_affichage > " . $data[ "ordre_affichage" ];
			$requete .= 	" AND id_resto = " . $num_restaurant;
			//echo $requete . "<br>";
			$liste = 		mysql_query( $requete );
			
			// ---- On déplace ------------------------------------------------------------ //
			if ( mysql_num_rows( $liste ) != 0 ) {
				while( $data = mysql_fetch_assoc( $liste ) ) {
					$requete = 	"UPDATE categories SET";
					$requete .= " ordre_affichage = (ordre_affichage-1)";
					$requete .= " WHERE id = " . $data[ "id" ];
					//echo $requete . "<br>";
					mysql_query($requete);
				}
			}
			
			// ---- Suppression de l'enregistrement --------------------------------------- //
			$requete = 	"DELETE FROM categories WHERE id = " . $num_categorie;
			//echo "--> " . $requete . "<br>";
			mysql_query($requete);
		}
		// -------------------------------------------------------------------------------- //
	}
	
	// Retourne la liste complète des catégories
	function getListeCategorie() {
		$requete = "SELECT * FROM categories";
		$requete .= " ORDER BY nom";
		//echo $requete . "<br><br>";
		$liste = mysql_query($requete);
		
		return $liste;
	}
	
	// Lister les liens URLRewrites d'un restaurant
	function getLinkCategorieByNumRestaurant($num_restaurant, $idv) {
		  
		$debug = false;
		if ( $debug ) echo "idv = " . $idv . "<br>";
        $requete="SELECT * FROM `metas` WHERE id_resto=" . $num_restaurant;
        $info = mysql_query($requete); 
        $data = mysql_fetch_assoc($info);
        
        $NomResto = $data[NomResto];
        $NomResto=str_replace("'","",$NomResto);
        $meta = $data[NomResto];
        $meta=strtolower($meta);
        $meta=str_replace("Ê","e",$meta);
        $meta=str_replace("Ô","o",$meta);
        $meta=str_replace("d'","d-",$meta);
        $meta=str_replace("l'","l-",$meta);
        $meta=str_replace("' ","-",$meta);
        $meta=str_replace(" '","-",$meta);
        $meta=str_replace("'","-",$meta);
        $meta=str_replace(" ","-",$meta);
        $meta=str_replace(" ","-",$meta);
        $meta=str_replace("--","-",$meta);
        if (substr($meta, -1) == "-") $meta = substr($meta, 0, -1);
        if ( $debug ) echo "meta=".$meta."<br>";

        
        $requete="SELECT * FROM `villes` WHERE id=" . $idv ." AND actif='1' AND meta<>''";
        if ( $debug ) echo $requete . "<br />";
        $info = mysql_query($requete);
        $NomQuartier=array(); $i=1;
        WHILE ($Ligne = mysql_fetch_array($info)) {
          $NomQuartier[$Ligne[id]][id_ville]=$Ligne[id];
          $NomQuartier[$Ligne[id]][meta]=$Ligne[meta];
          if ( $debug ) echo "NomQuartier[Ligne[id]][id_ville] | NomQuartier[Ligne[id]][meta] = " . $NomQuartier[$Ligne[id]][id_ville]."|".$NomQuartier[$Ligne[id]][meta] . "<br>";
          $NomQuartierAE = $NomQuartier[$Ligne[id]][meta]; 
          $i = $Ligne[id];
        }
        $max_id_quartier = $i;
        
        $requete="SELECT * FROM `zone_livraison` WHERE id_resto=" . $num_restaurant ." AND id_ville=" . $idv . " AND actif='1' ORDER BY id ASC, id_ville ASC";
        if ( $debug ) echo $requete . "<br />";
        $info = mysql_query($requete);
        $zone=array(); $i=1;
        WHILE ($Ligne = mysql_fetch_array($info)) {
        $zone[$i][$Ligne[id_ville]][id_ville]=$Ligne[id_ville];
        $zone[$i][$Ligne[id_ville]][id_resto]=$Ligne[id_resto];
        $i++;
        }
        $max_id_zone = $i-1;
        if ( $_SESSION[ "site" ][ "fonctionnement" ]=='emporter' ) $max_id_zone = 1;

        $requete="SELECT * FROM `categories`";
        $requete .= " WHERE id_resto=" . $num_restaurant;
        $requete .= " AND statut='1'";
        
        // Mode "LIVRAISON" ou "A EMPORTER"
        $requete .= ( $_SESSION[ "site" ][ "fonctionnement" ] == "livraison" ) ? " AND (mode='2' OR  mode='1')" : " AND (mode='3' OR  mode='1')";
        
        $requete .= " ORDER BY ordre_affichage ASC";
        if ( $debug ) echo $requete . "<br />";
        
        $info = mysql_query($requete);
        $categorie = array(); $i=1;
        $categorieAE = array();
        
        function suppr_accents($chaine) {
	        $accents = array(' -- ',' - ','œ','Œ','.',' ','(',')','À','Á','Â','Ã','Ä','Å','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ò','Ó','Ô','Õ','Ö','Ù','Ú','Û','Ü','Ý','à','á','â','ã','ä','å','ç','è','é','ê','ë','ì','í','î','ï','ð','ò','ó','ô','õ','ö','ù','ú','û','ü','ý','ÿ');
	        $sans = array('-','-','oe','oe','-','-','','','A','A','A','A','A','A','C','E','E','E','E','I','I','I','I','O','O','O','O','O','U','U','U','U','Y','a','a','a','a','a','a','c','e','e','e','e','i','i','i','i','o','o','o','o','o','o','u','u','u','u','y','y');
	        return str_replace($accents, $sans, $chaine);
        }
        
        if ( $debug ) echo "<br>";
        WHILE ( $Ligne = mysql_fetch_array( $info ) ) {
			$data = utf8_encode( stripslashes( $Ligne[nom] ) );
			//$data = htmlspecialchars( $Ligne[nom] );
			if ( $debug ) echo "---- databrut=" . $data . "---<br>";
			
			$categorie[$Ligne[id_resto]][$i][nombrut]=$data;
			$categorieAE[$i][nombrut] = $data;
			
			$data = str_replace( "&euro;", "euros", $Ligne[nom] );
			//echo "------ dataaccents = ".$data."<br>";
			
			$data = suppr_accents( utf8_encode( $data ) );
			//echo "------ dataaccents = ".$data."<br>";
			
			$data = stripslashes($data);
			//echo "------ dataantislashes = ".$data."<br>";
			
			$data = str_replace("'", "-", $data);
			$data = str_replace("&", "et", $data);
			//echo "------ dataantiapostrophe = ".$data."<br>";
			
			$data=strtolower($data);
			$data=str_replace("--","-",$data);
			
			$categorie[$Ligne[id_resto]][$i][nom]=$data;
			$categorieAE[$i][nom] = $data;
			
			$categorie[$Ligne[id_resto]][$i][id_cat]=$Ligne[id];
			$categorieAE[$i][id_cat] = $Ligne[id];
			if ( $debug ) echo "categorieAE[ " . $i . " ][nom] = " . $categorieAE[$i][nom] . "<br />";
			if ( $debug ) echo "categorieAE[ " . $i . " ][nombrut] = " . $categorieAE[$i][nombrut] . "<br />";
			$i++;
        }
        
        $max_id_cat = $i-1;
        if ( $debug ) echo "max_id_cat = " . $max_id_cat . "<br />";
        
        $links = '';
        //if ($_SESSION[ "site" ][ "fonctionnement" ]=='livraison') $linkmode = 'restaurant-livraison'; else $linkmode = 'restaurant-plats-a-emporter';
        $linkmode = ($_SESSION[ "site" ][ "fonctionnement" ]=='livraison') ? 'livraison' : 'plats-a-emporter';
        
        // --------- je monte les categories pour le AE ----------------------------------------------------------------------------------------------------------
        if ( $_SESSION[ "site" ][ "fonctionnement" ]=='emporter' ) {
        	if ( $debug ) echo "--------- A EMPORTER ---------<br>";
        	 $w = 0;
        	 FOR ($k=1;$k<=$max_id_cat;$k++) {
				if ( $debug ) echo "<hr>k=".$k."<br>";	
				if ($w>0) {$separateur="|";} else {$separateur="";}
        	     
				if ( $debug ) {
					echo "linkmode = " . $linkmode . "<br>";
					echo "NomQuartierAE = " . $NomQuartierAE . "<br>";
					echo "meta = " . $meta . "<br>";
					echo "categorieAE[ " . $k . " ][nom] = " . $categorieAE[$k][nom] . "<br>";
					echo "categorieAE[ " . $k . " ][nombrut] = " . $categorieAE[$k][nombrut] . "<br>";
				}
        	     
				//$links .= $separateur.$NomQuartier[$i][meta]."/".$meta."/".$categorie[$zone[$j][$i][id_resto]][$k][nom];
$links .= $separateur . "<a href='https://";
$links .= $_SERVER['HTTP_HOST'] . "/restaurant/" . $NomQuartierAE . "/" . $meta . "/" . $categorieAE[$k][nom];
$links .= "/" . $linkmode . "/" . $idv . "/0/" . $num_restaurant . "/" . $categorieAE[$k][id_cat] . "/page.htm'";
$links .= " title='" . $NomResto . " : " . $categorieAE[$k][nombrut] . "'>" . $categorieAE[$k][nombrut] . "</a>";
if ( $debug ) echo "links = " . $links . "<br>";
                     
               $w++;
               }
           }
        else {
        	if ( $debug ) echo "--------- LIVRAISON ---------<br>";
	        // ----------- je monte les categories pour la livraison --------------------------------------------------------------------------------------------------
	        FOR ($i=1;$i<=$max_id_quartier;$i++)
            {
            //echo "<font size=+2 color=red>ETUDE DU <b>QUARTIER N°".$i."</b></font><hr>";
            if ($NomQuartier[$i][meta]<>'')
               {
               //echo "Je regarde qui livre sur <b>" . $NomQuartier[$i][meta] . "</b><br>";
               FOR ($j=1;$j<=$max_id_zone;$j++)
                   {
                   if ($zone[$j][$i][id_resto]<>'')
                      {
                      //echo "le resto #".$zone[$j][$i][id_resto]."(".$meta.") y livre, voici ces catégories disponibles :<br>";
                      $w=0;
                      FOR ($k=1;$k<=$max_id_cat;$k++)
                          {
                          if ($categorie[$zone[$j][$i][id_resto]][$k][nom]<>'')
                             {
                             if ($w>0) {$separateur="|";} else {$separateur="";}
                             //$links .= $separateur.$NomQuartier[$i][meta]."/".$meta."/".$categorie[$zone[$j][$i][id_resto]][$k][nom];
//$links .= $_SERVER['HTTP_HOST'] . "/" . $linkmode . "/" . $NomQuartierAE . "/" . $meta . "/" . $categorieAE[$k][nom];
//$links .= "/" . $idv . "/0/" . $k . "/" . $categorieAE[$k][id_cat] . "/page.htm'";
//$links .= " title='" . $NomResto . " : " . $categorieAE[$k][nombrut] . "'>" . $categorieAE[$k][nombrut] . "</a>";

$links .= $separateur . "<a href='https://";
$links .= $_SERVER['HTTP_HOST'] . "/restaurant/" . $NomQuartier[$i][meta] . "/" . $meta . "/" . $categorie[$zone[$j][$i][id_resto]][$k][nom];
$links .= "/" . $linkmode . "/" . $idv . "/0/" . $num_restaurant . "/" . $categorie[$zone[$j][$i][id_resto]][$k][id_cat] . "/page.htm'";
$links .= " title='" . $NomResto . " : " . utf8_encode( $categorie[$zone[$j][$i][id_resto]][$k][nombrut] ) . "'>" . $categorie[$zone[$j][$i][id_resto]][$k][nombrut] . "</a>";
                             //if ( $debug ) echo "--->" . htmlentities($links) . "<br />";
                             if ( $debug ) echo "--->" . ($links) . "<br />";
                             //echo $NomQuartier[$i][meta]."/".$meta."/".$categorie[$zone[$j][$i][id_resto]][$k][nom]."<br>";
                             //echo "<b>".$categorie[$zone[$j][$i][id_resto]][$k][nom]."</b><br>";
                             $w++;
                             }
                          }
                      }
                   }
               }
            }
        }    
        //echo "links=".$links."<br>";

        return $links;
    }

	// Lister les catégories d'articles
	function getListeCategorieByNumRestaurant($num_restaurant, $statut=-1) {
		$requete = "SELECT * FROM categories";
		$requete .= " WHERE id_resto = " . $num_restaurant;
		
		if ( $statut != -1 )
			$requete .= " AND statut = '" . $statut . "'";
		
		$requete .= " ORDER BY ordre_affichage";
		//echo $requete . "<br><br>";
		$liste = mysql_query($requete);
		
		return $liste;
	}
	
	// Lister les catégories d'articles CACHÉES d'un restaurant
	function getListeCategorieCacheByNumRestaurant($num_restaurant) {
		$requete = "SELECT * FROM categories";
		$requete .= " WHERE id_resto = " . $num_restaurant;
		$requete .= " AND statut = '2'";
		$requete .= " ORDER BY ordre_affichage";
		//echo $requete . "<br><br>";
		$liste = mysql_query($requete);
		
		return $liste;
	}

  // retourne le id de la 1ere categorie du resto
	function getFirstCategorie($id_resto) {
		$requete = "SELECT * FROM categories";
		$requete .= " WHERE id_resto = " . $id_resto;
		$requete .= " AND statut = '1'";
		
		// Mode "LIVRAISON" ou "A EMPORTER"
		$requete .= ( $_SESSION[ "site" ][ "fonctionnement" ] == "livraison" ) ? " AND (mode='2' OR  mode='1')" : " AND (mode='3' OR  mode='1')";
		
		$requete .= " ORDER BY ordre_affichage ASC";
		$requete .= " LIMIT 0,1";
		//echo $requete . "<br><br>";
		$liste = mysql_query($requete);
		
		if (mysql_num_rows($liste) != 0)
			$data = mysql_fetch_assoc($liste);
		else
			$data = "";
		return $data[ "id" ];
	}
	
	// Retourne les composants d'une catégorie de fichiers
	function getCategorie($num_categorie) {
		$requete = "SELECT * FROM categories";
		$requete .= " WHERE id = " . $num_categorie;
		//echo $requete . "<br><br>";
		$liste = mysql_query($requete);
		
		if (mysql_num_rows($liste) != 0)
			$data = mysql_fetch_assoc($liste);
		else
			$data = "";
		return $data;
	}

	function getNomCategorie($num_categorie) {
		$requete = "SELECT * FROM categories";
		$requete .= " WHERE id = " . $num_categorie;
		//echo $requete . "<br><br>";
		$liste = mysql_query($requete);
		
		if (mysql_num_rows($liste) != 0)
			$data = mysql_fetch_assoc($liste);
		else
			$data = "";
		return $data[ "nom" ];
	}
	
	function getImageCategorie($num_categorie) {
		$requete = "SELECT * FROM categories";
		$requete .= " WHERE id = " . $num_categorie;
		//echo $requete . "<br><br>";
		$liste = mysql_query($requete);
		
		if (mysql_num_rows($liste) != 0)
			$data = mysql_fetch_assoc($liste);
		else
			$data = "";
		return $data[ "image" ];
	}

	// Retourne les composants d'une catégorie de fichiers
	function getCategorieByIdCat($num_categorie, $num_restaurant) {
		$requete = "SELECT * FROM categories";
		$requete .= " WHERE id_cat = " . $num_categorie;
		$requete .= " AND id_resto = " . $num_restaurant;
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
			$nombre_fichier = $data[ "total" ];
		}
		
		return $nombre_fichier;
	}
	
	function getMaxiAffichage($num_restaurant) {
		// Ordre maxi d'affichage
		$requete = "SELECT MAX(ordre_affichage) AS maxi FROM categories";
		$requete .= " WHERE id_resto = " . $num_restaurant;
		//echo $requete . "<br>";
		$ordre = mysql_query($requete);
		
		$data_count = mysql_fetch_assoc($ordre);
		$maxi = $data_count[ "maxi" ];
		
		return $maxi;
	}
	
	function getMaxiAffichageByIDcat($num_restaurant) {
		// Ordre maxi d'affichage
		//$requete = "SELECT MAX(ordre_affichage) AS maxi FROM categories";
		$requete = "SELECT MAX(id_cat) AS maxi FROM categories";
		$requete .= " WHERE id_resto = " . $num_restaurant;
		//echo $requete . "<br>";
		$ordre = mysql_query($requete);
		
		$data_count = mysql_fetch_assoc($ordre);
		$maxi = $data_count[ "maxi" ];
		
		return $maxi;
	}
	
	// Active / Désactive une catégorie
	function actionner($num_categorie, $actif) {
		$requete = "UPDATE categories SET";
		$requete .= " statut = '" . $actif . "'";
		$requete .= " WHERE id = " . $num_categorie;
		//echo $requete . "<br><br>";
		mysql_query($requete);
	}
	
	// Fait monter dans la liste la catégorie spécifiée
	function setPositionSuperieure($id_changement) {
		$categorie = new article_categorie();
		
		// Informations sur la catégorie
		$data = $categorie->getCategorie($id_changement);
		$ordre_affichage = $data[ "ordre_affichage" ];
		//echo "--> Ordre affichage : " . $ordre_affichage . "<br>";
		
		// On ne peut effectuer l'opération QUE si on n'a pas atteint la limite mini
		if ($ordre_affichage > 1) {
			// Catégorie située avant la catégorie sélectionnée
			$requete = "SELECT id, ordre_affichage FROM categories";
			$requete .= " WHERE ordre_affichage < " . $ordre_affichage;
			$requete .= " AND id_resto = " . $data[ "id_resto" ];
			$requete .= " ORDER BY ordre_affichage DESC";
			$requete .= " LIMIT 1";
			//echo "+++ " . $requete . "<br>";
			$liste_mouvement = mysql_query($requete);
			$data = mysql_fetch_assoc($liste_mouvement);
			
			// MAJ de la base
			$requete = "UPDATE categories SET";
			$requete .= " ordre_affichage = " . $ordre_affichage;
			$requete .= " WHERE id = " . $data[ "id" ];
			//echo "+++ " . $requete . "<br>";
			mysql_query($requete);
			
			$requete = "UPDATE categories SET";
			$requete .= " ordre_affichage = " . $data[ "ordre_affichage" ];
			$requete .= " WHERE id = " . $id_changement;
			//echo "+++ " . $requete . "<br>";
			mysql_query($requete);
		}
	}
	
	// Fait descendre dans la liste la catégorie spécifiée
	function setPositionInferieure($num_restaurant, $id_changement) {
		$categorie = new article_categorie();
		
		// Nombre total d'enregistrements pour la rubrique en cours
		$total = $categorie->getNombreCategoriePourRestaurant($num_restaurant);
		//echo "--> Total : " . $total . "<br>";
		
		// Informations sur la catégorie
		$data = $categorie->getCategorie($id_changement);
		$ordre_affichage = $data[ "ordre_affichage" ];
		//echo "--> Ordre affichage : " . $ordre_affichage . "<br>";
		
		// On ne peut effectuer l'opération QUE si on n'a pas atteint la limite maxi
		if ($ordre_affichage < $total) {
		
			// Catégorie située après la catégorie sélectionnée
			$requete = "SELECT id, ordre_affichage FROM categories";
			$requete .= " WHERE ordre_affichage > " . $ordre_affichage;
			$requete .= " AND id_resto = " . $num_restaurant;
			$requete .= " ORDER BY ordre_affichage";
			$requete .= " LIMIT 1";
			//echo "--- " . $requete . "<br>";
			$liste_mouvement = mysql_query($requete);
			$data = mysql_fetch_assoc($liste_mouvement);
			
			// MAJ de la base
			$requete = "UPDATE categories SET";
			$requete .= " ordre_affichage = " . $ordre_affichage;
			$requete .= " WHERE id = " . $data[ "id" ];
			//echo "--- " . $requete . "<br>";
			mysql_query($requete);
			
			$requete = "UPDATE categories SET";
			$requete .= " ordre_affichage = " . $data[ "ordre_affichage" ];
			$requete .= " WHERE id = " . $id_changement;
			//echo "--- " . $requete . "<br>";
			mysql_query($requete);
		}
	}
	
	// Retourne le nombre de catégories pour un restaurant donné
	function getNombreCategoriePourRestaurant($num_restaurant) {
		$requete = "SELECT COUNT(id) AS total FROM categories";
		$requete .= " WHERE id_resto = " . $num_restaurant;
		//echo $requete . "<br>";
		$info = mysql_query($requete);
			
		$data = mysql_fetch_assoc($info);
		$total = $data[ "total" ];
		
		return $total;
	}
	
	
	// --------------- Nouvelle gestion (partielle) --------------- //
	var $id = 0;
	var $id_cat = 0;
	var $id_resto = 0;
	var $nom = '';
	var $texte_sup = '';
	var $texte_inf = '';
	var $statut = '0';
	var $mode = '1';
	var $ordre_affichage = 0;
	var $image = "";
	
	// Charge
	function load( $id=0, $debug=false ) {
		$id = intval($id);
		if ($id <= 0) return false;
		
		$requete = "SELECT * FROM categories";
		$requete .= " WHERE id = '" . $id . "'";
		if ( $debug ) echo $requete . "<br>\n";
		$result = mysql_query($requete);
		
		if (!$result) return false;
		
		$data = mysql_fetch_assoc($result);
		if (empty($data)) return false;
		
		$this->id = $data[ "id" ];
		$this->id_cat = $data[ "id_cat" ];
		$this->id_resto = $data[ "id_resto" ];
		$this->nom = $data[ "nom" ];
		$this->texte_sup = $data[ "texte_sup" ];
		$this->texte_inf = $data[ "texte_inf" ];
		$this->statut = $data[ "statut" ];
		$this->mode = $data[ "mode" ];
		$this->ordre_affichage = $data[ "ordre_affichage" ];
		$this->image = $data[ "image" ];
		
		return true;
	}
	
	function loadByIDCategorie( $id_cat=0, $id_resto=0, $debug=false ) {
		$id_cat = intval( $id_cat );
		$id_resto = intval( $id_resto );
		if ( $id_cat <= 0 || $id_resto <= 0 ) return false;
		
		$requete = "SELECT * FROM categories";
		$requete .= " WHERE id_cat = '" . $id_cat . "'";
		$requete .= " AND id_resto = '" . $id_resto . "'";
		if ( $debug ) echo $requete . "<br>\n";
		$result = mysql_query($requete);
		
		if (!$result) return false;
		
		$data = mysql_fetch_assoc($result);
		if (empty($data)) return false;
		
		return $this->load( $data[ "id" ], $debug );
	}
	
	// Charge
	function loadByNom( $id_resto=0, $nom='' ) {
		$id_resto = intval( $id_resto );
		if ($id_resto <= 0) return false;
		
		$requete = "SELECT * FROM categories";
		$requete .= " WHERE id_resto = '" . $id_resto . "'";
		$requete .= " AND nom = '" . addslashes($nom) . "'";
		//echo $requete . "<br>";
		$result = mysql_query($requete);
		
		if (!$result) return false;
		
		$data = mysql_fetch_assoc($result);
		if (empty($data)) return false;
		
		return $this->load( $data[ "id" ] );
	}
	
	// Ajoute...
	private function ajouter( $debug=false ) {
		$requete = "INSERT INTO categories( id_cat, id_resto, nom, texte_sup, texte_inf,";
		$requete .= " statut, mode, ordre_affichage, image";
		$requete .= " ) VALUES(";
		$requete .= "'" . $this->id_cat . "', '" . $this->id_resto . "', '" . $this->nom . "', '" . $this->texte_sup . "', '" . $this->texte_inf . "', ";
		$requete .= "'" . $this->statut . "', '" . $this->mode . "', '" . $this->ordre_affichage . "', '" . $this->image . "'";
		$requete .= ")";
		if ( $debug ) echo $requete . "<br>\n";
		if ( !$debug ) $result = mysql_query($requete);
		
		return ( $result ) ? mysql_insert_id() : false;
	}
	
	// Modifie...
	private function modifier( $debug=false ) {
		$requete = "UPDATE categories SET";
		$requete .= " id_cat = '" . $this->id_cat . "',";
		$requete .= " id_resto = '" . $this->id_resto . "',";
		$requete .= " nom = '" . $this->nom . "',";
		$requete .= " texte_sup = '" . $this->texte_sup . "',";
		$requete .= " texte_inf = '" . $this->texte_inf . "',";
		$requete .= " statut = '" . $this->statut . "',";
		$requete .= " mode = '" . $this->mode . "',";
		$requete .= " ordre_affichage = '" . $this->ordre_affichage . "',";
		$requete .= " image = '" . $this->image . "'";
		$requete .= " WHERE id = " . $this->id;
		if ( $debug ) echo $requete . "<br>";
		if ( !$debug ) $result = mysql_query($requete);
		
		return ( $result ) ? $this->num_domaine : false;
	}
	
	// Interface entre le formulaire et la base
	function gererDonnee( $post=array(), $debug=false ) {
		//print_pre( $post );
		
		// Tentative de chargement de la catégorie
		$modification = $this->load( intval( $post[ "id" ] ) );
		
		$this->id_cat = intval( $post[ "id_cat" ] );
		$this->id_resto = intval( $post[ "id_resto" ] );
		$this->nom = $this->traiter_champ( $post[ "nom" ] );
		$this->texte_sup = $this->traiter_champ( $post[ "texte_sup" ] );
		$this->texte_inf = $this->traiter_champ( $post[ "texte_inf" ] );
		$this->statut = $post[ "statut" ];
		$this->mode = $post[ "mode" ];
		$this->ordre_affichage = intval( $post[ "ordre_affichage" ] );
		$this->image = $this->traiter_champ( $post[ "image" ] );
		
		// Ajout
		return ( !$modification )
			? $this->ajouter( $debug )
			: $this->modifier( $debug );
	}
	
	function setChamp( $champ, $valeur=0, $debug=false ) {
		$requete = "UPDATE categories SET";
		$requete .= " " . $champ . " = '" . $this->traiter_champ( $valeur ) . "'";
		$requete .= " WHERE id = " . $this->id;
		if ( $debug ) echo $requete . "<br>";
		if ( !$debug ) $result = mysql_query($requete);
		
		return ( $result ) ? $this->id : false;
	}
	
	function traiter_champ($texte='') {
		$texte = str_replace("\"", "", $texte);
		//$texte = utf8_decode( $texte );
		$texte = addslashes( $texte );
		
		return $texte;
	}
	
	private function getTableau( $liste ) {
		$tableau = array();
		
		if (mysql_num_rows($liste) != 0) {
			$i = 0;
			while( $data = mysql_fetch_assoc( $liste ) ) {
					$tableau[ $i ] = new article_categorie();
						
					foreach( $data as $key => $val ) {
						$tableau[ $i ]->$key = $val;
					}
					
					$i++;
				}
		}
		
		return $tableau;
	}
	
	// Retourne la liste des categories
	function getListe( $id= '', $id_resto='', $nom='', $tab=array(), $debug=false ) {
		$requete = "SELECT * FROM categories";
		$requete .= " WHERE id > 0";
		
		if ( $id != '' ) $requete .= " AND id = '" . $id . "'"; 
		if ( $id_resto != '' ) $requete .= " AND id_resto = '" . $id_resto . "'"; 
		if ( $nom != '' ) $requete .= " AND nom = '" . $nom . "'";
		if ( !empty( $tab[ "mode" ] ) ) {
			$fin_requete = "";
			foreach( $tab[ "mode" ] as $_mode ) {
				$fin_requete .= ( $fin_requete == "" ) ? " mode = '" . $_mode . "'" : " OR mode = '" . $_mode . "'";
			}
			$requete .= " AND ( " . $fin_requete . " )";
		}
		if ( $tab[ "statut" ] != '' ) $requete .= " AND statut IN (" . $tab[ "statut" ] . ")"; 
		
		$requete .= ( $tab[ "order_by" ] != '' ) ? " ORDER BY " . $tab[ "order_by" ] : " ORDER BY id";
		if ( $debug ) echo $requete . "<br>";
		$liste = mysql_query($requete);
		
		return $this->getTableau( $liste );
	}
	
	// Retourne la liste...
	function getListeV2( $tab=array(), $debug=false ) {
		$champ_souhaite = ( $tab[ "champ" ] != '' ) ? $tab[ "champ" ] : "*";
		$requete = "SELECT " . $champ_souhaite . " FROM categories";
		
		if ( !isset( $tab[ "where" ] ) ) {
			$requete .= " WHERE id > 0";
			
			if ( !empty( $tab ) ) {
				foreach( $tab as $champ => $val ) {
					if ( $champ != "direct" && $champ != "champ" && $champ != "order_by" && $champ != "sens" )
						$requete .= " AND " . $champ . " = '" . addslashes( $val ) . "'";
				}
			}
			
			$order_by = ( $tab[ "order_by" ] != "" ) ? $tab[ "order_by" ] : "id";
			$sens = ( $tab[ "sens" ] != "" ) ? $tab[ "sens" ] : "ASC";
			$requete .= " ORDER BY " . $order_by . " " . $sens;
		}
		else $requete .= $tab[ "where" ];
		
		if ( $debug ) echo $requete . "<br>";
		$liste = mysql_query($requete);
		
		return $this->getTableau( $liste );
	}
	
	// Retourne un lien vers la catégorie
	function getLink( $tab=array(), $tooltip=false, $target='', $debug=false ) {
		$article = new article_produit();
		
		// Version V1
		/*$lien = "<a href=\"@@link@@\" title='@@title@@'>@@texte@@</a>";
		$texte = utf8_encode( $tab[ "nom_categorie" ] );
		$lien = str_replace( "@@texte@@", $texte, $lien );
		
		$title = strtoupper( utf8_encode( $tab[ "nom_restaurant" ] ) ) . " : " . utf8_encode( $tab[ "nom_categorie" ] );
		$lien = str_replace( "@@title@@", $title, $lien );
		
		// Lien du type "restaurant/strasbourg-conseil-des-xv/md30-pizza/salades/livraison/4/0/2/30/page.htm"
		$nom_resto_meta = tranformer_url( $tab[ "nom_restaurant" ], 'utf-8', false );
		$categorie_meta = tranformer_url( suppr_accents( $tab[ "nom_categorie" ] ), 'utf-8', false );
		$link = ( $tab[ "fonctionnement" ] == 'l' )
			? "/restaurant/" . $tab[ "meta_ville" ] . "/" . $nom_resto_meta . "/" . $categorie_meta . "/livraison/" . $tab[ "num_ville" ] . "/0/" . $tab[ "num_restaurant" ] . "/" . $tab[ "num_categorie" ] . "/page.htm"
			: "/restaurant/" . $tab[ "meta_ville" ] . "/" . $nom_resto_meta . "/" . $categorie_meta . "/plats-a-emporter/" . $tab[ "num_ville" ] . "/0/" . $tab[ "num_restaurant" ] . "/" . $tab[ "num_categorie" ] . "/page.htm";
		$lien = str_replace( "@@link@@", $link, $lien );*/
		
		
		// Template du lien
		if ( $tooltip ) {
			$lien = "<a href=\"@@link@@\" @@target@@ class=\"lien-categorie\" title=\"<div id='tooltip-paiement'>
	                    <h3>@@title@@</h3>
	                    <ul>\n@@article@@</ul>
	                </div>\">@@texte@@</a>";
		}
		
		else {
			$lien = "<a href=\"@@link@@\" @@target@@ title='@@title@@'>@@texte@@</a>";
		}
		
		// Liste des articles composant cette catégorie
		unset( $recherche );
		$recherche[ "id_cat" ] = $tab[ "id_cat" ];
		$recherche[ "id_resto" ] = $_SESSION[ "site" ][ "num_restaurant" ];
		$recherche[ "fonctionnement" ] = $_SESSION[ "site" ][ "fonctionnement" ];
		$liste_article = $article->getListe( $recherche, false );
		
		$liste = "";
		if ( !empty( $liste_article ) ) {
			foreach( $liste_article as $_article ) {
				// Article disponible ou pas?
				$article_dispo = ( $_article->visible == '1' ) ? "" : " (<span style='color:#DF1818;'>non dispo</span>)";
				
				$NomArticle = utf8_encode( strtolower( $_article->nom ) );
				$NomArticle = str_replace( "pizza ", "", $NomArticle );
				$NomArticle = str_replace( "#", "", $NomArticle );
				$NomArticle = str_replace( "\"", "''", $NomArticle );
				$liste .= "<li>" . $NomArticle . $article_dispo . "</li>\n";
			}
		}
		$lien = str_replace( "@@article@@", $liste, $lien );
		
		$texte = utf8_encode( $tab[ "nom_categorie" ] );
		$texte = str_replace( "\"", "''", $texte );
		$lien = str_replace( "@@texte@@", $texte, $lien );
		
		$title = utf8_encode( $tab[ "nom_categorie" ] );
		$title = str_replace( "\"", "''", $title );
		$lien = str_replace( "@@title@@", $title, $lien );
		
		$lien = str_replace( "@@target@@", $target, $lien );
		
		// Lien du type "restaurant/strasbourg-conseil-des-xv/md30-pizza/salades/livraison/4/0/2/30/page.htm"
		$nom_resto_meta = tranformer_url( $tab[ "nom_restaurant" ], 'utf-8', false );
		$categorie_meta = tranformer_url( suppr_accents( $tab[ "nom_categorie" ] ), 'utf-8', false );
		$link = ( $tab[ "fonctionnement" ] == 'l' )
			? "/restaurant/" . $tab[ "meta_ville" ] . "/" . $nom_resto_meta . "/" . $categorie_meta . "/livraison/" . $tab[ "num_ville" ] . "/0/" . $tab[ "num_restaurant" ] . "/" . $tab[ "num_categorie" ] . "/page.htm"
			: "/restaurant/" . $tab[ "meta_ville" ] . "/" . $nom_resto_meta . "/" . $categorie_meta . "/plats-a-emporter/" . $tab[ "num_ville" ] . "/0/" . $tab[ "num_restaurant" ] . "/" . $tab[ "num_categorie" ] . "/page.htm";
		$lien = str_replace( "@@link@@", $link, $lien );
		
		
		/*echo "<pre>";
		print_r( $tab );
		echo "</pre>";*/
		
		if ( $tab[ "lien_entier" ] ) return $link;
		else return $lien;
	}
	
	// Indique si les articles d'une catégorie sont bien en ordre
	function isInOrder( $num_restaurant=0, $num_categorie=0, $debug=false ) {
		$requete = "SELECT ordre_affichage, COUNT( id ) AS nb FROM articles";
		$requete .= " WHERE id_resto = " . $num_restaurant;
		$requete .= " AND id_cat = " . $num_categorie;
		$requete .= " GROUP BY ordre_affichage";
		if ( $debug ) echo $requete . "<br>";
		$liste = mysql_query( $requete );
		
		$val_retour = true;
		if ( mysql_num_rows( $liste ) != 0 ) {
			if ( $debug ) echo "0...<br>";
			
			while( $data = mysql_fetch_assoc( $liste ) ) {
				if ( $debug ) echo "1...<br>";
				
				// Compte SUPÉRIEUR à 1 --> Erreur
				if ( $data[ "nb" ] > 1 ) {
					if ( $debug ) echo "2...<br>";
					$val_retour = false;
					break;
				}
			}
		}
		
		return $val_retour;
	}
	
	// ---- VERSION API MOBILE --------------------------------------------------------------------------------- //
	
	function AppliMobile_loadByIDCategorie( $id_cat=0, $id_resto=0, $debug=false ) {
		$id_cat = intval( $id_cat );
		$id_resto = intval( $id_resto );
		if ( $id_cat <= 0 || $id_resto <= 0 ) return false;
		
		$requete = "SELECT * FROM categories";
		$requete .= " WHERE id_cat = '" . $id_cat . "'";
		$requete .= " AND id_resto = '" . $id_resto . "'";
		if ( $debug ) echo $requete . "<br>\n";
		$result = mysql_query($requete);
		
		if (!$result) return false;
		
		$data = mysql_fetch_assoc($result);
		if (empty($data)) return false;
		
		return $this->load( $data[ "id" ], $debug );
	}
	
	// Charge la liste des categories d'1 resto
	function AppliMobile_getListeCat( $id_resto, $mode_fonctionnement, $debug = false ) {
		
		if ( $mode_fonctionnement == 'L' ) $mode = "'1','2'";
		if ( $mode_fonctionnement == 'AE' ) $mode = "'1','3'";
		$requete = "SELECT * FROM categories";
		$requete .= " WHERE id_resto = " . $id_resto;
	  $requete .= " AND statut <> '0'";
	  $requete .= " AND mode IN (" . $mode . ")";
		$requete .= " ORDER BY ordre_affichage ASC";
		if ( $debug ) echo $requete . "<br><br>";
		$liste = mysql_query($requete);
		
		return $liste;
	}

	// Charge la liste des articles d'une categorie
	function AppliMobile_getListeArt( $id_resto, $id_cat, $debug ) {
		
		$requete = "SELECT * FROM articles";
		$requete .= " WHERE id_resto = " . $id_resto;
		$requete .= " AND id_cat = " . $id_cat;
		$requete .= " ORDER BY ordre_affichage ASC";
		if ( $debug ) echo $requete . "<br><br>";
		$liste = mysql_query($requete);
		
		return $liste;
		
	}
	
	// Charge la complexite d'un article
	function AppliMobile_getComplexite( $id_resto, $id_cat, $id_art, $debug = false ) {
		if ( $debug ) echo "--- #id_art : " . $id_art . "<br>";
		
		// je recupere le id de la complexite dans la table detail_articles_V2
		$requete = "SELECT * FROM detail_articles_V2";
		$requete .= " WHERE id_resto = " . $id_resto;
		$requete .= " AND id_cat = " . $id_cat;
		$requete .= " AND id_art = " . $id_art;
		if ( $debug ) echo $requete . "<br><br>";

		$info = mysql_query($requete);
		
		$data = mysql_fetch_assoc($info);
		$id_detail_articles_V2 = $data[ "id" ];
		
		// puis je recupere les complexites
		$requete = "SELECT * FROM detail_articles_detail_V2";
		$requete .= " WHERE id_detail_articles_V2 = " . $id_detail_articles_V2;
		$requete .= " ORDER BY num_parametre ASC";
		if ( $debug ) echo $requete . "<br><br>";
		
		$liste = mysql_query($requete);
		
		return $liste;
		
	}
	// ------------------------------------------------------------ //
}
?>