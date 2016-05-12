function addEvent(argMainPanelID, argMainPanelCounting)
{
   // alert(argMainPanelID+'==='+ argMainPanelCounting)
    
    var ni          =   document.getElementById(argMainPanelID);
    var numi        =   document.getElementById(argMainPanelCounting);
    var num         =   (document.getElementById(argMainPanelCounting).value -1)+ 2;
    numi.value      =   num;
    
    //frmSimilarProductsPanel
    var newPanelRowDiv          =   document.createElement('div');
    newPanelRowDiv.setAttribute("id", argMainPanelID+"Row_"+num);
    newPanelRowDiv.innerHTML    =   '';
    
    
    
    var frmCategoriesIdsString  =   document.getElementById('frmCategoriesIdsString').value;
    var categoryDowpDownHTML    =   getCategoryDowpDownHTML(frmCategoriesIdsString, num);
    var newcategoryDiv          =   document.createElement('div');
    newcategoryDiv.setAttribute("id", "frmSimilarProductCategoryDiv_"+num);
    newcategoryDiv.innerHTML    =   categoryDowpDownHTML;
    
    newPanelRowDiv.innerHTML    +=   newcategoryDiv.innerHTML;
    
    
    var frmBrandsIdsString      =   document.getElementById('frmBrandsIdsString').value;
    var brandDowpDownHTML       =   getBrandDowpDownHTML(frmBrandsIdsString, num);
    var newBrandDiv             =   document.createElement('div');
    newBrandDiv.setAttribute("id", "frmSimilarProductBrandDiv_"+num);
    newBrandDiv.innerHTML       =   brandDowpDownHTML;
    newPanelRowDiv.innerHTML    +=   newBrandDiv.innerHTML;
    
    var newproductDiv           =   document.createElement('div');
    newproductDiv.setAttribute("id", "frmSimilarProductDivID_"+num);
    newproductDiv.setAttribute("width", "100%");
    newproductDiv.innerHTML     =   '<div style="float:left; margin:0 0 0 55px;" id="frmSimilarProductDivID_'+num+'">&nbsp;</div>';
    newproductDiv.innerHTML    +=   '<div style="float:right; margin:5px 0 0 0;" id="frmRemoveSimilarProductDivID_'+num+'"><img src="images/MinusSign.png" onclick="removeElement(\''+argMainPanelID+'Row_'+num+'\',\''+argMainPanelID+'\')" ></div>';
    newproductDiv.innerHTML    +=   '<div style="clear:both"></div>';
    
    newPanelRowDiv.innerHTML   +=   newproductDiv.innerHTML;
    
    var newproductActionDiv          =   document.createElement('div');
    newproductActionDiv.setAttribute("id", "frmSimilarProductActionID_"+num);
    newproductActionDiv.setAttribute("width", "100%");
    newproductActionDiv.innerHTML    =   '&nbsp;';
    newPanelRowDiv.innerHTML        +=   newproductActionDiv.innerHTML;
    
    //alert(newPanelRowDiv.innerHTML)
    ni.appendChild(newPanelRowDiv);
    
}

function addEventRecommended(argMainPanelID, argMainPanelCounting)
{
   
    
    var ni          =   document.getElementById(argMainPanelID);
    var numi        =   document.getElementById(argMainPanelCounting);
    var num         =   (document.getElementById(argMainPanelCounting).value -1)+ 2;
    numi.value      =   num;
    
    //frmSimilarProductsPanel
    var newPanelRowDiv          =   document.createElement('div');
    newPanelRowDiv.setAttribute("id", argMainPanelID+"Row_"+num);
    newPanelRowDiv.innerHTML    =   '';
    
    
    
    var frmCategoriesIdsString  =   document.getElementById('frmRecommendedCategoriesIdsString').value;
    var categoryDowpDownHTML    =   getRecommendedCategoryDowpDownHTML(frmCategoriesIdsString, num);
    var newcategoryDiv          =   document.createElement('div');
    newcategoryDiv.setAttribute("id", "frmRecommendedProductDivID_"+num);
    newcategoryDiv.innerHTML    =   categoryDowpDownHTML;
    
    newPanelRowDiv.innerHTML    +=   newcategoryDiv.innerHTML;
    
    
    var frmBrandsIdsString      =   document.getElementById('frmRecommendedBrandsIdsString').value;
    var brandDowpDownHTML       =   getRecommendedBrandDowpDownHTML(frmBrandsIdsString, num);
    var newBrandDiv             =   document.createElement('div');
    newBrandDiv.setAttribute("id", "frmRecommendedProductBrandDiv_"+num);
    newBrandDiv.innerHTML       =   brandDowpDownHTML;
    newPanelRowDiv.innerHTML    +=   newBrandDiv.innerHTML;
    
    var newproductDiv           =   document.createElement('div');
    newproductDiv.setAttribute("id", "frmRecommendedProductDivID_"+num);
    newproductDiv.setAttribute("width", "100%");
    newproductDiv.innerHTML     =   '<div style="float:left; margin:0 0 0 55px;" id="frmRecommendedProductDivID_'+num+'">&nbsp;</div>';
    newproductDiv.innerHTML    +=   '<div style="float:right; margin:5px 0 0 0;" id="frmRemoveRecommendedProductDivID_'+num+'"><img src="images/MinusSign.png" onclick="removeElement(\''+argMainPanelID+'Row_'+num+'\',\''+argMainPanelID+'\')" ></div>';
    newproductDiv.innerHTML    +=   '<div style="clear:both"></div>';
    
    newPanelRowDiv.innerHTML   +=   newproductDiv.innerHTML;
    
    var newproductActionDiv          =   document.createElement('div');
    newproductActionDiv.setAttribute("id", "frmRecommendedProductActionID_"+num);
    newproductActionDiv.setAttribute("width", "100%");
    newproductActionDiv.innerHTML    =   '&nbsp;';
    newPanelRowDiv.innerHTML        +=   newproductActionDiv.innerHTML;
    
    //alert(newPanelRowDiv.innerHTML)
    ni.appendChild(newPanelRowDiv);
    
}




function removeElement(divNum,ParentdivName)
{
    
    
    var d = document.getElementById(ParentdivName);
    var olddiv = document.getElementById(divNum);
    
   d.removeChild(olddiv);
}

function getCategoryDowpDownHTML(frmCategoriesIdsString, num)
{
    var frmCategoriesIdsStringArray     =   new Array();
    frmCategoriesIdsStringArray         =   frmCategoriesIdsString.split(',');
    var totalCategoriesCount            =   frmCategoriesIdsStringArray.length;
    
    var frmCategoriesNamesString        =   document.getElementById('frmCategoriesNamesString').value;
    var frmCategoriesNamesStringArray   =   new Array();
    frmCategoriesNamesStringArray       =   frmCategoriesNamesString.split(',');
    
    var categoriesOptionsString               =   '';
    
    
    var TempCount   =   $('#TempCount').val(num);
    
    
    for(var catIncr = 0; catIncr < totalCategoriesCount; catIncr++)
    {
        if(frmCategoriesIdsStringArray[catIncr] != '')
        {
            categoriesOptionsString += '<option value="'+frmCategoriesIdsStringArray[catIncr]+'">'+frmCategoriesNamesStringArray[catIncr]+'</option>';
        }
    }
    
    var categoriesDropDown   =   '<div style="float:left;  width:20%;  margin: 10px 0px 0px 0;">';
    categoriesDropDown   +=   '<select onchange="showProducts(this.value,document.getElementById(\'frmSimilarProductBrandID_'+num+'\').value,document.getElementById(\'TempCount\').value)" name="frmSimilarProductCategoryID_'+num+'" id="frmSimilarProductCategoryID_'+num+'" style="width:200px;">';
        categoriesDropDown   +=  '<option value="">'+SEL_CATEGORY+'</option>';
        categoriesDropDown   +=  categoriesOptionsString;
    categoriesDropDown   +=  '</select></div>';
    return categoriesDropDown;
}

function getRecommendedCategoryDowpDownHTML(frmCategoriesIdsString, num)
{
    var frmCategoriesIdsStringArray     =   new Array();
    frmCategoriesIdsStringArray         =   frmCategoriesIdsString.split(',');
    var totalCategoriesCount            =   frmCategoriesIdsStringArray.length;
    
    var frmCategoriesNamesString        =   document.getElementById('frmRecommendedCategoriesNamesString').value;
    var frmCategoriesNamesStringArray   =   new Array();
    frmCategoriesNamesStringArray       =   frmCategoriesNamesString.split(',');
    
    var categoriesOptionsString               =   '';
    
    
    var TempCount   =   $('#TempCount_R').val(num);
    
    
    for(var catIncr = 0; catIncr < totalCategoriesCount; catIncr++)
    {
        if(frmCategoriesIdsStringArray[catIncr] != '')
        {
            categoriesOptionsString += '<option value="'+frmCategoriesIdsStringArray[catIncr]+'">'+frmCategoriesNamesStringArray[catIncr]+'</option>';
        }
    }
    
    var categoriesDropDown   =   '<div style="float:left;  width:20%;  margin: 10px 0px 0px 0;">';
    categoriesDropDown   +=   '<select onchange="showRecommendedProducts(this.value,document.getElementById(\'frmRecommendedProductBrandID_'+num+'\').value,document.getElementById(\'TempCount_R\').value)" name="frmRecommendedProductCategoryID_'+num+'" id="frmRecommendedProductCategoryID_'+num+'" style="width:200px;">';
        categoriesDropDown   +=  '<option value="">'+SEL_CATEGORY+'</option>';
        categoriesDropDown   +=  categoriesOptionsString;
    categoriesDropDown   +=  '</select></div>';
    return categoriesDropDown;
}

function getBrandDowpDownHTML(frmBrandsIdsString, num)
{
    var frmBrandsIdsStringArray     =   new Array();
    frmBrandsIdsStringArray         =   frmBrandsIdsString.split(',');
    var totalBrandsCount            =   frmBrandsIdsStringArray.length;
    
    var frmBrandNamesString        =   document.getElementById('frmBrandsNamesString').value;
    var frmBrandNamesStringArray   =   new Array();
    
    var TempCount   =   $('#TempCount').val(num);
    frmBrandNamesStringArray       =   frmBrandNamesString.split(',');
    
    var brandOptionsString               =   '';
    for(var catIncr = 0; catIncr < totalBrandsCount; catIncr++)
    {
        if(frmBrandsIdsStringArray[catIncr] != '')
        {
            brandOptionsString += '<option value="'+frmBrandsIdsStringArray[catIncr]+'">'+frmBrandNamesStringArray[catIncr]+'</option>';
        }
    }
    
    var brandsDropDown   =   '<div style="float:left;  width:20%; margin: 10px 0px 0px 55px;">';
    brandsDropDown   +=   '<select onchange="showProducts(document.getElementById(\'frmSimilarProductCategoryID_'+num+'\').value,this.value,\''+num+'\')" name="frmSimilarProductBrandID_'+num+'" id="frmSimilarProductBrandID_'+num+'" style="width:200px;">';
        brandsDropDown   +=  '<option value="">'+SEL_BRAND+'</option>';
        brandsDropDown   +=  brandOptionsString;
    brandsDropDown   +=  '</select></div>';
    return brandsDropDown;
}



function getRecommendedBrandDowpDownHTML(frmBrandsIdsString, num)
{
    var frmBrandsIdsStringArray     =   new Array();
    frmBrandsIdsStringArray         =   frmBrandsIdsString.split(',');
    var totalBrandsCount            =   frmBrandsIdsStringArray.length;
    
    var frmBrandNamesString        =   document.getElementById('frmRecommendedBrandsNamesString').value;
    var frmBrandNamesStringArray   =   new Array();
    
    var TempCount   =   $('#TempCount_R').val(num);
    frmBrandNamesStringArray       =   frmBrandNamesString.split(',');
    
    var brandOptionsString               =   '';
    for(var catIncr = 0; catIncr < totalBrandsCount; catIncr++)
    {
        if(frmBrandsIdsStringArray[catIncr] != '')
        {
            brandOptionsString += '<option value="'+frmBrandsIdsStringArray[catIncr]+'">'+frmBrandNamesStringArray[catIncr]+'</option>';
        }
    }
    
    var brandsDropDown   =   '<div style="float:left;  width:20%; margin: 10px 0px 0px 55px;">';
    brandsDropDown   +=   '<select onchange="showRecommendedProducts(document.getElementById(\'frmRecommendedProductCategoryID_'+num+'\').value,this.value,\''+num+'\')" name="frmRecommendedProductBrandID_'+num+'" id="frmRecommendedProductBrandID_'+num+'" style="width:200px;">';
        brandsDropDown   +=  '<option value="">'+SEL_BRAND+'</option>';
        brandsDropDown   +=  brandOptionsString;
    brandsDropDown   +=  '</select></div>';
    return brandsDropDown;
}
function addField(divname) {
 //alert(divname);


  
          var newdiv = document.createElement('div');
          var counter=$('#counterProductSku').val();
         
          //var newHtml=newdiv.innerHTML = '</br>Enter Product ID-SKU&nbsp:&nbsp<input type="text" name="frmProductIdSku[]" id="frmProductIdSku[]"/><br/><br/>';
         // <td><div id="ProductIDSkuoption" style="display:none;">Enter Product ID-SKU&nbsp:&nbsp<input type="text" name="frmProductIdSku[]" id="frmProductIdSku[]"/></div></td><td><div id="addProductSkuField" style="display:none;"><a  onclick="addField('parentSkufields');" href="JavaScript:void(0);" style="float:left"><img src="images/PlusSign.png" style="float:left" /></a></div></td>
          //alert(newHtml);
          //document.getElementById(divname).appendChild(newHtml);
         var innerHTML = '<tr style="" id="ProductIDSkuoption"><td>'+SDSD+'</td></tr>';
								
	 newdiv.innerHTML=innerHTML;						
	alert(innerHTML);							
        // alert(newHtml);
         document.getElementById(divname).appendChild(newdiv);
          counter++;
          $('#counterProductSku').val(counter);
         
    
}
function addSkuId(argMainPanelID, argMainPanelCounting)
{
   // alert(argMainPanelID+'==='+ argMainPanelCounting)
    
    var ni          =   document.getElementById(argMainPanelID);
    var numi        =   document.getElementById('frmSimilarProductsPanelSkuCounting').value;
   
    var num         =   (document.getElementById(argMainPanelCounting).value -1)+ 2;
    numi.value      =   num;
    
    //frmSimilarProductsPanel
    var newPanelRowDiv          =   document.createElement('div');
    newPanelRowDiv.setAttribute("id", argMainPanelID+"Row_"+num);
    newPanelRowDiv.innerHTML    =   '';
    
   
    var categoryDowpDownHTML    =   '<div style="float:left;  width:20%; ">'+ENTER_PRODUCT_ID+'&nbsp:</div>';
    var newcategoryDiv          =   document.createElement('div');
    newcategoryDiv.setAttribute("id", "frmProductIdSku_"+numi);
    newcategoryDiv.innerHTML    =   categoryDowpDownHTML;
    
    newPanelRowDiv.innerHTML    +=   newcategoryDiv.innerHTML;
    
    
    //var frmBrandsIdsString      =   document.getElementById('frmBrandsIdsString').value;
    var brandDowpDownHTML       =   '<input type="text" name="frmProductIdSku[]" id="frmProductIdSku_'+numi+'" onblur="checkSkuID(this.value,'+numi+','+"'ProductSku'"+');"/>';
      brandDowpDownHTML         +='<div><span id="ProductSku_'+numi+'" style="color:red;"></span></div>';
    var newBrandDiv             =   document.createElement('div');
    newBrandDiv.setAttribute("id", "frmSimilarProductBrandDiv_"+num);
    newBrandDiv.innerHTML       =   brandDowpDownHTML;
    newPanelRowDiv.innerHTML    +=   newBrandDiv.innerHTML;
   
    var newproductDiv           =   document.createElement('div');
    newproductDiv.setAttribute("id", "frmSimilarProductDivID_"+num);
    newproductDiv.setAttribute("width", "100%");
    newproductDiv.innerHTML     =   '<div style="float:left; margin:0 0 0 0px;" id="frmSimilarProductDivID_'+num+'">&nbsp;</div>';
    newproductDiv.innerHTML    +=   '<div style="float:right; margin:5px 0 0 0;" id="frmRemoveSimilarProductDivID_'+num+'"><img src="images/MinusSign.png" onclick="removeElement(\''+argMainPanelID+'Row_'+num+'\',\''+argMainPanelID+'\')" ></div>';
    newproductDiv.innerHTML    +=   '';
    
    newPanelRowDiv.innerHTML   +=   newproductDiv.innerHTML;
    
    var newproductActionDiv          =   document.createElement('div');
    newproductActionDiv.setAttribute("id", "frmSimilarProductActionID_"+num);
    newproductActionDiv.setAttribute("width", "100%");
    newproductActionDiv.innerHTML    =   '&nbsp;';
    newPanelRowDiv.innerHTML        +=   newproductActionDiv.innerHTML;
    
    //alert(newPanelRowDiv.innerHTML)
    ni.appendChild(newPanelRowDiv);
    numi++;
    
     document.getElementById('frmSimilarProductsPanelSkuCounting').value=numi;
    
}
function addRecommendedSkuId(argMainPanelID,argMainPanelCounting)
{
   // alert(argMainPanelID+'==='+ argMainPanelCounting)
    
    var ni          =   document.getElementById(argMainPanelID);
    var numi        =   document.getElementById('frmRecommendedProductsPanelCountingNo').value;
  
    var num         =   (document.getElementById(argMainPanelCounting).value -1)+ 2;
    numi.value      =   num;
    
    //frmSimilarProductsPanel
    var newPanelRowDiv          =   document.createElement('div');
    newPanelRowDiv.setAttribute("id", argMainPanelID+"Row_"+num);
    newPanelRowDiv.innerHTML    =   '';
    
   
    var categoryDowpDownHTML    =   '<div style="float:left;  width:20%; ">'+ENTER_PRODUCT_ID+'&nbsp:</div>';
    var newcategoryDiv          =   document.createElement('div');
    newcategoryDiv.setAttribute("id", "frmProductIdSku_"+numi);
    newcategoryDiv.innerHTML    =   categoryDowpDownHTML;
    
    newPanelRowDiv.innerHTML    +=   newcategoryDiv.innerHTML;
    
    
    //var frmBrandsIdsString      =   document.getElementById('frmBrandsIdsString').value;
    var brandDowpDownHTML       =   '<input type="text" name="frmRecommendedProductIdSku[]" id="frmRecommendedProductIdSku_'+numi+'" onblur="checkSkuID(this.value,'+numi+','+"'ProductRecommendedSku'"+');"/>';
      brandDowpDownHTML         +='<div><span id="ProductRecommendedSku_'+numi+'" style="color:red;"></span></div>';
    var newBrandDiv             =   document.createElement('div');
    newBrandDiv.setAttribute("id", "frmSimilarProductBrandDiv_"+num);
    newBrandDiv.innerHTML       =   brandDowpDownHTML;
    newPanelRowDiv.innerHTML    +=   newBrandDiv.innerHTML;
   
    var newproductDiv           =   document.createElement('div');
    newproductDiv.setAttribute("id", "frmSimilarProductDivID_"+num);
    newproductDiv.setAttribute("width", "100%");
    newproductDiv.innerHTML     =   '<div style="float:left; margin:0 0 0 0px;" id="frmSimilarProductDivID_'+num+'">&nbsp;</div>';
    newproductDiv.innerHTML    +=   '<div style="float:right; margin:5px 0 0 0;" id="frmRemoveSimilarProductDivID_'+num+'"><img src="images/MinusSign.png" onclick="removeElement(\''+argMainPanelID+'Row_'+num+'\',\''+argMainPanelID+'\')" ></div>';
    newproductDiv.innerHTML    +=   '';
    
    newPanelRowDiv.innerHTML   +=   newproductDiv.innerHTML;
    
    var newproductActionDiv          =   document.createElement('div');
    newproductActionDiv.setAttribute("id", "frmSimilarProductActionID_"+num);
    newproductActionDiv.setAttribute("width", "100%");
    newproductActionDiv.innerHTML    =   '&nbsp;';
    newPanelRowDiv.innerHTML        +=   newproductActionDiv.innerHTML;
    
    //alert(newPanelRowDiv.innerHTML)
    ni.appendChild(newPanelRowDiv);
    numi++;
    
     document.getElementById('frmRecommendedProductsPanelCountingNo').value=numi;
    
}
function checkSkuID(str,id,errorField)
{


  var data = 'frmSkuId=' +str+ '&frmProcess=checkProductSku';
    $.ajax({
             //this is the php file that processes the data and send mail
             url: "product_action.php",
             
             type: "POST",
  
             //pass the data        
             data: data,    
              
             //Do not cache the page
             cache: false,
              
             //success
            
             success: function (data) {
             
              if(data==0)
              {
                $('#'+errorField+'_'+id).html(PRODUCT_ID_NOT_EXIST);
              
              // document.getElementById('frmProductIdSku_'+strval).value='';
                $('#'+errorField+'_'+id).focus();
                return false;
              }
              else
              {
                $('#'+errorField+'_'+id).html('');
                 return true;
              }
               //$('.slct_right').hide();
               //$('.slct_right').html('');
               //$('.slct_right').html(data);
               //$('.slct_right').show();
               //alert(data);
             //$('#productSizeData').val(data);
                 
             }      
         });
}

function checkExistSubSkuID(id,str,errorField)
{

  var error=0;
   var TotalcheckBoxes=document.getElementById('ProductSizecount').value;
		 //alert('count'+TotalcheckBoxes);
		 for(var i=0;i<TotalcheckBoxes;i++)
		 {
		    if(i!=id)
		    {
			var SkuId=document.getElementById('frmSubproductskuId_'+i).value;
			if(str==SkuId)
			{
			    $('#checkSkuIDexistence_'+id).html(SKU_ALL_EXIST);
			    $('#frmSubproductskuId_'+id).focus();
		            $('#frmsubskuid').val('false');
			     error=1;
                            return false;
			}
			
		    }
		}
		 if(error==0)
	      {
		$('#checkSkuIDexistence_'+id).html('');
                $('#frmsubskuid').val('true');
		 return true;
	      }
		 
		 
 
	
}

 function checkExistMainSkuID(str,errorField)
{


  var data = 'frmSkuId=' +str+ '&frmProcess=checkMainProductSku';
    $.ajax({
             //this is the php file that processes the data and send mail
             url: "product_action.php",
             
             type: "POST",
  
             //pass the data        
             data: data,    
              
             //Do not cache the page
             cache: false,
              
             //success
            
             success: function (data) {
          
              if(data!=0)
              {
		//alert(errorField);
                $('#ProductMainFieldSku').html(SKU_ALL_EXIST);
              
              // document.getElementById('frmProductIdSku_'+strval).value='';
	     // $('#frmSubproductskuId_'+id).val('');
                $('#frmProductCode').focus();
		$('#frmmainskuid').val('false');
                return false;
              }
              else
              {
                $('#ProductMainFieldSku').html('');
                $('#frmmainskuid').val('true');
		 return true;
              }
               //$('.slct_right').hide();
               //$('.slct_right').html('');
               //$('.slct_right').html(data);
               //$('.slct_right').show();
               //alert(data);
             //$('#productSizeData').val(data);
                 
             }      
         });
}

function checkskuIds()
{
   //alert("this is for test");
    var error=0;
     var Totalelements=document.getElementById('ProductSizecount').value;
      
				for(var i=1;i<Totalelements;i++)
				{
				    var k=parseInt(i)-1;
				   
				  
				       var SkuId=document.getElementById('frmSubproductskuId_'+i).value;
				       if(SkuId!='')
				       {
					//alert(SkuId);
				       var SkuIdPrevious=document.getElementById('frmSubproductskuId_'+k).value;
				       if(SkuId==SkuIdPrevious)
				       {
					//alert("already");
					   $('#checkSkuIDexistence_'+i).html(SKU_ALL_EXIST);
					   $('#frmSubproductskuId_'+i).focus();
					   $('#frmsubskuid').val('false');
					    error=1;
					   return false;
				       }
				       }
				   
				}
		 if(error==0)
	      {
		$('#checkSkuIDexistence_'+id).html('');
                $('#frmsubskuid').val('true');
		 return true;
	      }
}