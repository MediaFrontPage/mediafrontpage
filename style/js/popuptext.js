/*
Based on Mouse Over Text Box from http://mouseover-help-box.4wsearch.com/index.html
*/
var IB=new Object;
IB.ColTexte="#003366";IB.ColFond="#cccccc";IB.ColContour="#000000";IB.NbPixel=1;
var posX=0;posY=0;
var xOffset=10;yOffset=10;
function ShowPopupBox(texte) {
  contenu="<TABLE border=0 cellspacing=0 cellpadding=1 class=\"popupwrapper\"><TR><TD><TABLE border=0 cellpadding=2 cellspacing=0 class='popup'><TR><TD><FONT size='-1' face='arial'>"+texte+"</FONT></TD></TR></TABLE></TD></TR></TABLE>&nbsp;";
  var finalPosX=posX-xOffset;
  if (finalPosX<0) finalPosX=0;
  if (document.layers) {
    document.layers["bulle"].document.write(contenu);
    document.layers["bulle"].document.close();
    document.layers["bulle"].top=posY+yOffset;
    document.layers["bulle"].left=finalPosX;
    document.layers["bulle"].visibility="show";}
  if (document.all) {
    bulle.innerHTML=contenu;
    document.all["bulle"].style.top=posY+yOffset;
    document.all["bulle"].style.left=finalPosX;
    document.all["bulle"].style.visibility="visible";
  }
  
  else if (document.getElementById) {
    document.getElementById("bulle").innerHTML=contenu;
    document.getElementById("bulle").style.top=posY+yOffset;
    document.getElementById("bulle").style.left=finalPosX;
    document.getElementById("bulle").style.visibility="visible";
  }
}
function getMousePos(e) {
  if (document.all) {
  posX=event.x+document.body.scrollLeft; 
  posY=event.y+document.body.scrollTop;
  }
  else {
  posX=e.pageX; 
  posY=e.pageY; 
  }
}
function HidePopupBox() {
	if (document.layers) {document.layers["bulle"].visibility="hide";}
	if (document.all) {document.all["bulle"].style.visibility="hidden";}
	else if (document.getElementById){document.getElementById("bulle").style.visibility="hidden";}
}

function InitPopupBox() {
	if (document.layers) {
		window.captureEvents(Event.MOUSEMOVE);window.onMouseMove=getMousePos;
		document.write("<LAYER name='bulle' top=0 left=0 visibility='hide'></LAYER>");
	}
	if (document.all) {
		document.write("<DIV id='bulle' style='position:absolute;top:0;left:0;visibility:hidden;z-index:5000;'></DIV>");
		document.onmousemove=getMousePos;
	}
	
	else if (document.getElementById) {
	        document.onmousemove=getMousePos;
	        document.write("<DIV id='bulle' style='position:absolute;top:0;left:0;visibility:hidden;z-index:5000;'></DIV>");
	}

}
