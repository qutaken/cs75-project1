<?php
/****************************************************
 * helper.php
 *
 * CSCI S-75
 * Project 1
 * Chris Gerber
 *
 * Renders a view template with specified parameters
 * This should be required by all controllers.
 ****************************************************/
	require_once("constants.php");
/*
 * render() - Renders the template
 *
 * @param string $template - The name of the template to render.
 * @param array $data - An array of variables and values to pass to the template.
 */
function render($template, $data = array())
{
    $path = __DIR__ . '/../view/' . $template . '.php';
	if (file_exists($path))
    {
        extract($data);
        require($path);
    }
}

/*
 * query() - Queries the Database - returns: on success - a statement_handle ready to be executed.
 *                 							 on failure - false.
 *
 * @param string $query_string - The query that you want to query
 * @param array $array_values - An array with key=>value pairs where key is the placeholder
 *  and value is the value that gets plugged in to the string using bindValues()
 */
function prepare_query($query_string, $array_values)
{
	try 
	{
		$dbh = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_DATABASE, DB_USER, DB_PASSWORD);
		$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	} 
	catch(PDOexception $e) 
	{
		echo "Error: connecction could not be made with database we are very sorry for the inconvenience 
		and our team are working to fix this error.\n";
		return false;
	}
	// prepare the string for database query.
	$sth = $dbh->prepare($query_string);
	if ($sth === false)
	{
		echo "Not a valid SQL query";
		return false;
	}
	foreach ($array_values as $key => $value) {
		$sth->bindValues(':' . $key, $value);
	}
	return $sth;
}

/*
 * This piece of code makes sure the user is logged in before he can access any page
 * and if he isn't it redirects him to the login page.
 */
if (isset($_GET["page"]))
{
	$page = $_GET["page"];
	if ($page !== "login" | "register" | "logout")
	{
		if (!isset($_SESSION["userid"]))
		{
			header("Location: http://project1/");
			exit;
		}
	}	
}


?>
