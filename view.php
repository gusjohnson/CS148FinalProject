<?php
$baseURL = "https://www.uvm.edu/~gjohnso4/";
$folderPath = "cs148/assignment7.1/login/";
// full URL of this form 
$yourURL = $baseURL . $folderPath . "view.php";

require_once("connect.php");

function queryDatabase($qry, $dbase) {
    $dbase->beginTransaction();
    $dbase->query($qry);
    $dataEntered = $dbase->commit();
    return $dataEntered;
}

//############################################################################# 
// set all form variables to their default value on the form. for testing i set 
// to my email address. you lose 10% on your grade if you forget to change it. 

$email = "";
$firstName = "";
$lastName = "";
$birthday = "";
$userName = getenv('REMOTE_USER');

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

    print "<p>Email: " . $email . "";
    print "<p>First name: " . $firstName . "<br>";

// e-mail variables
    $messageA = "<h>Thanks for your submission.</h>";
    $messageB = "<p>Here is the data you entered:<br><br>E-mail: " . $email . "<br>";
    $messageB .= "First name: " . $firstName . "<br>Last name: " . $lastName . "</p>";
    $messageC = "";

    $subject = "UVM Skateboarding Database Contribution";
    include_once("mailMessage.php");
    $mailed = sendMail($email, $subject, $messageA . $messageB . $messageC);

    if ($mailed) {
        echo "Email successful.\n";
    } else {
        echo "Email failed.\n";
    }

    // $db->beginTransaction();
    $query = 'INSERT INTO tblUser SET fldFirstName = "' . $firstName . '",';
    $query .= 'fldLastName = "' . $lastName . '";';
    /* $stmt = $db->prepare($query);
    $stmt->execute();
    $success = $db->commit(); */
    
    $success = queryDatabase($query, $db);

    if ($success) {
        echo "Success.";
    } else {
        echo "Failure.";
    }
}

//} //btnSubmit actions

include ("top.php");

$ext = pathinfo(basename($_SERVER['PHP_SELF']));
$file_name = basename($_SERVER['PHP_SELF'], '.' . $ext['extension']);

print "\n\n";
print '<body id="' . $file_name . '">';
print "\n\n";

include ("header.php");
//print "\n\n";

include ("menu2.php");
?> 


<article>
    <h1>Online Skate Shop</h1>

    <?php
    echo "<p>Welcome, " . $userName . ".";
    ?>

    <!--   Take out enctype line    --> 
    <form action="<? print $_SERVER['PHP_SELF']; ?>" 
          enctype="multipart/form-data" 
          method="post" 
          id="frmRegister"> 
        <fieldset class="Submission"> 
            <legend>Please Register</legend> 

            <label class="required" for="txtEmail">Email: </label> 

            <input id ="txtEmail" name="txtEmail" class="element text medium<?php
    if ($emailERROR) {
        echo ' mistake';
    }
    ?>" type="text" maxlength="255" value="<?php echo $email; ?>" placeholder="enter your preferred email address" onfocus="this.select()"  tabindex="30"/> 
            <br>
            <label class="required" for="txtfirstName">First Name: </label> 

            <input id ="txtfirstName" name="txtfirstName" class="element text medium<?php
            if ($firstnameERROR) {
                echo ' mistake';
            }
    ?>" type="text" maxlength="255" value="<?php echo $firstName; ?>" placeholder="enter your first name" onfocus="this.select()"  tabindex="30"/> 
            <br>
            <label class="required" for="txtlastName">Last Name: </label> 

            <input id ="txtlastName" name="txtlastName" class="element text medium<?php
            if ($lastnameERROR) {
                echo ' mistake';
            }
    ?>" type="text" maxlength="255" value="<?php echo $lastName; ?>" placeholder="enter your last name" onfocus="this.select()"  tabindex="30"/> 


        </fieldset>  


        <fieldset class="buttons">
            <input type="submit" id="btnSubmit" name="btnSubmit" value="Register" tabindex="991" class="button">
            <input type="reset" id="butReset" name="butReset" value="Reset Form" tabindex="993" class="button" onclick="reSetForm()" > 
        </fieldset>                     

    </form>
    <br>

</article> 

<? 
include ("footer.php"); 
?> 

</body> 

</html>