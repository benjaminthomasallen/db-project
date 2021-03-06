<?php
/*
  Calendar controls, see calendar_builder for reference.

   Will be adjusted to implement event view restrictions in background for
   Public, Private, and RSO views. As well as RSO selection.
*/

/* select events public, private, rso */
$pArray= array('Public', 'RSO', 'Private');
$select_privacy_control = '<select name="privacy" id="privacy">'.
													'<option value="1" selected ="selected">'.
													'Public </option>'.
													'<option value="2">'.
													'RSO</option>'.
													'<option value="3">'.
													'Private </option></select>';

/* select month control */
$select_month_control = '<select name="month" id="month">';
for($x = 1; $x <= 12; $x++) {
	$select_month_control.= '<option value="'.$x.'"'.($x != $month ? '' : ' selected="selected"').'>'.date('F',mktime(0,0,0,$x,1,$year)).'</option>';
}
$select_month_control.= '</select>';

/* select year control */
$year_range = 7;
$select_year_control = '<select name="year" id="year">';
for($x = ($year-floor($year_range/2)); $x <= ($year+floor($year_range/2)); $x++) {
	$select_year_control.= '<option value="'.$x.'"'.($x != $year ? '' : ' selected="selected"').'>'.$x.'</option>';
}
$select_year_control.= '</select>';

/* "next month" control */
$next_month_link = '<a href="?month='.($month != 12 ? $month + 1 : 1).'&year='.($month != 12 ? $year : $year + 1).'" class="control">Next Month >></a>';

/* "previous month" control */
$previous_month_link = '<a href="?month='.($month != 1 ? $month - 1 : 12).'&year='.($month != 1 ? $year : $year - 1).'" class="control"><< 	Previous Month</a>';

/* bringing the controls together */
$controls = '<form method="get">'.$select_privacy_control.$select_month_control.$select_year_control.' <input type="submit" name="submit" value="Go" /><br>'.$previous_month_link.'     '.$next_month_link.' </form>';

echo $controls;
?>
