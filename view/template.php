<?php
	
	/* 
	 * This is the generic template that calls all the other templates.
	 * 
	 * Shall be able to take a title argument, a view argument, a error argument, 
	 * a header argument with a header name, and a data argument which shall be an array.
	 */
	
	require_once('../includes/helper.php');
	render('header', array('title' => isset($title) ? $title : 'C$75 Finance'));
	
	echo "	<div id='container'>
			<div id='frame'>
			<h2 id='header' style='font-family:sans-serif'>" . $header . "</h2> ";
	render($view, array('data' => isset($data) ? $data : array()));
	echo "</div>";
	
	if (isset($error))
		echo "<p>{$error}<p/>"; 
	echo "</div>";
	
	render('footer');

?>
