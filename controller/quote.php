<?php
/*******************
 * quote.php
 *
 * CSCI S-75
 * Project 1
 * Chris Gerber
 *
 * Quote controller
 *******************/

require_once('../model/model.php');
require_once('../includes/helper.php');

if (isset($_REQUEST['param']))
{
	$quote_data = get_quote_data(urlencode($_REQUEST['param']));
	render('quote', array('quote_data' => $quote_data));
}
else
{
	render('quote');
}
?>