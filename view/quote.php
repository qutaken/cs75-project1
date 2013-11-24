<?php
require_once('../includes/helper.php');
if (!isset($quote_data["symbol"]) || $quote_data["last_trade"] == 0.00)
{
    // No quote data
    render('header', array('title' => 'Quote'));
    print_quote_form(array());
}
else
{
    // Render quote for provided quote data
    render('header', array('title' => 'Quote for '.htmlspecialchars($quote_data["symbol"])));
?>


<!-- make a input field to input stock name -->
<?php print_quote_form($quote_data); ?>

<script type='text/javascript'>
// <! [[CDATA
// set the focus to the email field (located by id attribute)
$("input[name=param]").focus();

// ]] >
</script>


<?php
}
function print_quote_form($quote_data)
{
    echo '
        <div id="container">
            <div id="frame">
                <h2 id="header" style="font-family:sans-serif;">Get Quote</h2>
                <form action="quote" method="POST">
                    <div class="field text">
                        <label for="quote">Symbol</label>
                        <input type="text" name="param" placeholder="Stock Symbol" id="symbol">
                    </div>
                    <div class="field text">
                        <input type="submit" value="Submit">
                    </div>
                </form>
            </div>
    ';
    if (isset($quote_data["symbol"]))
    {
        echo'    <table id="table_view">
                <tr>
                    <th>Symbol</th>
                    <th>Name</th>
                    <th>Last Trade</th>
                </tr>
                <tr>';
                echo  "  <td>".htmlspecialchars($quote_data["symbol"])."</td>";
                echo  "  <td>".htmlspecialchars($quote_data["name"])."</td>";
                echo  "  <td>".htmlspecialchars($quote_data["last_trade"])."</td>
                </tr>
            </table>";
    }
    else
    {
        print "<br/>No valid symbol was provided, or no quote data was found.";
    }
    echo "</div>";
    
}

render('footer');
?>
