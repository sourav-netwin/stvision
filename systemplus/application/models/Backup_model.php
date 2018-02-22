<?php

/**
 * Description of Backup Model
 * This model handles all the backup related queries for booking
 * @author Arunsankar
 * @since 04-May-2017
 */
class Backup_model extends Model {

    /**
     * movePreviousYearBookings
     * this function retrieves records from plused_book table for the provided year and insert into new table, then delete recods for that year.
     */
    public function movePreviousYearBookings($year) {
        $this->db->query("INSERT INTO plused_book_" . $year . " SELECT * FROM plused_book WHERE YEAR(departure_date) = " . $year);
        $this->db->where('YEAR(departure_date)', $year)->delete('plused_book');
        return true;
    }

    /**
     * movePreviousYearPax
     * this function retrieves records from plused_rows table for the provided year and insert into new table, then delete recods for that year.
     */
    public function movePreviousYearPax($year) {
        $this->db->query("INSERT INTO plused_rows_" . $year . " SELECT * FROM plused_rows WHERE YEAR(data_partenza_campus) = " . $year);
        $this->db->where('YEAR(data_partenza_campus)', $year)->delete('plused_rows');
        return true;
    }

    /**
     * createBookingTable
     * creates new table for the provided year from the plused_book definations
     */
    public function createBookingTable($year) {
        $tableDefination = $this->getTableDefination('plused_book');
        $table = str_replace('plused_book', 'plused_book_' . $year, $tableDefination['Create Table']);
        return $this->db->query($table);
    }

    /**
     * createPaxTable
     * creates new table for the provided year from the plused_rows definations
     */
    public function createPaxTable($year) {
        $tableDefination = $this->getTableDefination('plused_rows');
        $table = str_replace('plused_rows', 'plused_rows_' . $year, $tableDefination['Create Table']);
        return $this->db->query($table);
    }

    /**
     * getTableDefination
     * gets table defination for provided table.
     */
    public function getTableDefination($table) {
        return $this->db->query('SHOW CREATE TABLE ' . $table)->row_array();
    }

    /**
     * getAllPreviousYears
     * get all previous years from plused_book of provided year.
     */
    public function getAllPreviousYears($year) {
        $this->db->select('YEAR(departure_date) as year');
        $this->db->from('plused_book');
        $this->db->where('YEAR(departure_date) < ', $year);
        $this->db->where('departure_date > ', 0);
        $this->db->group_by('YEAR(departure_date)');
        $res = $this->db->get();
        $res = $res->result();
        return $res;
    }

}
