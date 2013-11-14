<?php
require_once('../includes/helper.php');
render('header', array('title' => 'C$75 Finance'));
?>

<form method="POST" action="login" onsubmit="return validateForm();">
    E-mail address: <input type="text" name="email" /><br />
    Password: <input type="password" name="password" /><br />
	<input type="submit" value="Login" />
</form>

<script type='text/javascript'>
// <! [CDATA[

function validateForm()
{
	isValid = true;
	
	// check if the email address was entered (min=6: x@x.to)
	emailField = $("input[name=email]");
	if (emailField.val().length < 6)
		isValid = false;
		
	return isValid;
}

// set the focus to the email field (located by id attribute)
$("input[name=email]").focus();

// ]] >
</script>

<?php
render('footer');
?>
