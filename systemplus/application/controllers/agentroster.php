<?php

class Agentroster extends Controller {

	public function __construct()
	{
		parent::Controller();

		$this->load->helper(array('form', 'url'));
		$this->load->library('session','email');
		$this->load->model('agent_roster_model');
		$this->load->model('agent_booking_model');
		$this->load->model('magenti');
	}

	public function checkPaxLock()
	{
		if( $this->session->userdata('role') == 99 )
		{
			$enroll_id = $this->input->post('enroll_id');
			$year = $this->input->post('year');
			$isLocked = $this->agent_roster_model->checkPaxLock( $enroll_id, $year );
			if( !$isLocked )
			{
				echo '1';
			}
			else
			{
				echo '0';
			}
		}
		else
		{
			redirect('agents', 'refresh');
		}
	}

	public function editPaxList( $id, $year )
	{
		if( $this->session->userdata('username') && $this->session->userdata('role') != 200 )
		{
			$ismine = $this->agent_roster_model->checkAgentOrder( $this->session->userdata('id'), $id );
			if( $ismine )
			{
				$data['title'] = 'plus-ed.com | Edit pax list';
				$data['breadcrumb1'] = 'Bookings review';
				$data['booking_detail'] = $this->agent_booking_model->getBookingsDetails( $id );
				$data['breadcrumb2'] = 'Pax list for Booking '.$year."_".$id;

				if( $data['booking_detail']['status'] == 3 )
				{
					$data['booked_pax'] = $this->agent_roster_model->getBookedPaxDetails( $data['booking_detail']['enroll_id'] );
					$data['course_list'] = $this->agent_roster_model->getCourses();
					$data['activity_list'] = $this->agent_roster_model->getActivities();

          $this->load->view('lte/agents_new/booking/ajax_edit_pax',$data);
				}
				else
				{
					redirect('agents/dashboard','refresh');
				}
			}
			else
			{
				$this->session->sess_destroy();
				redirect('agents/dashboard','refresh');
			}
		}
		else
		{
   		redirect('agents','refresh');
 		}
	}

	public function postPax( $id )
	{
		if( $this->session->userdata('username') && $this->session->userdata('role') != 200 )
		{
			$ismine = $this->agent_roster_model->checkAgentOrder( $this->session->userdata('id'), $id );
			$isLocked = $this->agent_roster_model->getLockPaxByBookId( $id );

			if( $ismine && $isLocked == 0 )
			{
				$updatePAX = $this->agent_roster_model->postPax($id);
				if( $_POST["noChanges"] == "SEND" )
				{
					$booking_details = $this->agent_booking_model->getBookingsDetails($id);

					$this->load->library('email');
					$to_email = "campus@plus-ed.com";
					$from_email = "info@plus-ed.com";

					$data['year'] = date('Y', strtotime( $booking_details['enrol_created_on'] ) );
					$data['id'] = $id;
					$mymessage = $this->load->view('lte/agents_new/booking/roster_lock_email_template', $data, TRUE);

					$this->email->set_newline("\r\n");
					$this->email->from($from_email, 'Plus Sales Office');
					$this->email->to($to_email);
					$this->email->subject('Plus Sales Office - Roster locked for booking '.$data['year']."_".$id);
					$this->email->message( $mymessage );

					$sendRes1 = $this->email->send();
				}

				redirect('agentbooking/enrolledBookings','refresh');
			}
			else
			{
				redirect('agents/dashboard','refresh');
			}
		}
		else
		{
			$this->session->sess_destroy();
   		redirect('agents','refresh');
 		}
	}

	public function exportPaxForOffline( $enroll_id )
	{
		if ( $this->session->userdata('role') == 99 )
		{
			set_time_limit(EXPORT_TIME_LIMIT);
			ini_set('memory_limit', EXPORT_MEM_LIMIT);

			$ismine = $this->agent_roster_model->checkAgentOrder( $this->session->userdata('id'), $enroll_id );

			if( $ismine )
			{
				$nationality = $this->magenti->getNationality();
				$booking_detail = $this->agent_booking_model->getBookingsDetails( $enroll_id );

				if( $booking_detail['status'] == 3 )
				{
					$this->load->library('Excel_180');

					$booked_pax = $this->agent_roster_model->getBookedPaxDetails( $booking_detail['enroll_id'] );
					$course_list = $this->agent_roster_model->getCourses();
					$activity_list = $this->agent_roster_model->getActivities();

					$dataArray[] = array('Type', 'Surname', 'Name', 'Sex', 'DOB Date', 'DOB Month', 'DOB Year', 'Citizenship', 'Composition/Accomodation', 'Passport no.', 'Health Info', 'Share room with', 'GL ref', '', '');

          $counter = 1;
          $lockRow = array();
					foreach( $booked_pax as $pax )
					{
						if( $pax['pcomp_week'] != "" && $pax['accom_name'] != "" && $pax['courses_type'] != "" && $pax['act_activity_name'] != "" )
	            $package_comp = $pax['pcomp_week'].' Week - '.$pax['accom_name'].' - '.$pax['courses_type'].' - '.$pax['act_activity_name'];
	          else if ( $pax['pcomp_week'] != "" && $pax['accom_name'] != "" )
	          {
	            if( $pax['courses_type'] == "" && $pax['act_activity_name'] == "" )
	            {
	              $package_comp = $pax['pcomp_week'].' Week - '.$pax['accom_name'];
	            }
	            else if( $pax['courses_type'] == "" && $pax['act_activity_name'] != "" )
	            {
	              $package_comp = $pax['pcomp_week'].' Week - '.$pax['accom_name'].' - '.$pax['act_activity_name'];
	            }
	            else if( $pax['courses_type'] != "" && $pax['act_activity_name'] == "" )
	            {
	              $package_comp = $pax['pcomp_week'].' Week - '.$pax['accom_name'].' - '.$pax['courses_type'];
	            }
	          }

						if( empty( $pax["booked_pax_dob"] ) or $pax["booked_pax_dob"] == "0000-00-00" )
						{
							$pax["booked_pax_dob"] = "1970-01-01";
						}
						$dataArray[] = array(
														trim($pax["booked_tipo_pax"],'='),
														trim($pax["booked_pax_surname"],'='),
														trim($pax["booked_pax_name"],'='),
														trim($pax["booked_pax_gender"],'='),
														trim(date("d", strtotime($pax["booked_pax_dob"])),'='),
														trim(date("m", strtotime($pax["booked_pax_dob"])),'='),
														trim(date("Y", strtotime($pax["booked_pax_dob"])),'='),
														trim($pax["booked_pax_nationality"],'='),
														( $pax["booked_tipo_pax"] == 'GL' ) ? trim($pax["gl_accom_name"],'=') : trim($package_comp,'='),
														trim($pax["booked_pax_passport_no"],'='),
														trim($pax["booked_pax_salute"],'='),
														trim($pax["booked_pax_share_room"],'='),
														trim($pax["booked_pax_gl_rif"],'='),
														trim($pax["booked_pax_id"],'=')
													);
						if ($pax["booked_lock_pax"] == 1)
						{
							$lockRow[] = $counter + 1;
						}
						$counter += 1;
					}

					$sheetname = $this->excel_180->getSheetByName('Worksheet') ? 'Worksheet' : 'Sheet';
					if( is_array( $dataArray ) && !empty( $dataArray ) )
					{
						$sheet = $this->excel_180->getActiveSheet();
						$fileName = 'export_pax_' . date('Y', strtotime( $booking_detail['enrol_created_on'] ) ) . '_' . $enroll_id . '_' . time();
						$sheet->fromArray($dataArray, NULL, 'A1');
						$sheet->setCellValueByColumnAndRow('14', '1', $enroll_id);
						$rowCnt = 2;
						foreach ($nationality as $row)
						{
							$sheet->setCellValueByColumnAndRow('14', $rowCnt, $row['nationality']);
							$rowCnt += 1;
						}
						$nationalityCount = $rowCnt - 1;
						for ($col = 'A'; $col <= 'K'; $col++)
						{
							$sheet->getColumnDimension($col)->setAutoSize(TRUE);
						}
						$sheet->getProtection()->setPassword('G8#!H#t@2ZTVEW@');
						$sheet->getProtection()->setSheet(TRUE);
						for ($i = 2; $i <= $counter; $i++)
						{
							if (!in_array($i, $lockRow))
							{
								$sheet->getStyle('B' . $i . ':H' . $i)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
								$sheet->getStyle('J' . $i . ':M' . $i)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
							}
							else
							{
								//setting red color for locked cells
								$sheet->getStyle('A' . $i . ':M' . $i)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'F19E9E'))));
							}

							$objValidation = $sheet->getCell('D' . $i)->getDataValidation();
							$objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
							$objValidation->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
							$objValidation->setAllowBlank(true);
							$objValidation->setShowInputMessage(true);
							$objValidation->setShowErrorMessage(true);
							$objValidation->setShowDropDown(true);
							$objValidation->setErrorTitle('Input error');
							$objValidation->setError('Value is not in list.');
							$objValidation->setPromptTitle('Pick from list');
							$objValidation->setPrompt('Please pick a value from the drop-down list.');
							$objValidation->setFormula1('"M,F"');

							$objValidation1 = $sheet->getCell('H' . $i)->getDataValidation();
							$objValidation1->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
							$objValidation1->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
							$objValidation1->setAllowBlank(true);
							$objValidation1->setShowInputMessage(true);
							$objValidation1->setShowErrorMessage(true);
							$objValidation1->setShowDropDown(true);
							$objValidation1->setErrorTitle('Invalid nationality');
							$objValidation1->setError('Select nationality from the list.');
							$objValidation1->setPromptTitle('Select Nationality');
							$objValidation1->setPrompt('Please pick a nationality from the drop-down list.');
							$objValidation1->setFormula1($sheetname . '!$O$2:$O$' . $nationalityCount);

							$objValidation2 = $sheet->getCell('E' . $i)->getDataValidation();
							$objValidation2->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
							$objValidation2->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
							$objValidation2->setAllowBlank(true);
							$objValidation2->setShowInputMessage(true);
							$objValidation2->setShowErrorMessage(true);
							$objValidation2->setShowDropDown(true);
							$objValidation2->setErrorTitle('Invalid date');
							$objValidation2->setError('Date is not in list.');
							$objValidation2->setPromptTitle('Select DOB date');
							$objValidation2->setPrompt('Please pick a date from the drop-down list.');
							$objValidation2->setFormula1('"01,02,03,04,05,06,07,08,09,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31"');

							$objValidation3 = $sheet->getCell('F' . $i)->getDataValidation();
							$objValidation3->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
							$objValidation3->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
							$objValidation3->setAllowBlank(true);
							$objValidation3->setShowInputMessage(true);
							$objValidation3->setShowErrorMessage(true);
							$objValidation3->setShowDropDown(true);
							$objValidation3->setErrorTitle('Invalid month');
							$objValidation3->setError('Month is not in list.');
							$objValidation3->setPromptTitle('Select DOB month');
							$objValidation3->setPrompt('Please pick a month from the drop-down list.');
							$objValidation3->setFormula1('"01,02,03,04,05,06,07,08,09,10,11,12"');
						}
						$sheet->getColumnDimension('N')->setVisible(FALSE);
						$sheet->getColumnDimension('O')->setVisible(FALSE);
						$sheet->getStyle('A1:M1')->getFont()->setBold(true);
						header("Content-Type: application/vnd.ms-excel");
						header("Content-Disposition: attachment; filename=\"" . $fileName . ".xls\"");
						header("Cache-Control: max-age=0");
						$writeObj = PHPExcel_IOFactory::createWriter($this->excel_180, 'Excel5');
						$writeObj->save("php://output");
					}
					else
					{
						$this->session->set_flashdata('error_message', 'No records found to export.');
						redirect('agentbooking/enrolledBookings');
					}
				}
				else
				{
					$this->session->set_flashdata('error_message', 'Error occured.');
					redirect('agentbooking/enrolledBookings');
				}
			}
			else
			{
				$this->session->set_flashdata('error_message', 'Error occured.');
				redirect('agentbooking/enrolledBookings');
			}
		}
	}

	public function importPax()
	{
		if( $this->session->userdata('role') == 99 )
		{
			$this->load->library('excel_180');
			$errorCount = 0;
			$importCount = 0;
			$invalidExcel = 0;
			if( !empty($_FILES['importPaxFile']['name']) )
			{
				//if file is not empty
				$mimes = array('application/vnd.ms-excel','application/vnd.ms.excel', 'application/octet-stream', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/kset'); //setting the file mime type(.xls, .xlsx)

				if( in_array($_FILES['importPaxFile']['type'], $mimes) )
				{
					$fileName = $_FILES['importPaxFile']['tmp_name'];
					try
					{
						$fileType = PHPExcel_IOFactory::identify($fileName);
						$objReader = PHPExcel_IOFactory::createReader($fileType);
						$objPHPExcel = $objReader->load($fileName);
						$sheets = array();
						/* Code for validate the password added at the time of file generation for additional security
						$password = 'G8#!H#t@2ZTVEW@';
						$hash = $objPHPExcel->getActiveSheet()->getProtection()->getPassword(); // returns a hash
						$isValid = ($hash === PHPExcel_Shared_PasswordHasher::hashPassword($password));*/
						$this->db->trans_start(); //begin transaction
						$sheetcount = 1;
						foreach ($objPHPExcel->getAllSheets() as $sheet)
						{
							if($sheetcount == 1)
							{
								$sheetsarray = $sheet->toArray();
								$enroll_id = isset($sheetsarray[0][14]) ? $sheetsarray[0][14] : '0';
								unset($sheetsarray[0]);
								foreach ($sheetsarray as $sheetVal)
								{
									if( !empty($sheetVal[0]) )
									{
										if( $sheetVal[0] == "GL" || $sheetVal[0] == "STD" )
										{
											$isGender = FALSE;
											$isDate = FALSE;
											$isNationality = !empty($sheetVal[7]) ? $this->magenti->checkTypedNationality($sheetVal[7]) : TRUE;
											$isRowValid = $this->agent_roster_model->checkPaxIsValid($sheetVal[13], $enroll_id);
											$ismine = $this->agent_roster_model->checkAgentOrder($this->session->userdata('id'),$enroll_id);
											if( sizeof($sheetVal) != 15 )
											{
												$invalidExcel += 1;
											}
											if( empty($sheetVal[3]) || $sheetVal[3] == "M" || $sheetVal[3] == "F")
											{
												$isGender = TRUE;
											}
											if (!empty($sheetVal[4]) && !empty($sheetVal[5]) && !empty($sheetVal[6]))
											{
												if (checkdate(str_pad($sheetVal[5], 2, '0', STR_PAD_LEFT), str_pad($sheetVal[4], 2, '0', STR_PAD_LEFT), $sheetVal[6]))
												{
													$isDate = TRUE;
													$sheetVal[4] = $sheetVal[6] . '-' . str_pad($sheetVal[5], 2, '0', STR_PAD_LEFT) . '-' . str_pad($sheetVal[4], 2, '0', STR_PAD_LEFT);
												}
											}
											else
											{
												$isDate = TRUE;
											}
											if ( $isGender && $isDate && $isNationality && $isRowValid && $ismine )
											{
												//validating gender, date, nationality and row
												$isCount = $this->agent_roster_model->getImportPaxCount($sheetVal[13]);
												$isNotLocked = $this->agent_roster_model->checkPaxIsLocked($sheetVal[13]);

												if( $isCount && $isNotLocked )
												{
													$isUpdate = $this->agent_roster_model->updatePaxImport($sheetVal);
													if (!$isUpdate)
													{
														@log_message('error', $sheetVal[13].'-'.$sheetVal[0].'-Update failed in database.');
														$errorCount += 1;
													}
													else
													{
														$importCount += 1;
													}
												}
												else
												{
													@log_message('error', $sheetVal[13].'-'.$sheetVal[0].'-Record is new/locked. Failed to add.');
												}
											}
											else
											{
												@log_message('error', $sheetVal[13].'-'.$sheetVal[0].'-Gender/Date/Nationality/Row id with booking is invalid.');
												$errorCount += 1;
											}
										}
										else
										{
											@log_message('error', $sheetVal[0].'-Type field value is invalid.');
											$errorCount += 1;
										}
									}
								}
								$sheetcount += 1;
							}
						}
						if($invalidExcel > 0)
						{
							@log_message('error', 'Invalid file found.');
							$this->db->trans_rollback();
							$this->session->set_flashdata('error_message', 'Invalid excel file.');
							redirect('agentbooking/enrolledBookings');
						}
						elseif($errorCount > 0)
						{
							$this->db->trans_rollback();
							$this->session->set_flashdata('error_message', 'Failed to import.');
							redirect('agentbooking/enrolledBookings');
						}
						elseif($importCount == 0)
						{
							$this->db->trans_commit();
							$this->session->set_flashdata('success_message', 'No changes has been made.');
							redirect('agentbooking/enrolledBookings');
						}
						else
						{
							$this->db->trans_commit();
							$this->session->set_flashdata('success_message', 'Import successful.');
							redirect('agentbooking/enrolledBookings');
						}
					}
					catch (Exception $e)
					{
						@log_message('error', 'Error occured in import.');
						$this->db->trans_rollback();
						$this->session->set_flashdata('error_message', 'Failed to import.');
						redirect('agentbooking/enrolledBookings');
					}
				}
				else
				{
					@log_message('error', 'Invalid file type.');
					$this->db->trans_rollback();
					$this->session->set_flashdata('error_message', 'Invalid file type');
					redirect('agentbooking/enrolledBookings');
				}
			}
			else
			{
				@log_message('error', 'No file selected.');
				$this->db->trans_rollback();
				$this->session->set_flashdata('error_message', 'No file selected.');
				redirect('agentbooking/enrolledBookings');
			}
		}
	}

	public function bookingExists()
	{
		if( $this->session->userdata('role') == 99 )
		{
			$enroll_id = $this->input->post('enroll_id') ? $this->input->post('enroll_id') : '';
			$booking_exists = $this->agent_booking_model->bookingExists( $enroll_id );
			echo $booking_exists;
		}
		else {
			redirect('agents', 'refresh');
		}
	}

	function getVisaPopupDetails( $enroll_id )
	{
		if( $this->session->userdata('role') == 99 && !empty( $enroll_id ) && is_numeric( $enroll_id ) )
		{
			$data['booking_details'] = $this->agent_booking_model->getBookingsDetails( $enroll_id );
			$data['agent_details'] = $this->agent_roster_model->getBookingAgentDetails( $enroll_id );
			$data['booked_pax'] = $this->agent_roster_model->getBookedPaxDetails( $enroll_id );
			$data['templates'] = $this->magenti->getTemplateListNatMapped( $data['booking_details']['centri_id'] );

      $this->load->view('lte/agents_new/booking/overview_visa_details', $data);
		}
		else
		{
			redirect('agents', 'refresh');
		}
	}

	function lockSingleRoster()
	{
		if( $this->session->userdata('role') == 99) {
			$status = '0';
			$html = '';
			$res = array();
			$pax_id = $this->input->post('pax_id');
			$campus_id = $this->input->post('campus_id');
			if (!empty($pax_id) && is_numeric($pax_id))
			{
				$bookId = $this->agent_roster_model->getBookingId($pax_id);
				$isLock = $this->agent_roster_model->lockSingleRoster($pax_id);
				$data['templates'] = $this->magenti->getTemplateList($campus_id);
				if( $isLock === '2' )
				{
					$status = '2';
				}
				else if ( $isLock )
				{
					$status = '1';
					$mapError = 0;
					$html .= '<select style="width: 77px" class="tempSel" id="selTemp_'.$pax_id.'" ><option value="">Select</option>';
					if($data['templates'])
					{
						foreach($data['templates'] as $template)
						{
							$tempTitle = '';
							if ($template['template'] == 'UKIR')
							{
								$tempTitle = 'UK/Ireland';
							}
							if ($template['template'] == 'USA')
							{
								$tempTitle = 'USA';
							}
							if ($template['template'] == 'MAL')
							{
								$tempTitle = 'Malta';
							}
							if ($template['template'] == 'UKIRGLSTD')
							{
								$tempTitle = 'UK/Ireland - GL Standard';
							}
							if ($template['template'] == 'UKIRSTDSTD')
							{
								$tempTitle = 'UK/Ireland - STD Standard';
							}
							if ($template['template'] == 'UKIRSTDST')
							{
								$tempTitle = 'UK/Ireland - STD Short Term';
							}
							$isNationality = $this->agent_roster_model->checkNationality($bookId, $template['template'], $pax_id);
							if($isNationality){
								$html .= '<option value="'.$template['template'].'">'.$tempTitle.'</option>';
								$mapError += 1;
							}
						}
						$html .= '</select>';
						if($mapError == 0)
						{
							$html = '<select  style="width: 77px"><option value="">NA</option></select>';
						}
					}
					else
					{
						$status = '3';
						$html = '<select style="width: 77px"><option value="">NA</option></select>';
					}
				}
				else
				{
					$status = '0';
				}
			}
			else
			{
				$status = '0';
			}
			echo json_encode(array(
				'status' => $status,
				'result' => $html
			));
		}
		else {
			redirect('agents', 'refresh');
		}
	}

	function lockWholeRoster()
	{
		$status = 0;
		$result = array();
		$templ = array();
		if( $this->session->userdata('role') == 99 )
		{
			$enroll_id = $this->input->post('enroll_id');
			$campus_id  = $this->input->post('campus_id');
			if (!empty($enroll_id) && is_numeric($enroll_id))
			{
				$booking_details = $this->agent_roster_model->getBookedPaxDetails( $enroll_id );
				$complete_details_pax = $this->agent_roster_model->getCompletePaxCount( $enroll_id );
				if( count( $booking_details ) == $complete_details_pax )
				{
					$status = '1';
					$this->agent_roster_model->lockWholeRoster( $enroll_id );
				}
				else
				{
					$status = '0';
				}
			}
		}
		else
		{
			redirect('agents', 'refresh');
		}
		echo json_encode(array(
			'status' => $status
		));
	}

	function pdfSingleVisa( $pax_id, $enroll_id, $template = NULL )
	{
		if( $this->session->userdata('role') == 99 )
		{
			$ismine = $this->agent_roster_model->checkAgentOrder($this->session->userdata('id'), $enroll_id);
			if ($ismine)
			{
				$data['booking_detail'] = $this->agent_booking_model->getBookingsDetails($enroll_id);
				$data['pax_detail'] = $this->agent_roster_model->getPaxDetails($pax_id);
				$this->load->plugin('to_pdf');
				$html = $this->load->view('lte/agents_new/visa/PDF_single_'.$template, $data, true);

				$year = date('Y', strtotime( $data['booking_detail']['enrol_created_on'] ) );
				pdf_create($html, 'PDF_VISAS_' . $year . '_' . $data['booking_detail']['enroll_id'] . '__' . date("U"));
			}
			else
			{
				redirect('agents', 'refresh');
			}
		}
		else {
			redirect('agents', 'refresh');
		}
	}

	function lockTemplate( $pax_id = NULL, $template_value = NULL )
	{
		if( $this->session->userdata('role') == 99 )
		{
			$post = 0;
			if($pax_id == NULL || $template_value == NULL)
			{
				$pax_id = $this->input->post('pax_id');
				$template_value = $this->input->post('template_value');
				$post = 1;
			}
			$booking_id = $this->agent_roster_model->getBookingId( $pax_id );
			$isNationalty = $this->agent_roster_model->checkNationality($booking_id, $template_value, $pax_id);
			if( $isNationalty )
			{
				$isLocked = $this->agent_roster_model->lockTemplate($pax_id, $template_value);
				if( $isLocked )
				{
					if($post == 1)
					{
						echo '1';
					}
					else
					{
						return TRUE;
					}
				}
				else
				{
					if($post == 1)
					{
						echo '0';
					}
					else
					{
						return FALSE;
					}
				}
			}
			else
			{
				if($post == 1)
				{
					echo '2';
				}
				else
				{
					return FALSE;
				}
			}
		}
		else
		{
			redirect('agents', 'refresh');
    }
	}

	function getPaxTemplate()
	{
		if( $this->session->userdata('role') == 99 )
		{
			$enroll_id = $this->input->post('enroll_id');
			$data['booking_details'] = $this->agent_booking_model->getBookingsDetails( $enroll_id );
			$data['booked_pax'] = $this->agent_roster_model->getBookedPaxDetails( $enroll_id, '1' );
			$data['all_pax_count'] = count( $this->agent_roster_model->getBookedPaxDetails( $enroll_id ) );
			$data['templates'] = $this->magenti->getTemplateListNatMapped( $data['booking_details']['centri_id'] );
			$html = $this->load->view('lte/agents_new/booking/view_pax_template',$data, TRUE);
    	echo json_encode(array('result' => $html));
		}
		else
		{
			redirect('agents', 'refresh');
    }
	}

	function lockAllTmpl()
	{
		if( $this->session->userdata('role') == 99 )
		{
			$rowArr = json_decode($this->input->post('rowArr'));
			$iniTmpl = $this->input->post('iniTmpl');
			$enroll_id = $this->input->post('enroll_id');
			$error = 0;

			foreach($rowArr as $row)
			{
				$rowVal = explode('-', $row);
				if(!empty($rowVal[1]))
				{
					$isNationalty = $this->agent_roster_model->checkNationality($enroll_id,$rowVal[1], $rowVal[0]);
					if(!$isNationalty){
						$error += 1;
					}
				}
			}
			if($error == 0)
			{
				$isLocked = $this->agent_roster_model->lockTemplates( $enroll_id, $rowArr, $iniTmpl );
				echo ( $isLocked ) ? '1' : '0';
			}
			else
				echo '2';
		}
		else
		{
			redirect('agents', 'refresh');
    }
	}

	function pdfLockedVisas( $id = '' )
	{
		set_time_limit(300);
		if ($this->session->userdata('role') == 99)
		{
			$uri = func_get_args();
			$bookArr = explode('-', $uri[0]);
			$id = $bookArr[0];
			$isBookTemplate = TRUE;
			if(!empty($bookArr))
			{
				if(isset($bookArr[0]) && isset($bookArr[1]))
				{
					$isBookTemplate = $this->agent_roster_model->checkBookTemplate($bookArr[0],$bookArr[1]);
				}
			}
			if(!$isBookTemplate)
			{
				echo "ERROR - VISA NOT AVAILABLE";
				die();
			}

			$data['uriArray'] = array();
			$ismine = $this->agent_roster_model->checkAgentOrder( $this->session->userdata('id'), $id );
			$dwnVisa = $this->agent_roster_model->checkAnyPaxLocked( $id );
			if (!$dwnVisa || !$id)
			{
				echo "ERROR - VISA NOT AVAILABLE";
				die();
			}

			$uriCnt = 0;
			if( isset($uri[1]) )
			{
				foreach($uri as $k => $v)
				{
					$splVal = explode('-', $v);
					if($uriCnt > 0){
						$data['uriArray'][$splVal[0]] = $splVal[1];
					}
					$uriCnt += 1;
				}
			}

			if ($ismine)
			{
				$bookId = '';
				$data['booking_detail'] = $this->agent_booking_model->getBookingsDetails( $id );
				if( !empty($data['booking_detail']) )
				{
					$bookId = $data['booking_detail']['enroll_id'];
				}
				foreach($data['uriArray'] as $key => $uriEach)
				{
					$isNationality = $this->agent_roster_model->checkNationality($bookId, $uriEach, $key);
					if(!$isNationality){
						echo "ERROR - VISA NOT AVAILABLE";
						die();
					}
					$this->agent_roster_model->lockTemplate($key, $uriEach);
				}
				$data['initTemp'] = isset($bookArr[1]) ? $bookArr[1] : '';
				$data['locked'] = $data['booking_detail']['enrol_lock_pax'];
				$isWholeLock = $data['locked'] == 1 ? NULL : 1;
				$data['agency'] = $this->agent_booking_model->getBookingAgentDetails($this->session->userdata('id'));
				$data['detSTD'] = $this->agent_roster_model->listPax($id, "STD", $isWholeLock);
				$data['detGL'] = $this->agent_roster_model->listPax($id, "GL", $isWholeLock);
				$this->load->plugin('to_pdf');
				if(isset($uri[1]))
				{
					$html = $this->load->view('lte/agents_new/visa/PDF_visas_lock', $data, true);
				}
				else{
					redirect('agents', 'refresh');
				}
				pdf_create($html, 'PDF_VISAS_' . date('Y', strtotime( $data['booking_detail']['enrol_created_on'] ) ) . '_' . $id . '__' . date("U"));
			}
			else {
				redirect('agents', 'refresh');
			}
		}
		else {
			redirect('agents', 'refresh');
		}
	}

	function visaPDFDemo($templ = '')
	{
		set_time_limit(300);
		if($this -> session -> userdata('role') == 99)
		{
			if($templ && ($templ == 'USA' || $templ == 'UKIR' || $templ == 'MAL' || $templ == 'UKIRGLSTD' || $templ == 'UKIRSTDSTD' || $templ == 'UKIRSTDST' ))
			{
				$data['template'] = $templ;
				$this->load->plugin('to_pdf');
				$html = $this->load->view('visa/PDF_visas_demo', $data, true);
				pdf_create($html, 'PDF_VISAS_DEMO_'.$templ);
			}
			else
			{
				redirect('agents', 'refresh');
			}
		}
	}
}