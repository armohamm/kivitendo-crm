<?php
clearstatcache();
session_start();
if ($_POST["erpname"]) {
    if ( is_file("../".$_POST["erpname"]."/config/".$_SESSION['erpConfigFile'].".conf") ) {
        if ( is_writable("inc/conf.php") ) {
            $name = false;
            $configfile = file("inc/conf.php");
            $f = fopen("inc/conf.php","w");
            foreach( $configfile as $row ) {
                $tmp = trim($row);
                if ( preg_match('/ERPNAME/',$tmp) ) {
                    fputs($f,'$ERPNAME="'.$_POST["erpname"]."\";\n");
                    $name=true;
                } else {
                    if ( preg_match('/\?>/',$tmp) && !$name ) fputs($f,'$ERPNAME="'.$_POST["erpname"].'";'."\n");
                    fputs($f,$tmp."\n");
                }
            }
            fclose($f);
        } else {
            echo "inc/conf.php ist nicht beschreibbar";
        }
    }
    $_SESSION['ERPNAME'] = $_POST["erpname"];
    $_SESSION['erpConfigFile'] = $_POST['erpConfigFile'];
}

$conffile = '';
if ( substr(getcwd(),-3) == "inc" || substr(getcwd(),-6) == "jqhelp" || substr(getcwd(),-6) == "lxcars" ) {
    $conffile = "../";
}
$conffile .= "../".$_SESSION['ERPNAME']."/config/".$_SESSION['erpConfigFile'].".conf";

//$conf = array('ERPNAME','erpConfigFile');
//while( list($key,$val) = each($_SESSION) ) {
//    if ( ! in_array($key,$conf) ) unset($_SESSION[$key]);
//};

if ( is_file($conffile) ) {
    $tmp = anmelden();
    if ( $tmp ) {
        $rs = $_SESSION['db']->getOne('SELECT * FROM crm ORDER BY version DESC LIMIT 1');
        if ( is_object($rs) ) {
            echo "DebugInfo: MDB2 hat statt einem Array ein Objekt zurückgeben,  
                  PHP Fatal error:  Cannot use object of type MDB2_Error as array";           
            print_r($rs);
        }    
        if ( !$rs || $rs["version"]=="" || $rs["version"]==false ) {
            echo "CRM-Tabellen sind nicht (vollst&auml;ndig) installiert"; 
            flush(); 
            require("install.php");
            require("inc/update_neu.php");
        } else if (  $rs["version"] <> $_SESSION['VERSION'] ) {
            echo "Istversion: ".$rc[0]["version"]." Sollversion: ".$_SESSION['VERSION']."<br>";
            $oldver=$rc[0]["version"];
            require("inc/update_neu.php");
        } else {
            $db = $_SESSION["db"];
            $_SESSION["loginok"] = "ok";
            $LOGIN = True;
            require ("update_neu.php");
        } /*else {
            echo "db-Version nicht ok";
            exit;*/
    } else {
        echo $_SESSION["man"]." Session abgelaufen.";
        $Url  = (empty( $_SERVER['HTTPS'] )) ? 'http://' : 'https://';
        $Url .= $_SERVER['HTTP_HOST'];
        $Url .= preg_replace( "^crm/.*^", "", $_SERVER['REQUEST_URI'] );
        session_unset();
        header('Location: '.$Url.'login.pl?x=1');
        exit;
    };
} else {
    echo "Configfile nicht gefunden<br>$PHPSELF<br>";
    echo "ERP V 3.0.0 oder gr&ouml;&szlig;er erwartet!!!<br><br>";
    echo "<form name='erppfad' method='post' action='".$PHPSELF."'>";
    echo "Bitte den Verzeichnisnamen (nicht den Pfad) der ERP eingeben:<br>";
    echo "<input type='text' name='erpname'><br>";
    echo "Bitte den Namen des Konfigurationsfiles ERP eingeben (ohne conf):<br>";
    echo "<input type='text' name='conffile'><br>";
    echo "<input type='submit' name='saveerp' value='sichern'>";
    echo "</form>";
    exit;
}
?>
