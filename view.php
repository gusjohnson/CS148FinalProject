<?php
session_start();
$baseURL = "https://www.uvm.edu/~gjohnso4/";
$folderPath = "cs148/assignment7.1/login/";
// full URL of this form
$yourURL = $baseURL . $folderPath . "view.php";

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
    <h1>View Information from Database</h1>

    <?php
    echo "<p>Welcome, " . $userName . ".";
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
//make a query to get all the tables
            $selectedTable = htmlentities($_POST["lstTables"], ENT_QUOTES, "UTF-8");

    //Sets up the list for bar selection
            if (isset($_POST["btnTables"]) AND $selectedTable == "tblBars") { //figure out this SHIT RIGHT HERE
                $sql = 'SELECT pkBarID, fldName, fldStreet ';
                $sql .= 'FROM tblBars ';
                $sql .= 'ORDER BY fldName;';
                if ($debug)
                    print "<p>sql " . $sql;

                $names = showDatabaseInfo($sql, $db);

                
                ?>


                <fieldset class="listbox"><legend>Bars</legend><select name="lstBars" value="' . <?php echo $selectedBar; ?> . '" size="1" tabindex="10">
                        <?php
                        foreach ($names as $name) {
                            print '<option value="' . $name['fldName'] . '">' . $name['fldName'] . '</option>\n';
                        }

                        print "</select>\n";
                        print "<br><input type='submit'  id='btnView' name='btnView' value='View Info' >";
                        print "<br></fieldset>\n";
                        print "</form>\n";
            }
                    ?>

                    <?php
                    if (isset($_POST["btnView"])) {
                        $selectedBar = htmlentities($_POST["lstBars"], ENT_QUOTES, "UTF-8");
                        $query = 'SELECT fldName, fldStreet FROM tblBars WHERE fldName = "' . $selectedBar . '";';
                        $attributes = showDatabaseInfo($query, $db);

                        foreach ($attributes as $attribute) {
                            echo "<ul><li>" . $attribute['fldName']
                            . "</li><li>" . $attribute['fldStreet'] . "</li></ul><br>";
                        }
                    } //response to Get button
                    ?>

            <?php
//Sets up the table for restaurant selection
            if (isset($_POST["btnTables"]) AND $selectedTable == "tblRestaurants") {
                $sql = 'SELECT pkRestID, fldName, fldStreet ';
                $sql .= 'FROM tblRestaurants ';
                $sql .= 'ORDER BY fldName;';
                if ($debug)
                    print "<p>sql " . $sql;

                $names = showDatabaseInfo($sql, $db);

                ?>


                <fieldset class="listbox"><legend>Restaurants</legend><select name="lstRestaurants" value="' . <?php echo $selectedRestaurant; ?> . '" size="1" tabindex="10">
                        <?php
                        foreach ($names as $name) {
                            print '<option value="' . $name['fldName'] . '">' . $name['fldName'] . '</option>\n';
                        }

                        print "</select>\n";


                        print "<br>";
                        print "<input type='submit'  id='btnView' name='btnView' value='View Info' >";
                        print '<br></fieldset>';
                        print "</form>\n";
                    }
                    ?>

                    <?php
                    if (isset($_POST["btnView"])) {
                        $selectedRestaurant = htmlentities($_POST["lstRestaurants"], ENT_QUOTES, "UTF-8");
//echo $selectedBar;
                        $query = 'SELECT fldName, fldStreet, fldDescription FROM tblRestaurants WHERE fldName = "' . $selectedRestaurant . '";';
                        $attributes = showDatabaseInfo($query, $db);

                        foreach ($attributes as $attribute) {
                            echo "<ul><li>" . $attribute['fldName']
                            . "</li><li>" . $attribute['fldStreet'] . "</li><li>" . $attribute['fldDescription'] . "</li></ul><br>";
                        }
                    } //response to Get button
                    ?>
                            
            <?php
//Sets up the list for retail selection
        if (isset($_POST["btnTables"]) AND $selectedTable == "tblRetail") { //figure out this SHIT RIGHT HERE
            $sql = 'SELECT pkRetailID, fldName, fldStreet, fldDescription ';
            $sql .= 'FROM tblRetail ';
            $sql .= 'ORDER BY fldName;';
            if ($debug)
                print "<p>sql " . $sql;

            $names = showDatabaseInfo($sql, $db);

            ?>


            <fieldset class="listbox"><legend>Retail Stores</legend><select name="lstRetail" value="' . <?php echo $selectedRetail; ?> . '" size="1" tabindex="10">
                    <?php
                    foreach ($names as $name) {
                        print '<option value="' . $name['fldName'] . '">' . $name['fldName'] . '</option>\n';
                    }

                    print "</select>\n";
                    print "<br><input type='submit'  id='btnView' name='btnView' value='View Info' >";
                    print "<br></fieldset>\n";
                    print "</form>\n";
                }
                ?>

                <?php
                if (isset($_POST["btnView"])) {
                    $selectedRetail = htmlentities($_POST["lstRetail"], ENT_QUOTES, "UTF-8");
                    //echo $selectedBar;
                    $query = 'SELECT fldName, fldStreet, fldDescription FROM tblRetail WHERE fldName = "' . $selectedRetail . '";';
                    $attributes = showDatabaseInfo($query, $db);

                    foreach ($attributes as $attribute) {
                        echo "<ul><li>" . $attribute['fldName']
                        . "</li><li>" . $attribute['fldStreet'] 
                        . "</li><li>" . $attribute['fldDescription'] . "</li></ul><br>";
                    }
                } //response to Get button
                ?>
                    
             <?php
//Sets up the list for other selection
        if (isset($_POST["btnTables"]) AND $selectedTable == "tblOther") {
            $sql = 'SELECT pkOtherID, fldName, fldStreet, fldDescription ';
            $sql .= 'FROM tblOther ';
            $sql .= 'ORDER BY fldName;';
            if ($debug)
                print "<p>sql " . $sql;

            $names = showDatabaseInfo($sql, $db);

            ?>


            <fieldset class="listbox"><legend>Other</legend><select name="lstOther" value="' . <?php echo $selectedOther; ?> . '" size="1" tabindex="10">
                    <?php
                    foreach ($names as $name) {
                        print '<option value="' . $name['fldName'] . '">' . $name['fldName'] . '</option>\n';
                    }

                    print "</select>\n";
                    print "<br><input type='submit'  id='btnView' name='btnView' value='View Info' >";
                    print "<br></fieldset>\n";
                    print "</form>\n";
                }
                ?>

                <?php
                if (isset($_POST["btnView"])) {
                    $selectedOther = htmlentities($_POST["lstOther"], ENT_QUOTES, "UTF-8");
                    //echo $selectedBar;
                    $query = 'SELECT fldName, fldStreet, fldDescription FROM tblOther WHERE fldName = "' . $selectedOther . '";';
                    $attributes = showDatabaseInfo($query, $db);

                    foreach ($attributes as $attribute) {
                        echo "<ul><li>" . $attribute['fldName']
                        . "</li><li>" . $attribute['fldStreet'] 
                        . "</li><li>" . $attribute['fldDescription'] . "</li></ul><br>";
                    }
                } //response to Get button
                ?>


                <br>
                </article>

                <?php
                include ("footer.php");
                ?>

                </body>

                </html>