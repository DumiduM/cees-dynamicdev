<?php 
include '../../Model/dbh.inc.php';



class Edit extends dbh{
 
  public function getTitles ($pageType)
   { 
    $sql="SELECT program_title,idprogram FROM program WHERE page_type='".$pageType."'ORDER BY program_order";
    $result=$this->connect()->query($sql);
    $numRows=$result->num_rows;
    if($numRows>0){
        while($row=$result->fetch_assoc()){
           $data[]=$row;
        }
        echo json_encode($data);
    }
   }

   public function getProgram ($programId,$pageType)
   { 

    $sql="";
    if($pageType=="ID"){
        $sql="SELECT program.program_title,program.summary,program.status, program.image_url,program.idprogram,courses.description1,courses.description2,courses.idprogram ,courses.course_fee ,courses.course_duration ,courses.lecturer  FROM program INNER JOIN courses ON courses.idprogram=program.idprogram WHERE program.idprogram=".$programId;

    }
    if($pageType=="BP"){
        $sql="SELECT program.program_title,program.summary,program.status, program.image_url,program.idprogram,business_partnering.description2,business_partnering.description3,business_partnering.description1,business_partnering.idprogram  FROM program INNER JOIN business_partnering ON business_partnering.idprogram=program.idprogram WHERE program.idprogram=".$programId;

    }
    if($pageType=="SL"){
        $sql="SELECT program.program_title,program.summary,program.status, program.image_url,program.idprogram,solution_lab.idprogram ,solution_lab.description2,solution_lab.description1 FROM program INNER JOIN solution_lab ON solution_lab.idprogram=program.idprogram WHERE program.idprogram=".$programId;

    }

    $result=$this->connect()->query($sql);
    $numRows=$result->num_rows;
    if($numRows>0){
        while($row=$result->fetch_assoc()){
           $data[]=$row;
        }
        echo json_encode($data);
    }
   }

   public function UpdateProgram ($Title,$Summary,$status,$img,$programId,$Description, $lecturer,$CourseDuration, $CourseFee)
   { 
    $location="dddd";
    if($img==""){
      
    }else{
       $this->saveImage();
       $filename = $_FILES['file']['name'];
       $location = "assets/images/consultancy/". $filename;
    }
    $modified_at= date("Y-m-d h:i:sa");
     $sql="UPDATE program  SET program_title='".$Title."',summary='".$Summary."',image_url='". $location."',status=".$status.",modfied_at='". $modified_at."' WHERE idprogram=".$programId;
     $sql2="UPDATE courses  SET description='".$Description."',course_icon_url='". $location."',modified_at='". $modified_at."',course_fee=".$CourseFee.",course_duration='".$CourseDuration."',lecturer='".$lecturer."'WHERE idprogram=".$programId;

     $result=$this->connect()->query($sql);
     $result2=0;
      if($result==1)
      {
       $result2=$this->connect()->query($sql2);
      }
   
     return $result2? 'ok':'err';
   
   }

   function saveImage()
   {      
        /* Getting file name */
        $filename = $_FILES['file']['name'];
        $temp = explode(".", $filename);
        

        /* Location */
       $location = "../../assets/images/consultancy/". $filename;
       $uploadOk = 1;
       $imageFileType = pathinfo($location,PATHINFO_EXTENSION);
           /* Valid extensions */
       $valid_extensions = array("jpg","jpeg","png");
           /* Check file extension */
       if(!in_array(strtolower($imageFileType), $valid_extensions)) {
       $uploadOk = 0;
       }
       if($uploadOk == 0){
       echo 0;
       }else{
       /* Upload file */
       move_uploaded_file($_FILES['file']['tmp_name'],$location);
       }
       
   }

   public function UpdateProgramOder($programList)
   {
        $datas = json_decode($programList,true);
         //return $datas ;
       foreach( $datas as $data){
           $sql="UPDATE program  SET program_order='".$data['program_order']."' WHERE idprogram=".$data['programID'];
           $this->connect()->query($sql);
       }
       return 'ok';
  
   }

}


?>