<html>
<head>
<link href="css/calendar.css" type="text/css" rel="stylesheet" />
</head>
<body>
<?php
include 'php/calendar_builder.php';
/* sample usages */
echo '<h2>July 2009</h2>';
echo build_calendar(7,2009);

echo '<h2>August 2009</h2>';
echo build_calendar(8,2009);
?>
</body>
</html>
