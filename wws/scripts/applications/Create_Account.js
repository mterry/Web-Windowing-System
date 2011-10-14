$(document).ready(function() {
	// form submission request to login.php's post() function
	$("#Create_Account").submit(function (event) {
		even.preventDefault();

		$post(
			url: "http://web334.cs.uwindsor.ca/~terrym/wws/src/routing.php",
			data: {
				class: "Create_Account",
				method: "post_response",
				screenname: $("[name=screenname]").val(),
				password: $("[name=password]").val(),
				full_name: $("[name=full_name]").val(),
				email: $("[name=email]").val(),
				age: $("[name=age]").val()
			},
			success: function(response) {
				alert(response);
		});
	});
});
