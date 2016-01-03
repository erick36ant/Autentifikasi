<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categories extends CI_Controller {

	public function __construct()
    {
        parent::__construct();   
        $this->load->model('Categories_model','datamodel');     
		$this->load->helper(array('form', 'url'));
		$this->load->library('image_lib');	
		$this->load->library('upload');	
    }
	   
	public function index()
	{
		$data['title']='List Of Categories';	
		$data['array_categories'] = $this->datamodel->get_categories();
		$this->mytemplate->loadBackend('categories',$data);
	}

	public function form($mode,$id='')
	{
		$data['title']=($mode=='insert')? 'Add Categories' : 'Update Categories' ;				
		$data['categories'] = ($mode=='update') ? $this->datamodel->get_categories_by_id($id) : '';				
		$this->mytemplate->loadBackend('frmcategories',$data);	
	}

	public function process($mode,$id='')
	{
		
		if(($mode=='insert') || ($mode=='update'))
		{
			$this->do_upload();
			$result = ($mode=='insert') ? $this->datamodel->insert_entry($this->upload->file_name) : $this->datamodel->update_entry($this->upload->file_name) ;
		}
		
		else if($mode=='delete'){
			$result = $this->datamodel->hapus($id);
			delete_files('./uploads/'.$this->upload->file_name)
		}
		if ($result) redirect(site_url('backend/categories'),'location');
	}
	
	public function do_upload()
    {
            //membuat main image
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']    = 100;
		$config['max_width']  = 1024;
		$config['max_height']  = 768;
		$config['encrypt_name']  = TRUE;
		//$config['create_thumb'] = TRUE;
	
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		//$nama = $this->upload->file_name;
		
		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());
			
		}
		else
		{
			$this->thumbnail($this->upload->file_name);
			$this->wmark($this->upload->file_name);
			//$this->thumb_image($this->upload->file_name);
		
		//redirect(site_url('backend/categories'),'location');
			
		}
    }
	
	private function wmark($npath)
	{

			$config['image_library'] = 'gd2';
			$config['source_image'] = './uploads/'.$npath;
			$config['wm_text'] = 'erick-picture';
			$config['wm_type'] = 'text';
			$config['wm_font_path'] = './system/fonts/texb.ttf';
			$config['wm_font_size'] = 35;
			$config['wm_font_color'] = '000000';
			$config['wm_vrt_alignment'] = 'middle';
			$config['wm_hor_alignment'] = 'center';
			$config['wm_padding'] = 20;
			$config['overwrite'] = TRUE;
			
			
			$this->image_lib->initialize($config);	
			$this->load->library('image_lib',$config);
			$this->image_lib->watermark();
	}

	private function thumbnail($npath1)
	{

			$config['image_library'] = 'gd2';
			$config['source_image'] = './uploads/'.$npath1;
			$config['new_image'] = './uploads/thumb';
			$config['create_thumb'] = TRUE;
			$config['maintain_ratio'] = TRUE;
			$config['width']         = 75;
			$config['height']       = 50;
			
			$this->image_lib->initialize($config);	
			$this->load->library('image_lib', $config);
			$this->image_lib->resize();
	}
	
	private function dependensi($id)
	{
		return $this->datamodel->cek_dependensi($id);
	}
	
	

	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */

