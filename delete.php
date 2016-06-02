<?php

require_once 'config.php';

$controller = new Controller();
$view = new View();

echo $view->header();

$threadID = $_GET['threadID'];

if ($_POST['submit'] == 1) {
    $filepath = 'saved/'.$threadID.'.zip';
    $result = unlink($filepath);


    if ($result) {
        $type = 'success';
        $title = '<i class="fa fa-check"></i> Thread Removed';
        $msg = 'All Done.';
    } else {
        $type = 'danger';
        $title = '<i class="fa fa-remove"></i> Thread was not removed.';
        $msg = 'There was an issue removing the thread. Permissions more or less.';
    }
    echo $view->alert($title, $msg, $type);
} else {

    if (isset($threadID)) {
    echo $view->alert('<i class="fa fa-exclamation-circle"></i> Are you sure you want to delete this thread?', 'There is no going back after this. <form method="POST">

<p>  <button name="submit" class="btn btn-success" value="1"><i class="fa fa-check"></i> Yes</button></p>
</form></div>', 'info');
} else {
  echo $view->alert('There was no thread Selected','','danger');
}
}

echo $view->footer();
