$(document).ready(function() {
	$("#app-menu").delegate("div", "click", function() {
		var classname = $(this).attr("id");
		$("#window-container").empty();
		$.get(
			"wws/src/routing.php",
			{
				class: classname,
				method: "get_response"
			},
			function(data) {
				// BUG: This should append the XML string passed back from the get_response()
				// method to the "#window-container" div, but it's not working properly. Instead,
				// it's throwing a Javascript exception. If I do change the XSLT file to instead 
				// output HTML, it throws a different Javascript exception. If I just try to send
				// back plain text, and then parse it as XML, it complains that it is not well-
				// formed XML, when it certainly is (and I have checked with XML Validators such
				// as the one supplied by w3schools.com).
				$("#window-container").append(data);
		});
	});
	$.get(
		"wws/src/routing.php",
		{
			class: "Application",
			method: "json_get_app_list"
		},
		function(data) {
			var appmenu = $("div#app-menu").get(0);
			var applications = $.parseJSON(data);

			for (var obj in applications) {
				var appbutton = document.createElement("div");
				appbutton.setAttribute("class", "appbutton");
				appbutton.setAttribute("id", applications[obj].fields.name);
				var appicon = document.createElement("img");
				appicon.setAttribute("src", "wws/static/images/applications/" + applications[obj].fields.icon_path);
				appicon.setAttribute("alt", applications[obj].fields.name);
				appbutton.appendChild(appicon);
				appmenu.appendChild(appbutton);
			}
	});
});
$(document).load(function() {
	var new_width = $(window).width() - 96;
	$("#window-container").width(new_width);
});
$(window).resize(function(){
	var new_width = $(window).width() - 96;
	$("#window-container").width(new_width);
});
