<?php

  $zip = new ZipArchive();
  $res = $zip->open('./saved/test.zip', ZipArchive::CREATE);

  if ($res) {
      $zip->addFromString('help/test.txt', 'testing');
  }
