<?php
/*******************
 * quote.php
 *
 * CSCI S-75
 * Project 1
 * Velvel Marasow
 *
 * Register controller
 *******************/
require_once('../model/model.php');
require_once('../includes/helper.php');

if (isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["re_password"]))
{
	if (strcmp($_POST['password'], $_POST['re_password']))
		render('register', array('error' => "Passwords don't match."));
	else if (valid_password($_POST["password"]))
		render('register', array('error' => "Not a valid password."));	
	else if (valid_email($_POST["email"]))
		render('register', array('error' => "Not a valid email."));
	else
	{
		$email = $_POST["email"]; $password = $_POST["password"];
		/*
		 * validate the email
		 * hash the password
		 * start a transaction 
		 */
		//validate_email($email);
		$password = hash("SHA1", $password);
		$registered = register_user($email, $password, $error);
		if (!$registered)
		{
			render('register', array('error' => $error));
		}
		else
		{
			render('login');	
		}
	}
}
else
{
	render('register');
}