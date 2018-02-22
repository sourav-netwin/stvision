<?php

class Tktmanagemodel extends Model {

	function getAllCampus($attivi = 0) {
		$data = array();
		$this -> db -> order_by('nome_centri');
		if ($attivi == 1) {
			$this -> db -> where('attivo', $attivi);
		}
		$Q = $this -> db -> get('centri');
		if ($Q -> num_rows() > 0) {
			return $Q -> result_array();
		}
		return FALSE;
	}

	function getTicketDetails($campus = '', $priority = '', $date = '', $datePasses = '', $categories = '', $status = '', $hour = '', $type = '', $sent = 0) {
		if(APP_THEME == 'OLD'){
			$toggleModal = ' data-id="dialog_modal_btn_\',a.ptc_id,\'" ';
		}
		else{
			$toggleModal = ' data-toggle="modal"  data-target="#dialog_modal_\',a.ptc_id,\'" ';
		}
		$query = 'select a.ptc_id,a.campus_id,a.ptc_priority,a.ptc_category,a.ptc_title,case when char_length(a.ptc_content) > 100 then concat(substring(a.ptc_content,1,100),\'...\',\'&nbsp;&nbsp;<a href="javascript:void(0)" id="tktOpn_\',a.ptc_id,\'" class="morelink dialogbtn tktOpenClass" '.$toggleModal.'>more</a>\') else a.ptc_content end as ptc_content_small,a.ptc_content ,a.ptc_attachment,a.ptc_ref_booking,a.ptc_bo_reply,a.ptc_bo_attachment,a.ptc_bo_reply_time,a.ptc_bo_reply_by,a.ptc_closed,a.ptc_closed_time,a.ptc_cm_read,a.ptc_bo_read,a.ptc_created_time,a.ptc_created_by,a.ptc_active, a.ptc_sender_type, a.ptc_receiver_type, c.nome_centri from plused_ticket_cm as a left join centri as c on a.campus_id=c.id where 1=1 ';
		if (!empty($priority)) {
			$cnt = 0;
			foreach ($priority as $val) {
				if ($cnt == 0) {
					$query .= " and (a.ptc_priority = '" . $val . "' ";
				}
				else {
					$query .= " or a.ptc_priority = '" . $val . "' ";
				}

				$cnt += 1;
			}
			$query .= ')';
		}
		if (!empty($categories)) {
			$cnt = 0;
			foreach ($categories as $val) {
				if ($cnt == 0) {
					$query .= " and (a.ptc_category = '" . $val . "' ";
				}
				else {
					$query .= " or a.ptc_category = '" . $val . "' ";
				}

				$cnt += 1;
			}
			$query .= ')';
		}
		if (!empty($status)) {
			$cnt = 0;
			foreach ($status as $val) {
				if ($cnt == 0) {
					$query .= " and (a.ptc_closed = '" . $val . "' ";
				}
				else {
					$query .= " or a.ptc_closed = '" . $val . "' ";
				}

				$cnt += 1;
			}
			$query .= ')';
		}
		if (!empty($hour)) {
			if ($hour <= 12) {
				$query .= " and (time_format(timediff(NOW(), ptc_created_time ), '%H') = " . ($hour - 1) . ")";
			}
			if ($hour == 24) {
				$query .= " and (time_format(timediff(NOW(), ptc_created_time ), '%H') between 12 and 23)";
			}
			if ($hour == 48) {
				$query .= " and (time_format(timediff(NOW(), ptc_created_time ), '%H') between 23 and 47)";
			}
			if ($hour > 48) {
				$query .= " and (time_format(timediff(NOW(), ptc_created_time ), '%H') > 47)";
			}
		}
		if (!empty($date)) {
			$dateArr = explode('/', $date);
			$date = $dateArr[2] . '-' . $dateArr[1] . '-' . $dateArr[0];
			$query .= " and date(a.ptc_created_time) = '" . $date . "' ";
		}
		if (!empty($datePasses)) {
			$query .= " and DATEDIFF('" . date('Y-m-d') . "', DATE(a.ptc_created_time)) = " . $datePasses;
		}
		if (!empty($campus)) {
			$cnt = 0;
			foreach ($campus as $val) {
				if ($cnt == 0) {
					$query .= " and (a.campus_id = '" . $val . "' ";
				}
				else {
					$query .= " or a.campus_id = '" . $val . "' ";
				}

				$cnt += 1;
			}
			$query .= ')';
		}
		if( $sent == 1 )
		{
			$query .= " and ( ptc_sender_type = 'Backoffice' )";
			if (!empty($type)) {
				$cnt = 0;
				foreach ($type as $val) {
					if ($cnt == 0) {
						$query .= " and (a.ptc_receiver_type = '" . $val . "' ";
					}
					else {
						$query .= " or a.ptc_receiver_type = '" . $val . "' ";
					}

					$cnt += 1;
				}
				$query .= ')';
			}
		}
		else
		{
			$query .= " and ( ptc_receiver_type = 'Backoffice' )";
			if (!empty($type)) {
				$cnt = 0;
				foreach ($type as $val) {
					if ($cnt == 0) {
						$query .= " and (a.ptc_sender_type = '" . $val . "' ";
					}
					else {
						$query .= " or a.ptc_sender_type = '" . $val . "' ";
					}

					$cnt += 1;
				}
				$query .= ')';
			}
		}
		$query .= ' order by a.ptc_created_time desc';
		$result = $this -> db -> query($query);

		if ($result -> num_rows() > 0) {
			return $result -> result_array();
		}
		return FALSE;
	}

	function checkTicketStatus($selId) {
		$this -> db -> select('count(*) as count')
				-> from('plused_ticket_cm')
				-> where('ptc_id', $selId)
				-> where('ptc_active', 1);
		$result = $this -> db -> get();
		if ($result -> num_rows() > 0) {
			$resultArray = $result -> result_array();
			if ($resultArray[0]['count'] > 0) {
				return TRUE;
			}
			return FALSE;
		}
		return FALSE;
	}

	function replyTicket($data, $where) {
		$table = 'plused_ticket_cm';
		$this -> db -> where($where);
		if ($this -> db -> update($table, $data)) {
			return TRUE;
		}
		return FALSE;
	}

	function updateTicket($data, $where) {
		$table = 'plused_ticket_cm';
		$this -> db -> where($where);
		if ($this -> db -> update($table, $data)) {
			return TRUE;
		}
		return FALSE;
	}

	function getTicketDetailsUseId($ptcId = '') {
		if ($ptcId) {
			$this -> db -> where('ptc_id', $ptcId);
		}
		$this -> db -> select('a.*')
				-> from('plused_ticket_cm as a');
		$result = $this -> db -> get();
		if ($result -> num_rows() > 0) {
			return $result -> result_array();
		}
		return FALSE;
	}

	function deleteTicket($selId) {
		$this -> db -> where('ptc_id', $selId);
		if ($this -> db -> delete('plused_ticket_cm')) {
			return TRUE;
		}
		else {
			return FALSE;
		}
	}

	function getReplyDetails($ptcId = '') {
		if ($ptcId) {
			$this -> db -> where('ptc_id', $ptcId);
		}
		$this -> db -> select('ptc_id, ptc_bo_reply, ptc_bo_attachment')
				-> from('plused_ticket_cm');
		$result = $this -> db -> get();
		if ($result -> num_rows() > 0) {
			return $result -> result_array();
		}
		return FALSE;
	}

	function removeAttachment($selId) {
		$table = 'plused_ticket_cm';
		$this -> db -> where('ptc_id', $selId);
		$data = array(
			'ptc_bo_attachment' => ''
		);
		if ($this -> db -> update($table, $data)) {
			return TRUE;
		}
		return FALSE;
	}

	function deleteTicketReply($selId) {
		$table = 'plused_ticket_cm';
		$this -> db -> where('ptc_id', $selId);
		$data = array(
			'ptc_bo_reply' => '',
			'ptc_bo_attachment' => ''
		);
		if ($this -> db -> update($table, $data)) {
			return TRUE;
		}
		return FALSE;
	}

	function getUnreadBOTicketCount() {
		$this -> db -> select('count(*) as count')
				-> from('plused_ticket_cm')
				-> where('ptc_receiver_type', 'Backoffice')
				-> where('ptc_bo_read', 0);
		$result = $this -> db -> get();
		if ($result -> num_rows() > 0) {
			$resultArray = $result -> result_array();
			return $resultArray[0]['count'];
		}
		return FALSE;
	}

	function getUnreadCMTicketCount($campus) {
		$this -> db -> select('count(*) as count')
				-> from('plused_ticket_cm')
				-> where('ptc_cm_read', 0)
				-> where('campus_id', $campus)
				-> where('ptc_bo_reply !=', '');
		$result = $this -> db -> get();
		if ($result -> num_rows() > 0) {
			$resultArray = $result -> result_array();
			return $resultArray[0]['count'];
		}
		return FALSE;
	}

	function centerIdByName($nomecentro) {
		$data = array();
		$this -> db -> where('nome_centri', $nomecentro);
		$Q = $this -> db -> get('centri');
		if ($Q -> num_rows() > 0) {
			foreach ($Q -> result_array() as $row) {
				$data[] = $row;
			}
		}
		else {
			echo "ERROR! No access for campus $nomecentro. Please refer the error to Plus-Ed. Thank you.";
			die();
		}
		$Q -> free_result();
		return $data[0]["id"];
	}
}