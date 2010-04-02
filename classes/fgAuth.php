<?php
/** Authentication, Reminders and Signup
 * @package FlightGear
 * @subpackage Core
 * @copyright (C) 2010 FlightGear Team
 * @author Peter Morgan <ac001@daffodil.uk.com>
 * @version 0.1
 *
 *
*/
class fgAuth extends fgObject
{

    const LOGIN_FAIL = 'Login Fail';
    const LOGIN_SUCCESS = 'Login Success';

    const log_details_sent = 'Details Sent';
    const log_pass_sent = 'Password Sent';

    const ONLIINE_DETAILS_SENT = 'details_sent';
    const ONLIINE_AUTH = 'auth';

    private $IS_ROOT = false;

    public function __construct(){
        parent::__construct();
    }

    public function login($email, $pass, $remember=false){
        global $W, $Config;
        if($this->is_root){
            $email = $email.'@'.$Config->site->domain;
        }
        if(!$this->validate_email($email)){
        	 $err = 'Please enter a valid email address';
        	throw new dException(dError::LOGIN_FAIL ,$err);
        }

        //* Get matching record of email and check it exists
        $sql = 'select  
                    contact_id, account_id, pass
                from contacts 
                where 
                    email=?
                ';
        $login = $this->db->getRow($sql, array($email) );
        if(count($login) == 0){
            throw new dException(dError::LOGIN_FAIL, 'User with email "'.$email.'" not found');
        }

        //** User exits  - so perform other checks
        $U = $this->session_row ($login['contact_id'] );
           
        //* Check company account is online
        if($U['online'] !=  1){
            $err = 'The Company account matching this email is not active.';
            $this->log( array('account_id' => $U['account_id'], 'contact_id' => $U['contact_id']),
                             'Failure', $err);
            throw new dException(dError::LOGIN_FAIL,$err);
        }
    
        //* Check user is active
        if($U['active'] != 1){
            $err = 'The login matching this email is not active on the system.';
            $this->log( array('account_id' => $login['account_id'], 'contact_id' => $login['contact_id']),
                            'Failure', $err);
            throw new dException(dError::LOGIN_FAIL, $err);
        }
        
        //* Check user can login       
        if($U['can_login'] != 1){
            $err = 'The login matching this email is not enabled for web access';
            $this->log(array('account_id' => $login['account_id'], 'contact_id' => $login['contact_id']),
                             'Failure', $err);
            throw new dException(dError::LOGIN_FAIL, $err);
        }

        //* Check password    
        if($pass != $login['pass']){
            $err = 'Password failed';
            $this->log(array('account_id' => $login['account_id'], 'contact_id' => $login['contact_id']),
                                     'Failure', $err);
            throw new dException(dError::LOGIN_FAIL, $err);
        }

        //** Checks complete, so login user


        //** OLDE
        $login_ok = false;

        //* Record was found
        if(count($login) >1){

           
            $U = $this->session_row ($login['contact_id'] );
           
            //** Company is flagged as online
            if($U['online'] !=  1){
                $this->error = 'The Company account matching this email is not active.';
                $this->log( array('account_id' => $U['account_id'], 'contact_id' => $U['contact_id']),
                             'Failure', $this->error);

            //** Is this a root company login - ie backend
           // }elseif($this->_ && !$U['root']){
                
              //  $this->error = 'This web is for '.$W['ticker'].' staff only.<br><br>'
                           //     .'If you are a client, please click the link to login - <a href="'.$W['www'].'/login.php">'.$W['www'].'</a>';
              //  $this->log( array('account_id' => $U['account_id'], 'contact_id' => $U['contact_id']),
                         //    'Failure', $this->error);
               
            //** Company is active and online
           // }elseif($U['online'] != 1){
               // $this->error = 'The Company account matching this email is not enabled for online, contact support';
               // $this->log( array('account_id' => $U['account_id'], 'contact_id' => $U['contact_id']),
                        //     'Failure', $this->error);

            //** Email account is deleted   
            }elseif($U['active'] != 1){
                $this->error = 'The login matching this email is not active on the system.';
                $this->log( array('account_id' => $login['account_id'], 'contact_id' => $login['contact_id']),
                             'Failure', $this->error);

            //** Account can login
            }elseif($U['can_login'] != 1){
                $this->error = 'The login matching this email is not enabled for web access';
                $this->log(array('account_id' => $login['account_id'], 'contact_id' => $login['contact_id']),
                             'Failure', $this->error);
            
            //** Check password    
            }elseif($pass != $login['pass']){
                $this->error = 'Password failed';
                $this->log(array('account_id' => $login['account_id'], 'contact_id' => $login['contact_id']),
                                     'Failure', $this->error);

            //** Yipee were ok
            }else{
                $login_ok = true;
                $this->error = 'Login ok';
                $this->log(array(   'account_id' => $login['account_id'], 
                                    'contact_id' => $login['contact_id']),
                                     'Succesful', $this->error);
                
                $this->set_session( $login['contact_id'] );
                //print_r($_SESSION[SITE_KEY]['user']);
                if($remember){
                    $this->set_cookie($login['contact_id']);
                }
               
            }

            if(!$login_ok){
                $subj = '# www Site - Login Fail #: '.$email;
                $body = "Login failed:\n\n";
                $body .= $this->last_error(true);
            }else{
                $U = $_SESSION[SITE_KEY]['user'];
                $subj = 'www Site - Login Ok: '.$U['name'].' - '.$U['company'];
                $body = "User Details: \n\n";
                $body .= implode("\n", array($U['name'], $U['company'], $U['email']));
            }
           // return $login_ok;
			if(_LOCAL_){
				//
			}else{
	            $m = new dMailer_LoginNotice();
    	        $m->send_notice($subj, $body);
			}

            return $login_ok;

        //* No record found -count($login)
        }else{
            $this->error = 'No record matching <b>'.$email.'</b> was found';
            //$this->log(array(), 'Login Failure', $this->error);
            return  false;
        }
    }

    public function sneak($contact_id){
        global $W;
        $this->set_session($contact_id);
        header('Location: '.$W->www.'/account.php');
         
    }

    public function set_session($contact_id, $do_log = true){
            $_SESSION[SITE_KEY]['user'] = $this->session_row($contact_id);
            $_SESSION[SITE_KEY]['auth'] = 1;
    }

    public static function session_user(){
        return $_SESSION[SITE_KEY]['user'];
    }

    public function set_root($bool){
        $this->is_root = $bool;
    }

    public function set_cookie($contact_id, $tim='day'){
        switch($tim){
            case 'week':
                $s = time()+ (60 * 60 * 24 * 5); 
                break;

            case 'today':
            case 'day':
            default:
                $s = time()+ (60 * 60 * 16); // assume 16 hr day
                break;
        }
        setcookie(SITE_KEY.'_user_id', $contact_id, $s, '/');
    }



    public function session_row($contact_id){
            $sql = 'select contacts.contact_id, accounts.online, name, email, title, contacts.account_id,
                    root, company, contacts.active, contacts.can_login,
					contacts.email, contacts.mobile,
                    contacts.online_status, flagged,  pass_enforced
                    from contacts
                    inner join accounts on contacts.account_id = accounts.account_id
                    where contacts.contact_id=? ';
        return $this->db->getrow($sql, array($contact_id) );
    }

    public function check_password($contact_id, $current_password){
        $sql = 'select pass from contacts where contact_id = ?';
        $row = $this->db->getRow($sql, array($contact_id));
        return $row['pass'] == $current_password;
    }
    
    public function set_password($contact_id, $password){
        $sql = 'update contacts set pass = ?  where contact_id=?';
        $this->db->execute($sql, array( $password,$contact_id));
        $log = new dSysLog(dAuth::log_area, 'Password Changed');
        $log->add_id('contact_id', $contact_id);
        $log->set_details('Password changed by this contact');
        $log->save();
    }
    
    public function password_forced($contact_id, $password){
        $sql = 'update contacts set pass = ?, pass_enforced=null, online_status="auth"  where contact_id=?';
        $this->db->execute($sql, array( $password, $contact_id));
        $this->set_session($contact_id, false);
    }

	public function validate_email($email){
		return filter_var(filter_var($email, FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL);
	}

    public function password_forgot( $email ){
    	//echo "#";
        if(!$this->validate_email($email)){
        	$err = 'Please enter a valid email address';
        	throw new dException(dError::LOGIN_FAIL ,$err);
        }
        
        //* Get matching record of email
        $sql = 'select contacts.contact_id, email
                from contacts 
                where email=?';
        $login = $this->db->getRow($sql, array($email) );

        //* Record was found
        if(count($login) > 1){
            $U = $this->session_row ($login['contact_id'] );
            if($U['online'] != 1){
                $this->error = 'The Company account matching this email is not enabled online. Please contact support';
                return  false;
            }
            if($U['active'] != 1){
                $this->error = 'The user account matching this email is not active on the system. Please contact support';
                return  false;
            }
            if($U['can_login'] != 1){
                $this->error = 'The user account matching this email is not active on the system. Please contact support';
                return  false;
            }
            //* send credentials
            $a = new dMailer_SendPasswordReminder();
            $a->send_password($U['contact_id']);
            return true;

        //* No record found
        }else{
			$err = 'No account matching the email was not found on the system';
        	throw new dException(dError::LOGIN_FAIL ,$err);
        }

    }
    
    
    

    public function DEAD_remove_cookie(){
        setcookie(SITE_KEY.'_user_id', '', time() - 3600, '/');
    }

    //********************************** Static ***************************
    public static function security_checkpoint($json_mode = false){
        //AAAAAAAAARRRRRRRRRRRRGGGGGGGGGHG
        //TODO: bill
        //echo "funky";
        //print_r($_SESSION);
       // print_r($_SESSION[SITE_KEY]['user']);
        
        if( !isset($_SESSION[SITE_KEY]['user'])){
            if($json_mode){
                #die( json_encode( array('success' => false, '
                throw new dException(dError::LOGIN_REQUIRED);
            }else{
                header('Location: login.php');
            }
        }
        return;



        if( isset($_SESSION[SITE_KEY]['user']) ){
            return true;
        }elseif( isset($_COOKIE[SITE_KEY.'_user_id']) ){
                $a = new dAuth();
                $a->set_session($_COOKIE[SITE_KEY.'_user_id'], false);
                global $user;
                $user = $_SESSION[SITE_KEY]['user'];
                //header('Location: spin.php');
                return true;
        }
        //header('Location: login.php');
        return false;
    }

    public static function logout(){
        $_SESSION[SITE_KEY] = null;
        unset($_SESSION[SITE_KEY]);
        setcookie(SITE_KEY.'_user_id', '', time() - 3600, '/');
        header('Location: index.php');
    }


    public static function generate_password(){
        $totalChar = 2; // number of chars in the password
        $salt = 'abcdefhkmnpqrtuvwxyz';  // salt to select chars from
        srand((double)microtime()*1000000);
        $password='';
        for ($i=0;$i<$totalChar;$i++){
                    $password = $password . substr ($salt, rand() % strlen($salt), 1);
        }
        $salt = '2346789';  // salt to select chars from
        for ($i=0;$i<$totalChar;$i++){
                    $password = $password . substr ($salt, rand() % strlen($salt), 1);
        }
        // *************************
        // Display Password
        // *************************
       return $password;

    }

    public static function send_details($contact_id){
        $email = new dMailer_SendLoginDetails();
        $email->send_details($contact_id);
        //TODO log
        
    }

    private function log($ids_array, $event, $info){
        $l = new dSysLog('Login', $event);
        $l->add_ids($ids_array);
        $l->log($info);
    }

    public function last_error(){
        return $this->error;
    }

	public function signUp($user_array){
		//* Check user does not exist
		$sql = 'select count(*) as c from users where email=?';
		$count = $this->db->getOne($sql, $user_array['email']);
		#echo $count."#";
		if($count > 0){
			//throw new fgException('user email already exists', 
			//						"An account with the email '".$user_array['email']."'is already on the system");
		}

		//** Insert user to database
		$User =new fgUser(0);
		$User->name = $user_array['name'];
		$User->email = $user_array['email'];
		$User->callsign = $user_array['callsign'];
		$User->irc = $user_array['irc'];
		$User->cvs = $user_array['cvs'];
		$User->location = $user_array['location'];
		$User->email = $user_array['email'];
		$User->save();

		//** set up security
		$User->setPassword($user_array['pass']);
		$User->genToken();

		//** Send email
		$User->sendEmail('ack');
	}
}
?>
