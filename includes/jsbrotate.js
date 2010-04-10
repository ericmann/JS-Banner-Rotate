window.onload = jsbinit;

function jsbinit() {
	var allBanners = document.getElementById("jsBanners").getElementsByTagName("span");
	var totalBanners = allBanners.length;
	var lastBanner = totalBanners - 1;
	show = new Array();
	hide = new Array();
	for(var i = 0; i < allBanners.length; i++) {
		show[i] = new YAHOO.util.Anim(allBanners[i], {opacity:{to:1}}, imgfade);
		hide[i] = new YAHOO.util.Anim(allBanners[i], {opacity:{to:0}}, imgfade);
	}
	var k = 0;
	for(var j=0; j < allBanners.length - 1; j++) {
		createListener(j);							
	}
	show[lastBanner].onComplete.subscribe(function() {createNext(lastBanner, true);});
	
	show[0].animate();
}
function createNext(id, last) {
	if(last==false) {
		setTimeout(function() {
			hide[id].animate();
			show[(id+1)].animate();
			}, imgdisp);
	} else {
		setTimeout(function() {
			hide[id].animate();
			show[0].animate();
			}, imgdisp);
	}
}

function createListener(id) {
	show[id].onComplete.subscribe(function() {createNext(id, false);});
}