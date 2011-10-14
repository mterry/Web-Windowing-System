$(document).ready(function() {
	// form submission request to login.php's post() function
	$("#login").submit(function (event) {
		event.preventDefault();

		$.post(
			url: "http://web334.cs.uwindsor.ca/~terrym/wws/src/routing.php",
			data: {
				class: "Login",
				method: "post_response",
				screenname: $("[name=screenname]").val(),
				password: $("[name=password]").val()
			},
			success: function(response) {
				var obj = $.parseJSON(response);
				if (obj.status == "error") {
					for (value in obj.invalid_input) {
						if (value == "screenname") {
							$("#screenname").text(obj.invalid_input.screenname);
						}
						if (value == "password") {
							$("#password").text(obj.invalid_input.password);
						}
					}
				}
			});
	});
});
