<html>
	<head><title>User Stamm</title>
	{STYLESHEETS}
        <link type="text/css" REL="stylesheet" HREF="{ERPCSS}/main.css">
        <link rel="stylesheet" type="text/css" href="{JQUERY}/jquery-ui/themes/base/jquery-ui.css">
    {THEME}    
        <script type="text/javascript" src="{JQUERY}jquery-ui/jquery.js"></script>
    {JAVASCRIPTS}
<body>
{PRE_CONTENT}
{START_CONTENT}
<p class="listtop">Stammdaten</p>
<!-- Beginn Code ----------------------------------------------->
<br>
<table>
	<tr><td class="norm">User ID</td>	<td>: {uid}</td></tr>
	<tr><td class="norm">Login</td>		<td>: {login}</td></tr>
	<tr><td class="norm">Name</td>		<td>: {name}</td></tr>
	<tr><td class="norm">Strasse</td>	<td>: {addr1}</td></tr>
	<tr><td class="norm">Plz Ort</td>	<td>: {addr2} {addr3}</td></tr>
	<tr><td class="norm">Telefon gesch.&nbsp;</td><td>: {workphone}</td></tr>
	<tr><td class="norm">Telefon priv.</td>	<td>: {homephone}</td></tr>
	<tr><td class="norm">E-Mail</td>	<td>: <a href='mail.php?TO={email}'>{email}</a></td></tr>
	<tr><td class="norm">Abteilung</td>	<td>: {abteilung}</td></tr>
	<tr><td class="norm">Vertreter</td>	<td>: {vertreter}</td></tr>
	<tr><td class="norm">Bemerkung</td>	<td>: {notes}</td></tr>
</table>
<!-- End Code ----------------------------------------------->
<!--/td></tr></table-->
{END_CONTENT}
</body>
</html>

