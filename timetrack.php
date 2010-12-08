<?php
    require_once("inc/stdLib.php");
    require_once("inc/crmLib.php");
    require("firmacommon".XajaxVer.".php");
    include("inc/template.inc");

    $jscal1 ="<style type='text/css'>@import url(../js/jscalendar/calendar-win2k-1.css);</style>\n";
    $jscal1.="<script type='text/javascript' src='../js/jscalendar/calendar.js'></script>\n";
    $jscal1.="<script type='text/javascript' src='../js/jscalendar/lang/calendar-de.js'></script>\n";
    $jscal1.="<script type='text/javascript' src='../js/jscalendar/calendar-setup.js'></script>\n";
    $jscal2 ="<script type='text/javascript'><!--\n";
    $jscal2.="Calendar.setup( {inputField : 'START',ifFormat :'%d.%m.%Y',align : 'BL', button : 'trigger1'});\n";
    $jscal2.="Calendar.setup( {inputField : 'STOP',ifFormat :'%d.%m.%Y',align : 'BL', button : 'trigger2'});\n";
    $jscal2.="Calendar.setup( {inputField : 'startd',ifFormat :'%d.%m.%Y',align : 'BL', button : 'trigger3'});\n";
    $jscal2.="Calendar.setup( {inputField : 'stopd',ifFormat :'%d.%m.%Y',align : 'BL', button : 'trigger4'});\n";
    $jscal2.="//-->\n</script>";
    $t = new Template($base);
    $t->set_file(array("tt" => "timetrack.tpl"));
    if ($_POST["save"]) {
        $data = saveTT($_POST);
    } else if ($_POST["savett"]) {
        $rc = saveTTevent($_POST);
        $data = getOneTT($_POST["tid"]);
    } else if ($_GET["stop"]=="now") {
        $rc = stopTTevent($_GET["eventid"],date('Y-m-d H:i'));
        $data = getOneTT($_GET["tid"]);
    } else if ($_POST["search"]) {
        $data = searchTT($_POST);
        if (count($data)>1) {
            $t->set_block("tt","Liste","Block");
            foreach ($data as $row) {
                $t->set_var(array(
                    tid => $row["id"],
                    ttn => $row["ttname"]
                ));
                $t->parse("Block","Liste",true);
            }
            $visible = true;
            $data = $_POST;
        } else if (count($data)==0) {
            $data = $_POST;
            $data["msg"] = ".:not found:.";
        } else {
            $data = getOneTT($data[0]["id"]);
	        $delete = ($data["uid"]==$_SESSION["loginCRM"])?True:False;
        }
    } else if ($_POST["getone"]) {
        $data = getOneTT($_POST["tid"]);
	    $delete = ($data["uid"]==$_SESSION["loginCRM"])?True:False;
    } else if ($_POST["delete"]) {
        $rc = deleteTT($_POST["id"]);
        if ($rc) {
            $msg = ".:deleted:.";
        } else {
            $msg = ".:not posible:.";
        };
    } else if ($_POST["clr"]) {
            if ($_POST["clrok"]=="1" || count($_POST["clear"])>0) {
                if ($_POST["tid"]) {
                    if (count($_POST["clear"])>0) $evids = "and t.id in (".implode(",",$_POST["clear"]).") ";
                    $msg = mkTTorder($_POST["tid"],$evids);
                    $data = getOneTT($_POST["tid"]);
                    $data["msg"] = $msg;
                } else {
                    $data["msg"] = ".:missing:. .:customer:.";
                }
            } else {
                $data = getOneTT($_POST["tid"]);
                $data["msg"] = ".:clrok:.";
            }
    } else {
        unset($data);
        $data["active"] = "t";
    }
    if ($data["events"]) {
	$delete = False;
    }
    $t->set_var(array(
        ERPCSS  => $_SESSION["stylesheet"],
        AJAXJS  => $xajax->printJavascript(XajaxPath),
        noevent => ($data["active"]=="t")?"visible":"hidden",
        noown   => ($data["id"]>0 && $data["uid"]!=$_SESSION["loginCRM"])?"hidden":"visible",
        id      => $data["id"],
        name    => $data["name"],
        fid     => $data["fid"],
        tab     => $data["tab"],
        aim     => $data["aim"],
        ttname  => $data["ttname"],
        ttdescription => $data["ttdescription"],
        startdate  => $data["startdate"],
        stopdate   => $data["stopdate"],
        active.$data["active"] => "checked",
        msg     => $data["msg"],
        visible => ($visible)?"visible":"hidden",
        delete  => ($delete)?"visible":"hidden",
        chkevent => ($data["id"]>0)?"onLoad='getEventListe();'":"",
        jcal0 => ($jcalendar)?$jscal1:"",
        jcal1 => ($jcalendar)?"<a href='#' id='trigger1' name='START' title='.:startdate:.' onClick='false'><img src='image/date.png' border='0' align='middle'></a>":"",
        jcal2 => ($jcalendar)?"<a href='#' id='trigger2' name='STOP' title='.:stopdate:.' onClick='false'><img src='image/date.png' border='0' align='middle'></a>":"",
        jcal3 => ($jcalendar)?"<a href='#' id='trigger3' name='startid' title='.:stopdate:.' onClick='false'><img src='image/date.png' border='0' align='middle'></a>":"",
        jcal4 => ($jcalendar)?"<a href='#' id='trigger4' name='stopid' title='.:stopdate:.' onClick='false'><img src='image/date.png' border='0' align='middle'></a>":"",
        jcal5 => ($jcalendar)?$jscal2:"",

    ));

    $t->Lpparse("out",array("tt"),$_SESSION["lang"],"work");
?>