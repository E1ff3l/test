  	var timer=null;
  	var first=true;
  	var currentNumberOfCaractere=-1;
  	var currentdate=new Date();
  	var accountStopSmsStatusId=null;
  	
	function onch(my_form) 
	{
		maxLen=160;
		specialChar = 0;
		offset = -1;
	    nb_lines=0;
	 	needle="\n";
		nomform=my_form.id;

		if(currentNumberOfCaractere!=my_form.messageValue.value.length)
		{
			currentNumberOfCaractere=my_form.messageValue.value.length;
			var currentPos=Cursor_GetPos(my_form.messageValue.id);
			cleartimeout();
			
			my_form.messageValue.value=my_form.messageValue.value.replace(/[ÈÊË]/g,"E");
			my_form.messageValue.value=my_form.messageValue.value.replace(/[ÀÁÂÃ]/g,"A");
			my_form.messageValue.value=my_form.messageValue.value.replace(/[ÌÍÎÏ]/g,"I");
			my_form.messageValue.value=my_form.messageValue.value.replace(/[ÒÓÔÕ]/g,"O");
			my_form.messageValue.value=my_form.messageValue.value.replace(/[ÙÚÛ]/g,"U");
			
			my_form.messageValue.value=my_form.messageValue.value.replace(/[êë]/g,"e");
			my_form.messageValue.value=my_form.messageValue.value.replace(/[áâã]/g,"a");
			my_form.messageValue.value=my_form.messageValue.value.replace(/[íîïì]/g,"i");
			my_form.messageValue.value=my_form.messageValue.value.replace(/[ðóôõò]/g,"o");
			my_form.messageValue.value=my_form.messageValue.value.replace(/[œ]/g,"oe");
			my_form.messageValue.value=my_form.messageValue.value.replace(/[úû]/g,"u");
			my_form.messageValue.value=my_form.messageValue.value.replace(/[ýÿ]/g,"y");
			
			my_form.messageValue.value=my_form.messageValue.value.replace(/[«»“]/g,"\"");
			my_form.messageValue.value=my_form.messageValue.value.replace(/–/g,"-");
			my_form.messageValue.value=my_form.messageValue.value.replace(/[…]/g,"...");
			
			
			my_form.messageValue.value=my_form.messageValue.value.replace(/[#]/g,"");
			my_form.messageValue.value=my_form.messageValue.value.replace(/[¤]/g,"");
			my_form.messageValue.value=my_form.messageValue.value.replace(/[°]/g,"");
			
			Cursor_SetPos(my_form.messageValue.id,currentPos);
	
			for (i=0;i<my_form.messageValue.value.length;i++){
				charCode=my_form.messageValue.value.charCodeAt(i);
				if(charCode == 13){
					specialChar--;
				}
				if(charCode > 122 || charCode == 91 || charCode == 92 || charCode == 93 || charCode == 10 || charCode==8364){
					specialChar++;
				}
			}
	
			var nbCharacter=specialChar;
			
			my_form.messageValue.value = my_form.messageValue.value.substr(0, (maxLen)-nbCharacter);

			my_form.counter.value = maxLen - (my_form.messageValue.value.length+nbCharacter);
			
			var newtext=my_form.messageValue.value;
		}
		timer=setTimeout("onch(document.getElementById('"+nomform+"'))", 100);
		
	}

	function cleartimeout()
	{
		if(timer)
		{
			window.clearTimeout(timer);
		}
	}

	
	
	
	function getXhr ()
	{
		var currentxhr=null;
		if (window.XMLHttpRequest)         // Firefox et autres
		{
			currentxhr = new XMLHttpRequest ();
		}
		else if (window.ActiveXObject)     // Internet Explorer
		{
			try
			{
				currentxhr = new ActiveXObject ("Msxml2.XMLHTTP"); // IE version > 5
			}
			catch (e)
			{
				currentxhr = new ActiveXObject ("Microsoft.XMLHTTP");
			}
		}
		else // XMLHttpRequest non supporté par le navigateur
		{
			alert ('Votre navigateur ne supporte pas les objets XMLHttpRequest !');
			currentxhr = false;
		}
	  return currentxhr;

	} // getXhr ()
	
	
	
	
	
	 function Get_NbrCR(txt_){
		 var NbrCR = 0;
		 var Pos = txt_.indexOf("\r\n");
		 while( Pos > -1){
		 Pos = txt_.indexOf("\r\n", Pos+2);
		 NbrCR ++;
		 }
		 return( NbrCR);
		 }
		 //----------------------------------
		 function Cursor_SetPos( where_, pos_){
		 //-- Recup l'Objet
		 var Obj = document.getElementById( where_);
		 if( Obj){
		 Obj.focus();
		 if( typeof Obj.selectionStart != "undefined"){
		 Obj.setSelectionRange( pos_, pos_);
		 }
		 else{ // IE and consort
		 var Chaine = Obj.createTextRange();
		 Chaine.moveStart('character', pos_);
		 //-- Deplace le curseur
		 Chaine.collapse();
		 Chaine.select();
		 }
		 //-- Retour valeur Reelle placee
		 return( Cursor_GetPos( where_, pos_));
		 }
		 }
		 //----------------------------------
		 function Cursor_GetPos( where_, pos_){
		 //-- Recup l'Objet
		 var Obj= document.getElementById(where_);
		 if( Obj){
		 //-- Focus sur Objet
		 Obj.focus();
		 if(typeof Obj.selectionStart != "undefined")
		 return Obj.selectionStart;
		 else{ // IE and consort
		 var szMark = "~~";
		 var Chaine = Obj.value;
		 //-- Cree un double et insert la Mark ou est le curseur
		 var szTmp = document.selection.createRange();
		 szTmp.text = szMark;
		 //-- Recup. la position du curseur
		 var PosDeb = Obj.value.search(szMark);
		 //-(*)- Supprime les retours Chariot
		 var szAvant = Chaine.substring( 0 , PosDeb);
		 PosDeb -= Get_NbrCR( szAvant);
		 //-- Restaure valeur initiale
		 Obj.value = Chaine;
		 Chaine = Obj.createTextRange();
		 //-- Deplace le Debut de la chaine
		 Chaine.moveStart('character', PosDeb);
		 //-- Deplace le curseur
		 Chaine.collapse();
		 Chaine.select();
		 return( PosDeb);
		 }
		 }
		 }
		 //------------------------------------
		 function Cursor_AddTexte(where_, txt_){
		 //-- Recup l'Objet
		 var Obj = document.getElementById( where_);
		 if( Obj){
		 //-- Focus sur Objet
		 Obj.focus();
		 if( typeof Obj.selectionStart != "undefined"){
		 //-- Position du curseur
		 var PosDeb = Obj.selectionStart;
		 var PosFin = Obj.selectionEnd;
		 //-- Recup. des Chaines
		 var Chaine = Obj.value;
		 var szAvant = Chaine.substring( 0 , PosDeb);
		 var szApres = Chaine.substring( PosFin, Obj.textLength );
		 //-- Recup. texte selectionne
		 var szSelect = Chaine.substring( PosDeb, PosFin);
		 //-- Insertion du texte
		 Obj.value = szAvant + txt_ + szApres;
		 //-- Replace le curseur
		 Obj.setSelectionRange( szAvant.length + txt_.length, szAvant.length + txt_.length );
		 //-- Replace le Focus
		 Obj.focus();
		 }
		 else{ // IE and consort
		 //-- Recup. de la selection
		 var szSelect = document.selection.createRange().text;
		 //-- Si du Texte est selectionne on le remplace
		 if( szSelect.length > 0){
		 var Chaine = document.selection.createRange();
		 Chaine.text = txt_ ;
		 Chaine.collapse();
		 Chaine.select();
		 }
		 else{
		 var Chaine = Obj.value;
		 var szMark ="~~";
		 //-- Cree un double et insert la Mark ou est le curseur
		 var szTmp = document.selection.createRange().duplicate();
		 szTmp.text = szMark;
		 //-- Recup. la position du curseur
		 var PosDeb = Obj.value.search(szMark);
		 //-- Recup. des Chaines
		 var szAvant = Chaine.substring( 0 , PosDeb);
		 var szApres = Chaine.substring( PosDeb, Obj.textLength );
		 //-- Insertion du texte
		 Obj.value = szAvant + txt_ + szSelect + szApres;
		 //-- Repositionne le curseur
		 PosDeb += txt_.length;
		 //-(*)- Supprime les retours Chariot
		 PosDeb -= Get_NbrCR( szAvant);
		 //-- Recup de la Chaine
		 Chaine = Obj.createTextRange();
		 //-- Deplace le Debut de la chaine
		 Chaine.moveStart('character', PosDeb);
		 //-- Deplace le curseur
		 Chaine.collapse();
		 Chaine.select();
		 }
		 }
		 }
		 } 