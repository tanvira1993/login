<?php
    session_start();
    

    
    $db =  mysqli_connect("localhost", "root", "", "login");
    
    if ($db) {
        $select_db = mysqli_select_db($db, "login");
        
        if ($select_db) {
           $_SESSION['isFound'] = false;
            $email = false;


            if (isset($_POST['email'])) {
                $email = $_POST['email'];
            }

             $password = false;

            if (isset ($_POST['password'])) {
                $salt = "lolcum";
                $password =( $_POST['password']);
            }

            $query = "SELECT * FROM login  where email='$email' and password='$password'";
            //query for matching user 

            $result = mysqli_query($db, $query);
            
            $data=mysqli_fetch_assoc($result);
                if(mysqli_num_rows($result)>0)
                {
                    $attempt=(int)$data["attempt"]; // set attemp number for blocking purpose
                    if($attempt>4)//when  attemp is greater than value 
                    {
                        $error="";
                        if($attempt<5) //wrong pass or id
                            $error="Incorrect Username or password";


                        else 
                            $error="You're Blocked, Please contact an administrator";
                        $_SESSION["error"]=$error;

                        header("location: login.php");
                    }
                    else{ //check only email correct or not for paticular blocking. 
                        mysqli_query($db,"UPDATE login set attempt='0' where email='$email'");
                        header("location:profile.html");
                        $_SESSION['user']=$data;
                    }
                    die();
                } 
                else
                {
                    $quer = "SELECT * FROM login where email='$email'";
                    $result = mysqli_query($db, $quer);
                    $data=mysqli_fetch_assoc($result);
                    $attempt=(int)$data["attempt"];
                    if($attempt<6)
                        $attempt=$attempt+1;
                    //attemp set 0 for new time seesion when pass is correct.
                    mysqli_query($db,"UPDATE login set attempt='$attempt' where email='$email'");
                    $error="Incorrect";
                    if($attempt<5)
                        $error="Incorrect Username or password";

                    else
                        $error="You're Blocked, Please contact an administrator";

                    $_SESSION["error"]=$error;
                    header("location: login.php");

                }  



                mysqli_close($db);


                exit;
            
        }
    }
        
    
?>