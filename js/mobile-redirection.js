function je_redirige( num, mobile, page ) {
	//alert( page );
	if ( confirm( mobile + " - " + texte_confim ) ) {
	//if ( confirm( mobile + " - " + texte_confim + "\n(" + page + ")" ) ) {
		window.location.href = page + "?mob";
	}
}


//Initialize our user agent string to lower case.
var uagent = navigator.userAgent.toLowerCase();
//alert( "/js/mobile-redirection.js : " + uagent );

// ----------------- IPhone --------------------------------------------------------------------- //
var deviceIphone = "iphone";
function DetectIphone()
{
   if ( uagent.search(deviceIphone) > -1)
      return true;
   else
      return false;
}
// ---------------------------------------------------------------------------------------------- //

// ----------------- IPod Touch ----------------------------------------------------------------- //
var deviceIpod = "ipod";
function DetectIpod()
{
   if ( uagent.search(deviceIpod) > -1)
      return true;
   else
      return false;
}
// ---------------------------------------------------------------------------------------------- //


// ----------------- IPhone ou IPod Touch ------------------------------------------------------- //
function DetectIphoneOrIpod()
{
	if (DetectIphone())
		return true;
	else if (DetectIpod())
		return true;
	else
		return false;
}
// ---------------------------------------------------------------------------------------------- //

// ----------------- S60 Open Source Browser ---------------------------------------------------- //
var deviceS60 = "series60";
var deviceSymbian = "symbian";
var engineWebKit = "webkit";

//**************************
// Detects if the current browser is the S60 Open Source Browser.
// Screen out older devices and the old WML browser.
function DetectS60OssBrowser()
{
   if ( uagent.search(engineWebKit) > -1)
   {
     if ((uagent.search(deviceS60) > -1 || uagent.search(deviceSymbian) > -1))
        return true;
     else
        return false;
   }
   else
      return false;
}
// ---------------------------------------------------------------------------------------------- //


// ----------------- Android -------------------------------------------------------------------- //
var deviceAndroid = "android";
var deviceAndroidTablette = "tablet";
function DetectAndroid()
{
	if ( uagent.search(deviceAndroid) > -1 ) {
		
		// Android - Les tablettes Android affichent le site classique
		if ( uagent.search( deviceAndroidTablette ) > -1 ) return false;
		else return true;
	}
	else
		return false;
}
// ---------------------------------------------------------------------------------------------- //


// ----------------- Android -------------------------------------------------------------------- //
// 	Detects if the current device is an Android OS-based device and
//	the browser is based on WebKit.
function DetectAndroidWebKit()
{
   if (DetectAndroid())
   {
     if (DetectWebkit())
        return true;
     else
        return false;
   }
   else
      return false;
}
// ---------------------------------------------------------------------------------------------- //


// ----------------- Windows Mobile device ------------------------------------------------------ //
var deviceWinMob = "windows ce";
function DetectWindowsMobile()
{
   if (uagent.search(deviceWinMob) > -1)
      return true;
   else
      return false;
}
// ---------------------------------------------------------------------------------------------- //

// ----------------- BlackBerry ----------------------------------------------------------------- //
var deviceBB = "blackberry";
function DetectBlackBerry()
{
   if (uagent.search(deviceBB) > -1)
      return true;
   else
      return false;
}
// ---------------------------------------------------------------------------------------------- //

// ----------------- PalmOS device -------------------------------------------------------------- //
var devicePalm = "palm";

//**************************
// Detects if the current browser is on a PalmOS device.
function DetectPalmOS()
{
   if (uagent.search(devicePalm) > -1)
      return true;
   else
      return false;
}
// ---------------------------------------------------------------------------------------------- //

