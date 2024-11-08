<?php
if(!empty($_POST['name']) || !empty($_POST['email']) || !empty($_POST['mobile'])|| !empty($_POST['dob'])|| !empty($_POST['ms'])|| !empty($_POST['gen'])|| !empty($_POST['empid'])|| !empty($_POST['rm'])|| !empty($_POST['desg'])|| !empty($_POST['emptype'])|| !empty($_POST['salary'])|| !empty($_POST['doj'])|| !empty($_POST['dept'])||  !empty($_POST['pan'])|| !empty($_POST['ban'])|| !empty($_POST['bn'])|| !empty($_POST['adn']) || !empty($_POST['ifsc']) || !empty($_FILES['adr_file']['name'])){
    // $uploadedFile = '';
    // if(!empty($_FILES["file"]["type"])){

    //     $fileName = $_POST['name'] . '_' . $_FILES['file']['name'];
    //     $fileName = time().'_'.$_FILES['file']['name'];
    //     $valid_extensions = array("pdf");
    //     $temporary = explode(".", $_FILES["file"]["name"]);
    //     $file_extension = end($temporary);
    //     if((($_FILES["file"]["type"] == "application/pdf")) && in_array($file_extension, $valid_extensions)){
    //         $sourcePath = $_FILES['file']['tmp_name'];
    //         $targetPath = "pdfs/".$fileName;
    //         if(move_uploaded_file($sourcePath,$targetPath)){
    //             $uploadedFile = $fileName;
    //         }
    //     }
    // }

    $uploadedFile1 = '';
    if(!empty($_FILES["file1"]["type"])){
        $fileName = $_POST['name'] . '_' . $_FILES['file1']['name'];
        $valid_extensions = array("jpeg", "jpg", "png");
        $temporary = explode(".", $_FILES["file1"]["name"]);
        $file_extension = end($temporary);
        if((($_FILES["file1"]["type"] == "image/png") || ($_FILES["file1"]["type"] == "image/jpg") || ($_FILES["file1"]["type"] == "image/jpeg")) && in_array($file_extension, $valid_extensions)){
            $sourcePath = $_FILES['file1']['tmp_name'];
            $targetPath = "pics/".$fileName;
            if(move_uploaded_file($sourcePath,$targetPath)){
                $uploadedFile1 = $fileName;
            }
        }
    }

    $adr_file = '';
    if (!empty($_FILES["adr_file"]["type"])) {
        $fileName = $_POST['name'] . '_' . $_FILES['adr_file']['name'];
        $valid_extensions = array("pdf", "jpeg", "jpg", "png");
        $temporary = explode(".", $_FILES["adr_file"]["name"]);
        $file_extension = end($temporary);
    
        if ((($_FILES["adr_file"]["type"] == "application/pdf") || 
             ($_FILES["adr_file"]["type"] == "image/jpeg") || 
             ($_FILES["adr_file"]["type"] == "image/jpg") || 
             ($_FILES["adr_file"]["type"] == "image/png")) && 
            in_array($file_extension, $valid_extensions)) {
    
            $sourcePath = $_FILES['adr_file']['tmp_name'];
            $targetPath = "Emp_docs/Aadhaar/" . $fileName;
    
            if (move_uploaded_file($sourcePath, $targetPath)) {
                $adr_file = $fileName;
            }
        }
    }
    
    $pan_file = '';
    if(!empty($_FILES["pan_file"]["type"])) {
        $fileName = $_POST['name'] . '_' . $_FILES['pan_file']['name'];
        $valid_extensions = array("pdf", "jpeg", "jpg", "png"); 
        $temporary = explode(".", $_FILES["pan_file"]["name"]);
        $file_extension = end($temporary);
        
        if ((($_FILES["pan_file"]["type"] == "application/pdf") || 
        ($_FILES["pan_file"]["type"] == "image/jpeg") || 
        ($_FILES["pan_file"]["type"] == "image/jpg") || 
        ($_FILES["pan_file"]["type"] == "image/png")) && 
       in_array($file_extension, $valid_extensions)) {
            
            $sourcePath = $_FILES['pan_file']['tmp_name'];
            $targetPath = "Emp_docs/Pan/" . $fileName;
            
            if(move_uploaded_file($sourcePath, $targetPath)) {
                $pan_file = $fileName;
            }
        }
    }
    $ban_file = '';
    if(!empty($_FILES["ban_file"]["type"])) {
        $fileName = $_POST['name'] . '_' . $_FILES['ban_file']['name'];
        $valid_extensions = array("pdf", "jpeg", "jpg", "png"); 
        $temporary = explode(".", $_FILES["ban_file"]["name"]);
        $file_extension = end($temporary);
        
        if ((($_FILES["ban_file"]["type"] == "application/pdf") || 
        ($_FILES["ban_file"]["type"] == "image/jpeg") || 
        ($_FILES["ban_file"]["type"] == "image/jpg") || 
        ($_FILES["ban_file"]["type"] == "image/png")) && 
       in_array($file_extension, $valid_extensions)) {
            
            $sourcePath = $_FILES['ban_file']['tmp_name'];
            $targetPath = "Emp_docs/Bank/" . $fileName;
            
            if(move_uploaded_file($sourcePath, $targetPath)) {
                $ban_file = $fileName;
            }
        }
    }
    $edu_file = '';
    if(!empty($_FILES["edu_file"]["type"])) {
        $fileName = $_POST['name'] . '_' . $_FILES['edu_file']['name'];
        $valid_extensions = array("pdf", "jpeg", "jpg", "png"); 
        $temporary = explode(".", $_FILES["edu_file"]["name"]);
        $file_extension = end($temporary);
        
        if ((($_FILES["edu_file"]["type"] == "application/pdf") || 
        ($_FILES["edu_file"]["type"] == "image/jpeg") || 
        ($_FILES["edu_file"]["type"] == "image/jpg") || 
        ($_FILES["edu_file"]["type"] == "image/png")) && 
       in_array($file_extension, $valid_extensions)) {
            
            $sourcePath = $_FILES['edu_file']['tmp_name'];
            $targetPath = "Emp_docs/Education/" . $fileName;
            
            if(move_uploaded_file($sourcePath, $targetPath)) {
                $edu_file = $fileName;
            }
        }
    }
    $pvc = '';
    if(!empty($_FILES["pvc"]["type"])) {
        $fileName = $_POST['name'] . '_' . $_FILES['pvc']['name'];
        $valid_extensions = array("pdf", "jpeg", "jpg", "png"); 
        $temporary = explode(".", $_FILES["pvc"]["name"]);
        $file_extension = end($temporary);
        
        if ((($_FILES["pvc"]["type"] == "application/pdf") || 
        ($_FILES["pvc"]["type"] == "image/jpeg") || 
        ($_FILES["pvc"]["type"] == "image/jpg") || 
        ($_FILES["pvc"]["type"] == "image/png")) && 
       in_array($file_extension, $valid_extensions)) {
            
            $sourcePath = $_FILES['pvc']['tmp_name'];
            $targetPath = "Emp_docs/Pvc/" . $fileName;
            
            if(move_uploaded_file($sourcePath, $targetPath)) {
                $pvc = $fileName;
            }
        }
    }
    $resume = '';
    if(!empty($_FILES["resume"]["type"])) {
        $fileName = $_POST['name'] . '_' . $_FILES['resume']['name'];
        $valid_extensions = array("pdf", "jpeg", "jpg", "png"); 
        $temporary = explode(".", $_FILES["resume"]["name"]);
        $file_extension = end($temporary);
        
        if ((($_FILES["resume"]["type"] == "application/pdf") || 
        ($_FILES["resume"]["type"] == "image/jpeg") || 
        ($_FILES["resume"]["type"] == "image/jpg") || 
        ($_FILES["resume"]["type"] == "image/png")) && 
       in_array($file_extension, $valid_extensions)) {
            
            $sourcePath = $_FILES['resume']['tmp_name'];
            $targetPath = "Emp_docs/Resume/" . $fileName;
            
            if(move_uploaded_file($sourcePath, $targetPath)) {
                $resume = $fileName;
            }
        }
    }

    $exp_file = '';
    if(!empty($_FILES["exp_file"]["type"])) {
        $fileName = $_POST['name'] . '_' . $_FILES['exp_file']['name'];
        $valid_extensions = array("pdf", "jpeg", "jpg", "png"); 
        $temporary = explode(".", $_FILES["exp_file"]["name"]);
        $file_extension = end($temporary);
        
        if ((($_FILES["exp_file"]["type"] == "application/pdf") || 
         ($_FILES["exp_file"]["type"] == "image/jpeg") || 
         ($_FILES["exp_file"]["type"] == "image/jpg") || 
         ($_FILES["exp_file"]["type"] == "image/png")) && 
        in_array($file_extension, $valid_extensions)) {
            
            $sourcePath = $_FILES['exp_file']['tmp_name'];
            $targetPath = "Emp_docs/Experience/" . $fileName;
            
            if(move_uploaded_file($sourcePath, $targetPath)) {
                $exp_file = $fileName;
            }
        }
    }
    $passport = '';
    if(!empty($_FILES["passport"]["type"])) {
        $fileName = $_POST['name'] . '_' . $_FILES['passport']['name'];
        $valid_extensions = array("pdf", "jpeg", "jpg", "png"); 
        $temporary = explode(".", $_FILES["passport"]["name"]);
        $file_extension = end($temporary);
        
        if ((($_FILES["passport"]["type"] == "application/pdf") || 
        ($_FILES["passport"]["type"] == "image/jpeg") || 
        ($_FILES["passport"]["type"] == "image/jpg") || 
        ($_FILES["passport"]["type"] == "image/png")) && 
       in_array($file_extension, $valid_extensions)) {
            
            $sourcePath = $_FILES['passport']['tmp_name'];
            $targetPath = "Emp_docs/Passport/" . $fileName;
            
            if(move_uploaded_file($sourcePath, $targetPath)) {
                $passport = $fileName;
            }
        }
    }
    
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $dob = $_POST['dob'];
    $ms = $_POST['ms'];
    $gen = $_POST['gen'];
    $empid = $_POST['empid'];
    $rm = $_POST['rm'];
    $desg = $_POST['desg'];
    $emptype = $_POST['emptype'];
    $salary = $_POST['salary'];
    $doj = $_POST['doj'];
    $dept = $_POST['dept'];
    $pan = $_POST['pan'];
    $ban = $_POST['ban'];
    $bn = $_POST['bn'];
    $adn = $_POST['adn'];
    $ifsc = $_POST['ifsc'];
     $empstatus = $_POST['empstatus'];
     $work_location = $_POST['work_location'];
     $docs_uploaded = date('Y-m-d H:i:s');
     $service_provider = !empty($_POST['service_provider']) ? $_POST['service_provider'] : NULL;
     $sp_owner = !empty($_POST['sp_owner']) ? $_POST['sp_owner'] : NULL;
    
    //include database configuration file
    include_once 'dbConfig.php';
    
    $insert = $db->query("INSERT into emp(empname,empemail,empph,empdob,empms,empgen,emp_no,rm,desg,empty,salary,empdoj,dept,pan,ban,bn,adn,ifsc,adr_file,pan_file,ban_file,edu_file,pvc,resume,exp_file,passport,pic,empstatus,work_location,docs_uploaded,service_provider,sp_owner) VALUES ('".$name."','".$email."','".$mobile."','".$dob."','".$ms."','".$gen."','".$empid."','".$rm."','".$desg."','".$emptype."','".$salary."','".$doj."','".$dept."','".$pan."','".$ban."','".$bn."','".$adn."','".$ifsc."','".$adr_file."','".$pan_file."','".$ban_file."','".$edu_file."','".$pvc."','".$resume."','".$exp_file."','".$passport."','".$uploadedFile1."','".$empstatus."','".$work_location."','".$docs_uploaded."','".$service_provider."','".$sp_owner."')");
 
    echo $insert?'ok':'err';
}
?>