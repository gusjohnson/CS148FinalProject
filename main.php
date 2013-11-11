<?php
require_once("connect.php");

//############################################################################# 
// set all form variables to their default value on the form. for testing i set 
// to my email address. you lose 10% on your grade if you forget to change it. 

$email = "";
$firstName = "";
$lastName = "";
$birthday = "";




include ("top.php");

$ext = pathinfo(basename($_SERVER['PHP_SELF']));
$file_name = basename($_SERVER['PHP_SELF'], '.' . $ext['extension']);

print "\n\n";
print '<body id="' . $file_name . '">';
print "\n\n";

include ("header.php");
print "\n\n";

include ("menu.php");
?> 

<article>
    <h1>Online Skate Shop</h1>
    <p>
        Welcome to my website. Please register below.

        <br>

    </p>


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


</article> 

<? 
include ("footer.php"); 
?> 

</body> 

</html>