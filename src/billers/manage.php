<?php
include('./include/include_main.php');

//stop the direct browsing to this file - let index.php handle which files get displayed
checkLogin();


$sql = "SELECT * FROM {$tb_prefix}biller ORDER BY b_name";

$result = mysql_query($sql, $conn) or die(mysql_error());
$number_of_rows = mysql_num_rows($result);


if (mysql_num_rows($result) == 0) {
	$display_block = "<P><em>$mb_no_invoices.</em></p>";
}
else {
$display_block = <<<EOD
<b>$mb_page_header :: <a href='index.php?module=billers&view=add'>$mb_actions_new_biller</a></b>
 <hr></hr>


<table class="ricoLiveGrid manage" id="rico_biller" align="center">
<colgroup>
<col style='width:15%;' />
<col style='width:10%;' />
<col style='width:40%;' />
<!--
<col style='width:10%;' />
<col style='width:10%;' />
-->
<col style='width:25%;' />
<col style='width:10%;' />
</colgroup>
<thead>
<tr class="sortHeader">
<th class="noFilter sortable">$mb_table_action</th>
<th class=" index_table sortable">$mb_table_biller_id</th>
<th class="index_table sortable">$mb_table_biller_name</th>
<!--
<th class="index_table">$mb_table_phone</th>
<th class="index_table">$mb_table_mobile_phone</th>
-->
<th class="index_table sortable">$mb_table_email</th>
<th class="noFilter index_table sortable">$wording_for_enabledField</th>
</tr>
</thead>
EOD;



while ($biller = mysql_fetch_array($result)) {
	
        if ($biller['b_enabled'] == 1) {
                $wording_for_enabled = $wording_for_enabledField;
        } else {
                $wording_for_enabled = $wording_for_disabledField;
        }



	$display_block .= "
	<tr class='index_table'>
	<td class='index_table'>
	<a class='index_table' href='index.php?module=billers&view=details&submit={$biller['b_id']}&action=view'>
	{$mb_actions_view}</a>
	 :: 
	<a class='index_table' href='index.php?module=billers&view=details&submit={$biller['b_id']}&action=edit'>
	{$mb_actions_edit}</a></td>
	<td class='index_table'>{$biller['b_id']}</td>
	<td class='index_table'>{$biller['b_name']}</td>
	<!--
	<td class='index_table'>{$biller['b_phone']}</td>
	<td class='index_table'>{$biller['b_mobile_phone']}</td>
	-->
	<td class='index_table'>{$biller['b_email']}</td>
	<td class='index_table'>{$wording_for_enabled}</td>
	</tr>";

                
	
		}	

        $display_block .="</table>";
}

require("./src/include/js/lgplus/php/chklang.php");
require("./src/include/js/lgplus/php/settings.php");

getRicoLiveGrid("rico_biller","{ type:'number', decPlaces:0, ClassName:'alignleft'}");
	
echo $display_block; 
?>