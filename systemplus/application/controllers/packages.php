<?php

/**
 * Package class
 * @author Sandip Kalbhile
 * @since Dec 2016 
 */
class Packages extends Controller {

    public function __construct() {

        parent::Controller();
        // check user session and menus with their access.
        authSessionMenu($this);
        $this->load->model("tuition/campuscoursemodel", "campuscoursemodel");
        $this->load->model("agents/packagesmodel", "packagesmodel");
    }

    /**
     * This function will load package listing grid 
     */
    function index() {
        $data = array();
        $data['title'] = "plus-ed.com | Manage packages";
        $data['pageHeader'] = "Manage packages";
        $data['breadcrumb1'] = "Packages";
        $data['breadcrumb2'] = "Manage packages";
        $data['optionalDescription'] = "Manage bookings packages here...";
        $data['packageData'] = $this->packagesmodel->getData();
        $this->ltelayout->view('lte/agents_new/manage_packages', $data);
    }

    /**
     * server side validation for package
     * @return type 
     */
    function _runValidation() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('txtPackageName', 'Package', 'required');
        $this->form_validation->set_rules('selCampus', 'Campus', 'required');
        return $this->form_validation->run();
    }

    /**
     * This function can be used to add or update packages
     * @param int $edit_id 
     */
    function addedit($edit_id = 0) {
        $data = array(
            'error_message' => ''
        );
        if ($edit_id) {
            if (!empty($_POST)) {
                if ($this->_runValidation()) {
                    // get post data
                    $insertPackage = $this->_getPostArray();
                    // Add package basic info in database.
                    $packageResult = $this->packagesmodel->operation('update', $insertPackage, $edit_id);
                    if ($packageResult) {
                        // insert services added to the package
                        $generatedCompositions = $this->input->post('generatedCompositions');
                        if ($generatedCompositions) {
                            $this->_insertServicesForPackage($packageResult, $edit_id);
                            $this->_insertCompositionsForPackage($packageResult, $edit_id);
                        }
                        $this->_insertPackageAgents($packageResult, $edit_id);
                        $this->session->set_flashdata('success_message', 'Package updated successfully.');
                        redirect('packages');
                    } else {
                        $data['error_message'] = 'Unable to update package';
                    }
                }
            }
            // edit mode
            $packageInfo = $this->packagesmodel->getSinglePackageData($edit_id);
            $txtStartDate = new DateTime($packageInfo->pack_start_date);
            $txtExpiryDate = new DateTime($packageInfo->pack_expiry_date);
            $txtStartDate = $txtStartDate->format('d/m/Y');
            $txtExpiryDate = $txtExpiryDate->format('d/m/Y');

            $formData = array(
                'selCampus' => $packageInfo->pack_campus_id,
                'selCategoryProgram' => $packageInfo->pack_category_program_id,
                'txtProgDescription' => $packageInfo->pack_program_description,
                'txtPackageName' => $packageInfo->pack_package,
                'selAccommodation' => '',
                'selAccommodationGL' => '',
                'selCoursesType' => '',
                'txtFreeGL' => $packageInfo->pack_free_gl_per_pax,
                'txtExtraGLPrice' => $packageInfo->pack_extra_gl_price,
                'txtStartDate' => $txtStartDate,
                'txtExpiryDate' => $txtExpiryDate,
                'chkWeek1' => $packageInfo->pack_week_1,
                'chkWeek2' => $packageInfo->pack_week_2,
                'chkWeek3' => $packageInfo->pack_week_3,
                //pack_for_location,pack_location_region,pack_location_country,
                'chkValidRegion' => $packageInfo->pack_for_location,
                'selRegion' => $packageInfo->pack_location_region,
                'selCountry' => $packageInfo->pack_location_country,
                'txtCourseDirectorSalary' => $packageInfo->pack_cd_salary,
                'txtCourseDirectorAcco' => $packageInfo->pack_cd_accomodation,
                'txtAssistantCDSalary' => $packageInfo->pack_acd_salary,
                'txtAssistantCDAcco' => $packageInfo->pack_acd_accomodation,
                'txtCampusManagerSalary' => $packageInfo->pack_cm_salary,
                'txtCampusManagerAcco' => $packageInfo->pack_cm_accomodation,
                'txtAssistantCMSalary' => $packageInfo->pack_acm_salary,
                'txtAssistantCMAcco' => $packageInfo->pack_acm_accomodation,
                'txtTeacherAccommodation' => $packageInfo->pack_teacher_accomodation,
                'txtTeacherLunch' => $packageInfo->pack_teacher_lunch,
                'txtTravel' => $packageInfo->pack_travelling,
                'txtPrintingStationery' => $packageInfo->pack_printing_stationary,
                'txtBooks' => $packageInfo->pack_books,
                'txtExpenses' => $packageInfo->pack_expenses
            );
            $data['excursionData'] = $this->packagesmodel->getPackExcActivities($edit_id, "Excursion");
        } else {
            $formData = array(
                'selCampus' => '',
                'selCategoryProgram' => '',
                'txtProgDescription' => '',
                'txtPackageName' => '',
                'selAccommodation' => '',
                'selAccommodationGL' => '',
                'selCoursesType' => '',
                'txtFreeGL' => '',
                'txtExtraGLPrice' => '',
                'txtStartDate' => '',
                'txtExpiryDate' => '',
                'chkWeek1' => '',
                'chkWeek2' => '',
                'chkWeek3' => '',
                'chkValidRegion' => '',
                'selRegion' => '',
                'selCountry' => '',
                'txtCourseDirectorSalary' => '',
                'txtCourseDirectorAcco' => '',
                'txtAssistantCDSalary' => '',
                'txtAssistantCDAcco' => '',
                'txtCampusManagerSalary' => '',
                'txtCampusManagerAcco' => '',
                'txtAssistantCMSalary' => '',
                'txtAssistantCMAcco' => '',
                'txtTeacherAccommodation' => '',
                'txtTeacherLunch' => '',
                'txtTravel' => '',
                'txtPrintingStationery' => '',
                'txtBooks' => '',
                'txtExpenses' => '',
            );
            if (!empty($_POST)) {
                if ($this->_runValidation()) {
                    // get post data
                    $insertPackage = $this->_getPostArray();
                    // Add package basic info in database.
                    $packageResult = $this->packagesmodel->operation('insert', $insertPackage);
                    if ($packageResult) {
                        // insert services added to the package
                        $this->_insertServicesForPackage($packageResult);
                        $this->_insertCompositionsForPackage($packageResult);
                        $this->_insertPackageAgents($packageResult);
                        $this->session->set_flashdata('success_message', 'Package created successfully.');
                        redirect('packages');
                    } else {
                        $data['error_message'] = 'Unable to create package';
                    }
                }
            }
        }

        $data['edit_id'] = $edit_id;
        $data['formData'] = $formData;
        $campusId = $this->session->userdata('sess_campus_id');
        $data["campusList"] = $this->campuscoursemodel->getCampusList(1, $campusId);
        $data["accommodationListStudents"] = $this->packagesmodel->listAccommodation("Students");
        $data["accommodationListGroupLeaders"] = $this->packagesmodel->listAccommodation("Group Leaders");
        $data["coursesType"] = $this->packagesmodel->listCoursesType();

        $data["locationRegion"] = $this->packagesmodel->loadRegions();
        $data["categoryProgram"] = $this->packagesmodel->categoryProgram();

        if ($edit_id) {
            $data['title'] = "plus-ed.com | Edit package";
            $data['pageHeader'] = "Edit package";
            $data['breadcrumb1'] = "Packages";
            $data['breadcrumb2'] = "Edit package";
            $data['optionalDescription'] = "";

            $data['addedAccommodation'] = $this->packagesmodel->getPackExcActivities($edit_id, "Accommodation");
            $data['addedCourseType'] = $this->packagesmodel->getPackExcActivities($edit_id, "Course Type");
            $data['addedActivity'] = $this->packagesmodel->getPackExcActivities($edit_id, "Activity");
            $data['addedExcursion'] = $this->packagesmodel->getPackExcActivities($edit_id, "Excursion");
            $data['addedCompositions'] = $this->packagesmodel->getPackCompositions($edit_id);
        } else {
            $data['title'] = "plus-ed.com | Add package";
            $data['pageHeader'] = "Add package";
            $data['breadcrumb1'] = "Packages";
            $data['breadcrumb2'] = "Add package";
            $data['optionalDescription'] = "";
        }
        $this->ltelayout->view('lte/agents_new/addedit_packages', $data);
    }

    /**
     * load contries here 
     */
    function loadCountry() {
        $regionId = $this->input->post('regionId');
        $editCountry = $this->input->post('editCountry');
        $editCountry = explode(',', $editCountry);
        $loadCountry = $this->packagesmodel->loadCountry($regionId);
        if ($loadCountry) {
            foreach ($loadCountry as $country) {
                ?><option <?php echo (in_array($country['cou_descrizione'], $editCountry) ? "selected='selected'" : ""); ?> value="<?php echo $country['cou_descrizione']; ?>"><?php echo $country['cou_descrizione']; ?></option><?php
            }
        } else {
            echo '';
        }
    }

    /**
     * load agents for package 
     */
    function loadAgents() {
        $regionId = $this->input->post('countryId');
        $packageId = $this->input->post('packageId');
        $packageAgentsArr = array();
        $packageAgents = $this->packagesmodel->loadPackageAgents($packageId);
        if ($packageAgents != "")
            $packageAgentsArr = explode(',', $packageAgents);
        $loadAgents = $this->packagesmodel->loadAgents($regionId);
        if ($loadAgents) {
            foreach ($loadAgents as $agents) {
                ?><option <?php echo (in_array($agents['id'], $packageAgentsArr) ? "selected='selected'" : ""); ?> value="<?php echo $agents['id']; ?>"><?php echo $agents['businessname']; ?></option><?php
            }
        } else {
            echo '';
        }
    }

    /**
     * To get the request post data
     * @return array 
     */
    function _getPostArray() {
        $packageWeeks = $this->input->post('packageWeeks');
        $packageName = $this->input->post('txtPackageName');
        $campusId = $this->input->post('selCampus');
        $selCategoryProgram = $this->input->post('selCategoryProgram');
        $progDescription = $this->input->post('txtProgDescription');
        $freeGl = $this->input->post('txtFreeGL');
        $extraGLPrice = $this->input->post('txtExtraGLPrice');
        $startDate = $this->input->post('txtStartDate');
        $expiryDate = $this->input->post('txtExpiryDate');

        $chkValidRegion = $this->input->post('chkValidRegion');
        $selRegion = $this->input->post('selRegion');
        $selCountry = $this->input->post('selCountry');
        if ($chkValidRegion != 1) {
            $chkValidRegion = 0;
            $selRegion = "";
            $selCountry = "";
        } else {
            $chkValidRegion = 1;
            $selCountry = implode(',', $selCountry);
        }

        if (!empty($expiryDate) && !empty($expiryDate)) {
            $startDate = explode('/', $startDate);
            $expiryDate = explode('/', $expiryDate);
            if (array_key_exists(2, $startDate)) {
                $startDate = $startDate[2] . '-' . $startDate[1] . '-' . $startDate[0];
            }
            if (array_key_exists(2, $expiryDate)) {
                $expiryDate = $expiryDate[2] . '-' . $expiryDate[1] . '-' . $expiryDate[0];
            }
        } else {
            $startDate = "";
            $expiryDate = "";
        }

        $txtCourseDirectorSalary = $this->input->post('txtCourseDirectorSalary');
        $txtCourseDirectorAcco = $this->input->post('txtCourseDirectorAcco');
        $txtAssistantCDSalary = $this->input->post('txtAssistantCDSalary');
        $txtAssistantCDAcco = $this->input->post('txtAssistantCDAcco');
        $txtCampusManagerSalary = $this->input->post('txtCampusManagerSalary');
        $txtCampusManagerAcco = $this->input->post('txtCampusManagerAcco');
        $txtAssistantCMSalary = $this->input->post('txtAssistantCMSalary');
        $txtAssistantCMAcco = $this->input->post('txtAssistantCMAcco');
        $txtTeacherAccommodation = $this->input->post('txtTeacherAccommodation');
        $txtTeacherLunch = $this->input->post('txtTeacherLunch');
        $txtTravel = $this->input->post('txtTravel');
        $txtPrintingStationery = $this->input->post('txtPrintingStationery');
        $txtBooks = $this->input->post('txtBooks');
        $txtExpenses = $this->input->post('txtExpenses');


        $insertPackage = array(
            'pack_package' => $packageName,
            'pack_campus_id' => $campusId,
            'pack_category_program_id' => $selCategoryProgram,
            'pack_program_description' => $progDescription,
            'pack_free_gl_per_pax' => $freeGl,
            'pack_extra_gl_price' => $extraGLPrice,
            'pack_start_date' => $startDate,
            'pack_expiry_date' => $expiryDate,
            'pack_for_location' => $chkValidRegion,
            'pack_location_region' => $selRegion,
            'pack_location_country' => $selCountry,
            'pack_cd_salary' => $txtCourseDirectorSalary,
            'pack_cd_accomodation' => $txtCourseDirectorAcco,
            'pack_acd_salary' => $txtAssistantCDSalary,
            'pack_acd_accomodation' => $txtAssistantCDAcco,
            'pack_cm_salary' => $txtCampusManagerSalary,
            'pack_cm_accomodation' => $txtCampusManagerAcco,
            'pack_acm_salary' => $txtAssistantCMSalary,
            'pack_acm_accomodation' => $txtAssistantCMAcco,
            'pack_teacher_accomodation' => $txtTeacherAccommodation,
            'pack_teacher_lunch' => $txtTeacherLunch,
            'pack_travelling' => $txtTravel,
            'pack_printing_stationary' => $txtPrintingStationery,
            'pack_books' => $txtBooks,
            'pack_expenses' => $txtExpenses,
            'pack_created_by' => $this->session->userdata('id')
        );
        $insertPackage['pack_week_1'] = '';
        $insertPackage['pack_week_2'] = '';
        $insertPackage['pack_week_3'] = '';
        if ($packageWeeks) {
            foreach ($packageWeeks as $week) {
                $strSearch = strtolower(str_replace(' Week', '', $week));
                $insertPackage['pack_week_' . $strSearch] = 1;
            }
        }
        return $insertPackage;
    }

    /**
     * inserte package agents data
     * @param type $packageResult
     * @param type $edit_package_id 
     */
    function _insertPackageAgents($packageResult, $edit_package_id = 0) {
        if ($edit_package_id) {
            // remove all existing agents name
            $this->packagesmodel->operation('removeAgentsAdded', null, $edit_package_id);
        }
        $selAgents = $this->input->post('selAgents');
        foreach ($selAgents as $agentId) {
            $insertData = array(
                'pagnt_package_id' => $packageResult,
                'pagnt_agent_id' => $agentId
            );
            $this->packagesmodel->operation('insertPackageAgents', $insertData, null);
        }
    }

    /**
     * To insert services added into the database while inserting or updating package
     * @param mixed $packageResult
     * @param int $edit_package_id 
     */
    function _insertServicesForPackage($packageResult, $edit_package_id = 0) {
        if ($edit_package_id) {
            // remove all existing services added data from database.
            $this->packagesmodel->operation('removeServicesAdded', null, $edit_package_id);
        }
        //'Accommodation','Excursion','Activity','Course Type'
        $postServiceData = array(
            'stdAcc' => 'Accommodation',
            'excursion' => 'Excursion',
            'activities' => 'Activity',
            'coursesType' => 'Course Type'
        );

        foreach ($postServiceData as $pServiceName => $serviceDatabaseFlag) {
            // Add students accomodations
            if (isset($_POST[$pServiceName])) {
                $studentsAcc = array();
                $studentsAccommodation = $_POST[$pServiceName];
                if (!empty($studentsAccommodation)) {
                    foreach ($studentsAccommodation as $serviceId => $serviceDetails) {
                        $studentsAcc['serv_package_id'] = $packageResult;
                        $studentsAcc['serv_service_id'] = $serviceId;
                        $studentsAcc['serv_service_type'] = $serviceDatabaseFlag;
                        $studentsAcc['serv_cost'] = $serviceDetails['cost'];
                        if (isset($serviceDetails['service_week']))
                            $studentsAcc['serv_week'] = $serviceDetails['service_week'];
                        if (isset($serviceDetails['extra_night']))
                            $studentsAcc['serv_extra_night'] = $serviceDetails['extra_night'];
                        if (isset($serviceDetails['extra_activity']))
                            $studentsAcc['serv_extra_activity'] = $serviceDetails['extra_activity'];
                        if (isset($serviceDetails['extra_tuition']))
                            $studentsAcc['serv_extra_tuition'] = $serviceDetails['extra_tuition'];
                        $this->packagesmodel->operation('insertService', $studentsAcc);
                    }
                }
            }
        }
    }

    /**
     * insert compositions regarding the package while add/update
     * @param int $packageId
     * @param int $edit_package_id 
     */
    function _insertCompositionsForPackage($packageId, $edit_package_id = 0) {
        if ($edit_package_id) {
            // remove all existing compositions added data from database.
            $this->packagesmodel->operation('removeCompositions', null, $edit_package_id);
        }
        $rowCell = $this->input->post('rowCell');
        $pWeeks = $this->input->post('pWeeks');
        $accomIds = $this->input->post('accomIds');

        $ctypeIds = $this->input->post('ctypeIds');
        $actIds = $this->input->post('actIds');
        if (!empty($rowCell)) {
            foreach ($rowCell as $i) { // i- row index
                $weekText = $pWeeks[$i - 1];
                $weekId = str_replace(' Week', '', $weekText);
                $accommodationId = $accomIds[$i - 1];
                $courseTypeId = $ctypeIds[$i - 1];
                $activityId = $actIds[$i - 1];
                $excursionCost = $this->input->post('excursionCost_' . $i);
                $staffCharges = $this->input->post('staffCharges_' . $i);
                $otherCharges = $this->input->post('otherCharges_' . $i);
                $fullPrice = $this->input->post('fullPrice_' . $i);
                $priceA = $this->input->post('priceA_' . $i);
                $priceB = $this->input->post('priceB_' . $i);
                $priceC = $this->input->post('priceC_' . $i);
                $totalCost = $this->input->post('totalCost_' . $i);
                $insertData = array(
                    'pcomp_package_id' => $packageId,
                    'pcomp_week' => $weekId,
                    'pcomp_accom_id' => $accommodationId,
                    'pcomp_course_type_id' => $courseTypeId,
                    'pcomp_activity_id' => $activityId,
                    'pcomp_excursion_cost' => $excursionCost,
                    'pcomp_staff_charges' => $staffCharges,
                    'pcomp_other_charges' => $otherCharges,
                    'pcomp_full_price' => $fullPrice,
                    'pcomp_price_a' => $priceA,
                    'pcomp_price_b' => $priceB,
                    'pcomp_price_c' => $priceC,
                    'pcomp_total_cost' => $totalCost
                );
                $this->packagesmodel->operation('insertCompositions', $insertData);
            }
        }
    }

    /**
     * Get the html of the compositions table 
     */
    function getCompositionsTable() {
        $error_mes = "";
        $rowHtml = "";
        $rowCell = 1;
        $accommodations = $this->input->post('stdAcc');
        $coursesType = $this->input->post('coursesType');
        $activities = $this->input->post('activities');
        $excursion = $this->input->post('excursion');
        $packageWeeks = $this->input->post('packageWeeks');
        $staffCharges = $this->input->post('txtTotalStaffCharges');
        $otherCharges = $this->input->post('txtTotalOtherCharges');
        if (!empty($accommodations) && !empty($packageWeeks)) {
            $totalExcursionCost = 0;
            foreach ($packageWeeks as $pWeeks) {
                // calculate total cost of Excursions
                if (!empty($excursion))
                    foreach ($excursion as $exc) {
                        if ($exc['service_week'] == $pWeeks)
                            $totalExcursionCost += $exc['cost'];
                    }
                foreach ($accommodations as $accomId => $accom) {
                    //check if course types is not empty
                    if (!empty($coursesType)) {
                        foreach ($coursesType as $ctypeId => $ctype) {
                            if (!empty($activities)) {
                                foreach ($activities as $actId => $act) {
                                    $copositionName = $pWeeks . " - " . $accom['service_name'] . " - " . $ctype['service_name'] . " - " . $act['service_name'];
                                    $idsHidden = "<input type='hidden' name='pWeeks[]' value='" . $pWeeks . "' >";
                                    $idsHidden .= "<input type='hidden' name='accomIds[]' value='" . $accomId . "' >";
                                    $idsHidden .= "<input type='hidden' name='ctypeIds[]' value='" . $ctypeId . "' >";
                                    $idsHidden .= "<input type='hidden' name='actIds[]' value='" . $actId . "' >";
                                    $idsHidden .= "<input type='hidden' name='rowCell[]' value='" . $rowCell . "' >";
                                    $fullPrice = $accom['cost'] + $ctype['cost'] + $act['cost'];
                                    $rowHtml .= $this->_prepareRowHtml($pWeeks, $rowCell, $idsHidden, $copositionName, $fullPrice, $totalExcursionCost, $staffCharges, $otherCharges);
                                    $rowCell++;
                                }
                            } else {
                                // activity is empty
                                $copositionName = $pWeeks . " - " . $accom['service_name'] . " - " . $ctype['service_name'];
                                $idsHidden = "<input type='hidden' name='pWeeks[]' value='" . $pWeeks . "' >";
                                $idsHidden .= "<input type='hidden' name='accomIds[]' value='" . $accomId . "' >";
                                $idsHidden .= "<input type='hidden' name='ctypeIds[]' value='" . $ctypeId . "' >";
                                $idsHidden .= "<input type='hidden' name='actIds[]' value='0' >";
                                $idsHidden .= "<input type='hidden' name='rowCell[]' value='" . $rowCell . "' >";
                                $fullPrice = $accom['cost'] + $ctype['cost'];
                                $rowHtml .= $this->_prepareRowHtml($pWeeks, $rowCell, $idsHidden, $copositionName, $fullPrice, $totalExcursionCost, $staffCharges, $otherCharges);
                                $rowCell++;
                            }
                        }
                    } else {
                        // IF COURSE TYPE IS EMPTY
                        if (!empty($activities)) {
                            foreach ($activities as $actId => $act) {
                                $copositionName = $pWeeks . " - " . $accom['service_name'] . " - " . $act['service_name'];
                                $idsHidden = "<input type='hidden' name='pWeeks[]' value='" . $pWeeks . "' >";
                                $idsHidden .= "<input type='hidden' name='accomIds[]' value='" . $accomId . "' >";
                                $idsHidden .= "<input type='hidden' name='ctypeIds[]' value='0' >";
                                $idsHidden .= "<input type='hidden' name='actIds[]' value='" . $actId . "' >";
                                $idsHidden .= "<input type='hidden' name='rowCell[]' value='" . $rowCell . "' >";
                                $fullPrice = $accom['cost'] + $act['cost'];
                                $rowHtml .= $this->_prepareRowHtml($pWeeks, $rowCell, $idsHidden, $copositionName, $fullPrice, $totalExcursionCost, $staffCharges, $otherCharges);
                                $rowCell++;
                            }
                        } else {
                            // activity is empty
                            $copositionName = $pWeeks . " - " . $accom['service_name'];
                            $idsHidden = "<input type='hidden' name='pWeeks[]' value='" . $pWeeks . "' >";
                            $idsHidden .= "<input type='hidden' name='accomIds[]' value='" . $accomId . "' >";
                            $idsHidden .= "<input type='hidden' name='ctypeIds[]' value='0' >";
                            $idsHidden .= "<input type='hidden' name='actIds[]' value='0' >";
                            $idsHidden .= "<input type='hidden' name='rowCell[]' value='" . $rowCell . "' >";
                            $fullPrice = $accom['cost'];
                            $rowHtml .= $this->_prepareRowHtml($pWeeks, $rowCell, $idsHidden, $copositionName, $fullPrice, $totalExcursionCost, $staffCharges, $otherCharges);
                            $rowCell++;
                        }
                    }
                }
            }
        } else {
            $error_mes = "Please add at least one accommodation type and week";
        }

        if ($error_mes != "")
            $result = array("result" => 0, "message" => $error_mes);
        else
            $result = array("result" => 1, "htmlStr" => $rowHtml);

        echo json_encode($result);
    }

    /**
     * private function to create html for the compositions rows
     * @param int $pWeeks
     * @param int $rowCell
     * @param string $idsHidden
     * @param string $copositionName
     * @param float $fullPrice
     * @param float $totalExcursionCost
     * @return string 
     */
    function _prepareRowHtml($pWeeks, $rowCell, $idsHidden, $copositionName, $fullPrice, $totalExcursionCost, $staffCharges, $otherCharges) {
        $weekTotalCost = 0;
        $weekStaffCharges = 0;
        $weekOtherCharges = 0;
        if ($pWeeks == "1 Week") {
            $weekStaffCharges = $staffCharges;
            $weekOtherCharges = $otherCharges;
            $weekTotalCost = $fullPrice * 7 + $totalExcursionCost + ($staffCharges + $otherCharges);
        } elseif ($pWeeks == "2 Week") {
            $weekStaffCharges = 2 * $staffCharges;
            $weekOtherCharges = 2 * $otherCharges;
            $weekTotalCost = $fullPrice * 14 + $totalExcursionCost + 2 * ($staffCharges + $otherCharges);
        } elseif ($pWeeks == "3 Week") {
            $weekStaffCharges = 3 * $staffCharges;
            $weekOtherCharges = 3 * $otherCharges;
            $weekTotalCost = $fullPrice * 21 + $totalExcursionCost + 3 * ($staffCharges + $otherCharges);
        }
        $strHtml = "<tr>
                        <td>" . $copositionName . $idsHidden . "</td>
                        <td><span class='input-price-symbol' style='margin-right: 2px;margin-top: 0;position: relative;'></span>" . $totalExcursionCost . "<input type='hidden' id='excursionCost_" . $rowCell . "' name='excursionCost_" . $rowCell . "' value='" . $totalExcursionCost . "'></td>
                        <td><span class='input-price-symbol' style='margin-right: 2px;margin-top: 0;position: relative;'></span>" . $weekStaffCharges . "<input type='hidden' id='staffCharges_" . $rowCell . "' name='staffCharges_" . $rowCell . "' value='" . $weekStaffCharges . "'></td>
                        <td><span class='input-price-symbol' style='margin-right: 2px;margin-top: 0;position: relative;'></span>" . $weekOtherCharges . "<input type='hidden' id='otherCharges_" . $rowCell . "' name='otherCharges_" . $rowCell . "' value='" . $weekOtherCharges . "'></td>
                        <td><span class='input-price-symbol' style='margin-right: 2px;margin-top: 0;position: relative;'></span>" . $fullPrice . "<input type='hidden' id='totalCost_" . $rowCell . "' name='totalCost_" . $rowCell . "' value='" . $fullPrice . "'></td>
                        <td><span class='input-price-symbol' style='margin-right: 2px;margin-top: 0;position: relative;'></span>" . $weekTotalCost . "</td>
                        <td><span class='input-price-symbol'></span><input type='text' id='fullPrice_" . $rowCell . "' name='fullPrice_" . $rowCell . "' onkeypress='return keyRestrict(event,\"1234567890.\");' maxlength='10' class='form-control input-price calPercent' data-tcost='" . $weekTotalCost . "' value=''><span class='spanPer'></span></td>
                        <td><span class='input-price-symbol'></span><input type='text' id='priceA_" . $rowCell . "' name='priceA_" . $rowCell . "' onkeypress='return keyRestrict(event,\"1234567890.\");' maxlength='10' class='form-control input-price calPercent' data-tcost='" . $weekTotalCost . "' value=''><span class='spanPer'></span></td>
                        <td><span class='input-price-symbol'></span><input type='text' id='priceB_" . $rowCell . "' name='priceB_" . $rowCell . "' onkeypress='return keyRestrict(event,\"1234567890.\");' maxlength='10' class='form-control input-price calPercent' data-tcost='" . $weekTotalCost . "' value=''><span class='spanPer'></span></td>
                        <td><span class='input-price-symbol'></span><input type='text' id='priceC_" . $rowCell . "' name='priceC_" . $rowCell . "' onkeypress='return keyRestrict(event,\"1234567890.\");' maxlength='10' class='form-control input-price calPercent' data-tcost='" . $weekTotalCost . "' value=''><span class='spanPer'></span></td>
                    </tr>";
        return $strHtml;
    }

    /**
     * fetch campus excursions for dropdown
     */
    function getCampusExcursion() {
        $campusId = $this->input->post('campusId');
        $result = $this->packagesmodel->getCampusExcursion($campusId);
        if ($result) {
            foreach ($result as $campusEx) {
                /*
                ?>
                <option value="<?php echo $campusEx['exc_id']; ?>" ><?php echo ucwords($campusEx['exc_excursion_name']." - ".ucwords($campusEx['exc_day_type'])." - ".$campusEx['exc_type']." - ".$campusEx['exc_days']." - ".$campusEx['exc_weeks']); ?></option>
                <?php*/
                ?>
                <option value="<?php echo $campusEx['exc_id']; ?>" ><?php echo ucwords($campusEx['exc_excursion_name'])." - ".strtoupper($campusEx['exc_day_type']); ?></option>
                <?php
            }
        } else {
            echo '';
        }
    }

    /**
     * fetch campus activities for dropdown 
     */
    function getCampusActivities() {
        $campusId = $this->input->post('campusId');
        $result = $this->packagesmodel->getCampusActivities($campusId);
        if ($result) {
            foreach ($result as $campusAct) {
                ?>
                <option value="<?php echo $campusAct['act_id']; ?>" ><?php echo $campusAct['act_activity_name']; ?></option>
                <?php
            }
        } else {
            echo '';
        }
    }

    /**
     * get packages excursions, activities and course type added
     */
    function getPackExcActivities() {
        $pack_id = $this->input->post('pack_id');
        //'STD Accommodation','GL Accommodation','Excursion','Activity','Course Type'
        $resultDataExcursion = $this->packagesmodel->getPackExcActivities($pack_id, "Excursion");
        $resultDataActivities = $this->packagesmodel->getPackExcActivities($pack_id, "Activity");
        $resultDataCoursesType = $this->packagesmodel->getPackExcActivities($pack_id, "Course Type");
        ?>
        <div class="row">
            <div class="col-xs-12">
                <h4 class="modal-title">Excursion</h4></div>
        </div>
        <div class="row">
            <div class="col-xs-6">Excursion name</div>
            <div class="col-xs-6">Cost</div>
        </div>
        <?php
        if ($resultDataExcursion) {
            foreach ($resultDataExcursion as $excursion) {
                ?>
                <div class="row">
                    <div class="col-xs-6"><?php echo $excursion['service_name']; ?></div>
                    <div class="col-xs-6"><?php echo $excursion['serv_cost']; ?></div>
                </div>
                <?php
            }
        } else {
            ?>
            <div class="row">
                <div class="col-xs-12">No excursion added to package.</div>
            </div>
            <?php
        }
        ?>
        <br/>
        <div class="row">
            <div class="col-xs-12">
                <h4 class="modal-title">Activity</h4></div>
        </div>
        <div class="row">
            <div class="col-xs-6">Activity name</div>
            <div class="col-xs-6">Cost</div>
        </div>
        <?php
        if ($resultDataActivities) {
            foreach ($resultDataActivities as $activity) {
                ?>
                <div class="row">
                    <div class="col-xs-6"><?php echo $activity['service_name']; ?></div>
                    <div class="col-xs-6"><?php echo $activity['serv_cost']; ?></div>
                </div>
                <?php
            }
        } else {
            ?>
            <div class="row">
                <div class="col-xs-12">No activity added to package.</div>
            </div>
        <?php } ?>
        <br/>
        <div class="row">
            <div class="col-xs-12">
                <h4 class="modal-title">Course type</h4></div>
        </div>
        <div class="row">
            <div class="col-xs-6">Course type</div>
            <div class="col-xs-6">Cost</div>
        </div>
        <?php
        if ($resultDataCoursesType) {
            foreach ($resultDataCoursesType as $coursesType) {
                ?>
                <div class="row">
                    <div class="col-xs-6"><?php echo $coursesType['service_name']; ?></div>
                    <div class="col-xs-6"><?php echo $coursesType['serv_cost']; ?></div>
                </div>
                <?php
            }
        } else {
            ?>
            <div class="row">
                <div class="col-xs-12">No course type added to package.</div>
            </div>
        <?php
        }
    }

    /**
     * fetch package compositions and create html to show it in modal(listing view link) 
     */
    public function getViewCompositionsTable() {
        $package = $this->input->post("pack_id");
        $currency = $this->input->post("valuta");
        $currencySymbol = "";
        if ($package > 0) {
            $addedCompositions = $this->packagesmodel->getPackCompositions($package);
            if ($addedCompositions) {
                if ($currency == "EUR")
                    $currencySymbol = "&euro;";
                else if ($currency == "GBP")
                    $currencySymbol = "&pound;";
                else if ($currency == "USD")
                    $currencySymbol = "$";
                ?>
                <table class="table table-bordered table-responsive table-striped">
                    <thead>
                        <tr>
                            <th>Package composition</th>
                            <th>Excursion cost</th>
                            <th>Composition cost/day/pax</th>
                            <th>Total cost</th>
                            <th>Full price</th>
                            <th>Price A<br/>(10 to 19 pax)</th>
                            <th>Price B<br/>(20 to 39 pax)</th>
                            <th>Price C<br/>(40 pax and over)</th>
                        </tr>
                    </thead>
                    <tbody>
                <?php
                foreach ($addedCompositions as $addComp) {
                    $weekTotalCost = 0;
                    $pWeeks = $addComp['pcomp_week'];
                    if ($pWeeks == 1) {
                        $weekTotalCost = $addComp['pcomp_total_cost'] * 7 + $addComp['pcomp_excursion_cost'];
                    } elseif ($pWeeks == 2) {
                        $weekTotalCost = $addComp['pcomp_total_cost'] * 14 + $addComp['pcomp_excursion_cost'];
                    } elseif ($pWeeks == 3) {
                        $weekTotalCost = $addComp['pcomp_total_cost'] * 21 + $addComp['pcomp_excursion_cost'];
                    }
                    ?>
                            <tr>
                                <td><?php echo $addComp['composition_name']; ?></td>
                                <td><span><?php echo $currencySymbol; ?></span><?php echo customNumFormat($addComp['pcomp_excursion_cost']); ?></td>
                                <td><span><?php echo $currencySymbol; ?></span><?php echo customNumFormat($addComp['pcomp_total_cost']); ?></td>
                                <td><span><?php echo $currencySymbol; ?></span><?php echo customNumFormat($weekTotalCost); ?></td>
                                <td><span><?php echo $currencySymbol; ?></span><?php echo customNumFormat($addComp['pcomp_full_price']);
                    echo ($addComp['pcomp_full_price'] > 0 && $weekTotalCost > 0 ? " <br/>" . customNumFormat(100 - ($weekTotalCost * 100 / $addComp['pcomp_full_price'])) . "%" : ''); ?></td>
                                <td><span><?php echo $currencySymbol; ?></span><?php echo customNumFormat($addComp['pcomp_price_a']);
                    echo ($addComp['pcomp_price_a'] > 0 && $weekTotalCost > 0 ? " <br/>" . customNumFormat(100 - ($weekTotalCost * 100 / $addComp['pcomp_price_a'])) . "%" : ''); ?></td>
                                <td><span><?php echo $currencySymbol; ?></span><?php echo customNumFormat($addComp['pcomp_price_b']);
                    echo ($addComp['pcomp_price_b'] > 0 && $weekTotalCost > 0 ? " <br/>" . customNumFormat(100 - ($weekTotalCost * 100 / $addComp['pcomp_price_b'])) . "%" : ''); ?></td>
                                <td><span><?php echo $currencySymbol; ?></span><?php echo customNumFormat($addComp['pcomp_price_c']);
                    echo ($addComp['pcomp_price_c'] > 0 && $weekTotalCost > 0 ? " <br/>" . customNumFormat(100 - ($weekTotalCost * 100 / $addComp['pcomp_price_c'])) . "%" : ''); ?></td>
                            </tr>
                    <?php
                }
                ?>
                    </tbody>
                </table>
                <?php
            } else {
                ?><div >No compositions added for selected package</div><?php
            }
        }
    }

    /**
     * Print booking invoice pdf file 
     * @param type $enrollId 
     */
    function bookinginvoice($enrollId = 0) {
        $this->load->helper(array('mpdf6'));
        $this->load->model('agent_booking_model');

        $booking = $this->agent_booking_model->getBookingsDetails($enrollId);
        if ($booking) {
            $booking_composition = $this->agent_booking_model->getBookingComposition($enrollId);
            $booking_accomodation = $this->agent_booking_model->getBookingAccomodation($enrollId);
            $templateData = array(
                'book' => $booking,
                'booking_composition' => $booking_composition,
                'booking_accomodation' => $booking_accomodation
            );
            $this->load->view('lte/agents_new/pdf_booking_invoice', $templateData);
            if (1) {
                ob_start(); // start output buffer
                $this->load->view('lte/agents_new/pdf_booking_invoice', $templateData);
                $templateBody = ob_get_contents(); // get contents of buffer
                ob_end_clean();

                $academicContractFile = 'booking_invoice' . time();
                if (!file_exists(BOOKING_INVOICE_FILE)) {
                    mkdir(BOOKING_INVOICE_FILE, 0755, true);
                }
                writehtmltopdf($templateBody, $academicContractFile, "", true);
            }
        } else {
            
        }
    }
    
    /**
     * update functionality for extra type of fields 
     * like extra night charges
     * extra activities
     * extra tuition days cost 
     */
    function updateServiceExtra(){
        $servId = $this->input->post('servId');
        $extraNightCharges = $this->input->post('extraNightCharges');
        $servType = $this->input->post('servType');
        if(is_numeric($servId) && is_numeric($extraNightCharges)){
            if($servType == "accomodation")
            {
                $updateArr = array(
                    'serv_extra_night' => $extraNightCharges
                );
                echo $this->packagesmodel->updateServExtraCharges($servId,$updateArr);
            }
            elseif($servType == "activity")
            {
                $updateArr = array(
                    'serv_extra_activity' => $extraNightCharges
                );
                echo $this->packagesmodel->updateServExtraCharges($servId,$updateArr);
            }
            elseif($servType == "courseType")
            {
                $updateArr = array(
                    'serv_extra_tuition' => $extraNightCharges
                );
                echo $this->packagesmodel->updateServExtraCharges($servId,$updateArr);
            }
            
            
        }
    }

}

/* End of file packages.php */