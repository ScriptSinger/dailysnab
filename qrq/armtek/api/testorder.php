

<?php

// http://dailysnab.beget.tech/qrq/armtek/api/testorder.php

$response = file_get_contents('http://dailysnab.beget.tech/qrq/armtek/api/order.php?artid=105310&userid=snabdaily@gmail.com&password=Ar299792458&count=1&codesklad=0000112952&brand=LE.MA.');


echo "<br>";
echo "<br>";

print_r($response);

echo "<br>";
echo "<br>";





?>


