<?php
/** Response Date handler
 * @package FlightGear
 * @subpackage Core
 * @copyright (C) 2010 FlightGear Team
 * @author Peter Morgan <ac001@daffodil.uk.com>
 * @version 0.1
 *
 *
*/
class fgResponse
{
    private $_payload = array();
    private $_error = null;
	private $_format = null;

    public function __construct(){
       $this->_payload = self::emptyPayload();
    }

	public static function emptyPayload(){
       return array('success' => true);
	}

	public function setFormat($format){
		$this->_format = $format;
	}

    public function _add_val($key, $value){
            $this->_payload[$key] = $value;
    }
    public function _add_array($array){
        foreach($array as $k => $v){
            $this->_add_val($k, $v);    
        }
    }

    /** Add key/val variables to add to server reply
     *
     * This is jenerally used as $Reply->Add($request->command(), dClass::index($foo), true)
     * $arg2 will always be an array, however third argument will explode this, eg if a method returns an array 
     * such as items, count, limit etc
     * @param mixed $arg1 if only this vars then assumed to be array
     * @param mixed $arg2 will be an array of data to add with $arg1 as key
     * @param boolean $arg2_is_array will explode $args2 in array elements
    */
    public function add($arg1, $arg2 = null, $arg2_is_array = false){

	    //* Only one argument - so assumed to be array
        if(is_null($arg2)){
            if( is_array($arg1) ){
                $this->_add_array($arg1);
            }
            return;
        }    

        if($arg2_is_array){
            $this->_add_array($arg2);   
            return;
        } 
        $this->_add_val($arg1, $arg2);              
    }

    /** Adds a dTreeNode to the reply array
     * The nodes work in two modes, you either pass a $mivex_var
     * @var $mixed_var
    */
    public function add_node($node_arg, $arg_ki = null, $arg_id = null){

        //* Been passed a $label, $ki,  $id 
        if( !is_array($node_arg) && !is_null($arg_ki) && !is_null($arg_id) ){
            $n = new dTreeNode( $arg_ki, $arg_id);
            $n->text($node_arg);
            $n->leaf = false;
            $this->_nodes[] = $n->get_node();
            return;
        }
        //echo "ere";
        foreach($node_arg as $a){
            $this->_nodes[] = $a;
        }
    }
    public function send(){
        //self::plain();
        //echo "##".$this->tree_mode;
       // if($this->tree_mode && !$cancel_tree_mode){
            echo json_encode( $this->_nodes );
       // }else{
           // echo json_encode($this->_payload);
       // }
        //die();
    }

    public function send_tree($cancel_tree_mode = false){
        self::plain();
        //echo "##".$this->tree_mode;
       // if($this->tree_mode && !$cancel_tree_mode){
            echo json_encode( $this->_nodes );
       // }else{
         //   echo json_encode($this->_payload);
        //}
        die();
    }

    public static function send_error($exObj){
        self::send_exception($exObj);
    }

    public static function send_exception($exObj, $Req = null){
        dut::plain();
        //echo get_class($errorObj);
        //print_r($errorObj);
        $reply_data = array();
        $reply_data['success'] = false;
        $error_class_name =  get_class($exObj);
        //echo $error_class_name."\n";
        switch($error_class_name){
            case dError::dException:
                $reply_data['error'] = dError::get_app_error( $exObj );
                break;
            case dError::ADODB_Exception:
                $reply_data['error'] = dError::get_adodb( $exObj );
                break;
            default:
                $reply_data['error'] = dError::get_error( $exObj );
                break;
        }
        
         // $array = 
        if($Req){
            $reply_data['mode'] = $Req->mode();
            $reply_data['command'] = $Req->command();
        }
        
        self::plain();
        echo json_encode($reply_data);
        die();
    }


	public static function sendHeader(){
		 header('Content-type:'.fgMime::text);
	}

	public static function sendError($except){
		self::sendHeader();
		$payload = array();
		$payload['success'] = true;
		$payload['error'] = $except->error();
		echo json_encode($payload);
	}

	public function sendPayload(){
		self::sendHeader();
		echo json_encode($this->_payload);
	}
}
?>