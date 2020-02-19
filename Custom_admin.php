<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Custom_admin extends CI_Controller 
{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Kolkata");
               
		$this->load->library('upload');
			  // $this->load->library('session');

			  /* if (!$this->session->userdata('is_logged_in')) 
			    {
                  redirect('login');
                 }*/
	 $this->load->database();     
        $this->load->model('goldrop_model');
    }

	public function index()
	{ 
	  $data['ActiveM']="dashboard";
	  $data['page'] = 'admin/dashboard';
	  $this->load->view('common_admin/index', $data);
    	
	}

######### BLOG CATEGORY ################
	

	function BlogCatagory()
	{
	  $data['ActiveM']="BlogMamagement";
	  $data['Active']="Catagory";
	  $data['page'] = 'admin/blog_category';
	  $this->load->view('common_admin/index', $data);
	}

	function get_BlogCatagory()
	{
        $select=array("*");
		
		$where=array();
		$orderby=array();
		$limit='';
		$data=$this->goldrop_model->doselect('tbl_blog_category',$select,$where,$orderby,$limit);
		echo json_encode($data);
	}

	function BlogCatagoryID($blog_cat_id)
	{ 
      $arr=array('blog_cat_id'=>$blog_cat_id);
	  $select=array();
	  array_push($select,"*");
	  $where=array($arr); 
	  $orderby=array();
	  $limit='';
	  $data=$this->goldrop_model->doselect('tbl_blog_category',$select,$where,$orderby,$limit);
	  
	  echo json_encode($data);
	}

	function Changestatus_BlogCatagory()
	{
	  $data=json_decode(file_get_contents("php://input"));
	  $blog_cat_id=$data->blog_cat_id;
	  $data=$this->goldrop_model->change_status("tbl_blog_category",$blog_cat_id,"blog_cat_id");
	}

	function insert_BlogCatagory()
	{
	   $data=json_decode(file_get_contents("php://input"));

	   $array=array(
	   	'blog_cat_name'=>$data->blog_cat_name
	   );

	   $blog_cat_id=$data->blog_cat_id;

	   $table='tbl_blog_category';

	    if($data->buttonName=='Add')
	    {
	      $result=$this->goldrop_model->do_insert($array,$table);
	      if($result!=0)
	      {
echo json_encode(array("message"=>"inserted","blog_cat_id"=>$result));
	      }
	    }
	    else
	    {

	    	$result=$this->goldrop_model->do_update($array,$table,"$blog_cat_id","blog_cat_id");

	    	if($result)
	    	echo json_encode(array("message"=>"update"));
	    }

	}


############### // BLOG CATEGORY ###############	

######### SUBCATEGORY ################
	
	function BlogSubCatagory()
	{
		$data['ActiveM']="BlogMamagement";
		$data['Active']="BlogSubCatagory";
	  $data['page'] = 'admin/blog_subcategory';
	  $this->load->view('common_admin/index', $data);
	}
    
    function GetBlogSubCatagory()
    {
    	$select=array("*");
		
		$where=array(array("status"=>"'Active'"));
		$orderby=array();
		$limit='';
		$data=$this->goldrop_model->doselect('tbl_blog_category',$select,$where,$orderby,$limit);
		echo json_encode($data);
    }

	function get_SubBlogCatagory()
	{
        $select=array("
        	tbl_subblog_category.*,tbl_blog_category.blog_cat_id
        	AS Cat_Id,tbl_blog_category.blog_cat_name
        	");
		
		$where=array(array('tbl_blog_category.blog_cat_id'=>'tbl_subblog_category.blog_cat_id'));
		$orderby=array();
		$limit='';
		$data=$this->goldrop_model->doselect('
			tbl_subblog_category tbl_subblog_category,
			tbl_blog_category tbl_blog_category
			',$select,$where,$orderby,$limit);
		echo json_encode($data);
	}

	function SubBlogCatagoryID($subblog_cat_id)
	{ 
      $arr=array('subblog_cat_id'=>"'".$subblog_cat_id."'");
	  $select=array();
	  array_push($select,"*");
	  $where=array($arr); 
	  $orderby=array();
	  $limit='';
	  $data=$this->goldrop_model->doselect('tbl_subblog_category',$select,$where,$orderby,$limit);
	  
	  echo json_encode($data);
	}

	function Changestatus_SubBlogCatagory()
	{
	  $data=json_decode(file_get_contents("php://input"));
	  $subblog_cat_id=$data->subblog_cat_id;
	  $data=$this->goldrop_model->change_status("tbl_subblog_category",$subblog_cat_id,"subblog_cat_id");
	}

	function insert_SubBlogCatagory()
	{
	   $data=json_decode(file_get_contents("php://input"));

	   $array=array(
	   	'blog_cat_id'=>$data->blog_cat_id,
	   	'subblog_cat_name'=>$data->subblog_cat_name
	   );
	   //$subblog_cat_id=$data->subblog_cat_id;
	   $table='tbl_subblog_category'; 

	   if($data->buttonName=='Add')
	    {
	      $result=$this->goldrop_model->do_insert($array,$table);
	      if($result!=0)
	      {
echo json_encode(array("message"=>"inserted","subblog_cat_id"=>$result));
	      }
	    }
	    else
	    {

	    	$result=$this->goldrop_model->do_update($array,$table,"$subblog_cat_id","subblog_cat_id");

	    	if($result)
	    	echo json_encode(array("message"=>"update"));
	    }
	}


############### //BLOG SUBCATEGORY ###############	

############### BLOG ###############	
function blog()
	{
		$data['ActiveM']="BlogMamagement";
		$data['Active']="blog";
		$data['page'] = 'admin/blog';
	  $this->load->view('common_admin/index', $data);
	}

function get_BlogCat()
{
	$arr=array('status'=>"'Active'");
	  $select=array();
	  array_push($select,"*");
	  $where=array($arr); 
	  $orderby=array();
	  $limit='';
	  $data=$this->goldrop_model->doselect('tbl_blog_category',$select,$where,$orderby,$limit);
	  
	  echo json_encode($data);
}

function get_BlogSubCatagory($blog_catid=null)
{
	$arr=array('blog_cat_id'=>"'".$blog_catid."'",
		'status'=>"'Active'");
	  $select=array();
	  array_push($select,"*");
	  $where=array($arr); 
	  $orderby=array();
	  $limit='';
	  $data=$this->goldrop_model->doselect('tbl_subblog_category',$select,$where,$orderby,$limit);
	  
	  echo json_encode($data);
}

 function insert_Blog()
 {
   $data=json_decode(file_get_contents("php://input"));

    $config['upload_path']          = 'uploads/';
	$config['allowed_types']        = 'gif|jpg|png|pdf|jpeg|bmp';
	$config['max_size']             = 1000000000000;
	$config['max_width']            = 102400000;
	$config['max_height']           = 7680000;
	$config['overwrite']           = true;
    	 

            $this->upload->initialize($config);
		if (!$this->upload->do_upload('blog_pre_pic'))
                {
					$photo ='';					
            $error = array('error' => $this->upload->display_errors());
                }
                else
                {
            $data = array('upload_data' => $this->upload->data());
			$photo=$this->upload->data('file_name'); 
			$photo=$photo['file_name'];
                }

             if (!$this->upload->do_upload('blog_long_pic'))
                {
               
                	$this->load->library('image_lib');
                	$config['create_thumb']     = TRUE;
                	$config['maintain_ratio'] = TRUE;
				    $config['width'] = 707;
				    $config['height'] = 528;	
					$photo ='';					
            $error = array('error' => $this->upload->display_errors());
                }
                else
                {
            $data = array('upload_data' => $this->upload->data());
			$photo2=$this->upload->data('file_name'); 
			$photo2=$photo2['file_name'];
                }


   $buttonName=$this->input->post('buttonName');
   $blog_cat_id=$this->input->post('blog_cat_id');
   $subblog_cat_id=$this->input->post('subblog_cat_id');
   $blog_title=$this->input->post('blog_title');
   $blog_shrt= $this->input->post('blog_shrt');
   $blog_long=$this->input->post('blog_long');
   $blog_date=$this->input->post('blog_date');
   $blog_id=$this->input->post('blog_id');
   $table="tbl_blog";


   if ($blog_date != 'NaN-NaN-NaN' && $blog_date!="0000-00-00") 
   {
      $blog_date=date('Y-m-d',strtotime($blog_date));
   }
   else
   {
   	$blog_date="";
   }

   if(empty($blog_shrt) || $blog_shrt=="" || $blog_shrt==null || $blog_shrt=="null")
     	{
     		$blog_shrt="";
     	}
   
   
     if($buttonName=="Add")
     {
     	$array=array(
    "blog_cat_id"=>$blog_cat_id,
    "subblog_cat_id"=>$subblog_cat_id,
    "blog_slug"=>url_title($blog_title, 'dash', true),
    "blog_title"=>$blog_title,    
    "blog_shrt"=>$blog_shrt,
    "blog_long"=>$blog_long,
    "blog_pre_pic"=>$photo,
    "blog_long_pic"=>$photo2,
    "blog_date"=>$blog_date
   );
       $result=$this->goldrop_model->do_insert($array,$table);
	      if($result!=0)
	      {
echo json_encode(array("message"=>"inserted","blog_id"=>$result));
	      }
     } 
     else
     {

     	  
     	if(!empty($photo) && !empty($photo2))
     	{
     		$array=array
     		(
		    "blog_cat_id"=>$blog_cat_id,
		    "subblog_cat_id"=>$subblog_cat_id,
		    "blog_slug"=>url_title($blog_title, 'dash', true),
		    "blog_title"=>$blog_title,		   
		    "blog_shrt"=>$blog_shrt,
		    "blog_long"=>$blog_long,
		    "blog_pre_pic"=>$photo,
		    "blog_long_pic"=>$photo2,
		    "blog_date"=>$blog_date
		   );
     	}
     	else if(!empty($photo) && empty($photo2))
     	{
     		$array=array
     		(
		    "blog_cat_id"=>$blog_cat_id,
		    "subblog_cat_id"=>$subblog_cat_id,
		    "blog_slug"=>url_title($blog_title, 'dash', true),
		    "blog_title"=>$blog_title,
		    "blog_shrt"=>$blog_shrt,
		    "blog_long"=>$blog_long,
		    "blog_pre_pic"=>$photo,		    
		    "blog_date"=>$blog_date
		   );
     	}
     	else if(empty($photo) && !empty($photo2))
     	{
     		$array=array
     		(
		    "blog_cat_id"=>$blog_cat_id,
		    "subblog_cat_id"=>$subblog_cat_id,
		    "blog_slug"=>url_title($blog_title, 'dash', true),
		    "blog_title"=>$blog_title,
		    "blog_shrt"=>$blog_shrt,
		    "blog_long"=>$blog_long,
		    "blog_long_pic"=>$photo2,    
		    "blog_date"=>$blog_date
		   );
     	}
     	else
     	{
     		$array=array
     		(
		    "blog_cat_id"=>$blog_cat_id,
		    "subblog_cat_id"=>$subblog_cat_id,
		    "blog_slug"=>url_title($blog_title, 'dash', true),
		    "blog_title"=>$blog_title,
		    "blog_shrt"=>$blog_shrt,
		    "blog_long"=>$blog_long,		       
		    "blog_date"=>$blog_date
		   );
     	}

  

  $result=$this->goldrop_model->do_update($array,$table,$blog_id,"blog_id");

	    	if($result)
	    	echo json_encode(array("message"=>"update"));

     	
     }
 }

 function check_BlogTitle()
 {
 	 $blog_title=$this->input->post('blog_title');
 $blog_slug=url_title($blog_title, 'dash', true);
 	 
 	$select=array("tbl_blog.*");
    $where=array("tbl_blog.blog_title"=>"'".$blog_title."'",
    	         "tbl_blog.blog_slug"=>"'".$blog_slug."'",
                );
     array_push($select,"tbl_blog.*");

	$where=array($where);
	$orderby="";$limit=""; 
	  
	$data=$this->goldrop_model->donumrows('tbl_blog tbl_blog',
	  	$select,$where,$orderby,$limit);
	  echo json_encode($data);
 	 
 }

 function getBlog()
 {
 	//$arr=array('status'=>"'Active'");
 	$where=array("tbl_blog.blog_cat_id"=>"tbl_blog_category.blog_cat_id",
 "tbl_blog.subblog_cat_id"=>"tbl_subblog_category.subblog_cat_id"
 );
	  $select=array("tbl_blog_category.blog_cat_name,
	  	             tbl_subblog_category.subblog_cat_name
	  	 ");
	  array_push($select,"tbl_blog.*");
	  $where=array($where); 
	  $orderby=array();
	  $limit='';
	  $data=$this->goldrop_model->doselect('tbl_blog tbl_blog,
	  	 tbl_blog_category tbl_blog_category,
	  	 tbl_subblog_category tbl_subblog_category
	  	',
	  	$select,$where,$orderby,$limit);
	  echo json_encode($data);
 }

 function BlogByID($blog_id)
 { 	
 	$where=array("tbl_blog.blog_cat_id"=>"tbl_blog_category.blog_cat_id",
 "tbl_blog.subblog_cat_id"=>"tbl_subblog_category.subblog_cat_id",
 'blog_id'=>"'".$blog_id."'"
 );  
	  $select=array("tbl_blog_category.blog_cat_name,
	  	             tbl_subblog_category.subblog_cat_name
	  	 ");
	  array_push($select,"tbl_blog.*");
	  $where=array($where); 
	  $orderby=array();
	  $limit='';
	  $data=$this->goldrop_model->doselect('tbl_blog tbl_blog,
	  	 tbl_blog_category tbl_blog_category,
	  	 tbl_subblog_category tbl_subblog_category
	  	',
	  	$select,$where,$orderby,$limit);
	  echo json_encode($data);
 }

function Changestatus_Blog()
{
   $data=json_decode(file_get_contents("php://input"));
   $blog_id=$data->blog_id;
   $data=$this->goldrop_model->change_status("tbl_blog",$blog_id,"blog_id");
}

function Delete_Blog()
{
  $data=json_decode(file_get_contents("php://input"));
  $blog_id=$data->blog_id;

  $arr=array('blog_id'=>"'".$blog_id."'");
	  $select=array();
	  array_push($select,"*");
	  $where=array($arr);  

	  $orderby=array();
	  $limit='';
	  $data_img=$this->goldrop_model->doselect('tbl_blog',
	  	$select,$where,$orderby,$limit); 

	  $blog_pre_pic=$data_img[0]->blog_pre_pic;
	  $blog_long_pic=$data_img[0]->blog_long_pic;

	 if(!empty($blog_pre_pic))
	 	unlink('uploads/'.$blog_pre_pic);

	 if(!empty($blog_long_pic))
	 	unlink('uploads/'.$blog_long_pic);

	$where=array(array("blog_id"=>"'$blog_id'"));

	$data=$this->goldrop_model->do_delete("tbl_blog",$where);

	if($data)
	{
	  echo json_encode(array("message"=>"Deleted"));
    }

}


############### //BLOG ###############	

############ Comment ##############
function comment_manage()
{
	$data['ActiveM']="comment";
	$data['page'] = 'admin/management_comment';
	  $this->load->view('common_admin/index', $data);
}

public function get_coment()
{
	 $where=array( "tbl_blog.blog_id"=>"tbl_comment.blog_id",
	  			   "tbl_blog.status"=>"'Active'"
                   );

	  $select=array("tbl_blog.blog_title,
	  	             tbl_blog.blog_id
	  	            ");

	  array_push($select,"tbl_comment.*");

	  $where=array($where); 

	  $orderby=array(); 
	  
	  $limit=array(); 

	  $data=$this->goldrop_model->doselect('tbl_blog tbl_blog,
	   tbl_comment tbl_comment',$select,$where,$orderby,$limit);

	  echo json_encode($data);
}

public function Changestatus_comment()
{
  $data=json_decode(file_get_contents("php://input"));
   $comment_id=$data->comment_id;
   $data=$this->goldrop_model->change_status("tbl_comment",$comment_id,"comment_id");
}

############ Comment ##############

	 function g_password()
	{
		 //$data['ActiveM']="utilities";
		//$data['page'] = 'admin/g_user_management';
		//$this->load->view('admin/common/index', $data);

	     //$this->load->view('admin_utilities');
	}   

	 

	function  user_management(){
		
				
		$data['page'] = 'admin/g_user_management';
		$this->load->view('admin/common/index', $data);
		
	}  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */