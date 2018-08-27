// $(window).load(function() {
// 	var w = window.innerWidth / 7.5;
// 	if(w > 100) {
// 		w = 100;
// 	}
// 	document.documentElement.style.fontSize = w + 'px';
// 	window.onresize = function() {
// 		var w = window.innerWidth / 7.5;
// 		if(w > 100) {
// 			w = 100
// 		}
// 		document.documentElement.style.fontSize = w + 'px';
// 	}
// })
function g_load(){
    var w = window.innerWidth / 7.5;
    if(w > 100) {
        w = 100;
    }
    document.documentElement.style.fontSize = w + 'px';
    window.onresize = function() {
        var w = window.innerWidth / 7.5;
        if(w > 100) {
            w = 100
        }
        document.documentElement.style.fontSize = w + 'px';
    }
}
g_load()