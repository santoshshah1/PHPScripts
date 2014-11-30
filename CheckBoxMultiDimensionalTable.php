<script type="text/javascript">

var columnNumber;
var selectedItems="You have selected ";
var table, numberOfRows;

//general properties of table
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
		   selectedItems=selectedItems+"  "+table.rows[n].cells[i].textContent;
            i++;
        }           
    }	
	
	
//to select columnwise
	function getCol(n){	
		 tableProperties();
		 var i=1;
        while (table.rows.length >i) {
		selectedItems=selectedItems+"  "+table.rows[i].cells[n].textContent;
           //alert(table.rows[i].cells[n].textContent);
            i++;
        }	
		//alert(selectedItems);
	}
	
	
//to select individually
	function getIndividual(n){
	tableProperties();
	
	var numberOfColumns=0;
	var i,j;	
	
	for(i=0;i<numberOfRows;i++) {
        if(numberOfColumns < table.rows[i].cells.length)
            numberOfColumns = table.rows[i].cells.length;			
			}
			
	for(i=1; i<numberOfRows; i++)
	{
		for(j=1; j<numberOfColumns; j++)
			{
				var folderName=table.rows[i].cells[j].textContent;
				//alert(folderName);
				var isChecked=document.getElementById(folderName).checked;
				if(isChecked)
				{
					//alert(folderName+"Checked");
					selectedItems=selectedItems+"  "+folderName;
					//alert(selectedItems);
					
				}
			}	
		}	
	}
//to display the selected options
	function display()
	{
		alert(selectedItems);
	}
//to refresh page	
	function clearPage()
	{
	
	location.reload();
	}	
</script>
<table id="table" border="1" style="width:100%">
	<tr>
        <TD></TD>
        <TD><INPUT TYPE="Checkbox"  onClick="getCol(1)" ID="1">First Column</TD>
		<TD><INPUT TYPE="Checkbox"  onClick="getCol(2)" ID="2">Second Column</TD>
		<TD><INPUT TYPE="Checkbox" onClick="getCol(3)" ID="3">Third Column</TD>
        
    </tr>
    <tr>
        <TD><input type="checkbox" onclick="getRow(1)" ID="10">Firstrow</TD>
         <TD><INPUT TYPE="Checkbox"  onClick="getIndividual(this)" ID="11">11</TD>
		  <TD><INPUT TYPE="Checkbox"  onClick="getIndividual(this)" ID="12">12</TD>
		   <TD><INPUT TYPE="Checkbox"  onClick="getIndividual(this)" ID="13">13</TD>
    </tr>
    <tr>
        <TD><input type="checkbox" onclick="getRow(2)" ID="20">Secondrow</TD>
        <TD><INPUT TYPE="Checkbox"  onClick="getIndividual(this)" ID="21">21</TD>
		  <TD><INPUT TYPE="Checkbox"  onClick="getIndividual(this)" ID="22">22</TD>
		   <TD><INPUT TYPE="Checkbox"  onClick="getIndividual(this)" ID="23">23</TD>
    </tr>
    <tr>
        <TD><input type="checkbox" onclick="getRow(3)" ID="30">Thirdrow</TD>
        <TD><INPUT TYPE="Checkbox"  onClick="getIndividual(this)" ID="31">31</TD>
		  <TD><INPUT TYPE="Checkbox"  onClick="getIndividual(this)" ID="32">32</TD>
		   <TD><INPUT TYPE="Checkbox"  onClick="getIndividual(this)" ID="33">33</TD>
    </tr>
</table>
<br/>
<button onclick="display()">Submit</button>
<button onclick="clearPage()">clear</button>

