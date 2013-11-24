<?php
/*******************
 * login.php
 *
 * CSCI S-75
 * Project 1
 * Chris Gerber
 *
 * Login controller
 *******************/

require_once('../model/model.php');
require_once('../includes/helper.php');

if (isset($_POST['email']) &&
	isset($_POST['password']))
{
	
	$email = $_POST['email'];
	$password = $_POST['password'];
	
	$userid = login_user($email, hash("SHA1", $password), $error);
	if ($userid > 0)
	{
		$_SESSION['userid'] = $userid;
		render('home');
	}
	else
	{
		render('login', array('error' => $error));
	}
}
else
{
	render('login', array('error' => 'nothing entered'));
}
?>
