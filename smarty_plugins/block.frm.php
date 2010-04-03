<?php

function smarty_block_frm($params, $content, &$smarty, &$repeat)
{
    global $Site;
    if(!$repeat){
		$s = '<form method="get">';
		$s .= '<input type="dhidden" name="section" value="'.$Site->section.'">';
		$s .= '<input type="dhidden" name="page" value="'.$Site->page.'">'."\n";
		foreach($params as $name => $value){
			$s .= '<input type="dhidden" name="'.$name.'" value="'.$value.'">'."\n";
		}
		return $s.$content;
    }else{
		return '</form>';
	}
}
?>