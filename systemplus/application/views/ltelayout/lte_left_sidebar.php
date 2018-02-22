<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php echo LTE; ?>dist/img/avatar5.png" class="img-circle" alt="<?php echo ucwords($this->session->userdata('businessname')); ?>">
            </div>
            <div class="pull-left info">
                <p><?php echo ucwords($this->session->userdata('businessname')); ?></p>
                <!-- Status -->
      <!--          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>-->
            </div>
        </div>

        <!-- search form (Optional) -->
        <!--      <form action="#" method="get" class="sidebar-form">
                <div class="input-group">
                  <input type="text" name="q" class="form-control" placeholder="Search...">
                      <span class="input-group-btn">
                        <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                        </button>
                      </span>
                </div>
              </form>-->
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">Menu access</li>
            <!-- Optionally, you can add icons to the links -->
    <!--        <li class="active"><a href="#"><i class="fa fa-link"></i> <span>Link</span></a></li>
            <li><a href="#"><i class="fa fa-link"></i> <span>Another Link</span></a></li>-->
            <!--        <li class="treeview">
                      <a href="#"><i class="fa fa-link"></i> <span>Role management</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                      </a>
                      <ul class="treeview-menu">
                        <li><a href="<?php //echo base_url().'index.php/roles'    ?>">Roles</a></li>
                        <li><a href="<?php //echo base_url().'index.php/roleaccess'    ?>">Menu access</a></li>
                      </ul>
                    </li>-->
            <?php
            $CI = &get_instance();
            $sess_username = $CI->session->userdata('username');
            $sess_businessname = $CI->session->userdata('businessname');
            if (AGENT_SECTION == "NEW" && $sess_username == "a.sudetti@gmail.com" && $sess_businessname == "Topolino srl") {

                /* <li class="treeview">
                  <a href="javascript:void(0);"><i class="fa fa-sign-in"></i><span>Packages</span>
                  <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                  </span>
                  </a>
                  <ul class="treeview-menu">
                  <li><a href="<?php echo base_url();?>index.php/packages/addedit">Create new package</a></li>
                  <li><a href="<?php echo base_url();?>index.php/packages">Manage packages</a></li>
                  </ul>
                  </li> */
                ?>
                <li class="treeview">
                    <a href="javascript:void(0);"><i class="fa fa-sign-in"></i><span>Enrol</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?php echo base_url() . 'index.php/agentbooking/enrol' ?>">Enrol new group</a></li>
                        <li><a href="javascript:void(0);">Need help?</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="javascript:void(0);"><i class="fa fa-list"></i> <span>Bookings review</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="active">
                            <a href="<?php echo base_url() . 'index.php/agentbooking/enrolledBookings'; ?>" >Inserted bookings</a>
                        </li>
                    </ul>
                </li>
                <?php
            } else {
                $CI->load->model('vauth/vauthmodel', 'vauthmodel');
                $lmRoleId = $CI->session->userdata('role'); //lm - left menu
                if ($CI->session->userdata('is_admin'))
                    $lmRoleId = 1;
                if ($lmRoleId) {
                    $CI->db->flush_cache();
                    $leftSideMenu = $CI->vauthmodel->getLeftSideMenus($lmRoleId);
                    if (count($leftSideMenu)) {
                        leftSideBarMenuHtml($leftSideMenu);
                    }
                }
            }
            ?>
            <?php if ($this->session->userdata('ruolo') == "operatore") { ?>

            <?php } ?>
            <?php if ($this->session->userdata('ruolo') == "contabile") { ?>
                <li class="treeview">
                    <a href="javascript:void(0);"><i class="fa fa-sign-in"></i><span>Accounting</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?php echo base_url() . 'index.php/bo_accounting/viewActiveNew' ?>">Down payment</a></li>
                        <!-- <li><a href="<?php //echo base_url();     ?>index.php/bo_accounting/set_extras">Set discount and extra days</a></li> -->
                        <!-- <li><a href="<?php //echo base_url();     ?>index.php/bo_accounting/view_confirmed/9">Invoice balance</a></li> -->
                        <!-- <li><a href="<?php //echo base_url();     ?>index.php/bo_accounting/view_confirmed/0">Review outstandings</a></li> -->
                        <!-- <li><a href="<?php //echo base_url();     ?>index.php/bo_accounting/view_confirmed/1">Review settled bookings</a></li> -->
                        <li><a href="<?php echo base_url(); ?>index.php/bo_accounting/cm_balances">Review CM balances</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="javascript:void(0);"><i class="fa fa-files-o"></i><span>Invoice summary</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?php echo base_url() . 'index.php/invoice/summary' ?>">Invoice summary debtor report</a></li>
                        <li><a href="<?php echo base_url() . 'index.php/invoice/customerdetails' ?>">Agent detailed debtors report</a></li>
                    </ul>
                </li>
            <?php } ?>
            <?php
            if ($sess_username == "a.sudetti@gmail.com" && $sess_businessname == "Topolino srl") {
                ?>
                <li class="treeview">
                    <a href="javascript:void(0);"><i class="fa fa-sign-in"></i><span>Old Enrol Booking</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?php echo base_url() . 'index.php/enrol/booking' ?>">Enrol new group</a></li>
                    </ul>
                </li>
                <?php
            }
            ?>
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
<script>
    $(document).ready(function () {
        $("#btnSaleByDate").click(function () {
            var saleByDate = $("#mnuSaleByDate").val();
            saleByDate = saleByDate.replace('/', '-').replace('/', '-');
            if (saleByDate != "")
                window.location.href = siteUrl + "backoffice/salesNew/" + saleByDate;
        });

        $("#lmnuBYPayroll").click(function () {
            var lmnuYearDropdown = $("#lmnuYearDropdown").val();
            if (lmnuYearDropdown != "")
                window.location.href = siteUrl + "contract/payrolls/" + lmnuYearDropdown;
        });

        $("#mnuSaleByDate").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            changeYear: true,
            dateFormat: "dd/mm/yy",
            numberOfMonths: 1,
            onClose: function (selectedDate) {
                $("#mnuSaleByDate").val(selectedDate);
            }
        });

        $("#editamicode").click(function () {
            var searchmecode = $.trim($("#searchmecode").val());
            if (searchmecode != "")
            {
                $.ajax({
                    type: "POST",
                    data: "codesearch=" + searchmecode,
                    url: "<?php echo base_url(); ?>index.php/backoffice/traExcursionExists",
                    success: function (response) {
                        arr_response = response.split("_");
                        if (arr_response[1] != 0) {
                            if (arr_response[0] == "exc") {
                                window.location.href = "<?php echo base_url(); ?>index.php/backoffice/busExcDetail/code_" + searchmecode;
                            } else {
                                if (arr_response[0] == "tra") {
                                    window.location.href = "<?php echo base_url(); ?>index.php/backoffice/busTraDetail/code_" + searchmecode;
                                } else {
                                    window.location.href = "<?php echo base_url(); ?>index.php/backoffice/busAllExcDetail/code_" + searchmecode;
                                }
                            }
                        } else {
                            alert("Please enter valid code");
                        }
                    }
                });
            }
        });
    });
</script>