<?php

$baseURL = "http://www.uvm.edu/~gjohnso4/";
$folderPath = "cs148/assignment7.1/";
// full URL of this form 
$yourURL = $baseURL . $folderPath . "main.php";

require_once("connect.php");

include ("top.php");

$ext = pathinfo(basename($_SERVER['PHP_SELF']));
$file_name = basename($_SERVER['PHP_SELF'], '.' . $ext['extension']);

print "\n\n";
print '<body id="' . $file_name . '">';
print "\n\n";

include ("header.php");
print "<br>";

include ("menu.php");
?> 


<article>
    <h1>UVM Off-Campus Reference Guide</h1>
    
    <h2>Welcome. Please click "LOG IN" above to proceed.</h2>
    <br>
</article> 

<?php 
include ("footer.php"); 
?> 

</body> 
</html>