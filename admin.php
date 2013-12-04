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
echo "<br>";

include ("menu2.php");
?>


<article>
    <h1>Manage Database Information</h1>

    <?php
    echo "<p>Welcome, " . $userName . ". Please select a type below to manage the information.";
    ?>

    <form action="<? print $_SERVER['PHP_SELF']; ?>"
          method="post"
          id="frmRegister">




        <fieldset class="listbox"><legend>Type</legend>
            <p>Select a type of data and click "Edit Genre" to manage existing
                data or click "Add to Genre" to make a new submission.</p>
            <select name="lstTables" size="1" tabindex="10">
                <option value ="tblRestaurants">Restaurants</option>
                <option value ="tblBars">Bars</option>
                <option value ="tblRetail">Retail Stores</option>
                <option value ="tblOther">Other</option>
            </select><br>
            <input type='submit'  id='btnEdit' name='btnEdit' value='Edit Genre' >
            <input type='submit' id='btnAdd' name='btnAdd' value='Add to Genre' >
        </fieldset>


        <?php
        $selectedTable = htmlentities($_POST["lstTables"], ENT_QUOTES, "UTF-8");


//####################################################
//Sets up the admin to manage bar data
//####################################################
        //#########################################################
        //This sets up the form if the admin wants to add a bar
        //#########################################################

        if (isset($_POST["btnAdd"]) AND $selectedTable == "tblBars") {
            ?>

            <fieldset class="Submission"> 
                <legend>Bar Information</legend> 

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
        } //btnAdd post


        if (isset($_POST["btnSubmit"])) {
            $barName = htmlentities($_POST["txtName"], ENT_QUOTES, "UTF-8");
            $barStreet = htmlentities($_POST["txtStreet"], ENT_QUOTES, "UTF-8");
            $barDescription = htmlentities($_POST["txtDescription"], ENT_QUOTES, "UTF-8");


            $query = 'INSERT INTO tblBars SET fldName = "' . $barName . '", ';
            $query .= 'fldStreet = "' . $barStreet . '", fldDescription';
            $query .= '= "' . $barDescription . '", fkUsername = "' . $userName . '";';

            $success = queryDatabase($query, $db);

            if ($success) {
                echo "<p>Thanks for your submission.</p>";
            }
        } //response to Submit button
        
        //########################################################################
        //This sets up the form if the admin wants to update or delete a bar
        //########################################################################

        if (isset($_POST["btnEdit"]) AND $selectedTable == "tblBars") {
            $sql = 'SELECT pkBarID, fldName, fldStreet ';
            $sql .= 'FROM tblBars ';
            $sql .= 'ORDER BY fldName;';
            if ($debug)
                print "<p>sql " . $sql;

            $names = showDatabaseInfo($sql, $db);
            ?>


            <fieldset class="listbox"><legend>Bars</legend>
                <p>The first list is the list of bars. The second is the 
                    list of attributes of those bars. To delete a bar, simply
                    select a bar from the first list and click "Delete Info."
                    To edit information about a bar, select a bar from the first
                    list, select an attribute from the second list, type the
                    new information in the text box, and click "Update Info."</p><br>
                <select name="lstBars" value="' . <?php echo $selectedBar; ?> . '" size="1" tabindex="10">

    <?php
    foreach ($names as $name) {
        print '<option value="' . $name['fldName'] . '">' . $name['fldName'] . '</option>\n';
    }

    print "</select><br>";
    ?>

                    <select name ='lstFields' value='" <?php echo $selectedField; ?> "' size="1" tabindex="10">
                        <option value ="pkBarID">Bar ID</option>
                        <option value ="fldName">Bar Name</option>
                        <option value ="fldStreet">Bar Street</option>
                        <option value ="fldDescription">Bar Description</option>
                    </select><br>
                    <label for="txtInfo">Info: </label> 
                    <input id ="txtInfo" name="txtInfo" class="element text medium" type="text" maxlength="255" value="<?php echo $editInfo; ?>" onfocus="this.select()"  > 
                    <br>
                    <input type='submit' id='btnUpdate' name ='btnUpdate' value ='Update Info' >";
                    <input type='submit' id='btnDelete' name='btnDelete' value='Delete Info'>";
                    </fieldset>

    <?php
}

if (isset($_POST["btnDelete"])) {
    $selectedBar = htmlentities($_POST["lstBars"], ENT_QUOTES, "UTF-8");
    $query = 'DELETE FROM tblBars WHERE fldName = "' . $selectedBar . '";';
    $success = queryDatabase($query, $db);
    if ($success) {
        echo"<p>" . $selectedBar . " deleted.</p>";
    }
}

if (isset($_POST["btnUpdate"])) {
    $selectedBar = htmlentities($_POST["lstBars"], ENT_QUOTES, "UTF-8");
    $selectedField = htmlentities($_POST["lstFields"], ENT_QUOTES, "UTF-8");
    $editInfo = htmlentities($_POST["txtInfo"], ENT_QUOTES, "UTF-8");
    $query = 'UPDATE tblBars SET ' . $selectedField . ' ="' . $editInfo . '" WHERE fldName="' . $selectedBar . '";';
    $success = queryDatabase($query, $db);
    if ($success) {
        echo "<p>" . $selectedBar . " edited.</p>";
    }
}

        
//####################################################
//Sets up the admin to manage restaurant data
//####################################################
        //#########################################################
        //This sets up the form if the admin wants to add a restaurant
        //#########################################################

        if (isset($_POST["btnAdd"]) AND $selectedTable == "tblRestaurants") {
            ?>

            <fieldset class="Submission"> 
                <legend>Restaurant Information</legend> 

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
        } //btnAdd post


        if (isset($_POST["btnSubmit1"])) {
            $restaurantName = htmlentities($_POST["txtName"], ENT_QUOTES, "UTF-8");
            $restaurantStreet = htmlentities($_POST["txtStreet"], ENT_QUOTES, "UTF-8");
            $restaurantDescription = htmlentities($_POST["txtDescription"], ENT_QUOTES, "UTF-8");


            $query = 'INSERT INTO tblRestaurants SET fldName = "' . $restaurantName . '", ';
            $query .= 'fldStreet = "' . $restaurantStreet . '", fldDescription';
            $query .= '= "' . $restaurantDescription . '", fkUsername = "' . $userName . '";';

            $success = queryDatabase($query, $db);

            if ($success) {
                echo "<p>Thanks for your submission.</p>";
            }
        } //response to Submit button
        
        //########################################################################
        //This sets up the form if the admin wants to update or delete a restaurant
        //########################################################################

        if (isset($_POST["btnEdit"]) AND $selectedTable == "tblRestaurants") {
            $sql = 'SELECT pkRestID, fldName, fldStreet ';
            $sql .= 'FROM tblRestaurants ';
            $sql .= 'ORDER BY fldName;';
            if ($debug)
                print "<p>sql " . $sql;

            $names = showDatabaseInfo($sql, $db);
            ?>


            <fieldset class="listbox"><legend>Restaurants</legend>
                <p>The first list is the list of restaurants. The second is the 
                    list of attributes of those restaurants. To delete a restaurant, simply
                    select a restaurant from the first list and click "Delete Info."
                    To edit information about a restaurant, select one from the first
                    list, select an attribute from the second list, type the
                    new information in the text box, and click "Update Info."</p><br>
                <select name="lstRestaurants" value="' . <?php echo $selectedRestaurant; ?> . '" size="1" tabindex="10">

    <?php
    foreach ($names as $name) {
        print '<option value="' . $name['fldName'] . '">' . $name['fldName'] . '</option>\n';
    }

    print "</select><br>";
    ?>

                    <select name ='lstFields' value='" <?php echo $selectedField; ?> "' size="1" tabindex="10">
                        <option value ="pkRestID">Restaurant ID</option>
                        <option value ="fldName">Restaurant Name</option>
                        <option value ="fldStreet">Restaurant Street</option>
                        <option value ="fldDescription">Restaurant Description</option>
                    </select><br>
                    <label for="txtInfo">Info: </label> 
                    <input id ="txtInfo" name="txtInfo" class="element text medium" type="text" maxlength="255" value="<?php echo $editInfo; ?>" onfocus="this.select()"  > 
                    <br>
                    <input type='submit' id='btnUpdate1' name ='btnUpdate1' value ='Update Info' >";
                    <input type='submit' id='btnDelete1' name='btnDelete1' value='Delete Info'>";
                    </fieldset>

    <?php
}

if (isset($_POST["btnDelete1"])) {
    $selectedRestaurant = htmlentities($_POST["lstRestaurants"], ENT_QUOTES, "UTF-8");
    $query = 'DELETE FROM tblRestaurants WHERE fldName = "' . $selectedRestaurant . '";';
    $success = queryDatabase($query, $db);
    /*if ($success) {
        echo"<p>" . $selectedRestaurant . " deleted.</p>";
    }*/
}

if (isset($_POST["btnUpdate1"])) {
    $selectedRestaurant = htmlentities($_POST["lstRestaurants"], ENT_QUOTES, "UTF-8");
    $selectedField = htmlentities($_POST["lstFields"], ENT_QUOTES, "UTF-8");
    $editInfo = htmlentities($_POST["txtInfo"], ENT_QUOTES, "UTF-8");
    $query = 'UPDATE tblRestaurants SET ' . $selectedField . ' ="' . $editInfo . '" WHERE fldName="' . $selectedRestaurant . '";';
    $success = queryDatabase($query, $db);
    if ($success) {
        echo "<p>" . $selectedRestaurant . " edited.</p>";
    }
}

//####################################################
//Sets up the admin to manage retail data
//####################################################
        //#########################################################
        //This sets up the form if the admin wants to add a store
        //#########################################################

        if (isset($_POST["btnAdd"]) AND $selectedTable == "tblRetail") {
            ?>

            <fieldset class="Submission"> 
                <legend>Retail Information</legend> 

                <label for="txtName">Retail Store Name: </label> 

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
        } //btnAdd post


        if (isset($_POST["btnSubmit2"])) {
            $retailName = htmlentities($_POST["txtName"], ENT_QUOTES, "UTF-8");
            $retailStreet = htmlentities($_POST["txtStreet"], ENT_QUOTES, "UTF-8");
            $retailDescription = htmlentities($_POST["txtDescription"], ENT_QUOTES, "UTF-8");


            $query = 'INSERT INTO tblRetail SET fldName = "' . $retailName . '", ';
            $query .= 'fldStreet = "' . $retailStreet . '", fldDescription';
            $query .= '= "' . $retailDescription . '", fkUsername = "' . $userName . '";';

            $success = queryDatabase($query, $db);

            if ($success) {
                echo "<p>Thanks for your submission.</p>";
            }
        } //response to Submit button
        
        //########################################################################
        //This sets up the form if the admin wants to update or delete a store
        //########################################################################

        if (isset($_POST["btnEdit"]) AND $selectedTable == "tblRetail") {
            $sql = 'SELECT pkRetailID, fldName, fldStreet ';
            $sql .= 'FROM tblRetail ';
            $sql .= 'ORDER BY fldName;';
            if ($debug)
                print "<p>sql " . $sql;

            $names = showDatabaseInfo($sql, $db);
            ?>


            <fieldset class="listbox"><legend>Retail Stores</legend>
                <p>The first list is the list of stores. The second is the 
                    list of attributes of those stores. To delete a store, simply
                    select one from the first list and click "Delete Info."
                    To edit information about a store, select one from the first
                    list, select an attribute from the second list, type the
                    new information in the text box, and click "Update Info."</p><br>
                <select name="lstRetail" value="' . <?php echo $selectedRetail; ?> . '" size="1" tabindex="10">

    <?php
    foreach ($names as $name) {
        print '<option value="' . $name['fldName'] . '">' . $name['fldName'] . '</option>\n';
    }

    print "</select><br>";
    ?>

                    <select name ='lstFields' value='" <?php echo $selectedField; ?> "' size="1" tabindex="10">
                        <option value ="pkRetailID">Retail ID</option>
                        <option value ="fldName">Retail Name</option>
                        <option value ="fldStreet">Retail Street</option>
                        <option value ="fldDescription">Retail Description</option>
                    </select><br>
                    <label for="txtInfo">Info: </label> 
                    <input id ="txtInfo" name="txtInfo" class="element text medium" type="text" maxlength="255" value="<?php echo $editInfo; ?>" onfocus="this.select()"  > 
                    <br>
                    <input type='submit' id='btnUpdate2' name ='btnUpdate2' value ='Update Info' >";
                    <input type='submit' id='btnDelete2' name='btnDelete2' value='Delete Info'>";
                    </fieldset>

    <?php
}

if (isset($_POST["btnDelete2"])) {
    $selectedRetail = htmlentities($_POST["lstRetail"], ENT_QUOTES, "UTF-8");
    $query = 'DELETE FROM tblRetail WHERE fldName = "' . $selectedRetail . '";';
    $success = queryDatabase($query, $db);
    if ($success) {
        echo"<p>" . $selectedRestaurant . " deleted.</p>";
    }
}

if (isset($_POST["btnUpdate2"])) {
    $selectedRetail = htmlentities($_POST["lstRetail"], ENT_QUOTES, "UTF-8");
    $selectedField = htmlentities($_POST["lstFields"], ENT_QUOTES, "UTF-8");
    $editInfo = htmlentities($_POST["txtInfo"], ENT_QUOTES, "UTF-8");
    $query = 'UPDATE tblRetail SET ' . $selectedField . ' ="' . $editInfo . '" WHERE fldName="' . $selectedRetail . '";';
    $success = queryDatabase($query, $db);
    if ($success) {
        echo "<p>" . $selectedRetail . " edited.</p>";
    }
}

//####################################################
//Sets up the admin to manage other data
//####################################################
        //#########################################################
        //This sets up the form if the admin wants to add
        //#########################################################

        if (isset($_POST["btnAdd"]) AND $selectedTable == "tblOther") {
            ?>

            <fieldset class="Submission"> 
                <legend>Information</legend> 

                <label for="txtName">Other Name: </label> 

                <input id ="txtName" name="txtName" class="element text medium" type="text" maxlength="255" value="<?php echo $otherName; ?>" onfocus="this.select()"  tabindex="30"/> 
                <br>
                <label for="txtStreet">Street: </label> 

                <input id ="txtStreet" name="txtStreet" class="element text medium" type="text" maxlength="255" value="<?php echo $otherStreet; ?>" onfocus="this.select()"  tabindex="30"/> 
                <br>
                <label for="txtDescription">Description: </label> 

                <input id ="txtDescription" name="txtDescription" class="element text medium" type="text" maxlength="255" value="<?php echo $otherDescription; ?>" onfocus="this.select()"  tabindex="30"/> 

                <br>
                <input type="submit" id="btnSubmit2" name="btnSubmit3" value="Submit" tabindex="991" class="button">
                <input type="reset" id="butReset" name="butReset" value="Reset" tabindex="993" class="button" onclick="reSetForm()" > 
            </fieldset>
            <?php
        } //btnAdd post


        if (isset($_POST["btnSubmit3"])) {
            $otherName = htmlentities($_POST["txtName"], ENT_QUOTES, "UTF-8");
            $otherStreet = htmlentities($_POST["txtStreet"], ENT_QUOTES, "UTF-8");
            $otherDescription = htmlentities($_POST["txtDescription"], ENT_QUOTES, "UTF-8");


            $query = 'INSERT INTO tblOther SET fldName = "' . $otherName . '", ';
            $query .= 'fldStreet = "' . $otherStreet . '", fldDescription';
            $query .= '= "' . $otherDescription . '", fkUsername = "' . $userName . '";';

            $success = queryDatabase($query, $db);

            if ($success) {
                echo "<p>Thanks for your submission.</p>";
            }
        } //response to Submit button
        
        //########################################################################
        //This sets up the form if the admin wants to update or delete an entry
        //########################################################################

        if (isset($_POST["btnEdit"]) AND $selectedTable == "tblOther") {
            $sql = 'SELECT pkOtherID, fldName, fldStreet ';
            $sql .= 'FROM tblOther ';
            $sql .= 'ORDER BY fldName;';
            if ($debug)
                print "<p>sql " . $sql;

            $names = showDatabaseInfo($sql, $db);
            ?>


            <fieldset class="listbox"><legend>Other Entries</legend>
                <p>The first list is the list of other entries. The second is the 
                    list of attributes of those entries. To delete an entry, simply
                    select one from the first list and click "Delete Info."
                    To edit information about an entry, select one from the first
                    list, select an attribute from the second list, type the
                    new information in the text box, and click "Update Info."</p><br>
                <select name="lstOther" value="' . <?php echo $selectedOther; ?> . '" size="1" tabindex="10">

    <?php
    foreach ($names as $name) {
        print '<option value="' . $name['fldName'] . '">' . $name['fldName'] . '</option>\n';
    }

    print "</select><br>";
    ?>

                    <select name ='lstFields' value='" <?php echo $selectedField; ?> "' size="1" tabindex="10">
                        <option value ="pkOtherID">ID</option>
                        <option value ="fldName">Name</option>
                        <option value ="fldStreet">Street</option>
                        <option value ="fldDescription">Description</option>
                    </select><br>
                    <label for="txtInfo">Info: </label> 
                    <input id ="txtInfo" name="txtInfo" class="element text medium" type="text" maxlength="255" value="<?php echo $editInfo; ?>" onfocus="this.select()"  > 
                    <br>
                    <input type='submit' id='btnUpdate3' name ='btnUpdate3' value ='Update Info' >";
                    <input type='submit' id='btnDelete3' name='btnDelete3' value='Delete Info'>";
                    </fieldset>

    <?php
}

if (isset($_POST["btnDelete3"])) {
    $selectedOther = htmlentities($_POST["lstOther"], ENT_QUOTES, "UTF-8");
    $query = 'DELETE FROM tblOther WHERE fldName = "' . $selectedOther . '";';
    $success = queryDatabase($query, $db);
    if ($success) {
        echo"<p>" . $selectedOther . " deleted.</p>";
    }
}

if (isset($_POST["btnUpdate3"])) {
    $selectedOther = htmlentities($_POST["lstOther"], ENT_QUOTES, "UTF-8");
    $selectedField = htmlentities($_POST["lstFields"], ENT_QUOTES, "UTF-8");
    $editInfo = htmlentities($_POST["txtInfo"], ENT_QUOTES, "UTF-8");
    $query = 'UPDATE tblOther SET ' . $selectedField . ' ="' . $editInfo . '" WHERE fldName="' . $selectedOther . '";';
    $success = queryDatabase($query, $db);
    if ($success) {
        echo "<p>" . $selectedOther . " edited.</p>";
    }
}
?>




    </form>
                <br>
                </article>


<?php
include ("footer.php");
?>

                </body>

                </html>