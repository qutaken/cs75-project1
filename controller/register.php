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
	{
		render('register', array('error' => "Passwords don't match."));
	}
	else if (strlen($_POST['password']) < 7 ||
			(!preg_match('/((^[0-9]+[a-z]+)|(^[a-z]+[0-9]+))+[0-9a-z]+$/i', $_POST['password']))
	{
		render('register', array('error' => "Not a valid password."));	
	}
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