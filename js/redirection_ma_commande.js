//Initialize our user agent string to lower case.
var uagent = navigator.userAgent.toLowerCase();

// ----------------- IPhone --------------------------------------------------------------------- //
var deviceIphone = "iphone";
function DetectIphone( debug ) {
	if ( uagent.search(deviceIphone) > -1) {
		if ( debug) alert( "IPhone" );
		return true;
	}
	else return false;
}
// ---------------------------------------------------------------------------------------------- //

// ----------------- IPad ----------------------------------------------------------------------- //
var deviceIpad = "ipad";
function DetectIpad( debug )
{
   if ( uagent.search(deviceIpad) > -1) {
		if ( debug) alert( "IPad" );
		return true;
	}
   else
      return false;
}
// ---------------------------------------------------------------------------------------------- //

// ----------------- IPod Touch ----------------------------------------------------------------- //
var deviceIpod = "ipod";
function DetectIpod( debug )
{
   if ( uagent.search(deviceIpod) > -1) {
		if ( debug) alert( "IPod" );
		return true;
	}
   else
      return false;
}
// ---------------------------------------------------------------------------------------------- //


// ----------------- IPhone ou IPod Touch ------------------------------------------------------- //
function DetectIphoneOrIpod( debug )
{
    if ( DetectIphone( debug ) )
       return true;
    else if (DetectIpod( debug ))
       return true;
    else
       return false;
}

function isAppleProduct() {
    if (DetectIphone())
       return true;
    else if (DetectIpad())
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
function DetectS60OssBrowser( debug )
{
   if ( uagent.search(engineWebKit) > -1)
   {
     if ((uagent.search(deviceS60) > -1 || uagent.search(deviceSymbian) > -1)) {
		if ( debug) alert( "series60 ou symbian" );
		return true;
	}
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
function DetectAndroid( debug )
{
	if (uagent.search(deviceAndroid) > -1) {
	
		// Android - Les tablettes Android affichent le site classique
		if ( uagent.search( deviceAndroidTablette ) > -1 ) return false;
		else {
			if ( debug) alert( "Android" );
			return true;
		}
	}
	else
		return false;
}
// ---------------------------------------------------------------------------------------------- //


// ----------------- Android -------------------------------------------------------------------- //
// 	Detects if the current device is an Android OS-based device and
//	the browser is based on WebKit.
function DetectAndroidWebKit( debug )
{
   if (DetectAndroid( debug ) ) {
     if (DetectWebkit()) {
		if ( debug) alert( "Android" );
		return true;
	}
     else
        return false;
   }
   else
      return false;
}
// ---------------------------------------------------------------------------------------------- //


// ----------------- Windows Mobile device ------------------------------------------------------ //
var deviceWinMob = "windows ce";
function DetectWindowsMobile( debug )
{
   if (uagent.search(deviceWinMob) > -1) {
		if ( debug) alert( "windows ce" );
		return true;
	}
   else
      return false;
}
// ---------------------------------------------------------------------------------------------- //

// ----------------- BlackBerry ----------------------------------------------------------------- //
var deviceBB = "blackberry";
function DetectBlackBerry( debug )
{
   if (uagent.search(deviceBB) > -1) {
		if ( debug) alert( "blackberry" );
		return true;
	}
   else
      return false;
}
// ---------------------------------------------------------------------------------------------- //

// ----------------- PalmOS device -------------------------------------------------------------- //
var devicePalm = "palm";

//**************************
// Detects if the current browser is on a PalmOS device.
function DetectPalmOS( debug )
{
   if (uagent.search(devicePalm) > -1) {
		if ( debug) alert( "palm" );
		return true;
	}
   else
      return false;
}
// ---------------------------------------------------------------------------------------------- //

function getIframe( debug ) {
	if ( DetectIphoneOrIpod( debug ) ) return false;
	else if ( DetectS60OssBrowser( debug ) ) return false;
	else if ( DetectAndroid( debug ) ) return false;
	else if ( DetectAndroidWebKit( debug ) ) return false;
	else if ( DetectWindowsMobile( debug ) ) return false;
	else if ( DetectBlackBerry( debug ) ) return false;
	else if ( DetectPalmOS( debug ) ) return false;
	else return true;
}


