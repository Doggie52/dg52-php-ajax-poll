<form name="add" action="index.php?handle=add" method="post">
	<table>
		<tr>
			<td class="label">Poll Header:</td><td><input type="text" name="question" /></td>
		</tr>
		<tr>
			<td class="label">First Answer:</td><td><input type"text" name="a1" /></td>
		</tr>
		<tr>
			<td class="label">Second Answer:</td><td><input type="text" name="a2" /></td>
		</tr>
		<tr>
			<td class="label">Third Answer:</td><td><input type="text" name="a3" /></td>
		</tr>
		<tr>
			<td class="label">Fourth Answer:</td><td><input type="text" name="a4" /></td>
		</tr>
		<tr>
			<td class="label">Fifth Answer:</td><td><input type="text" name="a5" /></td>
		</tr>
		<tr>
			<td class="label">Show by default:</td><td><select name="show"><option value="1">Yes</option><option value="0">No</option></select></td>
		</tr>
		<tr>
			<td>&nbsp;</td><td class="label"><input type="submit" value="Add poll" name="submit" class="submit"/></td>
		</tr>
	</table>
</form>