function ImageLoadFailed() {
    window.event.srcElement.style.display = "None";
}
function imgcat(id_,w_,h_) {

	 var w=w_;
	 var h=h_;
	 var id=id_;
	 
	$('body').prepend('<div id="v5_lightbox"><div class="bcg"><img  src="'+id+'" /></div></div>');
  
    $(window).trigger('orientationchange');
	  	
	$("#v5_lightbox").click(function(){
		$(this).children().hide();
		$(this).remove();
        
	})
	$("#v5_lightbox").css('display','block');
	
 }

function twPopConstructeur(){
    var anchors = document.getElementsByTagName("a");
    for (var i=0; i<anchors.length; i++){
        var anchor = anchors[i];
        var relAttribute = String(anchor.getAttribute("class"));
        if (anchor.getAttribute("href") && (relAttribute.toLowerCase().match("twpop"))){
            var oParent = anchor.parentNode;
            var oImage=document.createElement("img");
            oImage.src = anchor.getAttribute("href");
            oImage.alt = anchor.getAttribute("title")

            var oLien=document.createElement("a");
            oLien.href = "#ferme";
            oLien.title = anchor.getAttribute("title");
            oLien.onclick = "return false;";
            oLien.appendChild(oImage);

            var sNumero = "id"+i;

            var node=document.createElement("div");
            node.id = sNumero;
            node.className = "twAudessus";
            node.appendChild(oLien);
            anchor.setAttribute("href","#"+sNumero);
      oParent.appendChild(node);
        }
    }
}