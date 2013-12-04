<nav>
    <ol style="text-align:left">
        <li><a href="main2.php">HOME</a></li>
        <li><a href="submit.php">SUBMIT DATA</a></li>
        <li><a href="view.php">VIEW DATA</a></li>
        <?php
        if ($userName == "gjohnso4" || $userName == "rerickso"){
            print '<li><a href="admin.php">MANAGE DATA</a></li>';
        }
        ?>
    </ol>
</nav>