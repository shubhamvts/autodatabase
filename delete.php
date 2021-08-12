<?php

session_start();

if ( ! isset($_SESSION['name']) ) {
	die("ACCESS DENIED");
}
require_once "pdo.php";

if (isset($_REQUEST['autos_id']))
{
    $auto_id = htmlentities($_REQUEST['autos_id']);

    if (isset($_POST['delete']))
    {
        $stmt = $pdo->prepare("
            DELETE FROM autos
            WHERE auto_id = :auto_id
        ");

        $stmt->execute([
            ':auto_id' => $auto_id,
        ]);

        $_SESSION['status'] = 'Record deleted';
        $_SESSION['color'] = 'green';

        header('Location: index.php');
        return;
    }

    $stmt = $pdo->prepare("
        SELECT * FROM autos
        WHERE auto_id = :auto_id
    ");

    $stmt->execute([
        ':auto_id' => $auto_id,
    ]);

    $auto = $stmt->fetch(PDO::FETCH_OBJ);
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Shubham Vats</title>

    </head>
    <body>
        <div>

            <p>
                Confirm: Deleting <?php echo $auto->make; ?>
            </p>

            <form method="post">
                <div>
                    <div>
                        <input type="submit" name="delete" value="Delete">
                        <a href="index.php">Cancel</a>
                    </div>
                </div>
            </form>

        </div>
    </body>
</html>
