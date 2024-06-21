<!-- removing special characters -->
<?php
$month = "January-February March April May June July August/September.October November#December";

// Remove special characters except spaces
$cleanMonth = preg_replace('/[^a-zA-Z\s]/', ' ', $month);
$cleanMonth = strtoupper($cleanMonth);

$sortMonth .= "</pre>";

header("Location: index.php?cleanMonth=" . urlencode($cleanMonth));
exit();

?>