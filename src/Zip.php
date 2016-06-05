<?php

class Zip
{
    private $_filePath = './saved/';

    public function threadSaved($threadID)
    {
        $this->_archive = new ZipArchive();

        if ($threadID !== null) {
            $this->setThreadID($threadID);
            $this->openArchive();
        }
    }

    public function __destruct()
    {
        if ($this->_hasResource) {
            $this->_archive->close();
        }
    }

    public function setThreadID($threadID)
    {
        $this->_threadID = $threadID;
    }

    public function openArchive()
    {
        $this->_hasResource = $this->_archive->open($this->_filePath.$this->_threadID.'.zip', ZipArchive::CREATE);
    }

    public function archiveExists()
    {
        return file_exists($this->_filePath.$this->_threadID.'.zip');
    }

    public function getNumFiles()
    {
        if ($this->_hasResource) {
            return $this->_archive->numFiles;
        }
    }

    public function hasResource()
    {
        return $this->_hasResource;
    }

    /**
     * Passthrough to the ZipArchive getNameIndex method.
     *
     * @param [int] $index [index to check for]
     *
     * @return [string] [Name of file at index.]
     */
    public function getNameAtIndex($index)
    {
        if ($this->_hasResource) {
            return $this->_archive->getNameIndex($index);
        }
    }
    /**
     * [getFileAtIndex description]
     * @param  [type] $index [description]
     * @return [type]        [description]
     */
        public function getFileAtIndex($index) {
          if ($this->hasResource()) {
            return $this->_archive->getFromIndex($index);
          }
        }



    private function cleanExt($ext)
    {
        if ($ext[0] == '.') {
            $ext = str_split($ext);
            unset($ext[0]);
            $ext = implode('', $ext);
        }

        return $ext;
    }

    public function fileSaved($filename, $ext)
    {
        $ext = $this->cleanExt($ext);

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
