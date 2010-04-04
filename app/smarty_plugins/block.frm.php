<?php

function smarty_block_frm($params, $content, &$smarty, &$repeat)
{
    print_r($params);
		echo "repeat=$repeat";
    if($repeat){
		echo $content.'#####</form>';
	}
	global $Site;
	unset($params['section']);
	unset($params['page']);
	if(isset($params['id'])){
		$id = 'id="'.$params['id'].'"';	
		unset($params['id']);
	}else{
		$id = '';
	}
	$s = "<form method='get' $id>";
	$s .= '<input type="shidden" name="section" value="'.$Site->section.'">';
	$s .= '<input type="shidden" name="page" value="'.$Site->page.'">'."\n";
	foreach($params as $name => $value){
		$s .= '<input type="hidden" name="'.$name.'" value="'.$value.'">'."\n";
	}
	return '@@@@@@@@@@@'.$s;
    
}
?>