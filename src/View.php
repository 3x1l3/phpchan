<?php

class View
{

    private $controller;

    public function __construct(Controller $controller)
    {
        $this->controller = $controller;
    }

    public function getController()
    {
        return $this->controller;
    }

    public function header($active = 'home')
    {
        $content = new \Content();
        $content->add('<!DOCTYPE html>');
        $content->add('<html><head><title>PHPChan</title>');
        $content->add('<meta name="viewport" content="width=device-width,initial-scale=1.0">');
        $content->add('<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" />');
        if ($this->getController()->getTheme() == 1)
            $content->add('<link rel="stylesheet" href="./css/theme/solar.css" />');
        else
            $content->add('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" />');


        $content->add('<link rel="stylesheet" href="./css/styles.css" />');
        $content->add('</head>');
        $content->add('<body>');
        $content->add('<div class="container-fluid">');
        $content->add('<h1>PHPChan</h1>');

        $url = \Utility\Url::createFromGlobal();

        $content->add('<ul class="nav nav-tabs">
     <li role="presentation" class="' . ($active == 'home' ? 'active' : '') . '"><a href="./">Home</a></li>
     <li role="presentation"  class="' . ($active == 'saved' || $active == 'loaded' ? 'active' : '') . '"><a href="savedThreads.php">Saved Threads</a></li>
         <li class="pull-right"><a href="' . $url->appendVar('theme', 'toggle') . '">Light <i class="fa ' . ($this->getController()->getTheme() ? 'fa-toggle-on' : 'fa-toggle-off') . '"></i> Dark</a></li>
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
                echo '<li class="active"><a href="board.php?b=' . $b . '&p=' . $i . '">' . $i . '</a></li>';
            } else {
                echo '<li><a href="board.php?b=' . $b . '&p=' . $i . '">' . $i . '</a>';
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

        $content->add('<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>');
        $content->add('<script src="./js/matchheight.js"></script>');

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
                    $Out .= '<i class="fa fa-angle-double-right"></i> <a href="board.php?b=' . $current_board . '">' . $board->title . '</a>';
                }
            }
        }

        if (isset($threadID)) {
            $Out .= ' <i class="fa fa-angle-double-right"></i> Thread ' . $threadID;
            $Out .= $this->saveButton($threadID, $current_board);
        }

        $Out .= '</h3>';

        return $Out;
    }

    public function blankModal()
    {
        return '<div class="modal fade" id="popup" tabindex="-1" role="dialog" aria-labelledby="popup">
    		  <div class="modal-dialog" role="document">
    		    <div class="modal-content">

    		      <div class="modal-body">
    		      </div>
    		    </div>
    		  </div>
    		</div>';
    }

    public function modal($id, $title, $body)
    {
        $out .= '<div class="modal fade" id="' . $id . '" tabindex="-1" role="dialog" aria-labelledby="' . $id . 'Label">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">' . $title . '</h4>
      </div>
      <div class="modal-body">
        ' . $body . '
      </div>

    </div>
  </div>
</div>';

        return $out;
    }

    public function drawThumb(ImageUrl $url, $width, $height, $type, $saved = false, $index = null)
    {
        $content = new Content();
        $content->Add('<div class="thumb-cell well well-sm">');


        if ($saved) {
            $content->Add('<i class="btn btn-default fa fa-floppy-o saved-icon"></i>');
        }

        $content->Add('<a class="popup-trigger" data-gallery="gallery" data-index="' . $index . '" data-ext="' . $url->ext . '" data-type="' . $type . '" data-height="' . $height . '" data-width="' . $width . '"  data-img="' . $url->build() . '">
        <img class="thumb" src="' . $url->build('thumb') . '" /></a>
      ');
        $content->Add('</div>');

        return $content->build();
    }

    public function alert($a_title, $a_message, $a_type)
    {
        $out = '<div class="alert alert-' . $a_type . '">';

        if (strlen(trim($a_title)) > 0) {
            $out .= '<h3> ' . $a_title . '</h3>';
        }

        $out .= '<p>' . $a_message . '</p></div>';

        return $out;
    }

    public function saveButton($threadID, $board)
    {
        $saved = file_exists('./saved/' . $threadID . '.zip');
        if ($saved) {
            $icon = 'fa-star ';
        } else {
            $icon = 'fa-star-o';
        }
        $out = '<div class="btn-group pull-right" role="group">';
        $out .= '<a class="btn btn-default " href="save.php?t=' . $threadID . '&b=' . $board . '"><i class="text-warning fa ' . $icon . '"></i> </a>';

        if ($saved) {
            $out .= '<a class="btn btn-default" href="load.php?t=' . $threadID . '">Show Saved</a>';
        }
        $out .= '</div>';

        return $out;
    }
}
