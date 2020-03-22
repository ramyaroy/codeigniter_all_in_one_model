<?php
   class Api_model extends CI_Model
   {
       public $title   = '';
       public $content = '';
       public $date    = '';
   
       public function __construct()
       {
           // Call the Model constructor
           parent::__construct();
       } 
    /*** Some common functions that can be used in generall ***/
    
    public function is_exist($table, $where='', $select='') //checks a row is exist or not, returns true if exists
    {
        $this->db->select($select);
        $this->db->from($table);
        if ($where!='') {
           $this->db->where($where);
        }
        $query=$this->db->get();
        $num_rows=$query->num_rows();
        if ($num_rows>0) {
            return true;
        } else {
            return false;
        }
    }

    public function is_unique($table, $where='', $select='') //checks if a row is unique or not , returns true if unique
    {
        $this->db->select($select);
        $this->db->from($table);
        if ($where!='') {
            $this->db->where($where);
        }
        $query=$this->db->get();
        $this->db->last_query();
        $num_rows=$query->num_rows();

        if ($num_rows>0) {
            return false;
        } else {
            return true;
        }
    }

    public function generate_joining_clause($join) //generates the joining clauses as given array
    {
        $keys = array_keys($join);
        for ($i=0;$i<count($join);$i++) {
            $join_table=$keys[$i]; //gets the array key (this is the joining table's name)

            $join_condition_type=explode(',', $join[$keys[$i]]); //explodes the array value (separated by a comma - 1st part:joing condition and second part:joining type)
            $join_condition=$join_condition_type[0];
            $join_type=$join_condition_type[1];

            $this->db->join($join_table, $join_condition, $join_type); //forms the join clauses
        }
    }

    public function generate_where_clause($where) //generates the joining clauses as given array
    {
        $keys = array_keys($where);  // holds the clause types. Ex- array(0=>'where',1=>'where_in'......................)
        for ($i=0;$i<count($keys);$i++) {
            if ($keys[$i]=='where') {
                $this->db->where($where['where']);
            }  // genereates the where clauses

            elseif ($keys[$i]=='where_in') {
                $keys_inner = array_keys($where['where_in']); // holds the field names. Ex- array(0=>'id',1=>'username'......................)
                for ($j=0;$j<count($keys_inner);$j++) {
                    $field=$keys_inner[$j]; // grabs the field names
                    $value=$where['where_in'][$keys_inner[$j]];     // grabs the array values of the grabed field to be find in
                    $this->db->where_in($field, $value);    //genereates the where_in clause  s
                } //end for
            } //end else if

            elseif ($keys[$i]=='where_not_in') {
                // works similar as where_in specified above

                $keys_inner = array_keys($where['where_not_in']);
                for ($j=0;$j<count($keys_inner);$j++) {
                    $field=$keys_inner[$j];
                    $value=$where['where_not_in'][$keys_inner[$j]];
                    $this->db->where_not_in($field, $value);    // genereates the where_not_in clauses
                } // end for
            } // end else if

            elseif ($keys[$i]=='or_where') {
                $this->db->or_where($where['or_where']);
            } // genereates the or_where clauses

            elseif ($keys[$i]=='or_where_advance') {
                // works similar as where_in but the array indexes & values are in reverse format as given parameter

                $keys_inner = array_keys($where['or_where_advance']);
                for ($j=0;$j<count($keys_inner);$j++) {
                    $field=$where['or_where_advance'][$keys_inner[$j]];
                    $value=$keys_inner[$j];
                    $this->db->or_where($field, $value);    // genereates the or_where clauses
                } // end for
            } // end else if

            elseif ($keys[$i]=='or_where_in') {
                // works similar as where_in specified above

                $keys_inner = array_keys($where['or_where_in']);
                for ($j=0;$j<count($keys_inner);$j++) {
                    $field=$keys_inner[$j];
                    $value=$where['or_where_in'][$keys_inner[$j]];
                    $this->db->or_where_in($field, $value);    // genereates the or_where_in clauses
                } // end for
            } // end else if

            elseif ($keys[$i]=='or_where_not_in') {
                // works similar as where_in specified above
                $keys_inner = array_keys($where['or_where_not_in']);
                for ($j=0;$j<count($keys_inner);$j++) {
                    $field=$keys_inner[$j];
                    $value=$where['or_where_not_in'][$keys_inner[$j]];
                    $this->db->or_where_not_in($field, $value);    // genereates the or_where_not_in clauses
                } // end for
            } // end else if
        } // end outer for
    }

    public function get_data($table, $where='', $select='', $join='', $limit='', $start=null, $order_by='', $group_by='', $num_rows=0) //selects data from a table as well as counts number of affected rows
    {
        // only get data except deleted values
        // $col_name=$table.".deleted";
        // if($this->db->field_exists('deleted',$table) && $show_deleted==0)
        // $where['where'][$col_name]="0";

        $this->db->select($select);
        $this->db->from($table);

        if ($join!='') {
            $this->generate_joining_clause($join);
        }
        if ($where!='') {
            $this->generate_where_clause($where);
        }

        if ($this->db->field_exists('deleted', $table)) {
            $deleted_str=$table.".deleted";
            $this->db->where($deleted_str, "0");
        }

        if ($order_by!='') {
            $this->db->order_by($order_by);
        }
        if ($group_by!='') {
            $this->db->group_by($group_by);
        }
        if (is_numeric($start) || is_numeric($limit)) {
            $this->db->limit($limit, $start);
        }
        $query=$this->db->get();
        // echo $this->db->last_query();
        if ($csv==1) {
            return $query;
        } //csv generation requires resourse ID
        $result_array=$query->result_array(); //fetches the rows from database and forms an array[]
        if ($num_rows==1) {
            $num_rows=$query->num_rows(); //counts the affected number of rows
            $result_array['extra_index']=array('num_rows'=>$num_rows);    //addes the affected number of rows data in the array[]
        }
        return $result_array; //returns both fetched result as well as affected number of rows
    }

    public function checkEmail($email)
    {
        $SQl="SELECT * FROM tbl_user WHERE email=? ";
        $query=$this->db->query($SQl, array($email));

        if ($query) {
            return $query->num_rows();
        }
    }
}




