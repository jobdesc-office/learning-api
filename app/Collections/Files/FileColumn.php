<?php

namespace App\Collections\Files;

use App\Collections\Collection;

class FileColumn extends Collection
{

   public function getId()
   {
      return $this->get('fileid');
   }

   public function getFilename()
   {
      return $this->get('filename');
   }

   public function getMimeType()
   {
      return $this->get('mimetype');
   }

   public function getFileSize()
   {
      return $this->get('filesize');
   }

   public function getTransTypeId()
   {
      return $this->get('transtypeid');
   }

   public function getRefId()
   {
      return $this->get('refid');
   }
}
