<?php
session_start();
//$_SESSION['submitted'] = false;
$baseURL = "https://www.uvm.edu/~gjohnso4/";
$folderPath = "cs148/assignment7.1/login/";
// full URL of this form 
$yourURL = $baseURL . $folderPath . "main2.php";

require_once("connect.php");


//############################################################################# 
// set all form variables to their default value on the form. for testing i set 
// to my email address. you lose 10% on your grade if you forget to change it. 

$email = "";
$firstName = "";
$lastName = "";
$userName = getenv('REMOTE_USER');

include("top.php");

$addUser = 'INSERT INTO tblUsernames SET pkUsername = "' . $userName . '";';
queryDatabase($addUser, $db);

$mailed = false;
$success = false;
$messageA = "";
$messageB = "";
$messageC = "";

if (isset($_POST["btnSubmit"])) {

    $fromPage = getenv("http_referer");

    if ($fromPage != $yourURL) {
        die("<p>Sorry you cannot access this page. Security breach detected and reported.</p>");
    }


// gets form values
    $email = htmlentities($_POST["txtEmail"], ENT_QUOTES, "UTF-8");
    $firstName = htmlentities($_POST["txtfirstName"], ENT_QUOTES, "UTF-8");
    $lastName = htmlentities($_POST["txtlastName"], ENT_QUOTES, "UTF-8");


// e-mail variables
    $messageA = "<h>Thanks for your submission.</h>";
    $messageB = "<p>Here is the data you entered:</p><br><p>E-mail: " . $email . "</p>";
    $messageB .= "<p>First name: " . $firstName . "</p><p>Last name: " . $lastName . "</p></p>";
    $messageC = "";

    $subject = "UVM Off-Campus Reference Guide Contribution";
    include_once("mailMessage.php");
    $mailed = sendMail($email, $subject, $messageA . $messageB . $messageC);

    $query = 'INSERT INTO tblUser SET fldFirstName = "' . $firstName . '",';
    $query .= 'fldLastName = "' . $lastName . '", fldEmail = "' . $email . '",'
            . 'fkUsername = "' . $userName . '";';
    
    $success = queryDatabase($query, $db);

}



$ext = pathinfo(basename($_SERVER['PHP_SELF']));
$file_name = basename($_SERVER['PHP_SELF'], '.' . $ext['extension']);

print "\n\n";
print '<body id="' . $file_name . '">';
print "\n\n";

include ("header2.php");
print "<br>";

include ("menu2.php");

?> 


<article>
    <h1>UVM Off-Campus Reference Guide</h1>

    <?php
    echo "<p>Welcome, " . $userName . ". This is UVM's unofficial reference guide for living off-campus. " . 
            "As a senior, I've learned that living off-campus is completely " .
            "different than living on-campus. You really get a feel for the area " .
            "and begin to feel like a local. The purpose of this website is to " .
            "provide a space to enter or view information about anything students " .
            "might find interesting or helpful. This includes restaurants, bars, " .
            "supermarkets, gas stations, etc. Please input your " .
            "e-mail and name below to view or submit to the database.</p><br>";

    
    if (isset($_POST["btnSubmit"])) { 
            print "<article id='info'><h2>Thanks. Your submission has "; 

            if (!$mailed AND !$success) { 
                echo "not "; 
            } 

            echo "been processed.</h2>"; 

            print "<p>A copy of the info you submitted has "; 
            if (!$mailed) { 
                echo "not "; 
            } 
            print "been sent to " . $email . " and has been inserted into our database.</p>"; 

            
            echo $messageB . $messageC;
            print "</article>";
            $_SESSION['submitted'] = true;
        } 
        else if ($_SESSION['submitted'] == true){
            print "<article id='info'><h2>Thanks for registering.</h2></article>";
        }
        else { 
            
        ?>
    
    
    <!--   Take out enctype line    --> 
    <form action="<? print $_SERVER['PHP_SELF']; ?>" 
          enctype="multipart/form-data" 
          method="post" 
          id="frmRegister" onsubmit="window.location.reload()"> 
        <fieldset class="Submission"> 
            <legend>Please Register</legend> 

            <label for="txtEmail">UVM E-mail: </label> 

            <input id ="txtEmail" name="txtEmail" class="element text medium<?php
    if ($emailERROR) {
        echo ' mistake';
    }
    ?>" type="text" maxlength="255" value="<?php echo $email; ?>" onfocus="this.select()"  tabindex="30"/> 
            <br>
            <label for="txtfirstName">First Name: </label> 

            <input id ="txtfirstName" name="txtfirstName" class="element text medium<?php
            if ($firstnameERROR) {
                echo ' mistake';
            }
    ?>" type="text" maxlength="255" value="<?php echo $firstName; ?>" onfocus="this.select()"  tabindex="30"/> 
            <br>
            <label for="txtlastName">Last Name: </label> 

            <input id ="txtlastName" name="txtlastName" class="element text medium<?php
            if ($lastnameERROR) {
                echo ' mistake';
            }
    ?>" type="text" maxlength="255" value="<?php echo $lastName; ?>" onfocus="this.select()"  tabindex="30"/> 


        </fieldset>  


        <fieldset class="buttons">
            <input type="submit" id="btnSubmit" name="btnSubmit" value="Register" tabindex="991" class="button">
            <input type="reset" id="butReset" name="butReset" value="Reset Form" tabindex="993" class="button" onclick="reSetForm()" > 
        </fieldset>                     

    </form>
    <br>

     <?php
        }
        ?>
    
</article> 

<? 
include ("footer.php"); 
?> 

</body> 

</html>