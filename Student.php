<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Student extends CI_controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('student_model');

	}

	public function index()
	{
		$data['students'] = $this->student_model->getstudent();
		$this->load->view('student_details' , $data);
	}

	public function addstudent()
	{
		$this->load->view('add_student');
	}

	public function addstudentdata()
	{
		if($_POST)
		{
			$data = array('name' => $this->input->post('name'), 
						  'email' => $this->input->post('email'),
						  'address' => $this->input->post('address'),
						  'phoneno' => $this->input->post('contact'));
			if($this->student_model->insertstudent($data))
			{
				 $this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Student details added successfully.</div>');
				 redirect(base_url().'student/addstudent', 'refresh');
			}
			else
			{
				$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Please Try Again...</div>');
			 redirect(base_url().'student/addstudent', 'refresh');
			}
		}
		else
		{
			redirect(base_url());
		}
	}

	public function editstudent($id)
	{
		if(!empty($id))
		{
			$data['students'] = $this->student_model->get_details($id);
			// print_r($data);
			$this->load->view('show_students' , $data);
		}
		else
		{
			redirect(base_url());
		}	
	}

	public function updatedetails($id)
	{

		if ($_POST) 
        {
        	$data = array('name' => $this->input->post('name'), 
						  'email' => $this->input->post('email'),
						  'address' => $this->input->post('address'),
						  'phoneno' => $this->input->post('contact'));
        	if($this->student_model->update_details($data, $id) > 0)
			{
				 $this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Student details updated successfully.</div>');
				 redirect(base_url().'student/editstudent/'.$id, 'refresh');
			}
			else
			{
				$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Please Try Again...</div>');
			 redirect(base_url().'student/editstudent/'.$id, 'refresh');
			}
        }
        else
        {
        	redirect(base_url());
        }
	}

	public function deletedetails($id)
	{
		$this->student_model->delete_details($id);
		
		$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Details  deleted successfully!</div>');
		
		redirect(base_url());
	}


}