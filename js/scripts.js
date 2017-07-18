// JavaScript Document
jQuery(document).ready(function($){
});		
						
var wpsc_methods = {

	disable_copy: function(hotkey)
	{
	if(!hotkey) var hotkey = document.body;
	if (typeof hotkey.onselectstart!="undefined") //For IE 
		hotkey.onselectstart=function(){return false}
	else if (typeof hotkey.style.MozUserSelect!="undefined") //For Firefox
		hotkey.style.MozUserSelect="none"
	else //Opera
		hotkey.onmousedown=function(){return false}
	hotkey.style.cursor = "default"
	},		
	disableEnterKey: function(e)
	{
		if (!e) var e = window.event;
		if (e.ctrlKey){
		alert('Content is secured!');
		 var key;
		 if(window.event)
			  key = window.event.keyCode;     //IE
		 else
			  key = e.which;     //firefox (97)
		 if (key == 97 || key == 65 || key == 67 || key == 88 || key == 43 || key == 26 || key == 5)
			  return false;
		 else
			return true;
			  }
	
	}		
}

