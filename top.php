<?php
session_start();

require_once("connect.php");

function queryDatabase($qry, $dbase) {
    $dbase->beginTransaction();
    $dbase->query($qry);
    $dataEntered = $dbase->commit();
    return $dataEntered;
}  

function showDatabaseInfo($qry, $dbase) {
    $dbase->beginTransaction();
    $stmt = $dbase->prepare($qry);
    $stmt->execute();
    $array = $stmt->fetchAll();
    $dbase->commit();
    return $array;
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>UVM Off-Campus Reference Guide</title>
        <meta charset="utf-8">
        <meta name="author" content="Gus Johnson">
        <meta name="description" content="Get a feel for some of the most famous skateboarding cities around the globe.">

        <!--[if lt IE 9]>
                <script src="//html5shim.googlecode.com/sin/trunk/html5.js"></script>
        <![endif]-->

        <link rel="stylesheet"
              href="formStyle.css"
              type="text/css"
              media="screen">

    </head>