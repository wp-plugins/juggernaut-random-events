/*
	Random Events v1.3
	by Andrew Kaser 
*/
	
function wpre_close()
{
	document.getElementById("ari_container").style.display = "none";

	var is_modal = document.getElementById("ari_modal_overlay");
	if ( is_modal != null ) {
		document.getElementById("ari_modal_overlay").style.display = "none";
	}
	
}