<?php

class Zip
{
    private $_filePath = './saved/';
    private $_archive = null;
    private $_hasResource = false;
    private $_threadID = null;

    public function __construct($threadID = null)
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

        if ($this->_hasResource) {
            $saved = (bool) $this->_archive->getFromName($filename.'.'.$ext);
        }

        return $saved;
    }

    public function saveToArchive($data, $filepath)
    {
        if ($this->_hasResource) {
            if ($this->_archive->locateName($filepath) === false && strlen(trim($filepath)) > 0) {
                $this->_archive->addFromString($filepath, $data);
            }
        }
    }
}
