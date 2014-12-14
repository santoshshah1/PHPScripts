<?php
/*
Plugin Name: Tabular Bulk Uploads



*/

function html_form_code()
{
wp_enqueue_script('jquery');

 echo '
 
 <html>
	<head>
		<script >
			$j=jQuery.noConflict();
            var columnNumber;
            var displayText="";
            var table, numberOfRows;

            function tableProperties()
            {
            table = document.getElementById("table");
             numberOfRows=table.rows.length;

            }
            
            //to select rowwise
               function getRow(n) {
               tableProperties();
                    var i=1;
                            while (table.rows[n].cells.length >i) {    
                                displayText=displayText+"  "+table.rows[n].cells[i].textContent;
                               i++;
                    }  

                }	
	
	
            //to select columnwise
            function getCol(n){	
                     tableProperties();
                     var i=1;
            while (table.rows.length >i) {                
                 displayText=displayText+"  "+table.rows[i].cells[n].textContent;
               //alert(table.rows[i].cells[n].textContent);
                i++;
            }	
                    //alert(displayText);
            }


            //to select individually
            function getIndividual(n){
                //alert ("1");
            tableProperties();
            var i=1;
            var numberOfColumns=0;

            for(i=0;i<numberOfRows;i++) {
            if(numberOfColumns < table.rows[i].cells.length)
                numberOfColumns = table.rows[i].cells.length;
            	
            }
            
            for(i=1; i<numberOfRows; i++)
            {
                    for(j=1; j<numberOfColumns; j++)
                            {
                                    var folderName=table.rows[i].cells[j].textContent;
                                   // alert(folderName);
                                    var isChecked=document.getElementById(folderName).checked;
                                    if(isChecked)
                                    {
                                            //alert(folderName+"Checked");
                                            displayText=displayText+"  "+folderName;
                                            //alert(displayText);

                                    }
                            }	
                    }
            
            
            
        }

            function display()
            {   
                
				document.getElementById("test").value = displayText;
				//alert(document.getElementById("test").value);
				//alert($("#SelectedDownloads").val());
                 alert( "You have selected : " +displayText);
				 

            }
			
   </script>
    </head>
 <form action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">
 
     <table id="table" border="1" style="width:100%">
            <tr>
                <TD></TD>
                <TD><INPUT TYPE="Checkbox"  onClick="getCol(1)" ID="1">First Column</TD>
                <TD><INPUT TYPE="Checkbox"  onClick="getCol(2)" ID="2">Second Column</TD>
                <TD><INPUT TYPE="Checkbox" onClick="getCol(3)" ID="3">Third Column</TD>
            </tr>
            <tr>
                <TD><input type="checkbox" onclick="getRow(1)" ID="10">Firstrow</TD>
                <TD><INPUT TYPE="Checkbox"  onClick="getIndividual(this)" ID="Imagefolder1">Imagefolder1</TD>
                <TD><INPUT TYPE="Checkbox"  onClick="getIndividual(this)" ID="Imagefolder2">Imagefolder2</TD>
                <TD><INPUT TYPE="Checkbox"  onClick="getIndividual(this)" ID="Imagefolder3">Imagefolder3</TD>
            </tr>
            <tr>
                <TD><input type="checkbox" onclick="getRow(2)" ID="20">Secondrow</TD>
                <TD><INPUT TYPE="Checkbox"  onClick="getIndividual(this)" ID="Imagefolder4">Imagefolder4</TD>
                <TD><INPUT TYPE="Checkbox"  onClick="getIndividual(this)" ID="Imagefolder5">Imagefolder5</TD>
                <TD><INPUT TYPE="Checkbox"  onClick="getIndividual(this)" ID="Imagefolder6">Imagefolder6</TD>
            </tr>
            <tr>
                <TD><input type="checkbox" onclick="getRow(3)" ID="30">Thirdrow</TD>
                <TD><INPUT TYPE="Checkbox"  onClick="getIndividual(this)" ID="Imagefolder7">Imagefolder7</TD>
                <TD><INPUT TYPE="Checkbox"  onClick="getIndividual(this)" ID="Imagefolder8">Imagefolder8</TD>
                <TD><INPUT TYPE="Checkbox"  onClick="getIndividual(this)" ID="Imagefolder9">Imagefolder9</TD>
            </tr>
        </table>
            
		<button name="submit" onclick="display()">Submit</button>
		<input id="test" type="hidden" name="test" value="' . ( isset( $_POST["test"] ) ? esc_attr( $_POST["test"] ) : '' ) . '" size="40" />
		
           
      
		</form>
	</html>';
	
}

function download()
{
if ( isset( $_POST['submit'] ) )
{
	$selectedString   = $_POST["test"] ;
	$foldersToDownload=explode(" ",$selectedString);

	$currenttime= time();
    $zipname = "Files$currenttime.zip";
    $createZipPath="Downloads/$zipname";
    $sourceFilePath="Repo";
    $zip = new ZipArchive;
    $zip->open($createZipPath, ZipArchive::CREATE);
    
    //Filter the zip process with the incoming request
	//echo $sourceFilePath;
    $handle = opendir($sourceFilePath); 
	

	
	
	while (false !== $f = readdir($handle)) { 
      if ($f != '.' && $f != '..') {
          
          for($i=0; $i<sizeof($foldersToDownload);$i++)
          {
                    if(strcmp($f, $foldersToDownload[$i])==0)
                    {
					//echo "comparing input";
                        HZip::folderToZip("Repo/$foldersToDownload[$i]",$zip,0);
                    }
          }
      }
      }
	  
	  //close zip
    $zip->close();
	
	
	$my_default_level = ob_get_level(); # learn about already set output buffers
$my_has_buffer = ob_start(); # my output buffer, with flagging

# burning down (somewhere after)
if ($my_has_buffer)
{
  $c = ob_get_level() - $my_default_level;
  if ($c <= 0)
  {
    # someone else already cleared my buffer.
  }
  else
  {
    while($c--)
    {
      ob_end_clean();
    }
  }
}
    
    //send the zip to browser    
    if(file_exists($createZipPath))
    {
        header('Content-Type: application/zip');
        header("Content-Disposition:attachment;filename=$zipname");
       header('Content-Length: ' . filesize($createZipPath));
      header("Location: $createZipPath");
        
        readfile("Downloads/$zipname");
        //unlink("Downloads/$zipname");
    }
echo '<div>';
            echo '<p>Thanks for downloading.</p>';
			
            echo '</div>';

}
}



//class to zip
class HZip 
{ 
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

//[foobar]
function foobar_func($atts)
{
ob_start();
html_form_code();
download();

 return ob_get_clean();

}



//add_filter('''the_content''','''replaceString''');
add_shortcode('foobar', 'foobar_func');
add_action('foobar', 'my_init_method')


?>