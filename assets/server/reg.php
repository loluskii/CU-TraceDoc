<?php 

require_once "config.php";
use PHPMailer\PHPMailer\PHPMailer;
include 'autoload.php';

session_start();


//to process the data when the form is submitted
if(($_SERVER["REQUEST_METHOD"] == "POST") && isset($_GET['action']) && $_GET['action']=="r" ){
    $full_name = mysqli_real_escape_string($con,$_POST["name"]);
    $role = mysqli_real_escape_string($con,$_POST["role"]);
    $email = mysqli_real_escape_string($con,$_POST["email"]);
   
    // Prepare a select statement to check if the id already exists
    $sql = "SELECT id FROM accounts WHERE user_id = ?";
    if($stmt = mysqli_prepare($con, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_user_id);

        // Set parameters
        $param_user_id = trim($_POST["id"]);

        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            /* store result */
            mysqli_stmt_store_result($stmt);

            if(mysqli_stmt_num_rows($stmt) == 1){
                echo 204; //user exists
            } else{
                $id = mysqli_real_escape_string($con,$_POST["id"]);
            }
        }
        else {
            echo 404; //error
        }
    }
    mysqli_stmt_close($stmt);

    $sql = "SELECT id FROM accounts WHERE user_email = ?";
    if($stmt = mysqli_prepare($con, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_user_id);

        // Set parameters
        $param_user_id = trim($_POST["id"]);

        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            /* store result */
            mysqli_stmt_store_result($stmt);

            if(mysqli_stmt_num_rows($stmt) < 0 ){
                echo 204; //user exists
            } else{
                $id = mysqli_real_escape_string($con,$_POST["id"]);
            }
        }
        else {
            echo 404; //error
        }
    }
    mysqli_stmt_close($stmt);
    
    // Prepare an insert statement
    $user_password = rand(100000,999999);
    $user_encrypted_password = md5($user_password);
    $user_activation_code = md5(rand());

    $sql = "INSERT INTO accounts (user_name, user_email, user_id, user_type, user_password, user_activation_code, user_email_status) VALUES (?, ?, ?, ?, ?, ?, 'not verified')";

    if($stmt = mysqli_prepare($con, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ssssss", $param_fname, $param_email,$param_user_id,$param_user_type, $param_password, $param_activation_code );

        // Set parameters
        $param_fname = $full_name;
        $param_email = $email;
        $param_user_id = $id;
        $param_user_type = $role;
        $param_password = $user_encrypted_password;
        $param_activation_code = $user_activation_code;
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $base_url = "http://localhost:8888/fyp/assets/server/reg.php?t=".$user_activation_code."&ac=verify";
            $message = 
            "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
            <html xmlns='http://www.w3.org/1999/xhtml'>
                <head>
                <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
                <meta name='viewport' content='width=device-width, initial-scale=1.0'/>
                </head>
                <body style='margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;'>
                <table border='0' cellpadding='0' cellspacing='0' width='100%'> 
                    <tr><td style='padding: 10px 0 30px 0;'>
                            <table align='center' border='0' cellpadding='0' cellspacing='0' width='600' style='border: 1px solid #cccccc; border-radius: 1em; overflow: hidden;border-collapse: collapse;'>
                                <tr>
                                    <td align='center' bgcolor='#70bbd9' style=' color: #153643; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif;'>
                                        <img src='https://covenantuniversity.edu.ng/var/cusite_admin/storage/images/media/images/the-world-university-rankings-2020-young/447122-1-eng-GB/THE-World-University-Rankings-2020-YOUNG.png' alt='Creating Email Magic'  style='display: block;' />
                                    </td>
                                </tr>
                                <tr>
                                    <td bgcolor='#fafbfc' style='padding: 40px 30px 40px 30px;'>
                                        <table border='0' cellpadding='0' cellspacing='0' width='100%' style=''>
                                            <tr>
                                                <td style='color: #153643; font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif, sans-serif; '>
                                                    <b style='font-size:45px;' >Hi there, </b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style='padding: 20px 0 10px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;'>
                                                    Your account has succesfully been created. You can log in now.
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style='padding: 0px 0 20px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 25px;'>
                                                    But first, you need to activate your account. <br> Click <a href='$base_url'>here</a> to do that.
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style='padding: 0px 0 10px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;'>
                                                    Your password is <span style='font-size: larger;'>$user_password</span> but you can change it after you log in. 
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td bgcolor='#523b75' style='padding: 30px 30px 30px 30px;'>
                                        <table border='0' cellpadding='0' cellspacing='0' width='100%'>
                                            <tr>
                                                <td style='color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;' width='75%'>
                                                    &copy; Covenant University 2020<br/>
                                                </td>
                                                
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </body>
            </html>
            ";

            $mail = new PHPMailer;
            $mail->isSMTP();
            $mail->SMTPDebug = 0;
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;
            $mail->SMTPAuth = true;
            $mail->Username = 'adeloreisaac@gmail.com';
            $mail->Password = 'Jesuloluwa123';
            $mail->setFrom('admintracedoc@cu.edu.ng', 'Administrator');
            $mail->addReplyTo('isaacadelore@gmail.com', 'First Last');
            $mail->addAddress($email);
            $mail->Subject = 'TraceDoc - Confirm Your Email';
            $mail->msgHTML($message);

            if($mail->send()){
                echo 500; //mail sent
            }
            else{
                echo 406; //error
            }


            

        } 
        else{
            echo 999 ;
        }
    }

    mysqli_close($con);
}
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}



if(isset($_GET['t']) && isset($_GET['ac']) && $_GET['ac']=="verify" ){
    $tokens = $_GET['t'];
    $query = "SELECT * FROM accounts WHERE user_activation_code='$tokens'";
    $rt = mysqli_query($con,$query) or die(mysqli_error($con));
    $rows = mysqli_num_rows($rt);
    if($rows === 1){
        $sql = "UPDATE accounts SET user_email_status = 'verified' WHERE user_activation_code = '$tokens'";
        $res = mysqli_query($con, $sql) or die(mysqli_error($con));

        if($res){
            header("location: ../../login.php");

        }else{
            echo mysqli_error($con);
        }
    }elseif ($rows < 1) {
        
    }
}


if(($_SERVER["REQUEST_METHOD"] == "POST") && isset($_GET['action']) && $_GET['action']=="l" ){
    $userID = mysqli_real_escape_string($con,$_POST["id"]);
    $userPass = mysqli_real_escape_string($con,$_POST["pass"]);

    $user_encrypted_pass = md5($userPass);

    $sql = "SELECT * FROM accounts WHERE user_id = '$userID' AND user_password = '$user_encrypted_pass' ";
    $res = mysqli_query($con,$sql) or die(mysqli_error($con));
    
    $rows = mysqli_num_rows($res);

    $record = mysqli_fetch_assoc($res);
    if($rows >= 1){
        $type = $record["user_type"];
        $user_name = $record["user_name"];
        if ($type === "Student") {
            $_SESSION["id"] = $userID;
            $_SESSION["user_type"] = "student";
            $_SESSION["user_name"] = $user_name;
            echo 500;
        }else{
            $_SESSION["id"] = $userID;
            $_SESSION["user_type"] = $type;
            $_SESSION["user_name"] = $user_name;
            echo 600;
        }
    }else{
        echo 404;
    }


}

if(($_SERVER["REQUEST_METHOD"] == "POST") && isset($_GET['action']) && $_GET['action']=="d" ){
    $id = mysqli_real_escape_string($con,$_POST["form_name"]);

    $sql = "SELECT * FROM forms WHERE form_code='$id'";
    $result = mysqli_query($con, $sql) or die(mysqli_error($con));
    $rows = mysqli_num_rows($result);

    $file = mysqli_fetch_assoc($result);
    if($rows > 0){
        $filename = $file['form_name'];
    }
    $filepath = 'forms/downloads/' .$filename.".docx";
        
    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filepath));
        flush(); // Flush system output buffer
        readfile($filepath);
        die();        
        exit;
    }
    else{
        echo "<script>alert('File not exist')</script>";
        // http_response_code(404);
        // die();
    }

}

if(($_SERVER["REQUEST_METHOD"] == "POST") && isset($_GET['action']) && $_GET['action']=="u" ){
    $userID = mysqli_real_escape_string($con,$_SESSION["id"]);
        
    if(!empty($_FILES['new_form']['name'])){
        $targetDir = "forms/uploads/";
        $fileName = basename($_FILES["new_form"]["name"]);

        if(strlen($fileName) == 12){
            $form_code = substr($fileName, 5,-5);
        }else{
            $form_code = substr($fileName, 5,-5);
        }
        $temp = explode(".", $_FILES["new_form"]["name"]);
        $newfilename = substr($userID, -3) .$form_code. '.' . end($temp);

        $sqls = "SELECT * FROM forms WHERE form_code = '$form_code'";
        $query = mysqli_query($con,$sqls);
        $records = mysqli_fetch_assoc($query);
        $form_description = $records["form_description"];


        
        $targetFilePath = $targetDir . $newfilename;
        if(move_uploaded_file($_FILES["new_form"]["tmp_name"], $targetFilePath)){
            // Insert image file name into database
            $sql = "INSERT into uploaded_forms (uploader_id, form_name, form_code, form_description) VALUES ('".$userID."','".$fileName."','".$form_code."','".$form_description."')";
            $result = mysqli_query($con, $sql) or die(mysqli_error($con));
            if($result){
                echo 400;
            }else{
                echo 404;
            } 
        }else{
            echo 600;
        }
    }else echo 3;

}

if(!empty($_POST["roleType"])){
    $role = $_POST["roleType"];
    $sqls = "SELECT * FROM accounts WHERE user_type = '$role' AND user_email_status = 'verified'  ";
    $res = mysqli_query($con, $sqls) or die(mysqli_error($con));

    if(mysqli_num_rows($res) > 0){
        while($name =  mysqli_fetch_assoc($res)){
            // echo"<option>Choose the reciever's name</option>";
            echo"<option value = $name[user_id] > $name[user_name] </option>";
        }
    }else{
        echo"<option> No receivers available at the moment. </option>";
    }
}else if(!empty($_POST["formtype"])){
    $form_desc = $_POST["formtype"];

    if($_SESSION["user_type"] == "student"){
        $sqls = "SELECT * FROM forms WHERE form_code = '$form_desc' AND initiator = 'Student'";
    }else{
        $sqls = "SELECT * FROM forms WHERE form_code = '$form_desc'";
    }
    $res = mysqli_query($con, $sqls) or die(mysqli_error($con));

    if(mysqli_num_rows($res) > 0){
        while($row =  mysqli_fetch_assoc($res)){
            echo $row["initiator"]."/ ".$row["form_code"];
        }
    }else{
        echo "Sorry. You are not authorised to view.";
    }
}

if(($_SERVER["REQUEST_METHOD"] == "POST") && isset($_GET['action']) && $_GET['action']=="newreq" ){
    $sender_id = $_SESSION["id"];
    $new_id = substr($sender_id, -3);//new sender id i.e. last 3 digits of user id

    $form_code = mysqli_real_escape_string($con,$_POST["form_name"]);
    $receiver_type = mysqli_real_escape_string($con,$_POST["receiver_role"]);
    $receiver_id = mysqli_real_escape_string($con,$_POST["receiver_id"]);
    $additional_note = mysqli_real_escape_string($con,$_POST["note"]);

    //Sql to get form description
    $s = "SELECT * FROM forms WHERE form_code = '$form_code'";
    $query = mysqli_query($con, $s) or die(mysqli_error($con));
    $rows = mysqli_num_rows($query);
    
    while($record = mysqli_fetch_assoc($query)){
        $form_request_type = $record["form_description"];
    }

    $request_name = $new_id.$form_code;

    $rec = "SELECT * FROM accounts WHERE user_id = '$receiver_id'";
    $rea = mysqli_query($con,$rec) or die(mysqli_error($con));

    if(mysqli_num_rows($rea) > 0){
        $row = mysqli_fetch_assoc($rea);
        $receiver_name = $row["user_name"];
    }

    $query = "INSERT INTO requests (request_name, form_request_type, sender_id, receiver_type, receiver_id, receiver_name, note) VALUES ('".$request_name."','".$form_request_type."','".$sender_id."','".$receiver_type."','".$receiver_id."','".$receiver_name."','".$additional_note."')";
    $result = mysqli_query($con, $query) or die(mysqli_error($con));
    if($result){
        echo 400;
    }else{
        echo 404;
    } 
}

if(($_SERVER["REQUEST_METHOD"] == "POST") && isset($_GET['action']) && $_GET['action']=="update" ){
    $dept = mysqli_real_escape_string($con,$_POST["dept"]);

    $user_id = $_SESSION["id"];
    $sql = "UPDATE accounts SET dept= '$dept' WHERE user_id = '$user_id'";
    $result = mysqli_query($con, $sql) or die(mysqli_error($con));

    if($result){
        echo 400;
    }else{
        echo 404;
    } 
}

//reset password
if(($_SERVER["REQUEST_METHOD"] == "POST") && isset($_GET['action']) && $_GET['action']=="reset" ){
    $user_id = $_SESSION["id"];
    $pass = mysqli_real_escape_string($con,$_POST["pass"]);
    $new_pass1 =  mysqli_real_escape_string($con,$_POST["new_pass1"]);
    $new_pass2 =  mysqli_real_escape_string($con,$_POST["new_pass2"]);
    $encryot_pass = md5($pass);

    $query = "SELECT * FROM accounts WHERE user_id = '$user_id'";
    $res = mysqli_query($con, $query) or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($res);

    $old_pass = $row["user_password"];
    if($old_pass === $encryot_pass){
        if($new_pass1 === $new_pass2){
            $final_pass = md5($new_pass1);
            $sql = "UPDATE accounts SET user_password = '$final_pass' WHERE user_id = '$user_id'";
            $result = mysqli_query($con, $sql) or die(mysqli_error($con));

            if($result){
                echo 400;
            }else{
                echo 404;
            } 
        }else{
            echo 500; //passwords not match
        }
    }else{
        echo 600;
    }//old password is incorrect
}

//view table of PENDING requests && delete rquests  StudentView 
if(!empty($_POST['action']) && $_POST['action'] == 'listSubmittedRequests'){
    $id = $_SESSION["id"];
    $sqlQuery = "SELECT id, request_name, form_request_type, receiver_name, date_sent FROM requests WHERE sender_id = '$id' and request_status = 'pending' ";
    $result = mysqli_query($con, $sqlQuery) or die(mysqli_error($con));
    $rows = mysqli_num_rows($result);
    $records = array();
    while( $record = mysqli_fetch_assoc($result) ) {
        $rows = array();
        $rows[] = $record['request_name'];
        $rows[] = $record['form_request_type'];
        $rows[] = $record['receiver_name'];
       
        $rows[] = $record['date_sent'];
        $rows[] = '<button type="button" name="delete" id="'.$record["id"].'" class="btn btn-danger btn-sm delete" >DELETE</button>           ';
        $records[] = $rows;
    }
    $output = array(
        "draw" => intval($_POST["draw"]),
        "recordsTotal" => count($records),
        "iTotalDisplayRecords" => count($records),
        "data" => $records
    );
    echo json_encode($output);

}else if(!empty($_POST['action']) && $_POST['action'] == 'deleteRecord' && $_POST["id"]) {
    $id = $_POST['id'];
    $query = "DELETE FROM requests WHERE id=?";
    $stmt = mysqli_prepare($con,$query);
    mysqli_stmt_bind_param($stmt,"s",$id);
    $result = mysqli_stmt_execute($stmt);

    if($result){
        $stmt->close();
        echo 1;
    }
    else{
        echo mysqli_error($db);
    }

}

if(($_SERVER["REQUEST_METHOD"] == "POST") && isset($_GET['a']) && $_GET['a']=="loadform"){
    $usert = $_SESSION["user_type"];
    if(!isset($_POST['searchTerm'])){ 
        
        $fetchData = mysqli_query($con,"select * from `forms` where initiator like '%".$usert."%' order by form_description limit 5");
    } else{ 
        $search = $_POST['searchTerm'];   
        $fetchData = mysqli_query($con,"select * from `forms` where initiator = '$usert' and form_description like '%".$search."%'");
    } 
      
    $data = array();
    while ($row = mysqli_fetch_array($fetchData)) {    
    $data[] = array("id"=>$row['form_code'], "text"=>$row['form_description']);
    }
    echo json_encode($data);
    
}

if(!empty($_POST['action']) && $_POST['action'] == 'listPendingRequest'){
    $id = $_SESSION["id"];
    $sqlQuery = "SELECT * FROM requests WHERE receiver_id = '$id' and request_status = 'pending' ";


    $result = mysqli_query($con, $sqlQuery) or die(mysqli_error($con));
    $rows = mysqli_num_rows($result);
    $records = array();

    while( $record = mysqli_fetch_assoc($result) ) {
        $sender_id = $record["sender_id"];

        $sql_two = "SELECT * FROM accounts WHERE user_id = '$sender_id'";
        $ans = mysqli_query($con, $sql_two) or die(mysqli_error($con));
        $r = mysqli_num_rows($result);
        while($rec_two = mysqli_fetch_assoc($ans)){
            $sender_name = $rec_two["user_name"];
        }

        $rows = array();
        $rows[] = $record['request_name'];
        $rows[] = $record['form_request_type'];
        $rows[] = $sender_name;
        $rows[] = $record['note'];
        $rows[] = $record['date_sent'];
        $rows[] = '<form id="formfield" style="display:inline" action="../assets/server/reg.php?action=resolveRequest" method="post"> 
                    <input name="id" type="hidden" value="'.$record["id"].'"> 
                    <button type="button" name="resolve" class="btn btn-info btn-sm resolve" id="submitBtn"  data-toggle="modal" data-target="#downloadModal">RESOLVE</button>
                   </form>                                                  
                <button type="button" name="delete" id="'.$record["id"].'" class="btn btn-danger btn-sm delete"  data-toggle="modal" data-target="#deleteModal">DELETE</button>';
        $records[] = $rows;
    }
    $output = array(
    "draw" => intval($_POST["draw"]),
    "recordsTotal" => count($records),
    "iTotalDisplayRecords" => count($records),
    "data" => $records
    );
    echo json_encode($output);

}else if(!empty($_POST['action']) && $_POST['action'] == 'deleteRequest' && $_POST["id"]) {
    $id = $_POST['id'];
    $query = "DELETE FROM requests WHERE id=?";
    $stmt = mysqli_prepare($con,$query);
    mysqli_stmt_bind_param($stmt,"s",$id);
    $result = mysqli_stmt_execute($stmt);

    if($result){
        $stmt->close();
        echo 1;
    }
    else{
        echo mysqli_error($con);
    }

}else if(($_SERVER["REQUEST_METHOD"] == "POST") && isset($_GET['action']) && $_GET['action']=="resolveRequest" ){
    $id = mysqli_real_escape_string($con,$_POST["id"]);
    echo "<script>alert(".$id.")</script>";
    $sql = "SELECT * FROM requests WHERE id='$id'";
    $result = mysqli_query($con, $sql) or die(mysqli_error($con));
    $rows = mysqli_num_rows($result);

    $records = mysqli_fetch_assoc($result);
    if($rows > 0){
        $request_name = $records['request_name'];
        // if(strlen($request_name) == 4){
        //     $req_id  = substr($request_name,-1);
        // }else{
        //     $req_id  = substr($request_name,-2);
        // }
        
    }
    $filepath = 'forms/uploads/' .$request_name.'.docx';
        
    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filepath));
        flush(); // Flush system output buffer
        readfile($filepath);
        unlink($filepath);
        die();        
        exit;
    }
    else{
        echo "<script>alert('File not exist')</script>";
        // http_response_code(404);
        // die();
    }

}

//upload a request // StaffView

if(($_SERVER["REQUEST_METHOD"] == "POST") && isset($_GET['action']) && $_GET['action']=="setresolved" ){
    $req_id = mysqli_real_escape_string($con,$_POST["form_name"]);
    $status = mysqli_real_escape_string($con,$_POST["status"]);
    $add_note = mysqli_real_escape_string($con,$_POST["name"]);

    if(!empty($_FILES['new_form']['name'])){
        $targetDir = "forms/uploads/";
        $fileName = basename($_FILES["new_form"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        if(move_uploaded_file($_FILES["new_form"]["tmp_name"], $targetFilePath)){
            $targetFilePath = "forms/uploads/".$fileName;
        }
    }else echo "nothing";

    $sql = "UPDATE requests SET request_status = 'RESOLVED' , note= '$add_note' WHERE id = '$req_id'";
    $result = mysqli_query($con, $sql) or die(mysqli_error($con));

    if($result){
        echo 400;
    }else{
        echo 500;
    }
}else if(!empty($_POST['action']) && $_POST['action'] == 'resolved'){
    $id = $_SESSION["id"];
    $sqlQuery = "SELECT request_name, form_request_type, sender_id, date_sent FROM requests WHERE receiver_id = '$id' AND request_status = 'resolved' ";
    $result = mysqli_query($con, $sqlQuery) or die(mysqli_error($con));
    $rows = mysqli_num_rows($result);
    $records = array();

    while( $record = mysqli_fetch_assoc($result) ) {
        $sender_id = $record["sender_id"];

        $sql_two = "SELECT * FROM accounts WHERE user_id = '$sender_id'";
        $ans = mysqli_query($con, $sql_two) or die(mysqli_error($con));
        while($rec_two = mysqli_fetch_assoc($ans)){
            $sender_name = $rec_two["user_name"];
        }
        $rows = array();
        $rows[] = $record['request_name'];
        $rows[] = $record['form_request_type'];
        $rows[] = $sender_name;
        $rows[] = $record['date_sent'];
        $records[] = $rows;

    }

    


    $output = array(
        "draw" => intval($_POST["draw"]),
        "recordsTotal" => count($records),
        "iTotalDisplayRecords" => count($records),
        "data" => $records
    );
    echo json_encode($output);
    

    exit;
}


//list resolved requests student view with download button

if(!empty($_POST['action']) && $_POST['action'] == 'listResolvedRequests'){
    $id = $_SESSION["id"];
    $sqlQuery = "SELECT * FROM requests WHERE sender_id = '$id' and request_status = 'resolved' ";


    $result = mysqli_query($con, $sqlQuery) or die(mysqli_error($con));
    $rows = mysqli_num_rows($result);
    $records = array();

    while( $record = mysqli_fetch_assoc($result) ) {
        $receiver_id = $record["receiver_id"];

        $sql_two = "SELECT * FROM accounts WHERE user_id = '$receiver_id'";
        $ans = mysqli_query($con, $sql_two) or die(mysqli_error($con));
        $r = mysqli_num_rows($result);
        while($rec_two = mysqli_fetch_assoc($ans)){
            $sender_name = $rec_two["user_name"];
        }

        $t = $record['date_resolved'];
        $date = substr($t,0,10);

        $rows = array();
        $rows[] = $record['request_name'];
        $rows[] = $record['form_request_type'];
        $rows[] = $sender_name;
        $rows[] = $record['resolve_note'];
        $rows[] = $date;
        $rows[] = '<form id="formfield" style="display:inline" action="../assets/server/reg.php?action=downloadResolved" method="post"> 
                    <input name="id" type="hidden" value="'.$record["id"].'"> 
                    <button type="button" name="resolve" class="btn btn-info btn-sm resolve" id="submitBtn"  data-toggle="modal" data-target="#downloadModal">DOWNLOAD</button>
                   </form>';
        $records[] = $rows;
    }
    $output = array(
    "draw" => intval($_POST["draw"]),
    "recordsTotal" => count($records),
    "iTotalDisplayRecords" => count($records),
    "data" => $records
    );
    echo json_encode($output);

}else if(($_SERVER["REQUEST_METHOD"] == "POST") && isset($_GET['action']) && $_GET['action']=="downloadResolved" ){
    $id = mysqli_real_escape_string($con,$_POST["id"]);
    echo "<script>alert(".$id.")</script>";
    $sql = "SELECT * FROM requests WHERE id='$id'";
    $result = mysqli_query($con, $sql) or die(mysqli_error($con));
    $rows = mysqli_num_rows($result);

    $records = mysqli_fetch_assoc($result);
    if($rows > 0){
        $request_name = $records['request_name'];
        // if(strlen($request_name) == 4){
        //     $req_id  = substr($request_name,-1);
        // }else{
        //     $req_id  = substr($request_name,-2);
        // }
        
    }
    $filepath = 'forms/uploads/' .$request_name.".docx";
        
    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filepath));
        flush(); // Flush system output buffer
        readfile($filepath);
        unlink($filepath);
        die();        
        exit;
    }
    else{
        echo "<script>alert('File not exist')</script>";
        // http_response_code(404);
        // die();
    }

}

if(($_SERVER["REQUEST_METHOD"] == "POST") && isset($_GET['action']) && $_GET['action']=="staffnewreq" ){
    $sender_id = $_SESSION["id"];
    $new_id = substr($sender_id, -3);//new sender id i.e. last 3 digits of user id

    $form_code = mysqli_real_escape_string($con,$_POST["form_name"]);
    $receiver_type = mysqli_real_escape_string($con,$_POST["receiver_role"]);
    $receiver_id = mysqli_real_escape_string($con,$_POST["receiver_id"]);
    $additional_note = mysqli_real_escape_string($con,$_POST["note"]);

    //Sql to get form description
    $s = "SELECT * FROM forms WHERE form_code = '$form_code'";
    $query = mysqli_query($con, $s) or die(mysqli_error($con));
    $rows = mysqli_num_rows($query);
    
    while($record = mysqli_fetch_assoc($query)){
        $form_request_type = $record["form_description"];
    }

    $request_name = $new_id.$form_code;

    $rec = "SELECT * FROM accounts WHERE user_id = '$receiver_id'";
    $rea = mysqli_query($con,$rec) or die(mysqli_error($con));

    if(mysqli_num_rows($rea) > 0){
        $row = mysqli_fetch_assoc($rea);
        $receiver_name = $row["user_name"];
    }

    $query = "INSERT INTO requests (request_name, form_request_type, sender_id, receiver_type, receiver_id, receiver_name, note) VALUES ('".$request_name."','".$form_request_type."','".$sender_id."','".$receiver_type."','".$receiver_id."','".$receiver_name."','".$additional_note."')";
    $result = mysqli_query($con, $query) or die(mysqli_error($con));
    if($result){
        echo 400;
    }else{
        echo 404;
    } 
}



?> 

 