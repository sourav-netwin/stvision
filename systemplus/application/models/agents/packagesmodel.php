<?php

/**
 * Class for packages management(Model)
 * @author Sandip
 * @since 28-Nov-2016
 */
class Packagesmodel extends Model {

    private $table = 'agnt_packages';

    function listAccommodation($type = 'Students'){
        $this->db->select('accom_id,accom_name');
        $result = $this->db->get("agnt_accommodation");
        return $result->result_array();
    }
    
    function listCoursesType(){
        $this->db->select('courses_type_id,courses_type');
        $result = $this->db->get("agnt_courses_type");
        return $result->result_array();
    }
    
    function getCampusExcursion($campusId){
        $this->db->select('exc_excursion_name,exc_id,exc_days,exc_type,exc_weeks,exc_day_type');
        $this->db->where('excm_campus_id',$campusId);
        $this->db->where("exc_type = 'excursion'");//(exc_type = 'planned' OR exc_type = 'extra')
        $this->db->order_by('exc_excursion_name','asc');
        $this->db->join('agnt_excursions','excm_exc_id = exc_id');
        $result = $this->db->get('agnt_campus_excursion');
        if($result->num_rows())
            return $result->result_array();
        else
            return 0;
    }
    
    function loadRegions(){
        $this->db->select('reg_descrizione,reg_id');
        $result = $this->db->get('plused_tb_regione');
        if($result->num_rows())
            return $result->result_array();
        else
            return 0;
    }
    
    function loadCountry($regionId = 0){
        $this->db->select('cou_descrizione,cou_id');
        if($regionId)
            $this->db->where('cou_regione',$regionId);
        $result = $this->db->get('plused_tb_country');
        if($result->num_rows())
            return $result->result_array();
        else
            return 0;
    }
    
    function loadAgents($countryId = ""){
        $this->db->select('businessname,id');
        if($countryId)
            $this->db->where_in('businesscountry',$countryId);
        $result = $this->db->get('agenti');
        if($result->num_rows())
            return $result->result_array();
        else
            return 0;
    }
    
    function getCampusActivities($campusId){
        $this->db->select('act_activity_name,act_id');
        $this->db->where('actm_campus_id',$campusId);
        $this->db->join('agnt_activities','actm_act_id = act_id');
        $result = $this->db->get('agnt_campus_activities');
        if($result->num_rows())
            return $result->result_array();
        else
            return 0;
    }
    
    function categoryProgram(){
        $this->db->select('procat_id,procat_name');
        $this->db->where('procat_is_active',1);
        $this->db->where('procat_is_deleted',0);
        $result = $this->db->get('agnt_program_categories');
        if($result->num_rows())
            return $result->result_array();
        else
            return 0;
    }
    
    function operation($action, $arrayData, $edit_id = 0) {
        $resultId = 0;
        switch ($action) {
            case 'insert':
                $this->db->insert('agnt_packages', $arrayData);
                $resultId = $this->db->insert_id();
                break;
            case 'update':
                $this->db->where('pack_package_id', $edit_id);
                $this->db->update('agnt_packages', $arrayData);
                $resultId = $edit_id;
                break;
            case 'insertService':
                $this->db->insert('agnt_package_services', $arrayData);
                $resultId = $this->db->insert_id();
                break;
            case 'insertCompositions':
                $this->db->insert('agnt_package_compositions', $arrayData);
                $resultId = $this->db->insert_id();
                break;
            case 'insertPackageAgents':
                $this->db->insert('agnt_package_agents', $arrayData);
                $resultId = $this->db->insert_id();
                break;
            case 'removeServicesAdded':
                $this->db->where('serv_package_id',$edit_id);
                $this->db->delete('agnt_package_services');
                break;
            case 'removeCompositions':
                $this->db->where('pcomp_package_id',$edit_id);
                $this->db->delete('agnt_package_compositions');
                break;
            case 'removeAgentsAdded':
                $this->db->where('pagnt_package_id',$edit_id);
                $this->db->delete('agnt_package_agents');
                break;
            case 'delete':
                break;
            default :
                break;
        }
        return $resultId;
    }
    
    function getData(){
        
        $this->db->select("pack_package_id,pack_category_program_id,procat_name,pack_package,pack_campus_id,nome_centri,valuta_fattura,pack_start_date,pack_expiry_date,pack_full_price,pack_price_a,pack_price_b,pack_price_c,
                pack_for_location,pack_location_region,pack_location_country,pack_extra_gl_price,pack_extra_tuition_price,
                group_concat(distinct(ct.courses_type)) as ct_courses_type,
                group_concat(distinct(agAcc.accom_name)) as accommodation,
                pack_cd_salary,pack_cd_accomodation,pack_acd_salary,pack_acd_accomodation,pack_cm_salary,pack_cm_accomodation,pack_acm_salary,pack_acm_accomodation,pack_teacher_accomodation,pack_teacher_lunch,pack_travelling,pack_printing_stationary,pack_books,pack_expenses
                ");
        $this->db->join('centri','pack_campus_id = centri.id','left');
        $this->db->join('agnt_package_services pctype',"pack.pack_package_id = pctype.serv_package_id and pctype.serv_service_type = 'Course Type'",'left');
        $this->db->join('agnt_courses_type ct','pctype.serv_service_id = ct.courses_type_id','left');
        
        $this->db->join('agnt_package_services stdAcc',"pack.pack_package_id = stdAcc.serv_package_id and stdAcc.serv_service_type = 'Accommodation'",'left');
        $this->db->join('agnt_accommodation agAcc','stdAcc.serv_service_id = agAcc.accom_id','left');
        $this->db->join('agnt_program_categories','pack_category_program_id = procat_id','left');
        
        $this->db->group_by('pack_package_id');
        $result = $this->db->get('agnt_packages pack');
        if($result->num_rows())
            return $result->result_array();
        else
            return 0;
    }
    
    function getSinglePackageData($pack_package_id){
        $this->db->select("pack_package_id,pack_package,pack_category_program_id,pack_program_description,pack_campus_id,pack_week_1,pack_week_2,pack_week_3,pack_free_gl_per_pax,pack_start_date,pack_expiry_date,pack_full_price,pack_price_a,pack_price_b,pack_price_c,pack_for_location,pack_location_region,pack_location_country,
            pack_extra_gl_price,pack_extra_tuition_price,pack_cd_salary,pack_cd_accomodation,pack_acd_salary,pack_acd_accomodation,pack_cm_salary,pack_cm_accomodation,pack_acm_salary,pack_acm_accomodation,pack_teacher_accomodation,pack_teacher_lunch,pack_travelling,pack_printing_stationary,pack_books,pack_expenses");
        $this->db->where('pack_package_id',$pack_package_id);
        $result = $this->db->get('agnt_packages pack');
        if($result->num_rows())
            return $result->row();
        else
            return 0;
    }
    
    function getPackExcActivities($package_id,$serviceType,$week = ''){
        $this->db->select("pack_package_id,pack_package,
             serv_id,serv_service_id,serv_service_type,serv_cost,serv_week,serv_extra_night,serv_extra_activity,serv_extra_tuition");
        if($week != ''){
            if($week == "1 Week")
                $this->db->where('serv_week',$week);
            else if($week == "2 Week")
                $this->db->where("(serv_week = '1 Week' OR serv_week = '2 Week')");
            else{ //  retrive all 
                }
        }
        $this->db->join('agnt_package_services ps',"pack.pack_package_id = ps.serv_package_id",'left');
        switch ($serviceType)
        {
            //'Accommodation','Excursion','Activity','Course Type'
            case 'Accommodation':
                $this->db->select('accom_name as service_name');
                $this->db->join('agnt_accommodation service','ps.serv_service_id = service.accom_id','left');
                break;
            case 'Excursion':
                $this->db->select('exc_excursion_name as service_name');
                $this->db->join('agnt_excursions service','ps.serv_service_id = service.exc_id','left');
                break;
            case 'Activity':
                $this->db->select('act_activity_name as service_name');
                $this->db->join('agnt_activities service','ps.serv_service_id = service.act_id','left');
                break;
            case 'Course Type':
                $this->db->select('courses_type as service_name');
                $this->db->join('agnt_courses_type service','ps.serv_service_id = service.courses_type_id','left');
                break;
        }
                
        $this->db->where('pack_package_id',$package_id);
        $this->db->where('serv_service_type',$serviceType);
        $result = $this->db->get('agnt_packages pack');

        if($result->num_rows())
            return $result->result_array();
        else
            return 0;
    }
    
    function updateServExtraCharges($servId,$updateArr){
        $this->db->where('serv_id',$servId);
        $this->db->update('agnt_package_services',$updateArr);
        return $this->db->affected_rows();
    }
    
    function getPackCompositions($package_id){
        $this->db->select('pc.*,acc.accom_name,ct.courses_type,act.act_activity_name,concat_ws(" - ",pc.pcomp_week," Week", acc.accom_name,ct.courses_type,act.act_activity_name) as composition_name',false);
        $this->db->where('pcomp_package_id',$package_id);
        $this->db->join('agnt_accommodation acc','pc.pcomp_accom_id = acc.accom_id','left');
        $this->db->join('agnt_courses_type ct','pc.pcomp_course_type_id = ct.courses_type_id','left');
        $this->db->join('agnt_activities act','pc.pcomp_activity_id = act.act_id','left');
        $result = $this->db->get('agnt_package_compositions pc');
        return $result->result_array();
        
    }
    
    function loadPackageAgents($packageId){
        $this->db->where('pagnt_package_id',$packageId);
        $this->db->select('group_concat(pagnt_agent_id) as agent_ids');
        $result = $this->db->get('agnt_package_agents');
        return $result->row()->agent_ids;
    }
    
    function saveInvoiceData($insertData, $action = "Add", $invoiceId = 0) {
        if (!empty($insertData)) {
            if (is_array($insertData)) {
                if ($action == "Add") {
                    $this->db->insert('agnt_booking_invoice', $insertData);
                    return $this->db->insert_id();
                } else {
                    $this->db->where('inv_invoice_id', $invoiceId);
                    $this->db->update('agnt_booking_invoice', $insertData);
                }
            }
        }
        return 0;
    }
}

/*End of file rolemanagementmodel.php*/
