<?php

/*
initialisasi di /etc/rc.local
=============================

echo 18 > /sys/class/gpio/export
echo 19 > /sys/class/gpio/export
echo 20 > /sys/class/gpio/export
echo 21 > /sys/class/gpio/export
echo 22 > /sys/class/gpio/export

echo out > /sys/class/gpio/gpio18/direction
echo out > /sys/class/gpio/gpio19/direction
echo out > /sys/class/gpio/gpio20/direction
echo out > /sys/class/gpio/gpio21/direction
echo out > /sys/class/gpio/gpio22/direction
*/

if(isset($_GET['webcam']) && isset($_GET['webcam']) == 1) {
        header("Content-Type: image/jpeg");
        echo file_get_contents("http://192.168.111.10:8888/out.jpg");
        exit;
}

if(isset($_GET['mode']) && isset($_GET['gpio']) && in_array($_GET['gpio'],range(18,22)) && ($_GET['mode'] == 1 || $_GET['mode'] == 0)) {
        exec("echo ".$_GET['mode']." > /sys/devices/virtual/gpio/gpio".$_GET['gpio']."/value");
        header("Location: /saklar.php");
}

function status($gpio) {
        $status = `cat /sys/devices/virtual/gpio/gpio$gpio/value`;
        if($status == 0) return "on";
        else return "off";
}

?>
<h1>saklar 1 [<?php echo status(20); ?>] : <a href="saklar.php?gpio=20&mode=0">on</a> <a href="saklar.php?gpio=20&mode=1">off</a></h1>
<h1>saklar 2 [<?php echo status(19); ?>] : <a href="saklar.php?gpio=19&mode=0">on</a> <a href="saklar.php?gpio=19&mode=1">off</a></h1>
<h1>saklar 3 [<?php echo status(18); ?>] : <a href="saklar.php?gpio=18&mode=0">on</a> <a href="saklar.php?gpio=18&mode=1">off</a></h1>
<h1>saklar 4 [<?php echo status(22); ?>] : <a href="saklar.php?gpio=22&mode=0">on</a> <a href="saklar.php?gpio=22&mode=1">off</a></h1>

<img src="saklar.php?webcam=1" />

<pre><h1>ifconfig</h1>
<?php echo `ifconfig`; ?>
</pre>

<h1>Code file ini</h1>
<?php echo show_source ('saklar.php'); ?>
