<table id="table_view">
    <tr>
        <th>Symbol</th>
        <th>Shares</th>
        <th>Price</th>
        <th>Total</th>
    </tr>
<?php
setlocale(LC_MONETARY, 'en_US.UTF-8');
$prices = $data['prices'];
foreach ($data['holdings'] as $holding)
{
    print "<tr>";
    print "<td>" . htmlspecialchars($holding["symbol"]) . "</td>";
    print "<td>" . htmlspecialchars($holding["amount"]) . "</td>";
    print "<td>" . htmlspecialchars(money_format('%i', $prices[$holding['symbol']][0])) . "</td>";
    print "<td>" . htmlspecialchars(money_format('%i', $prices[$holding['symbol']][1])) . "</td>";
    print "</tr>";
}
?>
	<table id="table_view">
		<th>Total: </th>
		<td><?= htmlspecialchars(money_format('%i', $data['total'])) ?></td>
	</table>
	<table id="table_view">
		<th>Balance: </th>
		<td><?= htmlspecialchars(money_format('%i', $data['balance'])) ?></td>
	</table>
</table>