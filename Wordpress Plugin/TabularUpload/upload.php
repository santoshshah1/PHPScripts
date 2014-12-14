

<?php
/*
Plugin Name: Tabular Bulk Uploads



*/


$id = $_GET['hi'];
//
echo '$_GET['''hi''']';

$foldersToDownload=explode(" ",$_GET['hi']);
class HZip 
{ 
    
	
	//print "abc";
public static function  folderToZip($folder, &$zipFile, $exclusiveLength) {
    $handle = opendir($folder); 
    while (false !== $f = readdir($handle)) { 
      if ($f != '.' && $f != '..') { 
        $filePath = "$folder/$f"; 
        $localPath = substr($filePath, 0);
        if (is_file($filePath)) {
           $zipFile->addFile($filePath, $localPath);
        } elseif (is_dir($filePath)) { 
          $zipFile->addEmptyDir($localPath); 
          self::folderToZip($filePath, $zipFile, 0); 
        } 
      } 
    } 
    closedir($handle);   
}
}

    $currenttime= time();
    $zipname = "Files$currenttime.zip";
    $createZipPath="Downloads/$zipname";
    $sourceFilePath="Repo";
    $zip = new ZipArchive;
    $zip->open($createZipPath, ZipArchive::CREATE);
    
    //Filter the zip process with the incoming request.
    $handle = opendir($sourceFilePath); 
    while (false !== $f = readdir($handle)) { 
      if ($f != '.' && $f != '..') {
          
          for($i=0; $i<sizeof($foldersToDownload);$i++)
          {
                    if(strcmp($f, $foldersToDownload[$i])==0)
                    {
                        HZip::folderToZip("Repo/$foldersToDownload[$i]",$zip,0);
                    }
          }
      }
      }
      
    //close zip
    $zip->close();
    
    
?>

