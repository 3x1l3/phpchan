<?php
require_once("config.php");

$controller = new Controller();
$view = new View();

echo $view -> header();

if (!isset($_GET['p']))
	$_GET['p'] = 1;


$json = $controller -> multiEx();
$array = json_decode($json);
$thumbs = $controller -> getThumbnails($json);

// echo '<pre>';
// print_r($array);
// echo '</pre>';

foreach ($array->threads as $thread) {

	$first = $thread -> posts[0];

	if ($first -> closed != 1) {

		echo '<a href="thread.php?t=' . $first -> no . '&b=' . $_GET['b'] . '"><div class="well well-sm row board">';
		echo '<div class="col-md-2 col-sm-2 col-xs-2"><img class="thumb" src="' . $controller -> genThumnailURL($first -> tim) . '" /></div>';
		echo '<div class="col-md-10 col-sm-10 col-xs-10"><h3>' . $first -> sub . '</h3>';
		echo '<p>' . $first -> com . '</p>';
		echo '<br /><i class="fa fa-file-image-o"></i> ' . $first -> images;
		echo '</div></div></a>';
	}
}


echo '<nav>
  <ul class="pagination pagination-lg">
    <li>
      <a href="#" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>';
for ($i = 1; $i <= 10; $i++) {

	if ($_GET['p'] == $i)
		echo '<li class="active"><a href="board.php?b='.$_GET['b'].'&p='.$i.'">' . $i . '</a></li>';
	else
		echo '<li><a href="board.php?b='.$_GET['b'].'&p='.$i.'">' . $i . '</a>';

}
echo ' <li>
      <a href="#" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
  </ul>
</nav>';
