<!-- The sidebar -->
<aside>
	<div class="top">
		<nav>
			<ul class="collapsible accordion">
<?php if($this->session->userdata('role')==100){
    /*$tuitionConArray = array('campusrooms','teachers','tuitions');
    $dashboardPath = $this->uri->segment(1);
    if(in_array($dashboardPath, $tuitionConArray)){
        $dashboardPath = 'backoffice';
    }*/
    $dashboardPath = 'backoffice';
    ?>
				<li id="dashboard"><a href="<?php echo base_url(); ?>index.php/<?php echo $dashboardPath; ?>/dashboard"><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/dashboard.png" alt="" height=16 width=16>Dashboard</a></li>
				<li id="boSalesRisks"><a href="javascript:void(0);"><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/chart-up.png" alt="" height=16 width=16>Sales and risks</a>
					<ul>
						<li id="boSalesRisks_1"><a href="<?php echo base_url(); ?>index.php/backoffice/salesNew"><span class="icon icon-bar-chart"></span>Sales</a></li>
						<li id="boSalesRisks_2"><input type="text" value="" class="salesD" style="width:70px;margin:5px 10px 10px 25px;"><input type="button" name="dateSalesmi" id="dateSalesmi" class="btnSalesByDate" value="by Date" /></li>
						<input type="hidden" class="hiddenSalesDate" value="">
					</ul>
		<?php if($this->session->userdata('ruolo')=="contabile"){?>
				<li id="boaccounting"><a href="javascript:void(0);"><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/money.png" alt="" height=16 width=16>Accounting</a>
					<ul>
						<li id="boaccounting_1"><a href="<?php echo base_url(); ?>index.php/bo_accounting/viewActiveNew"><span class="icon icon-list-alt"></span>Down payment</a></li>
						<li id="boaccounting_2"><a href="<?php echo base_url(); ?>index.php/bo_accounting/set_extras"><span class="icon icon-list-alt"></span>Set discount and extra days</a></li>
						<li id="boaccounting_3"><a href="<?php echo base_url(); ?>index.php/bo_accounting/view_confirmed/9"><span class="icon icon-list-alt"></span>Invoice balance</a></li>
						<li id="boaccounting_4"><a href="<?php echo base_url(); ?>index.php/bo_accounting/view_confirmed/0"><span class="icon icon-list-alt"></span>Review outstandings</a></li>
						<li id="boaccounting_5"><a href="<?php echo base_url(); ?>index.php/bo_accounting/view_confirmed/1"><span class="icon icon-list-alt"></span>Review settled bookings</a></li>
						<li id="boaccounting_6"><a href="<?php echo base_url(); ?>index.php/bo_accounting/cm_balances"><span class="icon icon-list-alt"></span>Review CM balances</a></li>
					</ul>
				</li>
		<?php } ?>
				<li id="bobooking"><a href="javascript:void(0);"><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/ui-layered-pane.png" alt="" height=16 width=16>Booking</a>
					<ul>
						<li id="bobooking_1"><a href="<?php echo base_url(); ?>index.php/backoffice/overviewBookingsNew"><span class="icon icon-list-alt"></span>Overview campus booking</a></li>
<?php  /* if($this->session->userdata('ruolo')=='superuser'){?>
						<li id="bobooking_7"><input type="text" class="cercathisid" id="searchme" name="searchme" style="width:50px;margin-top:5px;margin-left:25px;margin-right:10px;" /><input type="button" name="editami" id="editami" class="cercaid" value="Search ID" /></li>
						<input type="hidden" name="passa_id" id="passaid" class="passa_id" value="" />
<?php } */?>
						<?php /*<li id="bobooking_2"><a href="<?php echo base_url(); ?>index.php/backoffice/clearedBookingsToConfirm"><span class="icon icon-list-alt"></span>Confirm down payments</a></li> */ ?>
						<li id="bobooking_3"><a href="<?php echo base_url(); ?>index.php/backoffice/availabilityNew<?php /*old function reviewday2day_pax */?>"><span class="icon icon-list-alt"></span>Campus availability</a></li>
						<li id="bobooking_4"><a href="<?php echo base_url(); ?>index.php/backoffice/tuitionNew"><span class="icon icon-list-alt"></span>Review tuition day2day</a></li>
<?php if($this->session->userdata('ruolo')=='superuser'){?>
<?php /* <li id="bobooking_5"><a href="<?php echo base_url(); ?>index.php/backoffice/elapsedBookingsToElapse"><span class="icon icon-list-alt"></span>Reset elapsed bookings</a></li> */ ?>
<?php } ?>
						<li id="bobooking_6"><a href="<?php echo base_url(); ?>index.php/backoffice/exportCSVBookings/all/all/all/2016"><span class="icon icon-list-alt"></span>Download bookings (xls)</a></li>
						<li id="bobooking_7"><a href="<?php echo base_url(); ?>index.php/backoffice/exportAvailabilityDetailNew"><span class="icon icon-list-alt"></span>Download availability (xls)</a></li>
					</ul>
				</li>
				<li id="bocampus">
                                    <a href="javascript:void(0);"><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/home-share.png" alt="" height=16 width=16>Campus management</a>
					<ul>
						<li id="bocampus_2"><a href="<?php echo base_url(); ?>index.php/backoffice/new_reviewday2day_pax_new"><span class="icon icon-list-alt"></span>Campus trips & participants</a></li>
						<?php /* <li id="bocampus_1"><a href="<?php echo base_url(); ?>index.php/backoffice/campusAvailability"><span class="icon icon-columns"></span>Edit campus availability</a></li> */ ?>
                                        </ul>
                                </li>
                                <li id="mnutuition">
                                    <a href="javascript:void(0);"><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/graduation-hat.png" alt="" height=16 width=16>Tuition</a>
                                    <ul>
                                                <li id="mnutuition_1"><a href="<?php echo base_url(); ?>index.php/backoffice/campusCourses"><span class="icon icon-list-alt"></span>Courses</a></li>
                                                <li id="mnutuition_2"><a href="<?php echo base_url(); ?>index.php/campusrooms"><span class="icon icon-list-alt"></span>Campus rooms</a></li>
<!--                                                <li id="mnutuition_3"><a href="<?php //echo base_url(); ?>index.php/teachers"><span class="icon icon-list-alt"></span>Teachers</a></li>-->
                                                <li id="mnutuition_3"><a href="<?php echo base_url(); ?>index.php/staff/priority"><span class="icon icon-list-alt"></span>Staff priority</a></li>
                                                <li id="mnutuition_4"><a href="<?php echo base_url(); ?>index.php/tuitions"><span class="icon icon-list-alt"></span>Tuitions schedule</a></li>
                                                <li id="mnutuition_8"><a href="<?php echo base_url(); ?>index.php/tuitions/plan"><span class="icon icon-list-alt"></span>Class timetable</a></li>
                                                <li id="mnutuition_5"><a href="<?php echo base_url(); ?>index.php/tuitionsreports"><span class="icon icon-list-alt"></span>Tuitions schedule report</a></li>
                                                <li id="mnutuition_6"><a href="<?php echo base_url(); ?>index.php/tuitionsreports/teachers"><span class="icon icon-list-alt"></span>Teacher work report</a></li>
                                    </ul>
                                </li>
                                <li id="mnujobcontract">
                                    <a href="javascript:void(0);"><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/hand-shake.png" alt="" height=16 width=16>Job and contracts</a>
                                    <ul>
                                                <li id="mnujobcontract_1"><a href="<?php echo base_url(); ?>index.php/teachers/review"><span class="icon icon-list-alt"></span>Teachers CV review</a></li>
                                                <li id="mnujobcontract_2"><a href="<?php echo base_url(); ?>index.php/teachers/profilereview"><span class="icon icon-list-alt"></span>Teachers interviews</a></li>
                                                <li id="mnujobcontract_3"><a href="<?php echo base_url(); ?>index.php/jobofferhistory"><span class="icon icon-list-alt"></span>Job offer history</a></li>
                                                <li id="mnujobcontract_4"><a href="<?php echo base_url(); ?>index.php/contract"><span class="icon icon-list-alt"></span>Contract</a></li>
                                                <li id="mnujobcontract_5"><a href="<?php echo base_url(); ?>index.php/contract/payrolls"><span class="icon icon-list-alt"></span>Contract payrolls</a></li>
                                    </ul>
				</li>
                                <li id="mnusurvey">
                                    <a href="javascript:void(0);"><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/document-text.png" alt="" height=16 width=16>Survey</a>
                                    <ul>
                                                <li id="mnusurvey_1"><a href="<?php echo base_url(); ?>index.php/survey/report"><span class="icon icon-list-alt"></span>GL report</a></li>
                                                <li id="mnusurvey_2"><a href="<?php echo base_url(); ?>index.php/survey/studentsreport"><span class="icon icon-list-alt"></span>Students report</a></li>
                                    </ul>
				</li>
                                <li id="mnustudents">
                                    <a href="javascript:void(0);"><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/document-text.png" alt="" height=16 width=16>Students</a>
                                    <ul>
                                                <li id="mnustudents_1"><a href="<?php echo base_url(); ?>index.php/studentsreport"><span class="icon icon-list-alt"></span>Test report</a></li>
                                    </ul>
				</li>
				<li id="jocampbus"><a href="javascript:void(0);"><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table-join.png" alt="" height=16 width=16>Excursion management</a>
                                    <ul>
                                            <li id="jocampbus_1"><a href="<?php echo base_url(); ?>index.php/joincampuscompany"><span class="icon icon-list-alt"></span>Join campus and companies</a></li>
                                            <li id="jocampbus_2"><a href="<?php echo base_url(); ?>index.php/excursionexportimport"><span class="icon icon-list-alt"></span>Export and import</a></li>
                                    </ul>
                                </li>
                                <li id="jovisamgt"><a href="javascript:void(0);"><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table-join.png" alt="" height=16 width=16>VISA management</a>
                                    <ul>
                                            <li id="jovisamgt_1"><a href="<?php echo base_url(); ?>index.php/jointemplatecampus"><span class="icon icon-list-alt"></span>Join template-campus</a></li>

                                    </ul>
                                </li>

								<li id="jonatmgt"><a href="javascript:void(0);"><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table-join.png" alt="" height=16 width=16>Nationality management</a>
                                    <ul>
                                            <li id="jonatmgt_1"><a href="<?php echo base_url(); ?>index.php/jointemplatenationality"><span class="icon icon-list-alt"></span>Join template-nationality</a></li>

                                    </ul>
                                </li>
                                <li id="tktbomgt"><a href="javascript:void(0);"><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table-join.png" alt="" height=16 width=16>Ticket management <span id="BoNotif"></span></a>
                                    <ul>
                                            <li id="tktbomgt_1"><a href="<?php echo base_url(); ?>index.php/ticketmanagement"><span class="icon icon-list-alt"></span>Manage tickets</a></li>

                                    </ul>
                                </li>
                                <li id="role_management"><a href="javascript:void(0);"><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table-join.png" alt="" height=16 width=16>Role management <span id="BoNotif"></span></a>
                                    <ul>
                                            <li id="role_management_1"><a href="<?php echo base_url(); ?>index.php/roles"><span class="icon icon-list-alt"></span>Roles</a></li>
                                            <li id="role_management_2"><a href="<?php echo base_url(); ?>index.php/roleaccess"><span class="icon icon-list-alt"></span>Role access</a></li>
                                    </ul>
                                </li>
	<?php if($this->session->userdata('ruolo')=='superuser'){?>
			<?php if($this->session->userdata('username')=='andrea'){ ?>
				<li id="botransport"><a href="javascript:void(0);"><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/train-metro.png" alt="" height=16 width=16>Transportation</a>
					<ul>
<?php
/*
rimosse voci excursions spostate in sezione included excursions
						<li id="botransport_1"><a href="<?php echo base_url(); ?>index.php/backoffice/setUnplannedExcursions"><span class="icon icon-list-alt"></span>Book excursions</a></li>
						<li id="botransport_2"><a href="<?php echo base_url(); ?>index.php/backoffice/viewPlannedExcursions"><span class="icon icon-list-alt"></span>View booked excursions</a></li>
*/
?>
						<li id="botransport_4" style="margin-top:10px;margin-bottom:10px;"><input type="text" class="cercathiscode" id="searchmecode" name="searchmecode" style="width:50px;margin-left:25px;margin-right:10px;" /><input type="button" name="editamicode" id="editamicode" class="cercacode" value="Search Bus" /></li>
						<input type="hidden" name="passa_code" id="passacode" class="passa_code" value="" />
<?php
/*
rimosse voci transfers spostate in sezione transfers
						<li id="botransport_5"><a href="<?php echo base_url(); ?>index.php/backoffice/setTransfers/inbound"><span class="icon icon-list-alt"></span>Set inbound transfers</a></li>
						<li id="botransport_6"><a href="<?php echo base_url(); ?>index.php/backoffice/setTransfers/outbound"><span class="icon icon-list-alt"></span>Set outbound transfers</a></li>
						<li id="botransport_7"><a href="<?php echo base_url(); ?>index.php/backoffice/viewBookedTransfers"><span class="icon icon-list-alt"></span>View booked transfers</a></li>
*/
?>
						<li id="botransport_3"><a href="<?php echo base_url(); ?>index.php/backoffice/companiesDetails"><span class="icon icon-list-alt"></span>Companies details</a></li>
						<li id="botransport_8"><a href="<?php echo base_url(); ?>index.php/backoffice/servicesReview"><span class="icon icon-list-alt"></span>Services review by company</a></li>
						<li id="botransport_9"><a href="<?php echo base_url(); ?>index.php/backoffice/canceledBusReview"><span class="icon icon-list-alt"></span>Review canceled bus</a></li>
					</ul>
				</li>
				<li id="boplexcursions"><a href="javascript:void(0);"><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/bank.png" alt="" height=16 width=16>Included excursions</a>
					<ul>
						<li id="boplexcursions_1"><a href="<?php echo base_url(); ?>index.php/backoffice/setUnplannedExcursions"><span class="icon icon-edit"></span>Book included excursions</a></li>
						<li id="boplexcursions_2"><a href="<?php echo base_url(); ?>index.php/backoffice/viewPlannedExcursions"><span class="icon icon-list-alt"></span>Review included excursions</a></li>
					</ul>
				</li>
				<li id="boexcursions"><a href="javascript:void(0);"><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/bank--plus.png" alt="" height=16 width=16>Extra excursions</a>
					<ul>
						<li id="boexcursions_1"><a href="<?php echo base_url(); ?>index.php/backoffice/setUnplannedAllExcursions"><span class="icon icon-edit"></span>Book extra excursions</a></li>
						<li id="boexcursions_2"><a href="<?php echo base_url(); ?>index.php/backoffice/viewPlannedAllExcursions"><span class="icon icon-list-alt"></span>Rewiew extra excursions</a></li>
					</ul>
				</li>
				<li id="boattractions"><a href="javascript:void(0);"><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/globe-model.png" alt="" height=16 width=16>Attractions</a>
					<ul>
						<li id="boattractions_1"><a href="<?php echo base_url(); ?>index.php/backoffice/reviewBookedAttractions"><span class="icon icon-edit"></span>Confirm booked attractions</a></li>
						<li id="boattractions_2"><a href="<?php echo base_url(); ?>index.php/backoffice/reviewConfirmedAttractions"><span class="icon icon-list-alt"></span>View confirmed attractions</a></li>
					</ul>
				</li>
				<li id="botransfers"><a href="javascript:void(0);"><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/transfer_plane.png" alt="" height=16 width=16>Transfers</a>
					<ul>
						<li id="botransfers_1"><a href="<?php echo base_url(); ?>index.php/backoffice/setTransfers/inbound"><span class="icon icon-signin"></span>Book inbound transfers</a></li>
						<li id="botransfers_2"><a href="<?php echo base_url(); ?>index.php/backoffice/setTransfers/outbound"><span class="icon icon-signout"></span>Book outbound transfers</a></li>
						<li id="botransfers_3"><a href="<?php echo base_url(); ?>index.php/backoffice/viewBookedTransfers"><span class="icon icon-plane"></span>View booked transfers</a></li>
						<li id="botransfers_5"><a href="<?php echo base_url(); ?>index.php/backoffice/resetLostTransfers"><span class="icon icon-check"></span>Lost and found transfers</a></li>
<?php if($this->session->userdata('ruolo')=='superuser'){?>
						<li id="botransfers_4"><a href="<?php echo base_url(); ?>index.php/backoffice/reviewOpTransfers"><span class="icon icon-thumbs-up"></span>Review transfers</a></li>
<?php } ?>
					</ul>
				</li>
				<!-- li id="jocampbus"><a href="javascript:void(0);"><img src="<?php //echo base_url(); ?>img/icons/packs/fugue/16x16/table-join.png" alt="" height=16 width=16>Excursion management</a>
					<ul>
							<li id="jocampbus_1"><a href="<?php //echo base_url(); ?>index.php/joincampuscompany"><span class="icon icon-list-alt"></span>Join campus and companies</a></li>
							<li id="jocampbus_2"><a href="<?php //echo base_url(); ?>index.php/excursionexportimport"><span class="icon icon-list-alt"></span>Export and import</a></li>
					</ul>
				</li -->
			<?php } ?>
	<?php } ?>
<?php } ?>
<?php	 if(($this->session->userdata('role')!=400 && $this->session->userdata('role')!=500 && $this->session->userdata('role')!=501 && $this->session->userdata('role')!=502 && $this->session->userdata('role')!=100 && $this->session->userdata('role')!=200 && $this->session->userdata('role')!=300 && $this->session->userdata('role') != 550) || $this->session->userdata('ruolo')=='contabile'){
			if($this->session->userdata('role')!=97){
?>
				<li id="dashboard"><a href="<?php echo base_url(); ?>index.php/agents/dashboard"><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/dashboard.png" alt="" height=16 width=16>Dashboard</a></li>
				<li id="mktplusj"><a href="javascript:void(0);"><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/ui-layered-pane.png" alt="" height=16 width=16>Programmes Info & Prices</a>
					<ul>
						<li id="mktplusj_1"><a href="<?php echo base_url(); ?>index.php/agents/mkt_material_pj"><span class="icon icon-list-alt"></span>Junior Summer</a></li>
						<li id="mktplusj_2"><a href="<?php echo base_url(); ?>index.php/agents/mkt_material_pjw"><span class="icon icon-list-alt"></span>Junior Winter</a></li>
						<li id="mktplusj_3"><a href="javascript:void(0);"><span class="icon icon-list-alt"></span>Pathway</a></li>
						<li id="mktplusj_4"><a href="javascript:void(0);"><span class="icon icon-list-alt"></span>Undergraduate</a></li>
					</ul>
				</li>
<?php
			}
		} ?>

<?php
         if($this->session->userdata('role') == 500){
    ?>
                <li id="dashboard"><a href="<?php echo base_url(); ?>index.php/users/dashboard"><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/dashboard.png" alt="" height=16 width=16>Dashboard</a></li>
                <li id="myaccount">
                    <a href="javascript:void(0);">
                        <img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/ui-layered-pane.png" alt="" height=16 width=16>
                        My Account
                    </a>
                    <ul>
                        <li id="myaccount_1"><a href="<?php echo base_url(); ?>index.php/users/documents"><span class="icon icon-list-alt"></span>Personal information</a></li>
                        <li id="myaccount_2"><a href="<?php echo base_url(); ?>index.php/users/contracts"><span class="icon icon-list-alt"></span>Contracts</a></li>
                    </ul>
                </li>
    <?php
        }
        if($this->session->userdata('role') == 501){
    ?>
                <li id="dashboard"><a href="<?php echo base_url(); ?>index.php/survey/dashboard"><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/dashboard.png" alt="" height=16 width=16>Dashboard</a></li>
                <li id="takethesurvey">
                    <a href="javascript:void(0);">
                        <img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/ui-layered-pane.png" alt="" height=16 width=16>
                        Take the survey
                    </a>
                    <ul>
                        <li id="takethesurvey_1"><a href="<?php echo base_url(); ?>index.php/survey/view/report1"><span class="icon icon-list-alt"></span>Take survey 1</a></li>
                        <li id="takethesurvey_2"><a href="<?php echo base_url(); ?>index.php/survey/view/report2"><span class="icon icon-list-alt"></span>Take survey 2</a></li>
                    </ul>
                </li>
    <?php
        }
        if($this->session->userdata('role') == 502){
    ?>
                <li id="dashboard"><a href="<?php echo base_url(); ?>index.php/students/dashboard"><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/dashboard.png" alt="" height=16 width=16>Dashboard</a></li>
                <li id="students">
                    <a href="javascript:void(0);">
                        <img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/ui-layered-pane.png" alt="" height=16 width=16>
                        Test / Survey
                    </a>
                    <ul>
						<li id="students_1"><a href="<?php echo base_url(); ?>index.php/students/englishtest"><span class="icon icon-list-alt"></span>Grammar and vocabulary</a></li>
						<li id="students_2"><a href="<?php echo base_url(); ?>index.php/student_survey"><span class="icon icon-list-alt"></span>Take student survey</a></li>
                    </ul>
                </li>
    <?php
        }
        ?>

    <!-- COURSE DIRECTOR -->
    <?php
         if($this->session->userdata('role') == 400){
    ?>
            <li id="dashboard"><a href="<?php echo base_url(); ?>index.php/backoffice/dashboard"><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/dashboard.png" alt="" height=16 width=16>Dashboard</a></li>
            <li id="mnutuition">
                <a href="javascript:void(0);"><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/graduation-hat.png" alt="" height=16 width=16>Tuition</a>
                <ul>
<!--                            <li id="mnutuition_1"><a href="<?php //echo base_url(); ?>index.php/backoffice/campusCourses"><span class="icon icon-list-alt"></span>Courses</a></li>-->
                            <li id="mnutuition_2"><a href="<?php echo base_url(); ?>index.php/campusrooms"><span class="icon icon-list-alt"></span>Campus rooms</a></li>
                            <li id="mnutuition_7"><a href="<?php echo base_url(); ?>index.php/tuitions/updatelang"><span class="icon icon-list-alt"></span>Language knowledge</a></li>
                            <li id="mnutuition_4"><a href="<?php echo base_url(); ?>index.php/tuitions"><span class="icon icon-list-alt"></span>Tuitions schedule</a></li>
                            <li id="mnutuition_8"><a href="<?php echo base_url(); ?>index.php/tuitions/plan"><span class="icon icon-list-alt"></span>Class timetable</a></li>
                            <li id="mnutuition_9"><a href="<?php echo base_url(); ?>index.php/tuitions/teachers"><span class="icon icon-list-alt"></span>Teachers details</a></li>
                            <li id="mnutuition_10"><a href="<?php echo base_url(); ?>index.php/tuitions/teachersreview"><span class="icon icon-list-alt"></span>Teachers review</a></li>

                </ul>
            </li>
    <?php }?>
    <!-- END: COURSE DIRECTOR -->


<?php if($this->session->userdata('role')==99){?>
				<li id="enrol"><a href="javascript:void(0);"><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/book--plus.png" alt="" height=16 width=16>Enrol</a>
					<ul>
						<li id="enrol_1"><a href="<?php echo base_url(); ?>index.php/agents/enrol"><span class="icon icon-edit"></span>Enrol new group</a></li>
						<li id="enrol_2"><a href="javascript:void(0);"><span class="icon icon-exclamation-sign"></span>Need help?</a></li>
						<?php if($this->session->userdata('username')=='a.sudetti@gmail.com'){?>
						<li id="enrol_3"><a href="javascript:void(0);" class="newEnrol"><span class="icon icon-edit"></span>New Enrol</a></li>
						<?php } ?>
						</ul>
					</li>
					<li id="bookings">
						<a href="javascript:void(0);"><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/books-stack.png" alt="" height=16 width=16>Bookings review</a>
						<ul>
							<li id="bookings_1"><a href="<?php echo base_url(); ?>index.php/agents/insertedBookings"><span class="icon icon-star"></span>Inserted bookings</a></li>
						</ul>
					</li>
					<?php // if($this->session->userdata('username')=='m.marra@studytours.it' || $this->session->userdata('username')=='Ega_0ELxA' || $this->session->userdata('username')=='a.sudetti@gmail.com'){ ?>
					<li id="ag_excursions">
						<a href="javascript:void(0);"><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/bank.png" alt="" height=16 width=16>Extra excursions</a>
						<ul>
							<li id="ag_excursions_1"><a href="<?php echo base_url(); ?>index.php/agents/bookExtraExcursions/confirmed/id_centro/asc"><span class="icon icon-edit"></span>Book extra excursions</a></li>
							<li id="ag_excursions_3"><a href="<?php echo base_url(); ?>index.php/agents/viewExtraExcursions/confirmed/id_book/desc"><span class="icon icon-zoom-in"></span>Review excursions prices</a></li>
						</ul>
					</li>
					<li id="ag_attractions">
						<a href="javascript:void(0);"><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/globe-model.png" alt="" height=16 width=16>Attractions and entrances</a>
						<ul>
							<li id="ag_attractions_1"><a href="<?php echo base_url(); ?>index.php/agents/viewAttractions"><span class="icon icon-zoom-in"></span>Available attractions</a></li>
							<li id="ag_attractions_2"><a href="<?php echo base_url(); ?>index.php/agents/viewBookedAttractions"><span class="icon icon-star"></span>View booked attractions</a></li>
						</ul>
					</li>
					<?php // } ?>
					<li id="imagegallery">
						<a href="javascript:void(0);"><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/media-player.png" alt="" height=16 width=16>Media gallery</a>
						<ul>
							<li id="media_1"><a href="<?php echo base_url(); ?>index.php/agents/imageGallery"><span class="icon icon-picture"></span>Image gallery</a></li>
						</ul>
					</li>
<?php
}
?>
<?php if($this->session->userdata('role')==97){?>
					<li id="imagegallery">
						<a href="javascript:void(0);"><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/media-player.png" alt="" height=16 width=16>Media gallery</a>
						<ul>
							<li id="media_1"><a href="<?php echo base_url(); ?>index.php/agents/imageGallery"><span class="icon icon-picture"></span>Image gallery</a></li>
						</ul>
					</li>
<?php
}
?>
<?php if($this->session->userdata('role')==98){?>
				<li id="manage_ag"><a href="javascript:void(0);"><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/users.png" alt="" height=16 width=16>Manage agents</a>
					<ul>
						<li id="man_ag_1"><a href="<?php echo base_url(); ?>index.php/agents/listAgents"><span class="icon icon-list"></span>View agents</a></li>
						<li id="man_ag_2"><a href="<?php echo base_url(); ?>index.php/agents/insertAgent"><span class="icon icon-plus-sign"></span>Insert agent/prospect</a></li>
					</ul>
				</li>
				<li id="manage_crm"><a href="javascript:void(0);"><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/user-business.png" alt="" height=16 width=16>CRM Module</a>
					<ul>
						<li id="man_crm_1"><a href="<?php echo base_url(); ?>index.php/agents/viewOrganizer/<?php echo date("Y") ?>"><span class="icon icon-calendar"></span>View organizer</a></li>
					</ul>
				</li>
<?php
}
?>
<?php if($this->session->userdata('role')==200){?>
				<li id="campus_ca"><a href="javascript:void(0);"><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/books-stack.png" alt="" height=16 width=16>Campus review</a>
					<ul>
						<!--<li id="campus_ca_1"><a href="<?php //echo base_url(); ?>index.php/backoffice/ca_reviewday2day_pax_new"><span class="icon icon-list"></span>Review by month</a></li>-->
						<li id="campus_ca_2"><a href="<?php echo base_url(); ?>index.php/backoffice/ca_reviewbydate_pax_new"><span class="icon icon-list"></span>Review by date</a></li>
					</ul>
				</li>
				<li id="cabookings"><a href="javascript:void(0);"><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/ui-layered-pane.png" alt="" height=16 width=16>Bookings review</a>
					<ul>
						<li id="cabookings_1"><a href="<?php echo base_url(); ?>index.php/backoffice/ca_viewAllBookings"><span class="icon icon-edit"></span>Bookings and excursions</a></li>
					</ul>
				</li>
				<li id="botransport"><a href="javascript:void(0);"><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/train-metro.png" alt="" height=16 width=16>Transportation</a>
					<ul>
						<li id="botransport_7"><a href="<?php echo base_url(); ?>index.php/backoffice/ca_viewBookedTransfers"><span class="icon icon-list-alt"></span>View booked transfers</a></li>
						<li id="botransport_3"><a href="<?php echo base_url(); ?>index.php/backoffice/companiesDetails"><span class="icon icon-list-alt"></span>Companies details</a></li>
					</ul>
				</li>
				<li id="mngTkt"><a href="javascript:void(0);"><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table-join.png" alt="" height=16 width=16>Manage ticket<span id="CmNotif"></span></a>
					<ul>
						<li id="mngTkt_1"><a href="<?php echo base_url(); ?>index.php/backoffice/openTicket"><span class="icon icon-list-alt"></span>Open ticket</a></li>
						<li id="mngTkt_2"><a href="<?php echo base_url(); ?>index.php/backoffice/recapTicket"><span class="icon icon-list-alt"></span>Recap</a></li>
					</ul>
				</li>
				<li id="mngSrvy"><a href="javascript:void(0);"><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table-join.png" alt="" height=16 width=16>GL and students credentials<span id="GLCred"></span></a>
					<ul>
						<li id="mngSrvy_1"><a href="<?php echo base_url(); ?>index.php/backoffice/glCredentials"><span class="icon icon-list-alt"></span>GL and students list</a></li>
					</ul>
				</li>
				<li id="blncSht"><a href="javascript:void(0);"><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/table-join.png" alt="" height=16 width=16>Petty cash<span id="BalSht"></span></a>
					<ul>
						<li id="blncSht_1"><a href="<?php echo base_url(); ?>index.php/backoffice/bsPayments"><span class="icon icon-list-alt"></span>Payments</a></li>
					</ul>
				</li>
<?php
}
?>
<?php if($this->session->userdata('role')==300){?>
				<li id="cms_campus"><a href="javascript:void(0);"><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/building-hedge.png" alt="" height=16 width=16>Campus and excursions</a>
					<ul>
						<li id="cms_campus_1"><a href="<?php echo base_url(); ?>index.php/backoffice/cmsManageCampus"><span class="icon icon-list"></span>Manage campus</a></li>
						<li id="cms_campus_2"><a href="<?php echo base_url(); ?>index.php/backoffice/cmsManageExcursions/planned"><span class="icon icon-list"></span>Manage planned excursions</a></li>
						<li id="cms_campus_4"><a href="<?php echo base_url(); ?>index.php/backoffice/cmsManageExcursions/extra"><span class="icon icon-list"></span>Manage extra excursions</a></li>
						<li id="cms_campus_3"><a href="<?php echo base_url(); ?>index.php/backoffice/cmsManageAttractions"><span class="icon icon-list"></span>Manage attractions</a></li>
					</ul>
				</li>
				<li id="cms_bus"><a href="javascript:void(0);"><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/bus_excursion.png" alt="" height=16 width=16>Coaches and prices</a>
					<ul>
						<li id="cms_bus_1"><a href="<?php echo base_url(); ?>index.php/backoffice/cmsManageCoaches"><span class="icon icon-list"></span>Manage coach companies</a></li>
					</ul>
				</li>
				<li id="cms_airports"><a href="javascript:void(0);"><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/transfer_plane.png" alt="" height=16 width=16>Airports and stations</a>
					<ul>
						<li id="cms_airports_1"><a href="<?php echo base_url(); ?>index.php/backoffice/cmsManageAirports"><span class="icon icon-list"></span>Manage aiports</a></li>
					</ul>
				</li>
<?php
} 	if($this->session->userdata('role') == 550) {
?>
    <li id="dashboard"><a href="<?php echo base_url(); ?>index.php/webservice/index"><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/dashboard.png" alt="" height=16 width=16>Dashboard</a></li>
    <li id="mnuwebservice">
    	<a href="javascript:void(0);"><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/document-text.png" alt="" height=16 width=16>Webservice management</a>
        <ul>
        	<li id="mnuwebservice_1"><a href="<?php echo base_url(); ?>index.php/webservice/import"><span class="icon icon-list-alt"></span>Import file</a></li>
            <li id="mnuwebservice_2"><a href="<?php echo base_url(); ?>index.php/webservice/report"><span class="icon icon-list-alt"></span>Webservice data report</a></li>
            <li id="mnuwebservice_3"><a href="<?php echo base_url(); ?>index.php/webservice/glReport"><span class="icon icon-list-alt"></span>Export by GL</a></li>
        </ul>
	</li>
	<li id="mnusthistory">
    	<a href="javascript:void(0);"><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/document-text.png" alt="" height=16 width=16>ST history data</a>
        <ul>
        	<li id="mnusthistory_1"><a href="<?php echo base_url(); ?>index.php/sthistory/import"><span class="icon icon-list-alt"></span>Import file</a></li>
        	<li id="mnusthistory_2"><a href="<?php echo base_url(); ?>index.php/sthistory/report"><span class="icon icon-list-alt"></span>ST history data report</a></li>
        </ul>
	</li>
<?php
    }
?>
<!--
					<li id="invoices">
						<a href="javascript:void(0);"><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/money-coin.png" alt="" height=16 width=16>Invoices & payments</a>
						<ul>
							<li id="invoices_1"><a href="javascript:void(0);"><span class="icon icon-folder-open"></span>View Invoices</a></li>
							<li id="invoices_2"><a href="javascript:void(0);"><span class="icon icon-money"></span>Payments history</a></li>
						</ul>
					</li>
					<li id="charts">
						<a href="javascript:void(0);"><img src="<?php echo base_url(); ?>img/icons/packs/fugue/16x16/chart.png" alt="" height=16 width=16>Statistics / Charts</a>
						<ul>
							<li id="charts_1"><a href="javascript:void(0);"><span class="icon icon-bar-chart"></span>View statistics</a></li>
						</ul>
					</li> -->
				</ul></nav><!-- End of nav -->
			</div><!-- End of .top -->
<!--
			<div class="bottom sticky">
				<div class="divider"></div>
				<div class="progress">
					<div class="bar" data-title="Confirmed bookings" data-value="6" data-max="17" data-format=""></div>
					<div class="bar" data-title="Active bookings" data-value="3" data-max="17" data-format=""></div>
					<div class="bar" data-title="To be confirmed bookings" data-value="4" data-max="17" data-format=""></div>
					<div class="bar" data-title="Elapsed bookings" data-value="2" data-max="17" data-format=""></div>
					<div class="bar" data-title="Rejected bookings" data-value="2" data-max="17" data-format=""></div>
				</div>
				<div class="divider"></div>
				<div class="buttons">
					<a href="javascript:void(0);" class="button grey open-add-client-dialog">Enrol new group</a>
					<a href="<?php echo base_url(); ?>index.php/agents/logout" class="button grey open-add-client-dialog">Logout</a>
				</div>
			</div>--> <!-- End of .bottom -->

		</aside><!-- End of sidebar -->
<?php if($this->session->userdata('ruolo')=='superuser'){?>
<script>
	$(document).ready(function(){
	<?php
	/*
	//search booking id
		$("li#bobooking_7 input.cercaid").click(function(){
			$.ajax({
				type: "POST",
				data: "idsearch=" + $("input.passa_id").val(),
				url: "<?php echo base_url(); ?>index.php/backoffice/bookingExists",
				success: function(response){
					if(response==1){
						window.location.href = "<?php echo base_url(); ?>index.php/backoffice/take/" + $("input.passa_id").val();
					}else{
						alert("no id");
					}
				}
			});
		});
		$("input.cercathisid").blur(function(){
			$("input.passa_id").val($(this).val());
		});
	*/
	?>
	//search excursion code
		$("li#botransport_4 input.cercacode").click(function(){
			$.ajax({
				type: "POST",
				data: "codesearch=" + $("input.passa_code").val(),
				url: "<?php echo base_url(); ?>index.php/backoffice/traExcursionExists",
				success: function(response){
					arr_response = response.split("_");
					if(arr_response[1]!=0){
						if(arr_response[0]=="exc"){
							window.location.href = "<?php echo base_url(); ?>index.php/backoffice/busExcDetail/code_" + $("input.passa_code").val();
						}else{
							if(arr_response[0]=="tra"){
								window.location.href = "<?php echo base_url(); ?>index.php/backoffice/busTraDetail/code_" + $("input.passa_code").val();
							}else{
								window.location.href = "<?php echo base_url(); ?>index.php/backoffice/busAllExcDetail/code_" + $("input.passa_code").val();
							}
						}
					}else{
						alert("no code");
					}
				}
			});
		});
		$("input.cercathiscode").blur(function(){
			$("input.passa_code").val($(this).val());
		});

<?php if($this->session->userdata('role')==100){?>
	//sales by date

		 $( ".salesD" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			changeYear: true,
			dateFormat: "dd/mm/yy",
			numberOfMonths: 1,
			onClose: function( selectedDate ) {
				$(".hiddenSalesDate").val(selectedDate);
			}
		 });

		 $(".btnSalesByDate").click(function(){
			if($(".hiddenSalesDate").val()==""){
				alert("Please select a date!");
			}else{
				turnedDate = $(".hiddenSalesDate").val().split("/");
				okiDate = turnedDate[2]+"-"+turnedDate[1]+"-"+turnedDate[0];
				window.location.href = "<?php echo base_url(); ?>index.php/backoffice/salesNew/" + okiDate;
			}
		 });
<?php } ?>

	});
</script>
<?php } ?>


<?php if($this->session->userdata('username')=='a.sudetti@gmail.com'){?>
<script>
$(document).ready(function(){
//maschera new enrol agente
	$('.newEnrol').on('click', function(e){
        var diaH = $(window).height()* 0.9;
        e.preventDefault();
        $('<div/>', {'class':'myDlgClass', 'style' :'background:#fff url(http://plus-ed.com/vision_ag/img/logo_loading.gif) center center no-repeat;', 'id':'link-'+($(this).index()+1)})
            .html($('<iframe/>', {
                'src' : "http://plus-ed.com/vision_ag/index.php/agents/plusedNewEnrol/",
                'style' :'width:100%; height:100%;border:none;',
            })).appendTo('body')
            .dialog({
                'title' : 'Enrol new group',
                'width' : '90%',
                'height' : diaH,
                modal: true,
                buttons: [ {
                    text: "Close",
                    click: function() { $( this ).dialog( "close" ); }
                } ]
            });
    });
});
</script>
<?php } ?>

