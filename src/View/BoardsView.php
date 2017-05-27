<?php

namespace PHPChan\View;

class BoardsView
{

    public function drawTable(array $boards, $cols = 5)
    {
        $out = '';
        $out .= '<table  class="table table-bordered table-condensed">';
        $chunks = array_chunk($boards, $cols);
        foreach ($chunks as $chunk) {
            $out .= '<tr>';

            foreach ($chunk as $board) {
                $out .= '<td class=""><a href="' . $this->getUrl($board->shortTitle()) . '">' . $board->title() . '</a></td>';
            }
            $out .= '</tr>';
        }
        $out .= '</table>';

        return $out;
    }

    private function getUrl($name)
    {
        return 'board.php?b=' . $name;
    }
    private function getThreadUrl() {
        return 'thread.php?t=' . $first->no . '&b=' . $_GET['b'];
    }

    public function drawBoardPreview($saved)
    {
        $out = '';
        $out .= '<a  href="'.$this->getThreadUrl().'"><div data-toggle="tooltip" data-html="true" title="<i class=\'fa fa-file-image-o\'></i> ' . $first->images . '<br/>' . str_replace('"', "\'", $first->com) . '" class="col-md-2 col-sm-3 col-xs-6 board">';

        if ($saved)
            $out .= '<i class="btn btn-default fa fa-floppy-o"></i>';

        $out .= '<div class="well well-sm" ><div style="background-image: url(' . $controller->genThumnailURL($first->tim) . ')">';
        //. '<img class="thumb" src="' . $controller -> genThumnailURL($first -> tim) . '" />';
        //echo '' . $first -> sub . '';
        //echo '<p>' . $first -> com . '</p>';
        //echo '<br /><i class="fa fa-file-image-o"></i> ' . $first -> images;
        $out .= '</div></div></div></a>';
        return $out;
    }

}