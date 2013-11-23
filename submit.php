<?php
session_start();
$baseURL = "https://www.uvm.edu/~gjohnso4/";
$folderPath = "cs148/assignment7.1/login/";
// full URL of this form
$yourURL = $baseURL . $folderPath . "submit.php";

require_once("connect.php");
include("top.php");

//#############################################################################
// set all form variables to their default value on the form. for testing i set
// to my email address. you lose 10% on your grade if you forget to change it.

$email = "";
$firstName = "";
$lastName = "";
$userName = getenv('REMOTE_USER');


$mailed = false;
$success = false;
$_SESSION['submitted'] = true;
$messageA = "";
$messageB = "";
$messageC = "";


//include ("top.php");

$ext = pathinfo(basename($_SERVER['PHP_SELF']));
$file_name = basename($_SERVER['PHP_SELF'], '.' . $ext['extension']);

print "\n\n";
print '<body id="' . $file_name . '">';
print "\n\n";

include ("header2.php");
//print "\n\n";

include ("menu2.php");
?>


<article>
    <h1>Submit Information to Database</h1>

    <?php
    echo "<p>Welcome, " . $userName . ". Please select a type below and submit the information"
            . "to the database.";
    ?>

    <form action="<? print $_SERVER['PHP_SELF']; ?>"
          method="post"
          id="frmRegister">




        <fieldset class="listbox"><legend>Type</legend><select name="lstTables" value="' . <?php echo $selectedTable; ?> . '" size="1" tabindex="10">';
                <option value ="tblRestaurants">Restaurants</option>
                <option value ="tblBars">Bars</option>
                <option value ="tblRetail">Retail Stores</option>
                <option value ="tblOther">Other</option>
            </select><br>
            <input type='submit'  id='btnView' name='btnTables' value='View Genre' >

            <!--></fieldset><-->

            <?php
            $selectedTable = htmlentities($_POST["lstTables"], ENT_QUOTES, "UTF-8");

            
    //Sets up the form for bar submission
            if (isset($_POST["btnTables"]) AND $selectedTable == "tblBars") {
               ?>


            <fieldset class="Submission"> 
            <legend>Submit Info About a Bar</legend> 

            <label for="txtName">Bar Name: </label> 

            <input id ="txtName" name="txtName" class="element text medium" type="text" maxlength="255" value="<?php echo $barName; ?>" onfocus="this.select()"  tabindex="30"/> 
            <br>
            <label for="txtStreet">Street: </label> 

            <input id ="txtStreet" name="txtStreet" class="element text medium" type="text" maxlength="255" value="<?php echo $barStreet; ?>" onfocus="this.select()"  tabindex="30"/> 
            <br>
            <label for="txtDescription">Description: </label> 

            <input id ="txtDescription" name="txtDescription" class="element text medium" type="text" maxlength="255" value="<?php echo $barDescription; ?>" onfocus="this.select()"  tabindex="30"/> 

            <br>
            <input type="submit" id="btnSubmit" name="btnSubmit" value="Submit" tabindex="991" class="button">
            <input type="reset" id="butReset" name="butReset" value="Reset" tabindex="993" class="button" onclick="reSetForm()" > 
        </fieldset>
            <?php
            }
            ?>

                    <?php
                    if (isset($_POST["btnSubmit"])) {
                        $barName = htmlentities($_POST["txtName"], ENT_QUOTES, "UTF-8");
                        $barStreet = htmlentities($_POST["txtStreet"], ENT_QUOTES, "UTF-8");
                        $barDescription = htmlentities($_POST["txtDescription"], ENT_QUOTES, "UTF-8");
                        
                        
                        $query = 'INSERT INTO tblBars SET fldName = "' . $barName . '", ';
                        $query .= 'fldStreet = "' . $barStreet . '", fldDescription';
                        $query .= '= "' . $barDescription . '";';
                        
                        $success = queryDatabase($query, $db);
                        
                        if ($success){
                            echo "<p>Thanks for your submission.</p>";
                        }

                        
                    } //response to Submit button
                    ?>

            <?php
            //sets up the form for Restaurant submission
            if (isset($_POST["btnTables"]) AND $selectedTable == "tblRestaurants") {
               ?>


            <fieldset class="Submission"> 
            <legend>Submit Info About a Restaurant</legend> 

            <label for="txtName">Restaurant Name: </label> 

            <input id ="txtName" name="txtName" class="element text medium" type="text" maxlength="255" value="<?php echo $restaurantName; ?>" onfocus="this.select()"  tabindex="30"/> 
            <br>
            <label for="txtStreet">Street: </label> 

            <input id ="txtStreet" name="txtStreet" class="element text medium" type="text" maxlength="255" value="<?php echo $restaurantStreet; ?>" onfocus="this.select()"  tabindex="30"/> 
            <br>
            <label for="txtDescription">Description: </label> 

            <input id ="txtDescription" name="txtDescription" class="element text medium" type="text" maxlength="255" value="<?php echo $restaurantDescription; ?>" onfocus="this.select()"  tabindex="30"/> 

            <br>
            <input type="submit" id="btnSubmit1" name="btnSubmit1" value="Submit" tabindex="991" class="button">
            <input type="reset" id="butReset" name="butReset" value="Reset" tabindex="993" class="button" onclick="reSetForm()" > 
        </fieldset>
            <?php
            }
            ?>

                    <?php
                    if (isset($_POST["btnSubmit1"])) {
                        $restaurantName = htmlentities($_POST["txtName"], ENT_QUOTES, "UTF-8");
                        $restaurantStreet = htmlentities($_POST["txtStreet"], ENT_QUOTES, "UTF-8");
                        $restaurantDescription = htmlentities($_POST["txtDescription"], ENT_QUOTES, "UTF-8");
                        
                        
                        $query = 'INSERT INTO tblRestaurants SET fldName = "' . $restaurantName . '", ';
                        $query .= 'fldStreet = "' . $restaurantStreet . '", fldDescription';
                        $query .= '= "' . $restaurantDescription . '";';
                        
                        $success = queryDatabase($query, $db);
                        
                        if ($success){
                            echo "<p>Thanks for your submission.</p>";
                        }

                        
                    } //response to Submit button
                    ?>
                            
             <?php
            //sets up the form for Retail submission
            if (isset($_POST["btnTables"]) AND $selectedTable == "tblRetail") {
               ?>


            <fieldset class="Submission"> 
            <legend>Submit Info About a Store</legend> 

            <label for="txtName">Store Name: </label> 

            <input id ="txtName" name="txtName" class="element text medium" type="text" maxlength="255" value="<?php echo $retailName; ?>" onfocus="this.select()"  tabindex="30"/> 
            <br>
            <label for="txtStreet">Street: </label> 

            <input id ="txtStreet" name="txtStreet" class="element text medium" type="text" maxlength="255" value="<?php echo $retailStreet; ?>" onfocus="this.select()"  tabindex="30"/> 
            <br>
            <label for="txtDescription">Description: </label> 

            <input id ="txtDescription" name="txtDescription" class="element text medium" type="text" maxlength="255" value="<?php echo $retailDescription; ?>" onfocus="this.select()"  tabindex="30"/> 

            <br>
            <input type="submit" id="btnSubmit2" name="btnSubmit2" value="Submit" tabindex="991" class="button">
            <input type="reset" id="butReset" name="butReset" value="Reset" tabindex="993" class="button" onclick="reSetForm()" > 
        </fieldset>
            <?php
            }
            ?>

                    <?php
                    if (isset($_POST["btnSubmit2"])) {
                        $retailName = htmlentities($_POST["txtName"], ENT_QUOTES, "UTF-8");
                        $retailStreet = htmlentities($_POST["txtStreet"], ENT_QUOTES, "UTF-8");
                        $retailDescription = htmlentities($_POST["txtDescription"], ENT_QUOTES, "UTF-8");
                        
                        
                        $query = 'INSERT INTO tblRetail SET fldName = "' . $retailName . '", ';
                        $query .= 'fldStreet = "' . $retailStreet . '", fldDescription';
                        $query .= '= "' . $retailDescription . '";';
                        
                        $success = queryDatabase($query, $db);
                        
                        if ($success){
                            echo "<p>Thanks for your submission.</p>";
                        }

                        
                    } //response to Submit button
                    ?>
                    
            <?php
            //sets up the form for Other submission
            if (isset($_POST["btnTables"]) AND $selectedTable == "tblOther") {
               ?>


            <fieldset class="Submission"> 
            <legend>Submit Info About Anything Else</legend> 

            <label for="txtName">Other Name: </label> 

            <input id ="txtName" name="txtName" class="element text medium" type="text" maxlength="255" value="<?php echo $otherName; ?>" onfocus="this.select()"  tabindex="30"/> 
            <br>
            <label for="txtStreet">Street: </label> 

            <input id ="txtStreet" name="txtStreet" class="element text medium" type="text" maxlength="255" value="<?php echo $otherStreet; ?>" onfocus="this.select()"  tabindex="30"/> 
            <br>
            <label for="txtDescription">Description: </label> 

            <input id ="txtDescription" name="txtDescription" class="element text medium" type="text" maxlength="255" value="<?php echo $otherDescription; ?>" onfocus="this.select()"  tabindex="30"/> 

            <br>
            <input type="submit" id="btnSubmit3" name="btnSubmit3" value="Submit" tabindex="991" class="button">
            <input type="reset" id="butReset" name="butReset" value="Reset" tabindex="993" class="button" onclick="reSetForm()" > 
        </fieldset>
            <?php
            }
            ?>

                    <?php
                    if (isset($_POST["btnSubmit3"])) {
                        $otherName = htmlentities($_POST["txtName"], ENT_QUOTES, "UTF-8");
                        $otherStreet = htmlentities($_POST["txtStreet"], ENT_QUOTES, "UTF-8");
                        $otherDescription = htmlentities($_POST["txtDescription"], ENT_QUOTES, "UTF-8");
                        
                        
                        $query = 'INSERT INTO tblOther SET fldName = "' . $otherName . '", ';
                        $query .= 'fldStreet = "' . $otherStreet . '", fldDescription';
                        $query .= '= "' . $otherDescription . '";';
                        
                        $success = queryDatabase($query, $db);
                        
                        if ($success){
                            echo "<p>Thanks for your submission.</p>";
                        }

                        
                    } //response to Submit button
                    ?>


                <br>
                </article>

                <?php
                include ("footer.php");
                ?>

                </body>

                </html>