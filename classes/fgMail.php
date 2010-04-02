<?php
/** Mail Class
 * @package FlightGear
 * @subpackage General
 * @copyright (C) 2010 FlightGear Team
 * @author Peter Morgan <ac001@daffodil.uk.com>
 * @version 0.1
 *
 *
*/
class fgMail
{
    const sendmail = 'sendmail';
    const smtp = 'smtp';

    public $M;
    public $smarty;
	public $W;

    protected $template;
    protected $title;

    public $debug;
	public $use_container = true;

    public $regex = "/^([a-zA-Z0-9])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-]+)+/";

	protected $ini;

    function __construct(){
        global $smarty, $smtp;

		$this->smarty = $smarty;

		$this->ini = new fgObject(fgHelper::loadIniFile('mail.ini'));
		print_r($this->ini->smtp);

        $this->M = new phpmailer(true);


        if($this->ini->smtp->enabled){
		    //** Set some Inherited Vars
		    $this->M->Mailer = 'smtp';
		   # $this->M->SMTPDebug = true;
		    $this->M->SMTPAuth = true;
		    $this->M->SMTPKeepAlive = true;
            $this->M->Host = $this->ini->smtp->host;
            $this->M->Username = $this->ini->smtp->user;
            $this->M->Password = $this->ini->smtp->pass;

        }else{
            $this->M->Mailer = 'sendmail';

        }

        //** Set from and add system recipients
        $this->M->Sender = $this->ini->from->email;
        $this->M->From =   $this->ini->from->email;
        $this->M->FromName = $this->ini->from->name;
       
		$this->M->IsHTML(true);
		//* Add system addresses
		$addresses = $this->to_array($this->ini->email->admin);
        foreach($addresses as $em){
            $this->M->AddBCC($em);
        }

        //** Add the logo
        //$mail->AddEmbeddedImage('my-photo.jpg', 'my-photo', 'my-photo.jpg ');
       // echo SITE_ROOT.$this->W['logo'];
        //echo SITE_ROOT.'/'.$this->W->logo;
       # $this->M->AddEmbeddedImage(SITE_ROOT.'/'.$Config->root->ticker, $Config->root->ticker.'-logo', $Config->root->ticker, 'base64', 'image/gif');
       # $this->smarty->assign('MAIN', 'emails/'.$this->template.'.html');
      #  $this->smarty->assign('title', $this->title);
    }
	public function to_array($str){
		$arr = explode(',', $str);
		$ret = array();
		foreach($arr as $a){
			$arr[] = trim($a);
		}
		return $arr;
	}

    public function __destruct(){
        $this->M->SmtpClose();
    }


    //** assume its only emails so split on space ? WTF
    public function addEmails($str, $split = true){
        $emails = dUT::explode(' ',$str);
        foreach($emails as $em ){
           // $this->mailer->AddCC( $em );
        }
    }

    public function fetch_body(){
    	//global $smarty;
    	//$smarty->assign('title', $this->title);
    	//$smarty->assign('MAIN', 'emails/'.$this->template.'.html');
    	if($this->use_container){
    		$smarty->assign('MAIN', 'emails/'.$this->template);
    		$tmp = 'emails/core.container.html';
    		
    	}else{
    		$tmp = 'emails/'.$this->template.'.html';
    	}
    	
        return  $this->smarty->fetch($tmp);
                //? 'emails/core.container.html') 
                //: $this->smarty->fetch();
    }

	public function preview(){
	   header('Content-type: text/html');
       return $this->fetch_body();
	}



    public function do_send($close_after_send = false){
		//if($this->use_container){
			$this->M->Body = $this->fetch_body(); //$this->smarty->fetch('emails/core.container.html');
		//}else{
		//	$this->Body = $this->smarty->fetch('emails/templates/'.$this->template.'.html');
	//	}
        //$this->M->Subject = $this->subject;
        //echo "do_send";
        //echo $this->M->Body;
        if(!$this->M->Send()){
        	//** Dont think this fires as its an Exception ??
            $this->M->SmtpClose();
            return false;
        }else{
			if(_LOCAL_ && $close_after_send){
				$this->M->SmtpClose();
			}
            return true;
        }
    }

	public function setSubject($subject){
		$this->M->Subject = $subject;
	}
	public function setTitle($title){
		$this->title = $title;
	}

	public function sendMail($UserObj, $template){
		global $smarty;
		if(!$smarty){
			load_smarty();
		}
		//print_r($smarty);
		$this->M->addAddress($UserObj->email, $UserObj->name);
		$smarty->assign('User', $UserObj);
		$smarty->assign('title', $this->title);
		$smarty->assign('template', $template);
		$this->M->Body = $smarty->fetch('email_container.html');
		//ss$this->M->send();
		print_r($this->M->Body);
		
	   //header('Content-type: text/html');
       //return $this->fetch_body();
	}
}
?>