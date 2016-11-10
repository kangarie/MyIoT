<?php

function status($n) {
        if(!in_array($n,range(1,4))) exit;

        $out = json_decode(file_get_contents("http://192.168.111.19/digital/$n/r"),true);
        if ($out['return_value'] == 0) return "on";
        else return "off";
}

if(isset($_GET['mode']) && isset($_GET['gpio']) && in_array($_GET['gpio'],range(1,4)) && ($_GET['mode'] == 1 || $_GET['mode'] == 0)) {
        file_get_contents("http://192.168.111.19/digital/".$_GET['gpio']."/".$_GET['mode']);
        header("Location: /nodemcu.php");
}

?>

<h1>saklar 1 [<?php echo status(1); ?>] : <a href="nodemcu.php?gpio=1&mode=0">on</a> <a href="nodemcu.php?gpio=1&mode=1">off</a></h1>
<h1>saklar 2 [<?php echo status(2); ?>] : <a href="nodemcu.php?gpio=2&mode=0">on</a> <a href="nodemcu.php?gpio=2&mode=1">off</a></h1>
<h1>saklar 3 [<?php echo status(3); ?>] : <a href="nodemcu.php?gpio=3&mode=0">on</a> <a href="nodemcu.php?gpio=3&mode=1">off</a></h1>
<h1>saklar 4 [<?php echo status(4); ?>] : <a href="nodemcu.php?gpio=4&mode=0">on</a> <a href="nodemcu.php?gpio=4&mode=1">off</a></h1>

<img src="saklar.php?webcam=1" />

<h1>Code file ini</h1>
<?php echo show_source ('nodemcu.php'); ?>
