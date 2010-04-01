<?php

function smarty_block_source($params, $content, &$smarty, &$repeat)
{
    // only output on the closing tag
    if(!$repeat){

		$geshi = new Geshi($content, $params['lang']);
		$geshi->set_header_type(GESHI_HEADER_PRE);
		return $geshi->parse_code();
    }
}
?>