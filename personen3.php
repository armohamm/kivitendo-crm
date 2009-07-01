<?
// $Id: personen3.php 3578 2009-02-20 14:33:28Z hlindemann $
	require_once("inc/stdLib.php");
	include("inc/template.inc");
	include("inc/laender.php");
	include("inc/crmLib.php");
	include("inc/UserLib.php");
	include("inc/persLib.php");
	include("inc/FirmenLib.php");
	$t = new Template($base);
	$Q=($_GET["Quelle"])?$_GET["Quelle"]:$_POST["Quelle"];	
	
	if ($_POST["show"]) {
		header("location:firma2.php?Q=$Q&id=".$_POST["PID"]);
	} else if ($_POST["save"]||$_POST["neu"]) {
		if ($_POST["neu"]) { 
			$_POST["PID"]=0;
			$rc=savePersonStamm($_POST,$_FILES);
		} else {
			if (chkTimeStamp("contacts",$_POST["PID"],$_POST["mtime"])) {
				$rc=savePersonStamm($_POST,$_FILES);
			} else {
				$rc=-10;
			}
		}
		if (ereg("^[0-9]+$",$rc)) {
			$msg="Daten gesichert.";
			$daten=getKontaktStamm(($_POST["PID"])?$_POST["PID"]:$rc);
			$daten["Quelle"]=$Q;
			$btn3="<input type='submit' class='sichern' name='save' value='sichern update' tabindex='25'>";
			$btn1="<input type='submit' class='anzeige' name='show' value='zur Anzeige'>";
			$btn2="<input type='submit' class='sichernneu' name='neu' value='sichern als neu'>";
			vartplP ($t,$daten,$msg,$btn1,$btn2,$btn3,"cp_givenname","white",0,3);
		} else {
			if ($_POST["PID"]) {
				$_POST["cp_id"]=$_POST["PID"];
				$btn3="<input type='submit' class='sichern' name='save' value='sichern update' tabindex='25'>";
				$btn1="<input type='submit' class='anzeige' name='show' value='zur Anzeige'>";
			} else {
				$btn1="";
				$btn3="";
			}
			if ($rc==-10) {
				$msg="Daten wurden inzwischen modifiziert";
			} else {
				$msg="Fehler beim Sichern ($rc)";
			};
			$btn2="<input type='submit' class='sichernneu' name='neu' value='sichern als neu'>";			
			vartplP ($t,$_POST,$msg,$btn1,$btn2,$btn3,$rc,"red",1,3);
		}
	} else if ($_POST["edit"]>0 || $_GET["edit"]>0) {
		if ($_POST["id"]) {
			$id=$_POST["id"];
		} else {
			$id=$_GET["id"];
		}
		if (!$id) header("location:personen1.php?Q=$Q");
		$daten=getKontaktStamm($id);
		$daten["Quelle"]=$Q;
		$msg="Edit: <b>$id</b>";
		$btn3="<input type='submit' class='sichern' name='save' value='sichern update' tabindex='25'>";
		$btn1="<input type='submit' class='anzeige' name='show' value='zur Anzeige'>";
		$btn2="<input type='submit' class='sichernneu' name='neu' value='sichern als neu'>";
		vartplP ($t,$daten,$msg,$btn1,$btn2,$btn3,"cp_givenname","white",0,3);
	} else {
		$msg="Neue Person";
		leertplP($t,$_GET["fid"],$msg,3,true,$Q);
	}
	$t->Lpparse("out",array("pers1"),$_SESSION["lang"],"firma");

?>
