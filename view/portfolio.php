<table id="table_view">
    <tr>
        <th>Symbol</th>
        <th>Shares</th>
        <th>Price</th>
        <th>Total</th>
    </tr>
<?php
setlocale(LC_MONETARY, 'en_US.UTF-8');
$prices = isset($data['prices']) ? $data['prices'] : null;
if (isset($data['holdings']))
{
	foreach ($data['holdings'] as $holding)
	{
	    print "<tr>";
	    print "<td>" . htmlspecialchars($holding["symbol"]) . "</td>";
	    print "<td>" . htmlspecialchars($holding["amount"]) . "</td>";
	    print "<td>" . htmlspecialchars(money_format('%i', $prices[$holding['symbol']][0])) . "</td>";
	    print "<td>" . htmlspecialchars(money_format('%i', $prices[$holding['symbol']][1])) . "</td>";
	    print "<td><a href=\"/sell/{$holding['symbol']}\" class='list_item'>Sell</a></td>";
	    print "</tr>";
	}
}
?>
<?php if (isset($data['total'])): ?>
	<table id="table_view">
		<th>Total: </th>
		<td><?= htmlspecialchars(money_format('%i', $data['total'])) ?></td>
	</table>
<?php endif; ?>
	<table id="table_view">
		<th>Balance: </th>
		<td><?= htmlspecialchars(money_format('%i', $data['balance'])) ?></td>
	</table>
</table>