/** profile image **/
   function ajax_image_upload()
   {

    $user_id=$this->session->userdata('user_id');
$folderName=$this->session->userdata('firstname');
    $folderName=$user_id.$folderName;

    if (!is_dir('uploads/'.$user_id)) 
    {
      
    mkdir('uploads/'.$user_id,0777, true);
   }
   

      $config['upload_path']      = 'uploads/'.$user_id;
      $config['allowed_types']    = 'gif|jpg|png|jpeg|bmp';
      $config['max_size']         = 110000;
      $config['max_width']        = 102400;
      $config['max_height']       = 768000;
      $config['overwrite']        = FALSE;
      $config['encrypt_name']     = TRUE; 
      

     //$this->load->library('upload', $config);
     $this->upload->initialize($config);
     $this->load->library('image_lib');
  
  
    if (!$this->upload->do_upload('file'))
                {
                 $photo ='';
                 $error = array('error' => $this->upload->display_errors()); 
                }
                else
                {
                   $image_data =   $this->upload->data();
                   /*'maintain_ratio'  =>  TRUE,*/

                   $configer =  array(
                                        'image_library'   => 'gd2',
                                        'source_image'    =>  $image_data['full_path'],
                                        
                                        'width'           =>  250,
                                        'height'          =>  100,
                                        'master_dim'     => 'width'
                                      );

                $this->image_lib->clear();
                $this->image_lib->initialize($configer);
                $this->image_lib->resize();              

                 $photo=$image_data['file_name'];
                }

       $update_array=array(
        'profile_picture'=>$photo,
        'modified_date'=>date('Y-m-d'),
        'modified_time'=>date('H:i:s'),
       );

       $unlink_prev_image=$this->BookBeautyModel->selectuser($user_id);


    $folderName=$this->session->userdata('firstname');
    $folderName=$user_id.$folderName;
        
       if(!empty($unlink_prev_image->profile_picture))
       {
         unlink('uploads/'.$folderName."/".$unlink_prev_image->profile_picture);
       } 

    
    $result=$this->BookBeautyModel->updateData($update_array,'tbl_user',$user_id,"user_id");

     if($result) 
     {
      $data= array(
              'user_id'=> $this->session->userdata('user_id'),                
               'profile_picture'=>$photo,
                'is_logged_in' => 'login id',
                 );                  
        $this->session->set_userdata($data);
         
     }
     

   }
/** end profile image **/

