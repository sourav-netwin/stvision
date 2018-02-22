<?php

/**
 * Backofficeajax: handles all the ajax related fuctionality for backoffice
 * author: Arunsankar
 * date: 19-May-2017
 */
class Backofficeajax extends Controller {

    public function __construct() {

        parent::Controller();
        $this->load->model('backofficeajax_model', 'ajax');
        $this->load->library(array('session', 'email', 'ltelayout'));
    }

    public function updateBookingWeek() {
        $this->_backofficeOperatorCheck();
        $week = $this->input->post('week');
        $bookingId = $this->input->post('booking_id');
        if ($this->_isValidWeek($bookingId, $week)) {
            $this->_response('error', 'Please Select the valid week for Booking.');
        }
        $weekAvailableInPackage = $this->ajax->weekAvailableInPackage($week, $bookingId);
        if ($weekAvailableInPackage <= 0) {
            $this->_response('error', 'The mapped package does not allowed for ' . $week . ' week/s.');
        }
        $update = $this->ajax->updateWeek($week, $bookingId);
        $response = array();
        if ($update) {
            $this->_response('success', 'Week Updated Successfully.');
        } else {
            $this->_response('error', 'Something went wrong in updating week for booking.');
        }
    }

    private function _backofficeOperatorCheck() {
        if (!$this->session->userdata('role') == 100) {
            $this->_response('error', 'You are not Permitted for this operation.');
        }
    }

    private function _response($status, $message) {
        echo json_encode(array($status => true, 'message' => $message));
        exit(0);
    }

    private function _isValidWeek($bookingId, $week) {
        if (empty($bookingId) || empty($week)) {
            return false;
        }
        if (!is_numeric($week) || $week < 1 || $week > 3) {
            return false;
        }
    }

}

//End : additions by Arunsankar S
/* End of file backofficeajax.php */
