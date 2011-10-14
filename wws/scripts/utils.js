function load_async(url) {
	var head = document.getElementsByTagName("head")[0];
	var s = document.createElement("script");
	s.type = "text/javascript";
	s.src = url;
	head.appendChild(s);
}

function getElementsByClass(node,searchClass,tag) {
	var classElements = new Array();
	var els = node.getElementsByTagName(tag);
	var elsLen = els.length;
	var pattern = new RegExp("\b"+searchClass+"\b");
	for (i = 0, j = 0; i < elsLen; i++) {
		if ( pattern.test(els[i].className) ) {
			classElements[j] = els[i];
			j++;
		}
	}
	return classElements;
}

// This function will pass Javascript arrays back to PHP through cookies
function js_array_to_php_array (array) {
	var a_php = "";
	var total = 0;
	for (var key in a) {
		++ total;
		a_php = a_php + "s:" +
		String(key).length + ":\"" + String(key) + "\";s:" +
		String(a[key]).length + ":\"" + String(a[key]) + "\";";
	}
	a_php = "a:" + total + ":{" + a_php + "}";
	return a_php;
}
