<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
        
    <title>Sessions</title>
    <style>
        * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #F9EBEA; /* Creamy pink */
}

.container {
    display: flex;
    flex-direction: row;
}

.menu {
    width: 20%;
    height: 100vh;
    background-color: lightskyblue; /* Grayish blue */
    color: #FDFEFE; /* White */
}

.menu-container {
    width: 100%;
}

.profile-container {
    padding: 20px;
    text-align: center;
}

.profile-container img {
    border-radius: 50%;
    border: 2px solid #F4D03F; /* Yellow */
}

.profile-title {
    font-size: 24px; /* Larger font size */
    font-weight: bold;
    color: white; /* Purple */
    margin-bottom: 10px;
}

.profile-subtitle {
    font-size: 16px; /* Larger font size */
    color: white; /* Dark gray */
}

.logout-btn {
    margin-top: 20px;
    padding: 12px 24px; /* Larger padding */
    background-color: #C0392B; /* Red */
    color: #FFF;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.logout-btn:hover {
    background-color: #96281B; /* Darker red */
}

.dash-body {
    width: 80%;
    background-color: #FDFEFE; /* White */
    color: #17202A; /* Dark gray */
    padding: 20px;
}

.nav-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.header-search {
    display: flex;
    align-items: center;
}

.input-text {
    padding: 10px;
    border-radius: 8px; /* Rounded corners */
    border: 2px solid #D4AC0D; /* Gold */
    color: #17202A; /* Dark gray */
    background-color: transparent;
}

.login-btn {
    padding: 12px 24px; /* Larger padding */
    background-color: #117A65; /* Green */
    color: #FFF;
    border: none;
    border-radius: 8px; /* Rounded corners */
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.login-btn:hover {
    background-color: #0E6655; /* Darker green */
}

.heading-sub12 {
    font-size: 12px; /* Standard font size */
    color: #7F8C8D; /* Gray */
}

.heading-main12 {
    font-size: 16px; /* Larger font size */
    color: #17202A; /* Dark gray */
}

.filter-container {
    margin-bottom: 20px;
}

.dashboard-items {
    display: flex;
    align-items: center;
}

.dashboard-icons {
    width: 32px; /* Slightly larger icon */
    height: 32px; /* Slightly larger icon */
    background-size: cover;
    background-position: center;
    margin-left: 12px; /* Larger margin */
}

.scroll {
    overflow-y: auto;
}

.sub-table {
    width: 100%;
}

.table-heading {
    padding: 12px; /* Larger padding */
    font-weight: bold;
    color: #17202A; /* Dark gray */
    border-bottom: 2px solid #D4AC0D; /* Gold */
}

.table-row {
    border-bottom: 2px solid #D4AC0D; /* Gold */
}

.btn-primary {
    padding: 12px 24px; /* Larger padding */
    background-color: #F1C40F; /* Yellow */
    color: #17202A; /* Dark gray */
    border: none;
    border-radius: 8px; /* Rounded corners */
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn-primary:hover {
    background-color: #D4AC0D; /* Darker yellow */
}

.non-style-link {
    text-decoration: none;
    color: inherit;
}

</style>
</head>
<body>
    <?php

    //learn from w3schools.com

    session_start();

    if(isset($_SESSION["user"])){
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='p'){
            header("location: ../login.php");
        }else{
            $useremail=$_SESSION["user"];
        }

    }else{
        header("location: ../login.php");
    }
    

    //import database
    include("../connection.php");
    $sqlmain= "select * from patient where pemail=?";
    $stmt = $database->prepare($sqlmain);
    $stmt->bind_param("s",$useremail);
    $stmt->execute();
    $result = $stmt->get_result();
    $userfetch=$result->fetch_assoc();
    $userid= $userfetch["pid"];
    $username=$userfetch["pname"];


    //echo $userid;
    //echo $username;
    
    date_default_timezone_set('Asia/Kolkata');

    $today = date('Y-m-d');


 //echo $userid;
 ?>
 <div class="container">
     <div class="menu">
     <table class="menu-container" border="0">
             <tr>
                 <td style="padding:10px" colspan="2">
                     <table border="0" class="profile-container">
                         <tr>
                             <td width="30%" style="padding-left:20px" >
                                 <img src="../img/user.png" alt="" width="100%" style="border-radius:50%">
                             </td>
                             <td style="padding:0px;margin:0px;">
                                 <p class="profile-title"><?php echo substr($username,0,13)  ?>..</p>
                                 <p class="profile-subtitle"><?php echo substr($useremail,0,22)  ?></p>
                             </td>
                         </tr>
                         <tr>
                             <td colspan="2">
                                 <a href="../logout.php" ><input type="button" value="Log out" class="logout-btn btn-primary-soft btn"></a>
                             </td>
                         </tr>
                 </table>
                 </td>
             </tr>
             <tr class="menu-row" >
                    <td class="menu-btn menu-icon-home " >
                        <a href="index.php" class="non-style-link-menu "><div><p class="menu-text">Home</p></a></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-doctor">
                        <a href="doctors.php" class="non-style-link-menu"><div><p class="menu-text">All Doctors</p></a></div>
                    </td>
                </tr>
                
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-session menu-active menu-icon-session-active">
                        <a href="schedule.php" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">Scheduled Sessions</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-appoinment">
                        <a href="appointment.php" class="non-style-link-menu"><div><p class="menu-text">My Bookings</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-settings">
                        <a href="settings.php" class="non-style-link-menu"><div><p class="menu-text">Settings</p></a></div>
                    </td>
                </tr>
                
            </table>
        </div>
        <?php

                $sqlmain= "select * from schedule inner join doctor on schedule.docid=doctor.docid where schedule.scheduledate>='$today'  order by schedule.scheduledate asc";
                $sqlpt1="";
                $insertkey="";
                $q='';
                $searchtype="All";
                        if($_POST){
                        //print_r($_POST);
                        
                        if(!empty($_POST["search"])){
                            /*TODO: make and understand */
                            $keyword=$_POST["search"];
                            $sqlmain= "select * from schedule inner join doctor on schedule.docid=doctor.docid where schedule.scheduledate>='$today' and (doctor.docname='$keyword' or doctor.docname like '$keyword%' or doctor.docname like '%$keyword' or doctor.docname like '%$keyword%' or schedule.title='$keyword' or schedule.title like '$keyword%' or schedule.title like '%$keyword' or schedule.title like '%$keyword%' or schedule.scheduledate like '$keyword%' or schedule.scheduledate like '%$keyword' or schedule.scheduledate like '%$keyword%' or schedule.scheduledate='$keyword' )  order by schedule.scheduledate asc";
                            //echo $sqlmain;
                            $insertkey=$keyword;
                            $searchtype="Search Result : ";
                            $q='"';
                        }

                    }


                $result= $database->query($sqlmain)


                ?>
                  
        <div class="dash-body">
            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px; ">
                <tr >
                    <td width="13%" >
                    <a href="schedule.php" ><button  class="login-btn btn-primary-soft btn btn-icon-back"  style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px"><font class="tn-in-text">Back</font></button></a>
                    </td>
                    <td >
                            <form action="" method="post" class="header-search">

                                        <input type="search" name="search" class="input-text header-searchbar" placeholder="Search Doctor name or Email or Date (YYYY-MM-DD)" list="doctors" value="<?php  echo $insertkey ?>">&nbsp;&nbsp;
                                        
                                        <?php
                                            echo '<datalist id="doctors">';
                                            $list11 = $database->query("select DISTINCT * from  doctor;");
                                            $list12 = $database->query("select DISTINCT * from  schedule GROUP BY title;");
                                            

                                            


                                            for ($y=0;$y<$list11->num_rows;$y++){
                                                $row00=$list11->fetch_assoc();
                                                $d=$row00["docname"];
                                               
                                                echo "<option value='$d'><br/>";
                                               
                                            };


                                            for ($y=0;$y<$list12->num_rows;$y++){
                                                $row00=$list12->fetch_assoc();
                                                $d=$row00["title"];
                                               
                                                echo "<option value='$d'><br/>";
                                                                                         };

                                        echo ' </datalist>';
            ?>
                                        
                                
                                        <input type="Submit" value="Search" class="login-btn btn-primary btn" style="padding-left: 25px;padding-right: 25px;padding-top: 10px;padding-bottom: 10px;">
                                        </form>
                    </td>
                    <td width="15%">
                        <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                            Today's Date
                        </p>
                        <p class="heading-sub12" style="padding: 0;margin: 0;">
                            <?php 

                                
                                echo $today;

                                

                        ?>
                        </p>
                    </td>
                    <td width="10%">
                        <button  class="btn-label"  style="display: flex;justify-content: center;align-items: center;"><img src="../img/calendar.svg" width="100%"></button>
                    </td>


                </tr>
                
                
                <tr>
                    <td colspan="4" style="padding-top:10px;width: 100%;" >
                        <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)"><?php echo $searchtype." Sessions"."(".$result->num_rows.")"; ?> </p>
                        <p class="heading-main12" style="margin-left: 45px;font-size:22px;color:rgb(49, 49, 49)"><?php echo $q.$insertkey.$q ; ?> </p>
                    </td>
                    
                </tr>
                
                
                
                <tr>
                   <td colspan="4">
                       <center>
                        <div class="abc scroll">
                        <table width="100%" class="sub-table scrolldown" border="0" style="padding: 50px;border:none">
                            
                        <tbody>
                        
                            <?php

                                
                                

                                if($result->num_rows==0){
                                    echo '<tr>
                                    <td colspan="4">
                                    <br><br><br><br>
                                    <center>
                                    <img src="../img/notfound.svg" width="25%">
                                    
                                    <br>
                                    <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">We  couldnt find anything related to your keywords !</p>
                                    <a class="non-style-link" href="schedule.php"><button  class="login-btn btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Show all Sessions &nbsp;</font></button>
                                    </a>
                                    </center>
                                    <br><br><br><br>
                                    </td>
                                    </tr>';
                                    
                                }
                                else{
                                    //echo $result->num_rows;
                                for ( $x=0; $x<($result->num_rows);$x++){
                                    echo "<tr>";
                                    for($q=0;$q<3;$q++){
                                        $row=$result->fetch_assoc();
                                        if (!isset($row)){
                                            break;
                                        };
                                        $scheduleid=$row["scheduleid"];
                                        $title=$row["title"];
                                        $docname=$row["docname"];
                                        $scheduledate=$row["scheduledate"];
                                        $scheduletime=$row["scheduletime"];

                                        if($scheduleid==""){
                                            break;
                                        }

                                        echo '
                                        <td style="width: 25%;">
                                                <div  class="dashboard-items search-items"  >
                                                
                                                    <div style="width:100%">
                                                            <div class="h1-search">
                                                                '.substr($title,0,21).'
                                                            </div><br>
                                                            <div class="h3-search">
                                                                '.substr($docname,0,30).'
                                                            </div>
                                                            <div class="h4-search">
                                                                '.$scheduledate.'<br>Starts: <b>@'.substr($scheduletime,0,5).'</b> (24h)
                                                            </div>
                                                            <br>
                                                            <a href="booking.php?id='.$scheduleid.'" ><button  class="login-btn btn-primary-soft btn "  style="padding-top:11px;padding-bottom:11px;width:100%"><font class="tn-in-text">Book Now</font></button></a>
                                                    </div>
                                                            
                                                </div>
                                            </td>';

                                    }
                                    echo "</tr>";
                                    
                                    
                                    // echo '<tr>
                                    //     <td> &nbsp;'.
                                    //     substr($title,0,30)
                                    //     .'</td>
                                        
                                    //     <td style="text-align:center;">
                                    //         '.substr($scheduledate,0,10).' '.substr($scheduletime,0,5).'
                                    //     </td>
                                    //     <td style="text-align:center;">
                                    //         '.$nop.'
                                    //     </td>

                                    //     <td>
                                    //     <div style="display:flex;justify-content: center;">
                                        
                                    //     <a href="?action=view&id='.$scheduleid.'" class="non-style-link"><button  class="btn-primary-soft btn button-icon btn-view"  style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;"><font class="tn-in-text">View</font></button></a>
                                    //    &nbsp;&nbsp;&nbsp;
                                    //    <a href="?action=drop&id='.$scheduleid.'&name='.$title.'" class="non-style-link"><button  class="btn-primary-soft btn button-icon btn-delete"  style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;"><font class="tn-in-text">Cancel Session</font></button></a>
                                    //     </div>
                                    //     </td>
                                    // </tr>';
                                    
                                }
                            }
                                 
                            ?>
 
                            </tbody>

                        </table>
                        </div>
                        </center>
                   </td> 
                </tr>
                       
                        
                        
            </table>
        </div>
    </div>

    </div>

</body>
</html>
