<?php

class View
{
    public function __construct()
    {
    }

    public function header()
    {
        $content = new \Content();
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
  $content->add('<ul class="nav nav-pills">
  <li role="presentation" class="active"><a href="./">Home</a></li>
  <li role="presentation"><a href="savedThreads.php">Saved Threads</a></li>
</ul>');
        return $content;
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

    public function drawBreadcrumb($current_board, array $boards = null, $threadID = null)
    {
        $Out = '<h3>';
        $Out .= '<a href=".">Boards</a> ';
        if ($boards !== null) {
            foreach ($boards as $board) {
                if ($board->board == $_GET['b']) {
                    $Out .= '<i class="fa fa-angle-double-right"></i> <a href="board.php?b='.$current_board.'">'.$board->title.'</a>';
                }
            }
        }

        if (isset($threadID)) {
            $Out .= ' <i class="fa fa-angle-double-right"></i> Thread '.$threadID;
            $Out .= $this->saveButton($threadID, $current_board);
        }

        $Out .= '</h3>';

        return $Out;
    }


    public function modal($id, $title, $body) {
      $out .= '<div class="modal fade" id="'.$id.'" tabindex="-1" role="dialog" aria-labelledby="'.$id.'Label">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">'.$title.'</h4>
      </div>
      <div class="modal-body">
        '.$body.'
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>';

return $out;
    }

    public function drawThumb(ImageUrl $url, $width, $height ,$type, $saved = false) {
      $content = new Content();
      $content->Add('<div class="thumb-cell well well-sm">');

      if ($saved)
      $content->Add('<i class="btn btn-default fa fa-floppy-o"></i>');
      $content->Add('<a class="popup-trigger" data-type="'.$type.'" data-height="'.$height.'" data-width="'.$width.'"  data-img="' . $url->build(). '">
        <img class="thumb" src="' . $url->build('thumb') . '" /></a>
      ');
      $content->Add('</div>');

      return $content->build();
    }

    public function alert($a_title, $a_message, $a_type) {

        $out = '<div class="alert alert-'.$a_type.'"><h2> '.$a_title.'</h2>';
        $out .=  '<p>'.$a_message.'</p></div>';
        return $out;
    }

    public function saveButton($threadID, $board) {
      $saved = file_exists('./saved/'.$threadID.'.zip');
        if ($saved)
          $icon = 'fa-star ';
        else {
          $icon = 'fa-star-o';
        }
        $out ='<div class="btn-group pull-right" role="group">';
        $out .= '<a class="btn btn-default " href="save.php?t='.$threadID.'&b='.$board.'"><i class="text-warning fa '.$icon.'"></i> </a>';

        if ($saved) {
          $out .= '<a class="btn btn-default" href="load.php?t='.$threadID.'">Show Saved</a>';
        }
$out .= '</div>';
        return $out;
    }

}
