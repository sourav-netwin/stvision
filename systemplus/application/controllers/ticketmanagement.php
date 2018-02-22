<?php

/**
 * Class to control backoffice ticket management
 * @since 09-June-2016
 * @author Arunsankar
 */
class Ticketmanagement extends Controller {

    public function __construct() {

        parent::Controller();
        $this->load->helper(array('url'));
        $this->load->model("tuition/tktmanagemodel", "tktmanagemodel");
        $this->load->model('mbackoffice');
        $this->load->library(array('session', 'email', 'ltelayout'));
    }

    /**
     * Show ticket management UI
     * @author Arunsankar
     * @since 09-June-2016
     */
    function index() {
//        if ($this->session->userdata('username') && $this->session->userdata('role') == 100) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $data['title'] = "plus-ed.com | Ticket Management";
            $data['breadcrumb1'] = 'Ticket management';
            $data['breadcrumb2'] = 'Manage tickets';
            $data['campuses'] = array();
            $data['priorities'] = array();
            $data['categories'] = array();
            $data['sent_categories'] = array();
            $data['dateFiled'] = '';
            $data['daysPassed'] = '';
            $data['status'] = array();
            $data['hour'] = '';
            $data['type'] = array();

            if (isset($_POST['inTktFltr']) || isset($_POST['centri']) || isset($_POST['priority']) || isset($_POST['dateFiled']) || isset($_POST['daysPassed'])) {
                $data['campuses'] = isset($_POST['centri']) ? $_POST['centri'] : array();
                $data['priorities'] = isset($_POST['priority']) ? $_POST['priority'] : array();
                $data['categories'] = isset($_POST['category']) ? $_POST['category'] : array();
                $data['sent_categories'] = isset($_POST['sent_category']) ? $_POST['sent_category'] : array();
                $data['dateFiled'] = isset($_POST['dateFiled']) ? $_POST['dateFiled'] : '';
                $data['daysPassed'] = isset($_POST['daysPassed']) ? $_POST['daysPassed'] : '';
                $data['status'] = isset($_POST['status']) ? $_POST['status'] : array();
                $data['type'] = isset($_POST['type']) ? $_POST['type'] : array();
                $data['hour'] = isset($_POST['selHours']) ? $_POST['selHours'] : '';
            }
            $data["centri"] = $this->tktmanagemodel->getAllCampus(1);
            $data["tickets"] = $this->tktmanagemodel->getTicketDetails($data['campuses'], $data['priorities'], $data['dateFiled'], $data['daysPassed'], $data['categories'], $data['status'], $data['hour'], $data['type'], 0);
            $data["sent_tickets"] = $this->tktmanagemodel->getTicketDetails($data['campuses'], $data['priorities'], $data['dateFiled'], $data['daysPassed'], $data['sent_categories'], $data['status'], $data['hour'], $data['type'], 1);
            if (APP_THEME == 'OLD') {
                $this->load->view('tuition/plused_tkt_manage', $data);
            } else {
                $data['pageHeader'] = "Manage tickets";
                $data['optionalDescription'] = "";
                $this->ltelayout->view('lte/backoffice/ticket/manage_ticket', $data);
            }
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    /**
     * Function to check the ticket status
     * @author Arunsankar
     * @since 09-June-2016
     */
    function checkTicketStatus() {
//        if ($this->session->userdata('role') == 100 || $this->session->userdata('role') == 200 || $this->session->userdata('role') == 400) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $selId = $this->input->post('selId');
            $isTicketAvailable = $this->tktmanagemodel->checkTicketStatus($selId);
            if ($isTicketAvailable) {
                echo '1';
            } else {
                echo '0';
            }
        } else {
            redirect('ticketmanagement', 'refresh');
        }
    }

    /**
     * Function to open the modal for reply to ticket
     * @author Arunsankar
     * @since 09-June-2016
     */
    function openTicketReply($ptcId) {
//        if ($this->session->userdata('role') == 100 || $this->session->userdata('role') == 200 || $this->session->userdata('role') == 400) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $data['title'] = 'plus-ed.com | Reply Ticket';
            $data['breadcrumb1'] = 'Ticket Management';
            $data['breadcrumb2'] = 'Reply Ticket';
            $data['ptc_id'] = $ptcId;
            $ticketDetails = $this->tktmanagemodel->getTicketDetailsUseId($ptcId);
            $data['ticketDetail'] = $ticketDetails ? $ticketDetails[0] : array();
            if (APP_THEME == 'OLD') {
                $this->load->view('tuition/plused_replyTicket', $data);
            } else {
                $this->load->view('lte/backoffice/ticket/reply_ticket', $data);
            }
        } else {
            redirect('ticketmanagement', 'refresh');
        }
    }

    /**
     * Function to open the modal for edit reply to ticket
     * @author Arunsankar
     * @since 09-June-2016
     */
    function editTicketReply($ptcId) {
//        if ($this->session->userdata('role') == 100) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $data['title'] = 'plus-ed.com | Edit Reply';
            $data['breadcrumb1'] = 'Ticket Management';
            $data['breadcrumb2'] = 'Edit Reply';
            $data['ptc_id'] = $ptcId;
            $replyRecord = $this->tktmanagemodel->getReplyDetails($ptcId);
            $data['reply'] = $replyRecord[0];
            $ticketDetails = $this->tktmanagemodel->getTicketDetailsUseId($ptcId);
            $data['ticketDetail'] = $ticketDetails ? $ticketDetails[0] : array();
            $this->load->view('tuition/plused_EditReplyTicket', $data);
        } else {
            redirect('ticketmanagement', 'refresh');
        }
    }

    /**
     * Function to reply to ticket
     * @author Arunsankar
     * @since 10-June-2016
     */
    function replyTicket($ptcId) {
//        if ($this->session->userdata('role') == 100 || $this->session->userdata('role') == 200 || $this->session->userdata('role') == 400) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $errorNo = 0;
            $message = $_POST['tktMessage'];
            $error = '';
            if (empty($message)) {
                $errorNo += 1;
                $error = 'Please enter message';
            }
            if ($errorNo == 0) {
                $fileError = 0;
                $fileName = '';
                if (isset($_FILES['fileAttachment']['name'])) {
                    if (!empty($_FILES['fileAttachment']['name'])) {
                        $config['upload_path'] = TICKET_BO_PATH;
                        $config['allowed_types'] = '*';
                        $config['max_size'] = '2048';
                        $config['encrypt_name'] = TRUE;

                        $this->load->library('upload', $config);

                        if (!$this->upload->do_upload('fileAttachment')) {
                            $fileError += 1;
                            $this->session->set_flashdata('error_message', 'Failed to upload file (files greater than 2 MB is not allowed)');
                            $error = 'Failed to upload file (files greater than 2 MB is not allowed)';
                        } else {
                            $uploadData = $this->upload->data();
                            $fileName = $uploadData['file_name'];
                        }
                    }
                }
                if ($fileError == 0) {
                    $updateData = array(
                        'ptc_bo_reply' => $message,
                        'ptc_bo_read' => 1,
                        'ptc_bo_reply_time' => date('Y-m-d H:i:s'),
                        'ptc_bo_reply_by' => $this->session->userdata('id')
                    );
                    if ($fileName) {
                        $updateData['ptc_bo_attachment'] = $fileName;
                    }
                    $where = array(
                        'ptc_id' => $ptcId
                    );
                    $isUpdate = $this->tktmanagemodel->replyTicket($updateData, $where);
                    if ($isUpdate) {
                        $ticket = $this->mbackoffice->getTicket($ptcId);
                        $role = ($ticket->ptc_sender_type == 'Campus Manager') ? 'college_adm' : 'course_director';
                        $users = $this->mbackoffice->getTicketReceiver($ptcId, $role);
                        $this->sendReplyEmail($users);
                        $this->session->set_flashdata('success_message', 'Reply sent successfully');
                        echo '1';
                    } else {
                        echo 'Failed to sent ticket reply';
                    }
                } else {
                    echo $error;
                }
            }
        } else {
            redirect('ticketmanagement', 'refresh');
        }
    }

    /**
     * Function to edit reply to ticket
     * @author Arunsankar
     * @since 10-June-2016
     */
    function editReplyTicket($ptcId) {
//        if ($this->session->userdata('role') == 100) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $errorNo = 0;
            $message = $_POST['tktMessage'];
            $error = '';
            if (empty($message)) {
                $errorNo += 1;
                $error = 'Please enter message';
            }
            if ($errorNo == 0) {
                $fileError = 0;
                $fileName = '';
                if (isset($_FILES['fileAttachment']['name'])) {
                    if (!empty($_FILES['fileAttachment']['name'])) {
                        $config['upload_path'] = TICKET_BO_PATH;
                        $config['allowed_types'] = '*';
                        $config['max_size'] = '2048';
                        $config['encrypt_name'] = TRUE;

                        $this->load->library('upload', $config);

                        if (!$this->upload->do_upload('fileAttachment')) {
                            $fileError += 1;
                            $this->session->set_flashdata('error_message', 'Failed to upload file(files greater than 2 MB is not allowed)');
                            $error = 'Failed to upload file (files greater than 2 MB is not allowed)';
                        } else {
                            $uploadData = $this->upload->data();
                            $fileName = $uploadData['file_name'];
                        }
                    }
                }
                if ($fileError == 0) {
                    $updateData = array(
                        'ptc_bo_reply' => $message,
                        'ptc_bo_read' => 1,
                        'ptc_bo_reply_time' => date('Y-m-d H:i:s'),
                        'ptc_bo_reply_by' => $this->session->userdata('id')
                    );
                    if ($fileName) {
                        $updateData['ptc_bo_attachment'] = $fileName;
                    }
                    $where = array(
                        'ptc_id' => $ptcId
                    );
                    $isUpdate = $this->tktmanagemodel->replyTicket($updateData, $where);
                    if ($isUpdate) {
                        $this->session->set_flashdata('success_message', 'Reply sent successfully');
                        echo '1';
                    } else {
                        echo 'Failed to sent ticket reply';
                    }
                } else {
                    echo $error;
                }
            }
        } else {
            redirect('ticketmanagement', 'refresh');
        }
    }

    /**
     * Function to delete ticket from BO
     * @author Arunsankar
     * @since 10-June-2016
     */
    function deleteTicket() {
//        if ($this->session->userdata('role') == 100) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $selId = $this->input->post('selId');
            if ($selId && is_numeric($selId)) {
                $ticketDetails = $this->tktmanagemodel->getTicketDetailsUseId($selId);
                $isDelete = $this->tktmanagemodel->deleteTicket($selId);
                if ($isDelete) {
                    $ticketDetails[0]['ptc_attachment'] ? @unlink(TICKET_CM_PATH . $ticketDetails[0]['ptc_attachment']) : '';
                    echo '1';
                } else {
                    echo '0';
                }
            } else {
                $this->session->set_flashdata('error_message', 'Invalid ticket');
                redirect('ticketmanagement', 'refresh');
            }
        } else {
            redirect('ticketmanagement', 'refresh');
        }
    }

    /**
     * Function to delete ticket reply
     * @author Arunsankar
     * @since 10-June-2016
     */
    function deleteTicketReply() {
//        if ($this->session->userdata('role') == 100) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $selId = $this->input->post('selId');
            if ($selId && is_numeric($selId)) {
                $ticketDetails = $this->tktmanagemodel->getTicketDetailsUseId($selId);
                $isDelete = $this->tktmanagemodel->deleteTicketReply($selId);
                if ($isDelete) {
                    $ticketDetails[0]['ptc_bo_attachment'] ? @unlink(TICKET_BO_PATH . $ticketDetails[0]['ptc_bo_attachment']) : '';
                    $this->session->set_flashdata('success_message', 'Reply deleted successfully');
                    echo '1';
                } else {
                    echo '0';
                }
            } else {
                $this->session->set_flashdata('error_message', 'Invalid ticket');
                redirect('ticketmanagement', 'refresh');
            }
        } else {
            redirect('ticketmanagement', 'refresh');
        }
    }

    /**
     * Function to make ticket open/closed
     * @author Arunsankar
     * @since 10-June-2016
     */
    function changeTicketStatus() {
//        if ($this->session->userdata('role') == 100 || $this->session->userdata('role') == 200 || $this->session->userdata('role') == 400) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $selId = $this->input->post('selId');
            if ($selId && is_numeric($selId)) {
                $ticketDetails = $this->tktmanagemodel->getTicketDetailsUseId($selId);
                if ($ticketDetails[0]['ptc_closed'] == 1) {
                    $data['ptc_closed'] = 1;
                } else {
                    $data['ptc_closed'] = 1;
                }
                $data['ptc_closed_time'] = date('Y-m-d H:i:s');
                $where = array(
                    'ptc_id' => $selId
                );
                $isUpdate = $this->tktmanagemodel->updateTicket($data, $where);
                if ($isUpdate) {
                    echo '1';
                } else {
                    echo '0';
                }
            } else {
                $this->session->set_flashdata('error_message', 'Invalid ticket');
                redirect('ticketmanagement', 'refresh');
            }
        } else {
            redirect('ticketmanagement', 'refresh');
        }
    }

    /**
     * Function to remove the attachment in a reply
     * @author Arunsankar
     * @since 10-June-2016
     */
    function removeReplyAttachment() {
//        if ($this->session->userdata('role') == 100) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $selId = $this->input->post('selId');
            $ticketDetails = $this->tktmanagemodel->getTicketDetailsUseId($selId);
            $isRemove = $this->tktmanagemodel->removeAttachment($selId);
            if ($isRemove) {
                $ticketDetails[0]['ptc_bo_attachment'] ? @unlink(TICKET_BO_PATH . $ticketDetails[0]['ptc_bo_attachment']) : '';
                $this->session->set_flashdata('success_message', 'Attachment removed successfully');
                echo '1';
            } else {
                echo '0';
            }
        } else {
            redirect('ticketmanagement', 'refresh');
        }
    }

    /**
     * Function to check if any new ticket posted by CM
     * @author Arunsankar
     * @since 14-June-2016
     */
    function checkAnyBOAlert() {
//        if ($this->session->userdata('role') == 100) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $alertCount = $this->tktmanagemodel->getUnreadBOTicketCount();
            if ($alertCount) {
                if ($alertCount > 0) {
                    echo $alertCount;
                } else {
                    echo '0';
                }
            } else {
                echo '0';
            }
        } else {
            echo '0';
        }
    }

    /**
     * Function to check if any new reply come to db
     * @author Arunsankar
     * @since 14-June-2016
     */
    function checkAnyCMAlert() {
//        if ($this->session->userdata('role') == 200) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $campus = $this->tktmanagemodel->centerIdByName($this->session->userdata('businessname'));
            $alertCount = $this->tktmanagemodel->getUnreadCMTicketCount($campus);
            if ($alertCount) {
                if ($alertCount > 0) {
                    echo $alertCount;
                } else {
                    echo '0';
                }
            } else {
                echo '0';
            }
        } else {
            echo '0';
        }
    }

    /**
     * Function to make the ticket read by BO
     * @author Arunsankar
     * @since 14-June-2016
     */
    function readByBo() {
//        if ($this->session->userdata('role') == 100) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $selId = $this->input->post('selId');
            $data = array(
                'ptc_bo_read' => 1
            );
            $where = array(
                'ptc_id' => $selId
            );
            $isUpdate = $this->tktmanagemodel->updateTicket($data, $where);
            if ($isUpdate) {
                echo '1';
            } else {
                echo '0';
            }
        }
    }

    /**
     * Function to make the ticket read by BO
     * @author Arunsankar
     * @since 17-Feb-2017
     */
    function readByCm() {
//        if ($this->session->userdata('role') == 100) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $selId = $this->input->post('selId');
            $data = array(
                'ptc_cm_read' => 1
            );
            $where = array(
                'ptc_id' => $selId
            );
            $isUpdate = $this->tktmanagemodel->updateTicket($data, $where);
            if ($isUpdate) {
                echo '1';
            } else {
                echo '0';
            }
        }
    }

    /**
     * Show open ticket management UI
     * @author Arunsankar
     * @since 16-Feb-2017
     */
    function openTicket() {
//        if ($this->session->userdata('username') && $this->session->userdata('role') == 100) {
        if ($this->session->userdata('role')) {
            authSessionMenu($this);
            $data['title'] = "plus-ed.com | Ticket Management";
            $data['breadcrumb1'] = 'Ticket management';
            $data['breadcrumb2'] = 'Open ticket';

            $data["centri"] = $this->tktmanagemodel->getAllCampus(1);
            $data['bookings'] = $this->mbackoffice->getBookingRefFromCentro();
            if (isset($_POST['btnSave'])) {
                $errorNo = $insert_rec = 0;
                $centri = $_POST['centri'];
                $type = $_POST['type'];
                $priority = $_POST['priority'];
                $selCategory = $_POST['selCategory'];
                $tktTitle = $_POST['tktTitle'];
                $tktContent = $_POST['tktContent'];
                $selRefBooking = $_POST['selRefBooking'];

                if (empty($centri)) {
                    $errorNo += 1;
                    $this->session->set_flashdata('error_message', 'Please select campus');
                }
                if (empty($type)) {
                    $errorNo += 1;
                    $this->session->set_flashdata('error_message', 'Please select ticket type');
                }
                if ($priority != 'low' && $priority != 'medium' && $priority != 'high') {
                    $errorNo += 1;
                    $this->session->set_flashdata('error_message', 'Invalid priority');
                }
                if (empty($selCategory)) {
                    $errorNo += 1;
                    $this->session->set_flashdata('error_message', 'Please select category');
                }
                if (empty($tktTitle)) {
                    $errorNo += 1;
                    $this->session->set_flashdata('error_message', 'Please enter title');
                }
                if (empty($tktContent)) {
                    $errorNo += 1;
                    $this->session->set_flashdata('error_message', 'Please enter text');
                }
                if (empty($selRefBooking)) {
                    $errorNo += 1;
                    $this->session->set_flashdata('error_message', 'Please select Reference booking');
                }
                if ($errorNo == 0) {
                    $fileError = 0;
                    $fileName = '';
                    if (isset($_FILES['fileAttachment']['name'])) {
                        if (!empty($_FILES['fileAttachment']['name'])) {
                            $config['upload_path'] = TICKET_CM_PATH;
                            $config['allowed_types'] = '*';
                            $config['max_size'] = '2048';
                            $config['encrypt_name'] = TRUE;

                            $this->load->library('upload', $config);

                            if (!$this->upload->do_upload('fileAttachment')) {
                                $fileError += 1;
                                $this->session->set_flashdata('error_message', 'Failed to upload file,please upload files less than 2 MB');
                            } else {
                                $uploadData = $this->upload->data();
                                $fileName = $uploadData['file_name'];
                            }
                        }
                    }
                    if ($fileError == 0) {
                        foreach ($centri as $campus) {
                            foreach ($type as $ticket_type) {
                                $insertData = array(
                                    'campus_id' => $campus,
                                    'ptc_priority' => $priority,
                                    'ptc_category' => $selCategory,
                                    'ptc_title' => $tktTitle,
                                    'ptc_content' => $tktContent,
                                    'ptc_attachment' => $fileName,
                                    'ptc_ref_booking' => $selRefBooking,
                                    'ptc_sender_type' => 'Backoffice',
                                    'ptc_receiver_type' => $ticket_type
                                );
                                $isInsert = $this->mbackoffice->insertTicket($insertData);
                                if ($isInsert) {
                                    $insert_rec++;
                                }
                            }
                        }
                        $users = $this->mbackoffice->getTicketUserForEmail($centri, $type);
                        $this->sendTicketEmail($users);
                        if ($insert_rec > 0) {
                            $this->session->set_flashdata('success_message', "Tickets added successfully");
                            redirect('ticketmanagement/openTicket', 'refresh');
                        } else {
                            $this->session->set_flashdata('error_message', 'Failed to add ticket');
                            redirect('ticketmanagement/openTicket');
                        }
                    } else {
                        redirect('ticketmanagement/openTicket');
                    }
                } else {
                    redirect('ticketmanagement/openTicket');
                }
            }

            $data['pageHeader'] = "Open ticket";
            $data['optionalDescription'] = "";
            $this->ltelayout->view('lte/backoffice/ticket/open_ticket', $data);
        } else {
            $this->session->sess_destroy();
            redirect('backoffice', 'refresh');
        }
    }

    function getAjaxBooking() {
        $campusIds = $this->input->post('campusIds');
        $bookings = $this->mbackoffice->getBookingRefFromCentro($campusIds);
        ?>
        <option value="all">All</option>
        <?php
        if ($bookings) {
            foreach ($bookings as $booking) {
                ?>
                <option value="<?php echo $booking['booking_id'] ?>"><?php echo $booking['booking_id'] ?></option>
                <?php
            }
        }
    }

    function sendTicketEmail($users) {
        if (empty($users)) {
            return;
        }
        $this->load->library('email');
        foreach ($users as $user) {
            $data['user'] = $user;
            $messageBody = $this->load->view('tuition/email/ticket_open_backoffice', $data, true);
            $this->email->clear();
            $this->sendMail($user['email'], $messageBody);
        }
        return true;
    }

    function sendReplyEmail($users) {
        if (empty($users)) {
            return;
        }
        $this->load->library('email');
        foreach ($users as $user) {
            $data['user'] = $user;
            $data['ticket'] = $user['ptc_title'];
            $messageBody = $this->load->view('tuition/email/ticket_reply_backoffice', $data, true);
            $this->email->clear();
            $this->sendMail($user['email'], $messageBody);
        }
        return true;
    }

    function sendMail($toEmail, $messageBody) {
        $senderEmail = NO_REPLY_EMAIL;
        $this->email->clear();
        $this->email->set_newline("\r\n");
        $this->email->from($senderEmail, 'plus-ed.com');
        $this->email->to($toEmail);
        $this->email->subject("plus-ed.com | Ticket Reply");
        $this->email->message($messageBody);
        return $this->email->send();
    }

}
