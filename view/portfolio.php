<table id="table_view">
    <tr>
        <th>Symbol</th>
        <th>Shares</th>
    </tr>
<?php
foreach ($data['holdings'] as $holding)
{
    print "<tr>";
    print "<td>" . htmlspecialchars($holding["symbol"]) . "</td>";
    print "<td>" . htmlspecialchars($holding["amount"]) . "</td>";
    print "</tr>";
}
?>
	<table id="table_view">
		<th>Balance: </th>
		<td><?= htmlspecialchars($data['balance']) ?></td>
	</table>
</table>