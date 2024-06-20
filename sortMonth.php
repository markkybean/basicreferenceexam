<?php
$month = "January-February March April May June July August/September.October November#December";

// Remove special characters except spaces
$cleanMonth = preg_replace('/[^a-zA-Z\s]/', ' ', $month);

$counter = 0;
$sortMonth = '';
$sortMonth = '<pre>';
$monthsArray = explode(' ', $cleanMonth);
foreach ($monthsArray as $monthName) {
    $counter++;
    $sortMonth .= $counter . "\t" . $monthName . "<br>";
}
$sortMonth .= "</pre>";

header("Location: index.php?sortMonth=" . urlencode($sortMonth));
exit();

?>
