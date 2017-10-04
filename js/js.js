		function mon_test() {
			alert("Test affichage OK!");
		}
		
		var container_R = "";
		
		function MM_swapImgRestore() { //v3.0
			var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
		}
		
		function MM_preloadImages() { //v3.0
			var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
			var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
			if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
		}
		
		function MM_findObj(n, d) { //v4.01
			var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
			d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
			if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
			for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
			if(!x && d.getElementById) x=d.getElementById(n); return x;
		}
		
		function MM_swapImage() { //v3.0
			var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
			if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
		}
		
		function trim(sString) {
			while (sString.substring(0,1) == ' ') {
				sString = sString.substring(1, sString.length);
			}
			while (sString.substring(sString.length-1, sString.length) == ' '){
				sString = sString.substring(0,sString.length-1);
			}
			return sString;
		}
		
		function find(obj) {
			//alert("Objet recherche : " + obj);
			return document.getElementById(obj)!= null ? document.getElementById(obj) : null ;
		}
		
		function getOffset(obj, coord) {
			var val = obj["offset"+coord] ;
			while ((obj = obj.offsetParent )!=null) {
				val += obj["offset"+coord];
			}
			return val;
		}
		
		/////////////////////////////////////////////////////////////////////
		// affichage des messages d'erreur sur les controles de formulaires //
		var TimeOut = 0
		function erreur(el, message) {
			//alert("Element a chercher : " + el);
			clearTimeout(TimeOut);
			find(el).focus();
			find('erreurdiv').innerHTML = message;
			find('erreurdiv').style.display = "block";
			if(find(el).tagName == "TEXTAREA") {
				var yTo = getOffset(find(el),"Top") +find(el).offsetHeight;
			} else {
				var yTo = getOffset(find(el),"Top") +find(el).offsetHeight;
			}
			var xTo = getOffset(find(el),"Left");
			//alert("X : " + xTo);
			//alert("Y : " + yTo);
			find('erreurdiv').style.top = yTo;
			find('erreurdiv').style.left = xTo;
			TimeOut = setTimeout("find('erreurdiv').style.display = 'none'", 8000);
		}
		
		//--------------------------------------------------------------//
		function creation_objet() {
			try {
				return new XMLHttpRequest();
			} 
			catch(e) {	
				try {
					var aObj = new ActiveXObject("Msxml2.XMLHTTP");
				} 
				catch (e) {
					try {
						var aObj = new ActiveXObject("Microsoft.XMLHTTP");
					} 
					catch(e) {
						return false;
					}
				}
			}
			return aObj;
		}
		//--------------------------------------------------------------//
		
		function afficher_chat() {
			document.formulaire_connexion.action = "/chat.php";
			document.formulaire_connexion.method = "post";
			document.formulaire_connexion.target = "_blank";
			document.formulaire_connexion.submit();
		}
		
		function afficher_contenu(nom_div, commande_en_cours) {
			try {
				var formulaire_ajax = creation_objet();
				
				// Preparation des variables a transmettre
				var data = "nom_div=" + nom_div;
				data += "&c=" + commande_en_cours;
				//alert(data);
				
				formulaire_ajax.open("POST", "/commande/affichage_contenu.php", true);
				formulaire_ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				formulaire_ajax.setRequestHeader("Cache-Control","no-cache");
				formulaire_ajax.send(data);
				
				formulaire_ajax.onreadystatechange = function() {
					if (formulaire_ajax.readyState == 4) {
						//alert(formulaire_ajax.responseText);
						
						// Tout est bon --> On continue la commande
						if (formulaire_ajax.responseText == "ok")
							window.location.href = "/commande/resume_commande.php";
						else
							find(nom_div).innerHTML = formulaire_ajax.responseText;
					}
				}
			}
			catch(e) {
				alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest..." + e.message);
			}
		}
		
		/*function HTMLentities(texte) {
			texte = texte.replace(/"/g,'&quot;'); // 34 22
			texte = texte.replace(/&/g,'&amp;'); // 38 26
			texte = texte.replace(/\'/g,'&#39;'); // 39 27
			//texte = texte.replace(/</g,'&lt;'); // 60 3C
			//texte = texte.replace(/>/g,'&gt;'); // 62 3E
			texte = texte.replace(/\^/g,'&circ;'); // 94 5E
			texte = texte.replace(/ë/g,'&lsquo;'); // 145 91
			texte = texte.replace(/í/g,'&rsquo;'); // 146 92
			texte = texte.replace(/ì/g,'&ldquo;'); // 147 93
			texte = texte.replace(/î/g,'&rdquo;'); // 148 94
			texte = texte.replace(/ï/g,'&bull;'); // 149 95
			texte = texte.replace(/ñ/g,'&ndash;'); // 150 96
			texte = texte.replace(/ó/g,'&mdash;'); // 151 97
			texte = texte.replace(/ò/g,'&tilde;'); // 152 98
			texte = texte.replace(/ô/g,'&trade;'); // 153 99
			texte = texte.replace(/ö/g,'&scaron;'); // 154 9A
			texte = texte.replace(/õ/g,'&rsaquo;'); // 155 9B
			texte = texte.replace(/ú/g,'&oelig;'); // 156 9C
			texte = texte.replace(/ù/g,'&#357;'); // 157 9D
			texte = texte.replace(/û/g,'&#382;'); // 158 9E
			texte = texte.replace(/ü/g,'&Yuml;'); // 159 9F
			// texte = texte.replace(/ /g,'&nbsp;'); // 160 A0
			texte = texte.replace(/°/g,'&iexcl;'); // 161 A1
			texte = texte.replace(/¢/g,'&cent;'); // 162 A2
			texte = texte.replace(/£/g,'&pound;'); // 163 A3
			//texte = texte.replace(/ /g,'&curren;'); // 164 A4
			texte = texte.replace(/•/g,'&yen;'); // 165 A5
			texte = texte.replace(/¶/g,'&brvbar;'); // 166 A6
			texte = texte.replace(/ß/g,'&sect;'); // 167 A7
			texte = texte.replace(/®/g,'&uml;'); // 168 A8
			texte = texte.replace(/©/g,'&copy;'); // 169 A9
			texte = texte.replace(/™/g,'&ordf;'); // 170 AA
			texte = texte.replace(/´/g,'&laquo;'); // 171 AB
			texte = texte.replace(/¨/g,'&not;'); // 172 AC
			texte = texte.replace(/≠/g,'&shy;'); // 173 AD
			texte = texte.replace(/Æ/g,'&reg;'); // 174 AE
			texte = texte.replace(/Ø/g,'&macr;'); // 175 AF
			texte = texte.replace(/∞/g,'&deg;'); // 176 B0
			texte = texte.replace(/±/g,'&plusmn;'); // 177 B1
			texte = texte.replace(/≤/g,'&sup2;'); // 178 B2
			texte = texte.replace(/≥/g,'&sup3;'); // 179 B3
			texte = texte.replace(/¥/g,'&acute;'); // 180 B4
			texte = texte.replace(/µ/g,'&micro;'); // 181 B5
			texte = texte.replace(/∂/g,'&para'); // 182 B6
			texte = texte.replace(/∑/g,'&middot;'); // 183 B7
			texte = texte.replace(/∏/g,'&cedil;'); // 184 B8
			texte = texte.replace(/π/g,'&sup1;'); // 185 B9
			texte = texte.replace(/∫/g,'&ordm;'); // 186 BA
			texte = texte.replace(/ª/g,'&raquo;'); // 187 BB
			texte = texte.replace(/º/g,'&frac14;'); // 188 BC
			texte = texte.replace(/Ω/g,'&frac12;'); // 189 BD
			texte = texte.replace(/æ/g,'&frac34;'); // 190 BE
			texte = texte.replace(/ø/g,'&iquest;'); // 191 BF
			texte = texte.replace(/¿/g,'&Agrave;'); // 192 C0
			texte = texte.replace(/¡/g,'&Aacute;'); // 193 C1
			texte = texte.replace(/¬/g,'&Acirc;'); // 194 C2
			texte = texte.replace(/√/g,'&Atilde;'); // 195 C3
			texte = texte.replace(/ƒ/g,'&Auml;'); // 196 C4
			texte = texte.replace(/≈/g,'&Aring;'); // 197 C5
			texte = texte.replace(/∆/g,'&AElig;'); // 198 C6
			texte = texte.replace(/«/g,'&Ccedil;'); // 199 C7
			texte = texte.replace(/»/g,'&Egrave;'); // 200 C8
			texte = texte.replace(/…/g,'&Eacute;'); // 201 C9
			texte = texte.replace(/ /g,'&Ecirc;'); // 202 CA
			texte = texte.replace(/À/g,'&Euml;'); // 203 CB
			texte = texte.replace(/Ã/g,'&Igrave;'); // 204 CC
			texte = texte.replace(/Õ/g,'&Iacute;'); // 205 CD
			texte = texte.replace(/Œ/g,'&Icirc;'); // 206 CE
			texte = texte.replace(/œ/g,'&Iuml;'); // 207 CF
			texte = texte.replace(/–/g,'&ETH;'); // 208 D0
			texte = texte.replace(/—/g,'&Ntilde;'); // 209 D1
			texte = texte.replace(/“/g,'&Ograve;'); // 210 D2
			texte = texte.replace(/”/g,'&Oacute;'); // 211 D3
			texte = texte.replace(/‘/g,'&Ocirc;'); // 212 D4
			texte = texte.replace(/’/g,'&Otilde;'); // 213 D5
			texte = texte.replace(/÷/g,'&Ouml;'); // 214 D6
			texte = texte.replace(/◊/g,'&times;'); // 215 D7
			texte = texte.replace(/ÿ/g,'&Oslash;'); // 216 D8
			texte = texte.replace(/Ÿ/g,'&Ugrave;'); // 217 D9
			texte = texte.replace(/⁄/g,'&Uacute;'); // 218 DA
			texte = texte.replace(/€/g,'&Ucirc;'); // 219 DB
			texte = texte.replace(/‹/g,'&Uuml;'); // 220 DC
			texte = texte.replace(/›/g,'&Yacute;'); // 221 DD
			texte = texte.replace(/ﬁ/g,'&THORN;'); // 222 DE
			texte = texte.replace(/ﬂ/g,'&szlig;'); // 223 DF
			texte = texte.replace(/‡/g,'&aacute;'); // 224 E0
			texte = texte.replace(/·/g,'&aacute;'); // 225 E1
			texte = texte.replace(/‚/g,'&acirc;'); // 226 E2
			texte = texte.replace(/„/g,'&atilde;'); // 227 E3
			texte = texte.replace(/‰/g,'&auml;'); // 228 E4
			texte = texte.replace(/Â/g,'&aring;'); // 229 E5
			texte = texte.replace(/Ê/g,'&aelig;'); // 230 E6
			texte = texte.replace(/Á/g,'&ccedil;'); // 231 E7
			texte = texte.replace(/Ë/g,'&egrave;'); // 232 E8
			texte = texte.replace(/È/g,'&eacute;'); // 233 E9
			texte = texte.replace(/Í/g,'&ecirc;'); // 234 EA
			texte = texte.replace(/Î/g,'&euml;'); // 235 EB
			texte = texte.replace(/Ï/g,'&igrave;'); // 236 EC
			texte = texte.replace(/Ì/g,'&iacute;'); // 237 ED
			texte = texte.replace(/Ó/g,'&icirc;'); // 238 EE
			texte = texte.replace(/Ô/g,'&iuml;'); // 239 EF
			texte = texte.replace(//g,'&eth;'); // 240 F0
			texte = texte.replace(/Ò/g,'&ntilde;'); // 241 F1
			texte = texte.replace(/Ú/g,'&ograve;'); // 242 F2
			texte = texte.replace(/Û/g,'&oacute;'); // 243 F3
			texte = texte.replace(/Ù/g,'&ocirc;'); // 244 F4
			texte = texte.replace(/ı/g,'&otilde;'); // 245 F5
			texte = texte.replace(/ˆ/g,'&ouml;'); // 246 F6
			texte = texte.replace(/˜/g,'&divide;'); // 247 F7
			texte = texte.replace(/¯/g,'&oslash;'); // 248 F8
			texte = texte.replace(/˘/g,'&ugrave;'); // 249 F9
			texte = texte.replace(/˙/g,'&uacute;'); // 250 FA
			texte = texte.replace(/˚/g,'&ucirc;'); // 251 FB
			texte = texte.replace(/¸/g,'&uuml;'); // 252 FC
			texte = texte.replace(/˝/g,'&yacute;'); // 253 FD
			texte = texte.replace(/˛/g,'&thorn;'); // 254 FE
			texte = texte.replace(/ˇ/g,'&yuml;'); // 255 FF
			return texte;
		}*/
		
		function getEntier(chaine) {
			chaine_entier = "";
			chaine = trim( chaine );
			
			for (i=0; i<chaine.length; i++) {
				var lettre = chaine.charAt(i);
				if ( parseInt( lettre ) == lettre ) {
					chaine_entier += lettre;
				}
			}
			
			//alert("Dans getEntier : " + chaine + " ---> " + chaine_entier);
			return chaine_entier;
		}
		
		function gestion_totale_affichage_supplement( num_article, liste_ingredient, num_supplement, num_detail ) {
			//alert( liste_ingredient + " / " + num_supplement );
			var tableau_ingredient = liste_ingredient.split( "," );
			
			// Pour chaque DIV, on doit decocher toutes les cases
    		for(var i=0; i<tableau_ingredient.length; i++) {
    			//alert("i : " + i);
				
				// Si l'ingredient est > 0
				if ( tableau_ingredient[ i ] > 0 ) {
					//alert("Ing : " + tableau_ingredient[ i ]);
					
					// Liste des checkbox comprises dans le DIV
					if ( document.getElementById("div_" + tableau_ingredient[ i ]) ) {
						var tab_checkbox = document.getElementById("div_" + tableau_ingredient[ i ]).getElementsByTagName("input");
						
						// On decoche tout
						for (var j=0; j<tab_checkbox.length; j++) {
							tab_checkbox[ j ].checked = false;
						}
					}
				}
				
				// On cache le DIV
				gerer_affichage_supplement( tableau_ingredient[i], "none" );
			}
			
			// On affiche finalement les supplements de l'element selectionne
			if ( num_supplement != "" ) {
				
				// Mise en memoire de l'ingredient selectionne
				//alert(num_supplement + " / " + num_detail);
				find("sup_supplimentary_" + num_article).value = num_supplement;
				
				gerer_affichage_supplement( num_supplement, "block" );
			}
			
			// Dans le cas d'une liste deroulante, il faut avant tout recuperer la valeur selectionnee
			else {
				var val = document.getElementsByName("options[" + num_detail + "][]")[0].value;
				//alert( val );
				
				// Mise en memoire de l'ingredient selectionne
				//alert(num_supplement + " / " + num_detail);
				find("sup_supplimentary_" + num_article).value = val;
				
				gerer_affichage_supplement( val, "block" );
			}
		}
		
		function gerer_affichage_supplement( num_supplement, etat ) {
			//alert(num_supplement + " : " + etat);
			if ( find("div_" + num_supplement) ) find("div_" + num_supplement).style.display = etat;
		}