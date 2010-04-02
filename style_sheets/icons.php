<?php

//** THis is the constant to the remote image/fam fam icon files
$IconServerPath =   file_exists('../LOCAL') 
                    ? 'http://localhost/~test/famfamfam_silk_icons_v013/icons/'
                    : 'http://ico.daffodil.uk.com/'
                    ;

header('content-type:text/css');

$icons = array();

$icons['icoInvis'] = 'transparent.png';



/* Widgets **************************************/
$icons['icoAdd'] = 'add.png';
$icons['icoEdit'] = 'page_white_edit.png';
$icons['icoDelete'] = 'delete.png';
$icons['icoMerge'] = 'shape_ungroup.png';

$icons['icoHelp'] = 'help.png';
$icons['icoHome'] = 'house.png';

$icons['icoRefresh'] = 'arrow_refresh.png';
$icons['icoRefresh2'] = 'refresh.gif';
#$icons['icoGo'] = 'arrow_rotate_clockwise.png';
$icons['icoSave'] = 'accept.png';
$icons['icoCancel'] = 'bullet_black.png';
$icons['icoClipboard'] = 'page_paste.png';
$icons['icoGo'] = 'bullet_go.png';

#$icons['icoMore'] = 'bullet_arrow_down.png';
$icons['icoShowMore'] = 'zoom_in.png';
$icons['icoShowLess'] = 'zoom_out.png';



$icons['icoEmail'] = 'email.png';
$icons['icoSms'] = 'phone.png';
$icons['icoMessage'] = 'text_signature.png';
$icons['icoFreeText'] = 'textfield.png';


/* Widgets **************************************/
$icons['icoBlack'] = 'bullet_black.png';
$icons['icoBlue'] = 'bullet_blue.png';
$icons['icoGreen'] = 'bullet_green.png';
$icons['icoOrange'] = 'bullet_orange.png';
$icons['icoPink'] = 'bullet_pink.png';
$icons['icoPurlple'] = 'bullet_purple.png';
$icons['icoRed'] = 'bullet_red.png';
$icons['icoYellow'] = 'bullet_yellow.png';
$icons['icoDetails'] =  'bullet_white.png';

$icons['icoSearch'] = 'find.png';


/* Form **************************************/
$icons['icoClean'] = 'bullet_black.png';
$icons['icoDirty'] = 'bullet_red.png';


/* MAP */
$icons['icoMap'] = 'map.png';
$icons['icoGeocode'] = 'map_go.png';
$icons['icoMarkerRed'] = 'm_red.png';
$icons['icoMarkerGreen'] = 'm_green.png';
$icons['icoMarkerPink'] = 'm_pink.png';
$icons['icoMarkerBlue'] = 'm_blue.png';
$icons['icoMarkerOrange'] = 'm_orange.png';
$icons['icoMarkerYellow'] = 'm_yellow.png';
$icons['icoMarkerPurple'] = 'm_purple.png';


/* Wizzard **************************************/
$icons['icoNext'] = 'arrow_right.png';
$icons['icoPrev'] = 'arrow_left.png';
$icons['icoWizard'] = 'wand.png';

$icons['icoForward'] = 'arrow_right.png';
$icons['icoBack'] = 'arrow_left.png';

$icons['icoBrowse'] = 'browse.png';

/* Actions **************************************/
$icons['icoUpload'] = 'page_white_get.png';
$icons['icoDownload'] = 'page_white_put.png';

$icons['icoQuit'] = 'control_eject.png';
$icons['icoLogin'] = 'connect.png';


$icons['icoFilter'] = 'zoom.png';
$icons['icoDate'] = 'date.png';
$icons['icoCalendar'] = 'calendar.png';

$icons['icoDocs'] = 'table_multiple.png';

$icons['icoPdf'] = 'page_white_acrobat.png';
$icons['icoExtExcel'] = 'page_excel.png';
$icons['icoExtPdf'] = 'page_white_acrobat.png';
$icons['icoExtUnknown'] = 'page_white.png';

$icons['icoLogout'] = 'book_previous.png';


/*******************************************************************************************/
/* Application Icons  */
/*******************************************************************************************/


$icons['icoUser'] = 'user.png';
$icons['icoUserView'] = 'user.png';
$icons['icoUserAdd'] = 'user_add.png';
$icons['icoUserDelete'] = 'user_delete.png';
$icons['icoUserEdit'] = 'user_edit.png';

$icons['icoUserOnline'] = 'user_green.png';
$icons['icoUserOnlinePending'] = 'user_orange.png';
$icons['icoUserActive'] = 'user.png';
$icons['icoUserInActive'] = 'user_gray.png';
$icons['icoPermissions'] = 'bullet_key.png';


$icons['icoServers'] = 'server_database.png';
$icons['icoServer'] = 'server.png';
$icons['icoServerAdd'] = 'server_add.png';
$icons['icoServerDelete'] = 'server_delete.png';
$icons['icoServerEdit'] = 'server_edit.png';






$icons['icoOn'] = 'bullet_green.png';
$icons['icoOff'] = 'bullet_black.png';

$icons['icoFilterOn'] = 'bullet_pink.png';
$icons['icoFilterOff'] = 'bullet_purple.png';

$icons['icoStart'] = 'control_play_blue.png';
$icons['icoEnd'] = 'control_stop_blue.png';

$icons['icoError'] = 'exclamation.png';


$icons['icoSettings'] = 'plugin.png';
$icons['icoMerge'] = 'table_relationship.png';

$icons['icoFolder'] = 'folder.png';
$icons['icoFolderAdd'] = 'folder_add.png';
$icons['icoFolderOpen'] = 'folder_go.png';

$icons['icoBackDoor'] = 'lock_go.png';


//** Just include this file OK
if(!defined('STOP_ME_SPOOLING_ICON')){

    foreach($desktop_icons as $k => $v){
        $str =  '#'.$k.'-win-shortcut img { width:24px; height:24px; background-repeat:  no-repeat;';
        $str .= "background-image:  url('".$IconServerPath.$v."');"; // url(../images_desktop/lab_locations.png);"
        $str .= "filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='".$IconServerPath.$v."', sizingMethod='scale');}\n";
        echo $str;
    }
    echo "\n\n";
    
    
    foreach($icons as $k => $v){
        echo '.'.$k.'{background-image: url('.$IconServerPath.$v.') !important;}'."\n";
    }

}


?>
