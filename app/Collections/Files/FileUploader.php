<?php

namespace App\Collections\Files;

use App\Collections\Files\FileColumn;
use App\Services\Masters\FilesServices;
use DB;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class FileUploader
{
   /**
    * @var string
    * File temporary path, path of file that will be moved
    */
   protected $temp_path;
   /**
    * @var string
    * Uploaded file name
    */
   protected $filename;
   /**
    * @var string
    * Upload file destination
    */
   protected $directories;
   /**
    * @var string
    * Mime Type of file
    */
   protected $mime_type;
   /**
    * @var boolean
    * Check if file has error
    */
   protected $is_error;
   /**
    * @var int
    * File size
    */
   protected $size;
   /**
    * @var UploadedFile
    * File object
    */
   protected $file;
   /**
    * @var int
    * trans type id of file data
    */
   protected $transtypeid;
   /**
    * @var int
    * owner / reference of file
    */
   protected $refid;

   /**
    * @param string $temp_path temporary path
    * @param string $filename uploaded file name
    * @param string $directories file upload destination
    * @param int $transtypeid trans type id of file
    * @param int $refid file owner/reference
    */
   public function __construct($temp_path, $filename,  $directories = null, $transtypeid = null, $refid = null)
   {
      $this->transtypeid = $transtypeid;
      $this->refid = $refid;

      $this->temp_path = $temp_path;
      $this->directories = $directories;
      $this->filename = $filename;
      $this->file = new UploadedFile($temp_path, $filename);

      $this->mime_type = $this->file->getMimeType();
      $this->is_error = $this->file->getError() != 0;
      $this->size = $this->file->getSize();
   }

   /**
    * @param string $filename if filename is not null then it will override constructor filename
    * @param string $directories if directories is not null then it will override constructor directories
    * @return FileColumn|false
    */
   public function upload($directories = null, $filename = null)
   {
      if ($directories != null) {
         $this->directories = $directories;
      }

      if ($filename != null) {
         $this->filename = $filename;
      }

      $result = $this->file->storeAs("public/$this->directories", $this->filename . '.' . $this->file->guessExtension());
      if ($result) {
         $data = [];
         $filesService = new FilesServices();
         $data['transtypeid'] = $this->transtypeid;
         $data['refid'] = $this->refid;
         $data['directories'] = $this->directories;
         $data['filename'] = $this->filename . '.' . $this->file->guessExtension();
         $data['mimetype'] = $this->mime_type;
         $data['filesize'] = $this->size;

         $anchorData = [
            'transtypeid' => $this->transtypeid,
            'refid' => $this->refid,
            'filename' => $this->filename,
         ];
         $result = $filesService->newQuery()->updateOrCreate($anchorData, $data);
         return new FileColumn($result);
      }
      return false;
   }
}
