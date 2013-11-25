            <form action="quote" method="POST">
                <div class="field text">
                    <label for="quote">Symbol</label>
                    <input type="text" name="param" placeholder="Stock Symbol" id="symbol">
                </div>
                <div class="field text">
                    <input type="submit" value="Submit">
                </div>
            </form>

<?php
if (isset($data["symbol"]) && $data["last_trade"] > 0.0)
    {
        echo'    <table id="table_view">
                <tr>
                    <th>Symbol</th>
                    <th>Name</th>
                    <th>Last Trade</th>
                </tr>
                <tr>';
                echo  "  <td>".htmlspecialchars($data["symbol"])."</td>";
                echo  "  <td>".htmlspecialchars($data["name"])."</td>";
                echo  "  <td>".htmlspecialchars($data["last_trade"])."</td>
                </tr>
            </table>";
    }
?>

<script type='text/javascript'>
// <! [[CDATA
// set the focus to the email field (located by id attribute)
$("input[name=param]").focus();

// ]] >
</script>