<?php

require 'Medoo.php';

use Medoo\Medoo;

/**
 * Connection Class
 */
class Connection
{
/*
 * Static Variables
 */
  static $dbhost = "localhost";
  static $dbuser = "root";
  static $dbpass = "dude";
  static $dbname = "new_db";
  static $dbtype = "mariadb";

/*
 * Instance Variables
 */
 private $db;

 private $stu_id;

/*
 * Constructor
 */
  function __construct()
  {
    try
    {

      $this -> db = new Medoo([
      'database_type' => static::$dbtype,
      'database_name' => static::$dbname,
      'server' => static::$dbhost,
      'username' => static::$dbuser,
      'password' => static::$dbpass
      ]);

    } catch (Exception $e)
    {
      die("Database Error");
    }
  }

/*
 * Helpers
 */
  function query($qry)
  {
    $res = $this -> db ->query($qry);
    return $res;
  }
  function view($tbname)
  {
    $res = $this -> db -> select(
      $tbname,"*"
    );
    return $res;
  }
  function add_login($det)
  {
    if( $det[0]=='' || $det[1]=='')
    return false;
    $res = $this -> db -> insert(
      'login',
      ['username'=>$det[0],'password'=>$det[1],'acc_type'=>$det[2]]
    );
    return $res;
  }
  function update_login($det)
  {
    if( $det[0]=='' || $det[1]=='')
    return false;
    $res = $this -> db -> update(
      'login',
      ['password'=>$det[0]],
      ['login_id'=>$det[1]]
    );
    return $res;
  }
  function get_stu_id($admn)
  {
    $res = $this -> db -> get(
    'stu_base',
    ['id'],
    ['admn_no' => $admn]
    );
    if($res){
      $stu_id = $res['id'];
      return $res['id'];
    }
    return false;
  }

 function get_dept($depid)
 {
   $res = $this -> db -> get(
     'dept',
     ['name','shortname'],
     ['dep_id' => $depid]
   );
   if($res)
    return $res;
  else
   return false;
 }

 function get_depts()
 {
   $res = $this -> db -> select(
     'dept',
     ['dep_id','name','shortname']
   );
   if($res)
   {
     unset($res[0]);
     return $res;
   }
  else
   return false;
 }

 function get_course($cid)
 {
   $res = $this -> db -> get(
     'course',
     ['name','dept','coursetype','duration'],
     ['course_id' => $cid]
   );
   if($res)
    return $res;
  else
   return false;
 }

 function get_courses()
 {
   $res = $this -> db -> select(
     'course',
     ['course_id','name','dept','coursetype']
   );
   if($res)
    return $res;
  else
   return false;
 }

  function get_batches()
  {
    $res = $this -> db -> select(
      'batch',
      ['batch_id','course','yearofpassing']
    );
    if($res)
     return $res;
   else
    return false;
  }

  function get_subs()
  {
    $res = $this -> db -> select(
      'sub_info',
      ['sub_id','name','dep_id','semester']
    );
    if($res)
     return $res;
   else
    return false;
  }

  function get_subinfo($subid)
  {
    $sub = $this -> db -> get(
      'sub_info',
      ['name','semester','marks_max'],
      ['sub_id' => $subid]
    );

    if($sub)
     return array_values($sub);
    else
     return false;
  }

  function get_students($batch)
  {
    $st = $this -> db -> select(
      'stu_base',
      ['id'],
      ['batch'=>$batch]
    );
    if(!st)
    return false;
    else {
      $res = array();
      foreach ($st as $key => $value) {
        $value = array_values($value);
        array_push($value,$this -> db -> get(
          'stu_details',
          ['name'],
          ['id'=>$value[0]]
        ));
        array_push($res, $value);
      }
      return $res;
    }
  }

/*
 * Login Function
 */
  function login($user,$password)
  {
    $pass = $this -> db -> get(
    'login',
    ['password','acc_type'],
    ['username' => $user]
    );

    if($pass)
      if($password == $pass['password'])
      {
        return $pass['acc_type'];
      }
      else {
        return -1;
      }
    else {
      return -2;
    }
  }

/**************************************************************/
/*******************GET FUNCTIONS******************************/
/**************************************************************/
/*
 * Get Profile
 */
 function get_stu_profile($id)
 {
   $err = -1;
   $res = $this -> db -> get(
     'stu_details',
     ['name','dob','category','relegion','caste','address','email','mob'],
     ['id' => $id]
   );

   if($res)
   {
     $result = $res;
   }
   else{
     return $err;
   }

   $res = $this -> db -> get(
    'stu_family',
    ['f_id','m_id','lg_id'],
    ['id' => $id]
   );

   if($res)
    $result = array_merge($result,$res);
   else {
     $err--;
     return $err;
   }

   $res = $this -> db -> get(
   'stu_base',
   ['dept'],
   ['id' => $id]
   );

   if($res)
    $result['dept'] = $this -> get_dept($res)['name'];
   else {
     $temp = $this -> db ->error();
     $err-=3;
     return $err;
   }

  return $result;
 }

/*
 *Parent's profile
 */
 function get_parent_profile($pid)
 {
   $res = $this -> db -> get(
     'family_details',
     ['name','occupation','address','email','mob'],
     ['id' => $pid]
   );

   if($res)
    return $res;
   else
    return false;
 }

/*
 *Previous Academic Details
 */
 function get_prev_acinfo($id)
 {
   $res = $this -> db -> select(
     'prev_academ',
     ['coursetype','year_of_passing','institute','board_university','marks_scored','marks_max'],
     ['stu_id' => $id]
   );

   if($res)
     return $res;
   else
    return false;
 }

/*
 *Academic Details
 */
 function get_acdetails($id)
 {
   $subs = $this -> db -> select(
     'stu_marks',
     ['sub_id','marks_sessional','marks_chance1','marks_chance2','marks_chance3','marks_chance4'],
     ['stu_id' => $id]
   );

   $result = array();

   foreach ($subs as $key => $value) {
     $result[$key] = array();
     $temp = $this -> db -> get(
       'sub_info',
       ['sub_code','name','semester','marks_max'],
       ['sub_id' =>$value['sub_id']]
     );
     $result[$key] = array_merge($result[$key],$temp);
     $value = array_values($value);
     $result[$key]['sub_id'] = $value[0];
     $result[$key]['int_marks'] = $value[1];
     $result[$key]['ext_marks'] = max($value[2],$value[3],$value[4],$value[5]);
   }

   $marks = array();
   foreach ($result as $key => $value) {
     if(!isset($marks[$value['semester']]))
        $marks[$value['semester']] = array();
     array_push($marks[$value['semester']], $value);
   }
   ksort($marks);
   return $marks;
 }

/**************************************************************/
/*****************SET FUNCTIONS********************************/
/**************************************************************/
/*
 *Add New Student
 */
 function add_student($var)
 {
   foreach ($var as $key => $value) {
     if($value == '')
     return -1;
   }
   $this -> db -> insert(
     'stu_base',
     ['admn_no'=>$var[0],'batch'=>$var[1],'dojoin'=>date('Y-m-d',strtotime($var[2]))
   ]);
   $id =  $this -> db -> id();
   if($id != 0)
    {
      $this -> db -> insert(
        'login',
        ['username'=>$var[0],'password'=>$var[3],'acc_type'=>1]
      );
      $temp = $this -> db -> id();
      if($temp == 0)
      {
        $this -> db -> update(
          'login',
          ['password'=>$var[3],'acc_type'=>1],
          ['username'=>$var[0]]
        );
      }
    }
    return $id;
 }

/*
 *Add Student Details
 */
 function add_stu_details($var)
 {
   foreach ($var as $key => $value) {
     if($value == '')
     return -1;
   }

   $this -> db ->insert(
     'stu_details',
     ['id'=>$var[0],'name'=>$var[1],'dob'=>date('Y-m-d',strtotime($var[2])),'category'=>$var[3],'relegion'=>$var[4],'caste'=>$var[5],'address'=>$var[6],'email'=>$var[7],'mob'=>$var[8]]
   );
   $temp = $this -> db -> id();
   if($temp == 0)
   {
     $this -> db -> update(
       'stu_details',
       ['name'=>$var[1],'dob'=>date('Y-m-d',strtotime($var[2])),'category'=>$var[3],'relegion'=>$var[4],'caste'=>$var[5],'address'=>$var[6],'email'=>$var[7],'mob'=>$var[8]],
       ['id'=>$var[0]]
     );
   }
   return $this -> db -> id();
 }

/*
 *Add Marks
 */
 function add_marks($stu_id,$sub_id,$marks)
 {
   $this -> db ->insert(
     'stu_marks',
     ['stu_id'=>$stu_id,'sub_id'=>$sub_id,'marks_sessional'=>$marks[0],'marks_chance1'=>$marks[1],'marks_chance2'=>$marks[2],'marks_chance3'=>$marks[3],'marks_chance4'=>$marks[4]]
   );
   $temp = $this -> db -> id();
   if($temp == 0)
   {
     $this -> db -> update(
       'stu_marks',
       ['marks_sessional'=>$marks[0],'marks_chance1'=>$marks[1],'marks_chance2'=>$marks[2],'marks_chance3'=>$marks[3],'marks_chance4'=>$marks[4]],
       ['AND'=>['stu_id'=>$stu_id,'sub_id'=>$sub_id] ]
     );
   }
   return $this -> db -> id();
 }

/**************************************************************/
/*****************ADMIN FUNCTIONS********************************/
/**************************************************************/

/*
 *Add Department
 */
 function add_dept($dep)
 {
   foreach ($dep as $key => $value) {
     if($value == '')
     return false;
   }
   $this -> db -> insert(
     'dept',
     ['name'=>$dep[0],'shortname'=>$dep[1]]
   );
   return $this -> db -> id();
 }

/*
 *Add Course
 */
 function add_course($det)
 {
   foreach ($det as $key => $value) {
     if($value == '')
     return false;
   }
   $this -> db -> insert(
     'course',
     ['name'=>$det[0],'coursetype'=>$det[1],'dept'=>$det[2],'duration'=>$det[3]]
   );
  return $this -> db -> id();
 }

/*
 *Add Batch
 */
 function add_batch($bat)
 {
   foreach ($bat as $key => $value) {
     if($value == '')
     return false;
   }
   $this -> db -> insert(
     'batch',
     ['course'=>$bat[0],'yearofpassing'=>$bat[1]]
   );
  return $this -> db -> id();
 }
/*
 *Add Subject
 */
 function add_subject($sub)
 {
   foreach ($sub as $key => $value) {
     if($value == '')
     return false;
   }
   $this -> db -> insert(
     'sub_info',
     ['name'=>$sub[0],'sub_code'=>$sub[1],'dep_id'=>$sub[2],'semester'=>$sub[3],'marks_max'=>$sub[4]]
   );
   return $this -> db -> id();
 }

/*
 *End of Class
 */
}
?>
