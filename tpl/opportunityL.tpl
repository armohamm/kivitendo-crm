<!-- $Id$ -->
<html>
	<head><title></title>
    <link type="text/css" REL="stylesheet" HREF="../css/{ERPCSS}"></link>
    <link type="text/css" REL="stylesheet" HREF="css/{ERPCSS}"></link>
	<script language="JavaScript">
	<!--
		function showO(id) {
			self.location="opportunity.php?id="+id
		}
	//-->
	</script>
<body>
<p class="listtop">.:opportunity:.</p>
<span style="position:absolute; left:10px; top:47px; width:95%;">
<!-- Hier beginnt die Karte  ------------------------------------------->
<table>
	<tr ><td class="norm">.:company:.&nbsp;</td><td class="norm">&nbsp;.:order:.</td><td class="norm" style="width:20;text-align:right">%</td><td class="norm" style="width:80;text-align:center">&euro;</td><td>.:status:.</td></tr>
<!-- BEGIN Liste -->
	<tr  onMouseover="this.bgColor='#FF0000';" onMouseout="this.bgColor='{LineCol}';" bgcolor="{LineCol}" onClick="showO({id});" colspan="0">
		<td class="norm">{firma}&nbsp;</td><td class="norm">&nbsp;{title}</td><td class="norm" style="width:20;text-align:right">{chance}</td><td class="norm" style="width:80;text-align:right"> {betrag}</td><td class="norm">&nbsp;{status}</td>
        <td><a href="opportunity.php?history={oppid}"><img src="image/extra.png" border="0" style="visibility:{show}"></a></td>
</tr>
<!-- END Liste -->
</table>
<!-- Hier endet die Karte ------------------------------------------->
</span>
</body>
</html>
