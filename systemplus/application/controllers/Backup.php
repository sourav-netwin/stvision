<?php

/**
 * Description of Backup
 * This controller handles all the backup related operations for booking
 * @author Arunsankar
 * @since 04-May-2017
 */

class Backup extends Controller {

    public function __construct() {
        parent::Controller();
        $this->load->model('Backup_model', 'backup');
        if (!$this->session->userdata('logged_in')) {
            exit("<h1>You don't have Permission to Use this Functionality.</h1>");
        }
    }

    /**
     * separateBookings
     * this function is used to seperate the bookings year wise and move these as per the year tables.
     */

    public function separateBookings($currentYear = '') {
        echo '<title>Booking Separation</title><h3>Process Stated..';
        $this->validateYear($currentYear);
        $previousYears = $this->getAllPreviousYears($currentYear);
        echo '.<br>.';
        foreach ($previousYears as $date) {
            echo '<br>.';
            if (empty($date->year)) {
                continue;
            }
            if ($this->makeBackupTables($date->year)) {
                echo '<br>.';
                $this->backup->movePreviousYearBookings($date->year);
                $this->backup->movePreviousYearPax($date->year);
            }
        }
        echo '</h3>';
        exit('<h1>Backup Created Successfully</h1>');
    }

    /**
     * validateYear
     * this function validates year.
     */

    private function validateYear($year) {
        if (empty($year)) {
            exit("<h1>Please Provide Year.</h1>");
        }
        if (!is_numeric($year) || strlen($year) != 4) {
            exit("<h1>Please Provide Valid Year.</h1>");
        }
    }

    /**
     * getAllPreviousYears
     * this function retrieves all the previous years from plused_book table
     */

    private function getAllPreviousYears($year) {
        $allPreviousYears = $this->backup->getAllPreviousYears($year);
        if (empty($allPreviousYears)) {
            exit('<h1>No Previous Years Available</h1>');
        }
        return $allPreviousYears;
    }

    /**
     * makeBackupTables
     * this function creates new table in database for the year passed
     */

    private function makeBackupTables($year) {
        if ($this->backup->createBookingTable($year)) {
            if ($this->backup->createPaxTable($year)) {
                return true;
            }
        }
        return false;
    }
}