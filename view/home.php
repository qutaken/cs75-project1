<?php
require_once('../includes/helper.php');
render('header', array('title' => 'C$75 Finance'));
?>

<ul>
	<li><a href="quote/GOOG">Get quote for Google</a></li>
	<li><a href="portfolio">View Portfolio</a></li>
	<li><a href="logout">Logout</a></li>
</ul>

<?php
render('footer');
?>
