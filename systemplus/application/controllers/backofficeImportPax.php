<?php
/**
 * This controller is created to handle the alerts for data change in vision and dev server.
 *
 */
class backofficeimportpax extends Controller {

    public function __construct() {
        parent::Controller();
        $this->load->helper(array('form', 'url'));
    }
    
    function importCheckCampus(){
        $wsdl_url = 'http://testing.com';
        $wsdl_url = 'http://devtours.studytours.it/ws/vision.asmx?wsdl';
        $client = new SoapClient($wsdl_url, array('soap_version' => SOAP_1_1));
        $params = array(
            '_UserId' => 'visioN@0315',
            '_Psw' => 'j%asbwY3'
        );
        $result = $client->getPrenotazioni($params);
        $jsonR = $result->getPrenotazioniResult;
        $task_array = json_decode($jsonR, true);
        if ($task_array) {
            foreach ($task_array as $data) {
                var_dump($data);die;
            }
        }
    }
 
}/* End of file backofficeimportpax.php */