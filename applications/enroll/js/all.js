// logout the current user
function logout() {
	jQuery.get('/code/php/logout.php', function(data) {
	if (data == "success") {
		// user is logged out, reload this page
	} else {
		alert('something went terribly wrong during logout: ' + data);
	}
	window.location.href = "/applications/User/login.php";
	});
}

function reloadContacts() {
	// remove all rows from the table
	jQuery('#contacts-list').children().remove();

	// fill the table with the list of contacts
	jQuery.getJSON('getContacts.php?action=load', function( refs ) {
		console.log( refs.length );
		refs.sort(function(a,b) { return b.date - a.date; });
		for (var i = 0; i < refs.length; i++) {
			var d = new Date(refs[i].date*1000);
			jQuery('#contacts-list').append('<tr contact-id="' + refs[i].id + '" title="last changed: ' + d.toDateString() + '"><td>'+ refs[i].date + '</td><td>'+ refs[i].id + '</td><td>'+ refs[i].opted + '</td><td>' + refs[i].schoolName + '</td><td>' + refs[i].preferredContact + '</td><td>' + refs[i].referredBy + '</td></tr>');
		}
		jQuery('#contacts-table').DataTable();
	});
}

jQuery('document').ready(function() {

	if (typeof user_name != 'undefined') {
		jQuery('#user_name').text(user_name);
		if (user_name == "admin") {
			console.log(user_name + "YES");
		} else {
			console.log(user_name + "NO");
		}
	}

	// if the user is an admin, then show the user admin button
	if (admin) {
		jQuery('#user_admin_button').prop('disabled', false);
	} else {
		jQuery('#user_admin_button').prop('disabled', true);
	}

	reloadContacts();
});
