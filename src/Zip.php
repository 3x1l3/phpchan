<?php

class Zip
{
    private $_filePath = './saved/';

    public function threadSaved($threadID)
    {
        //var_dump($threadID);
        $saved = false;
        if (file_exists($this->_filePath.$threadID.'.zip')) {
            $zip = new ZipArchive();
            $res = $zip->open($this->_filePath.$threadID.'.zip');
            if ($res) {
                $saved = (bool) $zip->getFromName($post->tim.''.$post->ext);
            }
        }
      return $saved;
    }
}
