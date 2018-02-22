<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('getDateFromJSONString')) {

    /**
     * parseJSONDate
     *
     * parse JSON date
     *
     * @param string $json_date
     * @return	formatted date
     * @access  public
     * @author  Preeti M
     */
    function getDateFromJSONString($json_date) {
        $sec = substr($json_date, 6, 10);
        $dt = date("Y-m-d H:i:s", $sec);
        return $dt;
    }

}

/**
 * Site URL
 *
 * Create a local URL based on your basepath. Segments can be passed via the
 * first parameter either as a string or an array.
 *
 * @access	public
 * @param	string
 * @return	string
 */
if ( ! function_exists('seoUrl'))
{
	function seoUrl($string) {
            //Lower case everything
            $string = strtolower($string);
            //Make alphanumeric (removes all other characters)
            $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
            //Clean up multiple dashes or whitespaces
            $string = preg_replace("/[\s-]+/", " ", $string);
            //Convert whitespaces and underscore to dash
            $string = preg_replace("/[\s_]/", "-", $string);
            return $string;
        }
}

if (!function_exists('authSessionMenu')) {

    /**
     * This function will check the user session and menu access for for the user. 
     * 
     * @access public
     * @author Sandip Kalbhile
     */
    function authSessionMenu($CI, $onlyCheckController = false) {
        //$CI = &get_instance();

        if (APP_THEME == "OLD")
            return true;

        $CI->load->model('vauth/vauthmodel', 'vauthmodel');
        $sessionData = $CI->session->all_userdata();
        if (isset($sessionData['role'])) {
            $userRoleId = $sessionData['role'];
            if (isset($sessionData['is_admin']))
                if ($sessionData['is_admin'])
                    $userRoleId = 1;
            $controllerName = $CI->router->fetch_class();
            $methodName = $CI->router->fetch_method();
            if ($onlyCheckController)
                $methodName = "";
            $userMenus = $CI->vauthmodel->checkRoleMenusAuthentication($controllerName, $methodName, $userRoleId);
            if ($userMenus) {
                return $userMenus;
            } else {
                accessDenied($CI);
            }
        } else { //if(isset($sessionData['role']))
            $actionController = $CI->uri->segment(1);
            if ($actionController == "students")
                redirect('vauth/students');
            elseif ($actionController == "survey")
                redirect('vauth/gl');
            else
                redirect('vauth/logout');
        }
    }

}
if (!function_exists('handleRoleRedirection')) {

    /**
     * This function handles request for redirection and per user role.
     * @param type $userRole 
     * @access public
     * @author Sandip Kalbhile
     */
    function handleRoleRedirection($userRole = 0) {
        switch ($userRole) {
            case 501: // Group leaders
                redirect('vauth/gl', 'refresh');
                break;
            case 502: // Students test
                redirect('vauth/students', 'refresh');
                break;
            case 500: // Students test
                redirect('vauth/users', 'refresh');
                break;
            case 97: // Agent
            case 98: // Agent
            case 99: // Agent 97=mediaViewer, 99 = agente, 98 = account manager
                redirect('vauth/agents', 'refresh');
                break;
            default: // Backoffice operator
                redirect('backoffice', 'refresh');
                break;
        }
    }

}
if (!function_exists('accessDenied')) {

    /**
     * This function will load user page not found page
     * @param object $CI 
     * @access public
     * @author Sandip Kalbhile
     */
    function accessDenied($CI) {
        $data = array();
        $data['title'] = "plus-ed.com | Page not found";
        $data['pageHeader'] = "Page not found";
        $data['breadcrumb1'] = "404";
        $data['optionalDescription'] = "or you don't have access.";
        $CI->load->library('ltelayout');
        ob_start();
        $CI->ltelayout->view('ltelayout/404pagenotfound', $data);
        $result = ob_get_contents();
        ob_clean();
        echo $result;
        exit(0);
    }

}
if (!function_exists('leftSideBarMenuHtml')) {

    /**
     * This function creates html for left side bar menus
     * @param type $mnuArrData 
     * @access public
     * @author Sandip Kalbhile
     */
    function leftSideBarMenuHtml($mnuArrData = array()) {
        $CI = &get_instance();
        if (count($mnuArrData)) {
            foreach ($mnuArrData as $mnuArr) {
                ?>
                <li class="treeview">
                    <a href="<?php echo ($mnuArr['mnu_url'] == '#' || $mnuArr['mnu_url'] == '' ? 'javascript:void(0);' : base_url() . 'index.php/' . $mnuArr['mnu_url']); ?>"><i class="fa <?php echo (empty($mnuArr['mnu_menu_name']) ? 'fa-link' : $mnuArr['mnu_icon_class']); ?>"></i> <span><?php echo $mnuArr['mnu_menu_name'] ?></span>
                        <?php
                        if (array_key_exists('child', $mnuArr)) {
                            ?>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        <?php } ?>
                    </a>
                    <?php
                    if (array_key_exists('child', $mnuArr)) {
                        ?><ul class="treeview-menu"><?php
                        // If super user
                        if ($CI->session->userdata("is_admin") == 1 && $mnuArr['mnu_menu_name'] == "Transportation") {
                            ?>
                                <li>
                                    <div class="row" style="padding-top: 10px;">
                                        <div class="col-xs-6">
                                            <input type="text" class="form-control" id="searchmecode" name="searchmecode" style="margin-left: 17px;">
                                        </div>
                                        <div class="col-xs-5 mr-bot-10">
                                            <input type="button" value="Search bus" class="btn btn-primary" id="editamicode" name="editamicode">
                                        </div>
                                    </div>
                                </li>
                                <?php
                            }
                            foreach ($mnuArr['child'] as $mnu) {
                                ?>
                                <li><a href="<?php echo ($mnu['mnu_url'] == '#' || $mnu['mnu_url'] == '' ? 'javascript:void(0);' : base_url() . 'index.php/' . $mnu['mnu_url']); ?>"><?php echo $mnu['mnu_menu_name'] ?></a></li>
                                <?php
                                if ($mnu['mnu_url'] == 'backoffice/salesNew') {
                                    ?>
                                    <li>
                                        <div class="row">
                                            <div class="col-xs-6">
                                                <input id="mnuSaleByDate" readonly style="margin-left: 17px;" type="text" class="form-control" value="">
                                            </div>
                                            <div class="col-xs-5 mr-bot-10">
                                                <input type="button" value="by Date" class="btn btn-primary" id="btnSaleByDate" name="btnSaleByDate">
                                            </div>
                                        </div>
                                    </li>
                                    <?php
                                }
                                elseif ($mnu['mnu_url'] == 'contract/payrolls') {
                                    ?>
                                    <li>
                                        <div class="row">
                                            <div class="col-xs-6">
                                                <select style="margin-left: 17px;" class="form-control" id="lmnuYearDropdown" name="lmnuYearDropdown">
                                                    <?php for($mnYear=date('Y'); $mnYear >2000 ; $mnYear--){?>
                                                    <option value="<?php echo $mnYear;?>"><?php echo $mnYear;?></option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                            <div class="col-xs-5 mr-bot-10">
                                                <input type="button" value="by Year" class="btn btn-primary" id="lmnuBYPayroll" name="lmnuBYPayroll">
                                            </div>
                                        </div>
                                    </li>
                                    <?php
                                }
                            }
                            ?></ul><?php
                    }
                    ?>
                </li>
                <?php
            }
        }
    }

}

if (!function_exists('showSessionMessageIfAny')) {

    /**
     * This will echo session success / failure messages
     * @param object $CI 
     * @access public
     * @author Sandip Kalbhile
     */
    function showSessionMessageIfAny($CI, $msgType = "", $displayMessage = "") {
        $success_message = $CI->session->flashdata('success_message');
        $error_message = $CI->session->flashdata('error_message');
        if (!empty($success_message)) {
            ?>
            <div class="session-message">
                <div class="alert alert-success alert-dismissable text-center">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $success_message ?>
                </div>
            </div>
            <?php
        }
        if (!empty($error_message)) {
            ?>
            <div class="session-message">
                <div class="alert alert-danger alert-dismissable text-center">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $error_message ?>
                </div>
            </div>
            <?php
        }
        if (!empty($displayMessage)) {
            ?>
            <div class="session-message">
                <div class="alert alert-danger alert-dismissable text-center">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $displayMessage ?>
                </div>
            </div>
            <?php
        }
    }

}

function random_color_part() {
    return str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
}

function random_color_2() {
    return random_color_part() . random_color_part() . random_color_part();
}

function customNumFormat($numInput) {
    return number_format($numInput, 2, ',', '.');
}

if (!function_exists('getThumbnailName')) {
    function getThumbnailName($thumbnailImage){
        if(!empty($thumbnailImage))
        {
            $thumbnailImage = pathinfo($thumbnailImage);
            if(COUNT($thumbnailImage)){
                $extn = $thumbnailImage['extension'];
                $filename = $thumbnailImage['filename'];
                $thumbnailImage = $filename."_thumb.".$extn;
            }
        }
        return $thumbnailImage;
    }
}
/**
 * write_mysql_log($message, $db)
 *
 * Author(s): thanosb, ddonahue
 * Date: May 11, 2008
 * 
 * Writes the values of certain variables along with a message in a database.
 *
 * Parameters:
 *  $message: Message to be logged
 *  $db: Object that represents the connection to the MySQL Server    
 *
 * Returns array:
 *  $result[status]:   True on success, false on failure
 *  $result[message]:  Error message
 */
if (!function_exists('write_my_log')) {

    function write_my_log($message = "") {

        $CI = & get_instance();
        $sessionData = $CI->session->all_userdata();
        // Check message
        if ($message == '') {
            return array("status" => false, "message" => 'Message is empty');
        }

        // Get IP address
        if (($remote_addr = $_SERVER['REMOTE_ADDR']) == '') {
            $remote_addr = "REMOTE_ADDR_UNKNOWN";
        }

        // Get requested script
        if (($request_uri = $_SERVER['REQUEST_URI']) == '') {
            $request_uri = "REQUEST_URI_UNKNOWN";
        }


        // Construct query
        $insertLog = array(
            'remote_addr' => $remote_addr,
            'request_uri' => $request_uri,
            'message' => $message,
            'session_data' => serialize($sessionData)
        );
        $result = $CI->db->insert("plused_log", $insertLog);

        if ($result) {
            return array("status" => true);
        } else {
            return array("status" => false, "message" => 'Unable to write to the database');
        }
    }

}

function random_color() {
    $colorTr = array(
        '#707b7c',
        '#ba4a00',
        '#d4ac0d',
        '#229954',
        '#17a589',
        '#2e86c1',
        '#e74c3c',
        '#8e44ad',
        '#f1c40f',
        '#f39c12',
        '#d35400',
        '#4a235a'
    );
    return $colorTr[array_rand($colorTr)];
    /* '#2874a6',
      '#bb8fce',
      '#1abc9c',
      '#f7dc6f',
      '#85929e',
      '#922b21',
      '#273746',
      '#27ae60',
      '#b03a2e',
      '#78281f',
      '#512e5f',
      '#9ACD32',
      '#00FF7F',
      '#00FA9A',
      '#90EE90',
      '#98FB98',
      '#8FBC8F',
      '#3CB371',
      '#2E8B57',
      '#808000',
      '#556B2F',
      '#6B8E23',
      '#DEB887',
      '#D2B48C',
      '#BC8F8F',
      '#F4A460',
      '#DAA520',
      '#CD853F',
      '#D2691E',
      '#8B4513',
      '#A0522D',
      '#A52A2A',
      '#800000',
      '#7CFC00',
      '#7FFF00',
      '#32CD32',
      '#00FF00',
      '#228B22',
      '#008000',
      '#006400',
      '#ADFF2F',
      '#9ACD32',
      '#00FF7F',
      '#00FA9A',
      '#90EE90',
      '#98FB98',
      '#8FBC8F',
      '#3CB371',
      '#2E8B57',
      '#808000'
     */
}

if (!function_exists('datatable_param')) {

    /**
     * This function will proces the start, offset and sorting parameters for jquery datatable
     * @param request parameters, default column for sorting
     * @access public
     * @author Arunsankar
     */
    function datatable_param($request, $defaultOrderCol, $orderType = 'desc') {
        $param = array();
        $param['start'] = $request['start'];
        $param['offset'] = $request['length'];
        $orderBy = $request['order'];
        $order = array();
        if ((isset($orderBy[0]['column'])) && $request['draw'] > 1) {
            $orderColIndex = $request['order']['0']['column'];
            $param['column'] = $request['columns'][$orderColIndex]['name'];
            $param['type'] = $request['order']['0']['dir'];
        } else {
            $param['column'] = $defaultOrderCol;
            $param['type'] = $orderType;
        }
        return $param;
    }

}

if (!function_exists('datatable_json')) {

    /**
     * This function will return the json encoded response for jquery datatable
     * @param current draw, records count, data
     * @access public
     * @author Arunsankar
     */
    function datatable_json($draw, $count, $data) {
        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => intval($count),
            "recordsFiltered" => intval($count),
            "data" => $data, // total data array
        );
        return json_encode($response);
    }

}

if (!function_exists('setColumnAutoWidth')) {

    function setColumnAutoWidth($objPHPExcel, $rangeColFrom, $rangeColTo) {
        for ($col = $rangeColFrom; $col !== $rangeColTo; $col++) {
            $objPHPExcel->getActiveSheet()
                    ->getColumnDimension($col)
                    ->setAutoSize(true);
        }
    }

}
if (!function_exists('getCurrencyArea')) {

    function getCurrencyArea($currencyCode) {
        switch ($currencyCode) {
            case 'EUR':
                return "Euro";
                break;
            case 'GBP':
                return "UK";
                break;
            case 'USD':
                return "USA";
                break;
        }
    }

}

function getSurveyStarRating($rate = 0,$stars = 4){
    if($stars)
    {
        $mood = "";
        $smiley = "";
        switch ($rate){
            case 1:
                $mood = "Poor";
                $smiley = "smiley-sad.png";
                break;
            case 2:
                $mood = "Satisfactory";
                if($stars == 2)
                    $smiley = "smiley-yell.png";
                else
                    $smiley = "smiley-neutral.png";
                break;
            case 3:
                $mood = "Good";
                $smiley = "smiley.png";
                break;
            case 4:
                $mood = "Excellent";
                $smiley = "smiley-yell.png";
                break;
        }
        for ($i = 1; $i <= $stars; $i++) 
        {
            if($i == $rate)
            {
                ?><img src='<?php echo base_url() ?>js/raty/img/survey/<?php echo $smiley;?>' alt='<?php echo $rate;?>' title='<?php echo $mood;?>' width='16'><?php
            }
            else
            {
                ?><img src='<?php echo base_url() ?>js/raty/img/survey/face-off.png' alt='<?php echo $rate;?>' title='<?php echo $mood;?>' width='16'><?php
            }
        }
    }
}

function print_tags($csvStr,$newLine = 0,$row = array()){
    $html = "";
    $csvStr = explode(',', $csvStr);
    if(!empty($csvStr)){
        foreach ($csvStr as $element){
            if($newLine)
                $html .= "<div style='margin: 0 0 5px;padding: 9px 0 5px 5px;' class='callout callout-info'>
                                <h4>".htmlspecialchars($element)."</h4>
                                <p>Brief description: ".$row['exc_brief_description']."</p>
                                <p>Day's: ".$row['exc_days']."</p>
                                <p>Airport: ".$row['exc_airport']."</p>
                         </div>";
            else
                $html .= "<span style='float: left;margin-top: 5px;' class='label label-success mr-right-5' >".htmlspecialchars($element)."</span>";
        }
    }
    return $html;
}