<?php

class View
{
    public function __construct()
    {
    }

    public function header()
    {
        $content = new Content();
        $content->add('<!DOCTYPE html>');
        $content->add('<html><head><title>PHPChan</title>');
        $content->add('<meta name="viewport" content="width=device-width,initial-scale=1.0">');
        $content->add('<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" />');
        $content->add('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" />');

        $content->add('<link rel="stylesheet" href="./css/styles.css" />');
        $content->add('<link rel="stylesheet" href="./css/jquery.fancybox.css" />');
        $content->add('</head>');
        $content->add('<body>');
        $content->add('<h1>PHPChan</h1>');
        $content->add('<div class="container-fluid">');

        return $content;
    }
    public function modal()
    {
        return '<div class="modal fade" id="popup" tabindex="-1" role="dialog" aria-labelledby="popup">
		  <div class="modal-dialog" role="document">

		    <div class="modal-content">
				<i class="fa fa-arrows-alt fullscreen-icon fadeout"></i>
		      <div class="modal-body">

		      </div>

		    </div>
		  </div>
		</div>';
    }

    public function pagination($p, $b)
    {
        echo '<nav>
		  <ul class="pagination pagination-lg">
		    <li>
		      <a href="#" aria-label="Previous">
		        <span aria-hidden="true">&laquo;</span>
		      </a>
		    </li>';
        for ($i = 1; $i <= 10; ++$i) {
            if ($p == $i) {
                echo '<li class="active"><a href="board.php?b='.$b.'&p='.$i.'">'.$i.'</a></li>';
            } else {
                echo '<li><a href="board.php?b='.$b.'&p='.$i.'">'.$i.'</a>';
            }
        }
        echo ' <li>
		      <a href="#" aria-label="Next">
		        <span aria-hidden="true">&raquo;</span>
		      </a>
		    </li>
		  </ul>
		</nav>';
    }

    public function footer()
    {
        $content = new Content();
        $content->add('</div>');

        $content->add('<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>');
        $content->add('<script src="./js/jquery.fancybox.js"></script>');

        $content->add('<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>');
        $content->add('<script src="./js/site.js"></script>');

        $content->add('</body>');
        $content->add('</html>');

        return $content;
    }

    public function drawBreadcrumb(array $boards = null, array $threads = null)
    {
        $Out = '<h2>';
        $Out .= '<a href=".">Boards</a> ';
        if ($boards !== null) {
            foreach ($boards as $board) {
                if ($board->board == $_GET['b']) {
                    $Out .= '<i class="fa fa-angle-double-right"></i> '.$board->title.'';
                }
            }
        }

        if (isset($_GET['t'])) {
        }

        $Out .= '</h2>';

        return $Out;
    }
}
