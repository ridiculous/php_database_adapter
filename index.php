<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>PHP Database layer</title>
    </head>
    <body>
        <?php
        include 'models/people.php';
        $peep = new People();
        $attrs = $peep->_new(array('name' => 'Ryan Buckley', 'age' => 25));
        // $peep->_migrate();
        ?>
        <div>
            <h2><?php print_r($attrs); ?></h2>
        </div>
    </body>
</html>
