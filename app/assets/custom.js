// JavaScript Document
jQuery(document).ready(function() {
  $(document).ready(function() {
   $('#cmsfunc').find('dd').hide().end().find('dt').click(function() {
     $(this).next().slideToggle();
   });
  $("#cmsfunc dt").hover(function(){
	$(this).addClass("highlight");
	},function(){
	$(this).removeClass("highlight");
	});
  }); 
});
function addCaptionsToCode() {
    var codes = document.getElementsByTagName("code");
    var elTitle, elPre;
    for (var i=0, l=codes.length ; i<l ; i++) {
        title = codes[i].title;
        if (title) {
            // Remove title from CODE
            codes[i].title = "";
            // Prepare caption DIV
            elTitle = document.createElement("div");
            elTitle.innerHTML = title;
            elTitle.className = "JScodeCaption";
            // Add class to PRE
            elPre = codes[i].parentNode;
            elPre.className += " JS";
            // Insert before the PRE
            elPre.parentNode.insertBefore(elTitle, elPre);
        }
    }
}
