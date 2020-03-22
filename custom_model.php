<?php 

class custom_model extends CI_Model 
{

    var $title   = '';
    var $content = '';
    var $date    = '';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

  function do_insert($data,$table)
    {

     $query = $this->db->insert($table,$data);
        if($query){
        return $this->db->insert_id();
        }else{
         return 0;
        }
    }

   function change_status($table,$value,$index)
   {
    $sql = "UPDATE ".$table." SET status = if(status = 'Active','Inactive','Active') WHERE ".$index." = ".$value."
      ";
      $query=$this->db->query($sql);

      if($query)
        return true;
      else
        return false;
   }

function do_update($array,$table,$id,$index)
{
   $sql="UPDATE ".$table." SET ";
    foreach ($array as $key => $value) 
    {
       $sql.=" ".$key."='".addslashes($value)."',";
    }
    $sql=substr($sql,0,-1);
    $sql.=" WHERE `".$index."` = '".$id."' ";
  
   $query=$this->db->query($sql);

     if($query)
       return true; 
}

function donumrows($table,$select,$where,$orderby,$limit)
{
   $select1=' * ';
     $where1=' WHERE 1 ';
     $orderby1='';
     $limit1='';
    if(!empty($select)){
        $select1=implode(",",$select);
        
    }
    
    if(!empty($where)){
      foreach($where as $k=>$val){ 
        foreach($val as $k1=>$val1){

          $where1.=' AND '.$k1."= ".$val1."";
        }
      }
    }
    
    if(!empty($orderby)){
      $orderby1=' ORDER BY ';
      foreach($orderby as $k2=>$val2){
         $orderby1.=" ".$k2." ".$val2.",";
      }
      $orderby1=substr($orderby1,0,-1);
    }

    if(!empty($limit)){
      $limit1='';
      foreach($limit as $k2=>$val2){
         $limit1.=" ".$k2." ".$val2.",";
      }
      $limit1=substr($limit1,0,-1);
    }
    
    $data=array();

   $sql="SELECT ".$select1." FROM ".$table." ".$where1." ".$orderby1." ".$limit1;

   $query=$this->db->query($sql);
    
    if($query)
      return $query->num_rows();
}

  function doselect($table,$select,$where,$orderby,$limit){
    $select1=' * ';
     $where1=' WHERE 1 ';
     $orderby1='';
     $limit1='';
    if(!empty($select)){
        $select1=implode(",",$select);
        
    }
    
    if(!empty($where)){
      foreach($where as $k=>$val){ 
        foreach($val as $k1=>$val1){

          $where1.=' AND '.$k1."= ".$val1."";
        }
      }
    }
    
    if(!empty($orderby)){
      $orderby1=' ORDER BY ';
      foreach($orderby as $k2=>$val2){
         $orderby1.=" ".$k2." ".$val2.",";
      }
      $orderby1=substr($orderby1,0,-1);
    }

    if(!empty($limit)){
      $limit1='';
      foreach($limit as $k2=>$val2){
         $limit1.=" ".$k2." ".$val2.",";
      }
      $limit1=substr($limit1,0,-1);
    }
    
    $data=array();

    $sql="SELECT ".$select1." FROM ".$table." ".$where1." ".$orderby1." ".$limit1;


 
   $query=$this->db->query($sql);
    
    if($query)
      return $query->result();
     
   // return $data;    
  }

  function doselectPrevNext($table,$select,$where,$orderby,$limit){
    $select1=' * ';
     $where1=' WHERE 1 ';
     $orderby1='';
     $limit1='';
    if(!empty($select)){
        $select1=implode(",",$select);        
    }
    
    if(!empty($where)){
      foreach($where as $k=>$val){ 
        foreach($val as $k1=>$val1){

          $where1.=' AND '.$k1."".$val1."";
        }
      }
    }
    
    if(!empty($orderby)){
      $orderby1=' ORDER BY ';
      foreach($orderby as $k2=>$val2){
         $orderby1.=" ".$k2." ".$val2.",";
      }
      $orderby1=substr($orderby1,0,-1);
    }

    if(!empty($limit)){
      $limit1='';
      foreach($limit as $k2=>$val2){
         $limit1.=" ".$k2." ".$val2.",";
      }
      $limit1=substr($limit1,0,-1);
    }
    
    $data=array();



     $sql="SELECT ".$select1." FROM ".$table." ".$where1." ".$orderby1." ".$limit1;

   $query=$this->db->query($sql);
    
    if($query)
      return $query->result();     
   // return $data;    
  }

  function do_delete($table,$where)
  {
    $where1=' WHERE 1 ';
    if(!empty($where)){
      foreach($where as $k=>$val){ 
        foreach($val as $k1=>$val1){

          $where1.=' AND '.$k1."= ".$val1."";
        }
      }
    }

  $sql="DELETE FROM ".$table." ".$where1;
  $query=$this->db->query($sql);
  
  if ($query) {
    return true;
  }

     
  }

	
}
	
	
	
	?>