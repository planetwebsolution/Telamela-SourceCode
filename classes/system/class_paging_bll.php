<?php
ini_set('memory_limit', '1024M');
/**
*
* Module name : Paging
*
* Parent module : class
*
* Date created : 21st December 2013
*
* Date last modified : 21st December 2013
*
* Author : vivek avasthi
*
* Last modified by : vivek avasthi
*
* Comments : Paging class use for pagingnation. Display link numbers, next, previous, firs and last.
*
*/ 	

class Paging extends Core

{
	
	var $page;

	var $next_page;

	var $prev_page;

	var $num_pages;



	/**
	*
	* Function name : getPageStartLimit
	*
	* Return type : integer
	*
	* Date created : 15th October 2013
	*
	* Date last modified : 15th October 2013
	*
	* Author : Ashok Singh Negi
	*
	* Last modified by : Ashok Singh Negi
	*
	* Comments : This function return start page
	*
	* User instruction : $objOrder = new getPageStartLimit($page, $limit)
	*
	*/	  

	function getPageStartLimit($argPage, $argLimit)

	{

		if($argPage == '' || $argPage == 0)

		{

			$argPage = 1;

		} 

		

		$varPageStart = ($argLimit * $argPage) - $argLimit;

		return $varPageStart;

	}

	

	

	/**
	*
	* Function name : calculateNumberofPages
	*
	* Return type : integer
	*
	* Date created : 15th October 2013
	*
	* Date last modified : 15th October 2013
	*
	* Author : Ashok Singh Negi
	*
	* Last modified by : Ashok Singh Negi
	*
	* Comments : This function return total page
	*
	* User instruction : $objOrder = new calculateNumberofPages($argNumRows, $argLimit)
	*
	*/ 	 

	function calculateNumberofPages($argNumRows, $argLimit)   

	{
          
		/* if ( basename($_SERVER['PHP_SELF']) === 'order_disputed_manage_uil.php' ) {
			$argNumRows = $argNumRows -1;
		} */

		if($argNumRows > $argLimit)

		{

			if($argNumRows % $argLimit == 0)

			{

				$this->num_pages = ($argNumRows / $argLimit);

			} 	

			else 

			{

				$this->num_pages = ($argNumRows / $argLimit) + 1;

				$this->num_pages = (int)$this->num_pages;

			}

		} 

		else if($argNumRows <= $argLimit)

		{

		$this->num_pages = 1; 

		}

		

		return $this->num_pages;

	}

	
	/**
	*
	* Function name : displayProductListingPaging
	*
	* Return type : String
	*
	* Date created : 6th May 2013
	*
	* Date last modified : 6th May 2013
	*
	* Author : Deepesh Pathak
	*
	* Last modified by : ADeepesh Pathak
	*
	* Comments : This function return total page
	*
	* User instruction : $objOrder = new displayProductListingPaging($page, $num_pages, $limit, $varPageName='', $varPageID='',$arrRequest='')
	*
	*/ 	 

	function displayProductListingPaging($page, $num_pages, $limit, $varPageName='', $varPageID='',$arrRequest='' , $argDispName = '')

	{

		$objCore = new Core();

		if($page=="")

		{ 

			$page = 1;

		} 

		$this->page = $page;

		$this->next_page = $page + 1;

		$this->prev_page = $page - 1;

		$this->num_pages = $num_pages;

		$varReques = $_REQUEST;

		//print_r($_REQUEST);

		if(isset($varReques['PHPSESSID']))

		{

		unset($varReques['PHPSESSID']);

		}

		if(isset($varReques['__utmz']))

		{

			unset($varReques['__utmz']);

		}

		if(isset($varReques['__utma']))

		{

			unset($varReques['__utma']);

		}

		if(isset($varReques['__utmc']))

		{

			unset($varReques['__utmc']);

		}

		if(isset($varReques['__utmb']))

		{

			unset($varReques['__utmb']);

		}

		if(isset($varReques['celeb']))

		{

			unset($varReques['celeb']);

		}

	

		if($argDispName == '')

		{

			$varDispName = 'page';

			$varQryStr = $objCore->generateValidateString($varRequest,'',$varDispName);

		}

		else

		{

			$varDispName = $argDispName;

		}

	

		$varQryStr = $this->qryStr($varReques,'cookie_AgentUserPassword');

	

		$varQryStr = str_replace('?&'.$varDispName,'?'.$varDispName,$varQryStr);

		$varQryStr = str_replace('&'.$varDispName,'&amp;'.$varDispName,$varQryStr);

		$varQryStr = $objCore->generateValidateString($varRequest,'',$varDispName);

		$varRequest = $_SERVER['QUERY_STRING'];

		$varQryStr = $_SERVER['QUERY_STRING'];

		

		if(trim($varQryStr) == '')

		{

			$varQryStr = '?'.$varQryStr; 

		}

		else

		{

			$varQryStr = '?'.preg_replace('/&page=([0-9])+/','',$varQryStr).'&amp;';

		}

		

		$page_list ='';

		
	

		if (($this->page-1) > 0)

		{ 

			if($varPageName!='' && $varPageID!='')

			{

				$page_list .= '<li><a class="first" href="'.$PHP_SELF.$varQryStr.$varDispName.'='.($this->page-1).'&amp;PageName='.$varPageName.'&amp;PageId='.$varPageID.'" class="back" >&nbsp;</a><li>'; 

			}

			else

			{

				$page_list .= '<li><a class="first" href="'.$PHP_SELF.$varQryStr.$varDispName.'='.($this->page-1).'" class="back" >&nbsp;</a></li>';

			}	

		}

		else

		{

			if($varPageName!='' && $varPageID!='')

			{

				$page_list .= '<li><a class="first" href="#" onclick="return false;">&nbsp;</a></li>'; 

			}

			else

			{

				$page_list .='<li><a class="first" href="#" onclick="return false;">&nbsp;</a></li>'; 

			}	

		}

		$varPageList1 =''.$page_list.'';

		$page_list="";

		//code for paging if number of pages are more than 10

		if($this->num_pages>5)

		{

			$i = $this->page;

			$totalpage = $this->page + 4;

			for ($i=$this->page; $i<=$totalpage; $i++)

			{

				//paging by default display l page condition added 

				if($i>$this->num_pages)

				{ break; }

			

				if($this->num_pages>1)

				{

					if ($i == $this->page  )

					{

						// $page_list .= '<span class="text"><strong>'.$i.'</strong></span>';

						$page_list .= '<li><a>'.$i.'</a></li>';

					}

					else

					{

						if($varPageName!='' && $varPageID!='')

						{

							$page_list .= '<li><a href="'.$PHP_SELF.$varQryStr.$varDispName.'='.$i.'&amp;PageName='.$varPageName.'&amp;PageId='.$varPageID.'">'.$i.'</a></li>';

						}

						else

						{

							$page_list .= '<li><a href="'.$PHP_SELF.$varQryStr.$varDispName.'='.$i.'">'.$i.'</a></li>';

						}

					}

				}

			}

			

			if($totalpage < $this->num_pages)

			{

				if(($totalpage+1) < $this->num_pages)

				{

					$page_list .= '<li><a>...</a></li>';

				}

				$page_list .= '<li><a href="'.$PHP_SELF.$varQryStr.$varDispName.'='.$this->num_pages.'">'.$this->num_pages.'</a></li>';

			}

		}

		else 

		{

			for($x=1;$x<=$this->num_pages;$x++) 

			{

				if($x == $this->page)

				{

					//shows paging only if number of pages is greater than one 

					if($this->num_pages>1)

					{

						$page_list .=  '<li><a>'.$x.'</a></li>';

					}	 

				} 

				else

				{

					if($varPageName!='' && $varPageID!='')

					{

						$page_list .=  '<li><a href="'.$PHP_SELF.$varQryStr.$varDispName.'='.$x.'&amp;PageName='.$varPageName.'&amp;PageId='.$varPageID.'" >'.$x.'</a></li>';

					}

					else

					{

						$page_list .=  '<li><a href="'.$PHP_SELF.$varQryStr.$varDispName.'='.$x.'" >'.$x.'</a></li>';

					}

				} 

			}

		}//end of if else condition

	

		$varPageList2 = ''.$page_list.'';

		$page_list="";

		// Print the Next and Last page links if necessary 

		if (($this->page+1) <= $this->num_pages)

		{	

			if($varPageName!='' && $varPageID!='')

			{

				$page_list .= '<li><a class="last" href="'.$PHP_SELF.$varQryStr.$varDispName.'='.($this->page+1).'&amp;PageName='.$varPageName.'&amp;PageId='.$varPageID.'" >&nbsp;</a></li>';

			}

			else

			{

				$page_list .= '<li><a class="last" href="'.$PHP_SELF.$varQryStr.$varDispName.'='.($this->page+1).'" >&nbsp;</a></li>';

			}

		}

		else

		{	

			if($varPageName!='' && $varPageID!='')

			{

				$page_list .= '<li><a class="last">&nbsp;</a></li>';

			}

			else

			{

				$page_list .= '<li><a class="last">&nbsp;</a></li>';

			}

		}
		
		$varPageList3 = ''.$page_list.'';

		$varPageListing =$varPageList1.$varPageList2.$varPageList3;

		$page_list .= "";

		echo $varPageListing;

	} //end of function

	
	/**
	*
	* Function name : displayPaging
	*
	* Return type : String
	*
	* Date created : 15th October 2013
	*
	* Date last modified : 15th October 2013
	*
	* Author : Ashok Singh Negi
	*
	* Last modified by : Ashok Singh Negi
	*
	* Comments : This function return total page
	*
	* User instruction : $objOrder = new displayPaging($page, $num_pages, $limit, $varPageName='', $varPageID='',$arrRequest='')
	*
	*/ 	 

	function displayPaging($page, $num_pages, $limit, $varPageName='', $varPageID='',$arrRequest='' , $argDispName = '')

	{
		
		$objCore = new Core();

		if($page=="")

		{ 

			$page = 1;

		} 

		$this->page = $page;

		$this->next_page = $page + 1;

		$this->prev_page = $page - 1;

		$this->num_pages = $num_pages;

		$varReques = $_REQUEST;

		//print_r($_REQUEST);

		if(isset($varReques['PHPSESSID']))

		{

		unset($varReques['PHPSESSID']);

		}

		if(isset($varReques['__utmz']))

		{

			unset($varReques['__utmz']);

		}

		if(isset($varReques['__utma']))

		{

			unset($varReques['__utma']);

		}

		if(isset($varReques['__utmc']))

		{

			unset($varReques['__utmc']);

		}

		if(isset($varReques['__utmb']))

		{

			unset($varReques['__utmb']);

		}

		if(isset($varReques['celeb']))

		{

			unset($varReques['celeb']);

		}

	

		if($argDispName == '')

		{

			$varDispName = 'page';

			$varQryStr = $objCore->generateValidateString($varRequest,'',$varDispName);

		}

		else

		{

			$varDispName = $argDispName;

		}

	
		$varQryStr = $this->qryStr($varReques,'cookie_AgentUserPassword');

	

		$varQryStr = str_replace('?&'.$varDispName,'?'.$varDispName,$varQryStr);

		$varQryStr = str_replace('&'.$varDispName,'&amp;'.$varDispName,$varQryStr);

		$varQryStr = $objCore->generateValidateString($varRequest,'',$varDispName);

		$varRequest = $_SERVER['QUERY_STRING'];

		$varQryStr = $_SERVER['QUERY_STRING'];

		

		if(trim($varQryStr) == '')

		{

			$varQryStr = '?'.$varQryStr; 

		}

		else

		{
			
			$varQryStr = '?'.preg_replace('/&page=([0-9])+/','',$varQryStr).'&amp;';

		}

		

		$page_list ='';//<p class="paging">';

		/*if($this->page>10)

		{

			if(($this->page-1) > 0)

			{ 

				if($varPageName!='' && $varPageID!='')

				{

					$page_list .= '<a href="'.$PHP_SELF.$varQryStr.$varDispName.'='.($this->page-10).'&amp;PageName='.$varPageName.'&amp;PageId='.$varPageID.'" class="back" >&lt;&lt;&nbsp;Back10</a>';

				}

				else

				{

					$page_list .= '&nbsp;<a href="'.$PHP_SELF.$varQryStr.$varDispName.'='.($this->page-10).'" class="back" >&lt;&lt;&nbsp;Back10</a>&nbsp;';

				}

			}

		}*/

	//<a class="first paginate_button paginate_button_disabled" tabindex="0" id="DataTables_Table_0_first">First</a><a class="previous paginate_button paginate_button_disabled" tabindex="0" id="DataTables_Table_0_previous">Previous</a><span><a class="paginate_active" tabindex="0">1</a><a class="paginate_button" tabindex="0">2</a><a class="paginate_button" tabindex="0">3</a></span><a class="next paginate_button" tabindex="0" id="DataTables_Table_0_next">Next</a><a class="last paginate_button" tabindex="0" id="DataTables_Table_0_last">Last</a>

		if (($this->page-1) > 0)

		{ 

			if($varPageName!='' && $varPageID!='')

			{
				//back
				$page_list .= '<a class="previous paginate_button paginate_button_disabled" href="'.$PHP_SELF.$varQryStr.$varDispName.'='.($this->page-1).'&amp;PageName='.$varPageName.'&amp;PageId='.$varPageID.'">Prev</a>'; 
                

			}

			else

			{
				// class="back"
				$page_list .= '<a class="previous paginate_button" href="'.$PHP_SELF.$varQryStr.$varDispName.'='.($this->page-1).'">Prev</a>';
                //echo $page_list;die;

			}	

		}

		else

		{

			if($varPageName!='' && $varPageID!='')

			{

				$page_list .= '<a class="first paginate_button paginate_button_disabled">Prev</a>'; 

			}

			else

			{

				$page_list .= '<a class="first paginate_button paginate_button_disabled">Prev</a>'; 

			}	

		}

		$varPageList1 =''.$page_list.'';

		$page_list="";

		//code for paging if number of pages are more than 10
		
		/* Commented by Krishna Gupta to show activated page number highlighted (08-10-15) */
		//if($this->num_pages>5)
		
		/**
		 * Showing pagginnation in admin panel
		 * 
		 * @author : Krishna Gupta
		 * 
		 * @created : 08-10-15
		 * 
		 * @last Modified : 21-10-2015
		 */
		//echo $this->page;
		if ($this->page > 1 && $this->page <= ($this->num_pages - 4)) {
			$firstPage = 1;
			if ($this->num_pages > 4 && $_GET['page']>4) {
				
				$page_list .= '<a class="paginate_button" href="'.$PHP_SELF.$varQryStr.$varDispName.'='.$firstPage.'">'.$firstPage.'</a>';
				$dotts = '<strong>...</strong>';
				$page_list .= '<a class="paginate_button" href="'.$PHP_SELF.$varQryStr.$varDispName.'='.($_GET['page']-1).'">'.$dotts.'</a>';
			} else {
				if ($_GET['page'] > 2) {
				$page_list .= '<a class="paginate_button" href="'.$PHP_SELF.$varQryStr.$varDispName.'='.$firstPage.'">'.$firstPage.'</a>';
				$dotts = '<strong>...</strong>';
				$page_list .= '<a class="paginate_button" href="'.$PHP_SELF.$varQryStr.$varDispName.'='.($_GET['page']-1).'">'.$dotts.'</a>';
				} else {
					$page_list .= '<a class="paginate_button" href="'.$PHP_SELF.$varQryStr.$varDispName.'='.$firstPage.'">'.$firstPage.'</a>';
				}
			}
		} else {
			if ($_GET['page']>2) {
				$firstPage = 1;
			$page_list .= '<a class="paginate_button" href="'.$PHP_SELF.$varQryStr.$varDispName.'='.$firstPage.'">'.$firstPage.'</a>';
			$dotts = '<strong>...</strong>';
			$page_list .= '<a class="paginate_button" href="'.$PHP_SELF.$varQryStr.$varDispName.'='.($_GET['page']-1).'">'.$dotts.'</a>';
			} elseif ($_GET['page']==2) {
				$firstPage = 1;
				$page_list .= '<a class="paginate_button" href="'.$PHP_SELF.$varQryStr.$varDispName.'='.$firstPage.'">'.$firstPage.'</a>';
					
			}
		}
		//}
		/* if ($this->num_pages > 4 && $_GET['page']>4) {
			
			$firstPage = 1;
			$page_list .= '<a class="paginate_button" href="'.$PHP_SELF.$varQryStr.$varDispName.'='.$firstPage.'">'.$firstPage.'</a>';
			$dotts = '<strong>...</strong>';
			$page_list .= '<a class="paginate_button" href="'.$PHP_SELF.$varQryStr.$varDispName.'='.$firstPage.'">'.$dotts.'</a>';
		} */ /* elseif ($this->num_pages > 5 && $_GET['page']>4) {
			
			$firstPage = 1;
			$page_list .= '<a class="paginate_button" href="'.$PHP_SELF.$varQryStr.$varDispName.'='.$firstPage.'">'.$firstPage.'</a>';
			$dotts = '<strong>...</strong>';
			$page_list .= '<a class="paginate_button" href="'.$PHP_SELF.$varQryStr.$varDispName.'='.$firstPage.'">'.$dotts.'</a>';
		} */
		/* Commented by Krishna Gupta to show activated page number highlighted (08-10-15) ends */
		
		if($this->num_pages>1)

		{
			$page_list .= '<span>';
			$i = $this->page;

			$totalpage = $this->page + 4;
		
			/* Pagination by Krishna Gupta start (14-10-2015) */
			/* if($totalpage > $this->num_pages)
			{
				if ($this->num_pages > 10) {
					$lower_pagination = 1;
					$page_list .= '<a class="paginate_button" href="'.$PHP_SELF.$varQryStr.$varDispName.'='.$lower_pagination.'">'.$lower_pagination.'</a>';
					$page_list .= '<a class="paginate_button" href="'.$PHP_SELF.$varQryStr.$varDispName.'='.($lower_pagination+1).'">'.($lower_pagination+1).'</a>';
					$page_list .= '<a class="paginate_button" href="'.$PHP_SELF.$varQryStr.$varDispName.'='.($lower_pagination+2).'">'.($lower_pagination+2).'</a>';
					$page_list .= '<a class="paginate_button" href="'.$PHP_SELF.$varQryStr.$varDispName.'='.($lower_pagination+3).'">'.($lower_pagination+3).'</a>';
					$page_list .= '<a class="paginate_button" href="'.$PHP_SELF.$varQryStr.$varDispName.'='.($lower_pagination+4).'">'.($lower_pagination+4).'</a>';
					$page_list .= '<a class="paginate_button" href="">...</a>';
				} else {
					$i = $this->page;
					if (($i-1)>0) {
						if (($i-3)>0) {
							$page_list .= '<a class="paginate_button" href="'.$PHP_SELF.$varQryStr.$varDispName.'='.($i-3).'&amp;PageName='.$varPageName.'&amp;PageId='.$varPageID.'">'.($i-3).'</a>';
						}
						if (($i-2)>0) {
							$page_list .= '<a class="paginate_button" href="'.$PHP_SELF.$varQryStr.$varDispName.'='.($i-2).'&amp;PageName='.$varPageName.'&amp;PageId='.$varPageID.'">'.($i-2).'</a>';
						}
						$page_list .= '<a class="paginate_button" href="'.$PHP_SELF.$varQryStr.$varDispName.'='.($i-1).'&amp;PageName='.$varPageName.'&amp;PageId='.$varPageID.'">'.($i-1).'</a>';
					}
				}
			} */ 
			/* Pagination by Krishna Gupta ends */
			
			for ($i=$this->page; $i<=$totalpage; $i++)

			{

				//paging by default display l page condition added 

				if($i>$this->num_pages)

				{ break; }

				

				if($this->num_pages>1)

				{

					if ($i == $this->page  )

					{ 
						
						/**
						 * This code is working for show left side pagination according to active current page
						 * 
						 * @author : Krishna Gupta (09-10-15)
						 */
						/* if (($i-1)>0) {
							if (($i-3)>0) {
								$page_list .= '<a class="paginate_button" href="'.$PHP_SELF.$varQryStr.$varDispName.'='.($i-3).'&amp;PageName='.$varPageName.'&amp;PageId='.$varPageID.'">'.($i-3).'</a>';
							}
							if (($i-2)>0) {
								$page_list .= '<a class="paginate_button" href="'.$PHP_SELF.$varQryStr.$varDispName.'='.($i-2).'&amp;PageName='.$varPageName.'&amp;PageId='.$varPageID.'">'.($i-2).'</a>';
							}
							$page_list .= '<a class="paginate_button" href="'.$PHP_SELF.$varQryStr.$varDispName.'='.($i-1).'&amp;PageName='.$varPageName.'&amp;PageId='.$varPageID.'">'.($i-1).'</a>';
						} */
						/* Ends */
						// $page_list .= '<span class="text"><strong>'.$i.'</strong></span>';
						//if ($i != $this->num_pages) {
							$page_list .= '<a class="paginate_active">'.$i.'</a>';
						//}
						/* if (($i+1)>0) {
							if (($i+3)>0) {
								$page_list .= '<a class="paginate_button" href="'.$PHP_SELF.$varQryStr.$varDispName.'='.($i+3).'&amp;PageName='.$varPageName.'&amp;PageId='.$varPageID.'">'.($i+3).'</a>';
							}
							if (($i+2)>0) {
								$page_list .= '<a class="paginate_button" href="'.$PHP_SELF.$varQryStr.$varDispName.'='.($i+2).'&amp;PageName='.$varPageName.'&amp;PageId='.$varPageID.'">'.($i+2).'</a>';
							}
							$page_list .= '<a class="paginate_button" href="'.$PHP_SELF.$varQryStr.$varDispName.'='.($i+1).'&amp;PageName='.$varPageName.'&amp;PageId='.$varPageID.'">'.($i+1).'</a>';
						} */
					}

					else

					{

						if($varPageName!='' && $varPageID!='')

						{

							$page_list .= '<a class="paginate_button" href="'.$PHP_SELF.$varQryStr.$varDispName.'='.$i.'&amp;PageName='.$varPageName.'&amp;PageId='.$varPageID.'">'.$i.'</a>';

						}

						else

						{

							$page_list .= '<a class="paginate_button" href="'.$PHP_SELF.$varQryStr.$varDispName.'='.$i.'">'.$i.'</a>';

						}

					}

				}

			}

			/* echo $totalpage.'<br/>';
			echo $this->num_pages.'<br/>';
			die; */
			
			
			/* echo $totalpage.'<br/>';
			echo $this->num_pages.'<br/>'; */
			if($totalpage < $this->num_pages)

			{
				
				if(($totalpage+1) < $this->num_pages)

				{

					//$page_list .= '<a><strong>...</strong></a>';
					$dotted = '<strong>...</strong>';
					$page_list .= '<a class="paginate_button" href="'.$PHP_SELF.$varQryStr.$varDispName.'='.($totalpage+1).'">'.$dotted.'</a>';
				}

				$page_list .= '<a class="paginate_button" href="'.$PHP_SELF.$varQryStr.$varDispName.'='.$this->num_pages.'">'.$this->num_pages.'</a>';

			} 
			$page_list .= '</span>';
		}

		else 

		{

			for($x=1;$x<=$this->num_pages;$x++) 

			{

				if($x == $this->page)

				{

					//shows paging only if number of pages is greater than one 

					if($this->num_pages>1)

					{

						$page_list .=  '<a class="paginate_button">'.$x.'</a>';

					}	 

				} 

				else

				{

					if($varPageName!='' && $varPageID!='')

					{

						$page_list .=  '<a class="paginate_button" href="'.$PHP_SELF.$varQryStr.$varDispName.'='.$x.'&amp;PageName='.$varPageName.'&amp;PageId='.$varPageID.'" >'.$x.'</a>';

					}

					else

					{

						$page_list .=  '<a class="paginate_button" href="'.$PHP_SELF.$varQryStr.$varDispName.'='.$x.'" >'.$x.'</a>';

					}

				} 

			}

		}//end of if else condition

	

		$varPageList2 = ''.$page_list.'';

		$page_list="";

		// Print the Next and Last page links if necessary 

		if (($this->page+1) <= $this->num_pages)

		{	

			if($varPageName!='' && $varPageID!='')

			{

				$page_list .= '<a class="next paginate_button" href="'.$PHP_SELF.$varQryStr.$varDispName.'='.($this->page+1).'&amp;PageName='.$varPageName.'&amp;PageId='.$varPageID.'" class="continue" >Next</a>';

			}

			else

			{

				$page_list .= '<a class="next paginate_button" href="'.$PHP_SELF.$varQryStr.$varDispName.'='.($this->page+1).'" class="continue" >Next</a>';

			}

		}

		else

		{	

			if($varPageName!='' && $varPageID!='')

			{

				$page_list .= '<a class="last paginate_button paginate_button_disabled">Next</a>';

			}

			else

			{

				$page_list .= '<a class="last paginate_button paginate_button_disabled">Next</a>';

			}

		}

		

		/*if($totalpage <= $this->num_pages)

		{

			if(($this->page + 10) <= $this->num_pages)

			{	

				if($varPageName!='' && $varPageID!='')

				{

					$page_list .= '<a href="'.$PHP_SELF.$varQryStr.$varDispName.'='.($this->page+10).'&amp;PageName='.$varPageName.'&amp;PageId='.$varPageID.'" class="continue">Continue10&nbsp;&gt;&gt;</a>';

				}

				else

				{

					$page_list .= '<a href="'.$PHP_SELF.$varQryStr.$varDispName.'='.($this->page+10).'" class="continue" >Continue10&nbsp;&gt;&gt;</a>';

				}

			}

		}*/

		$varPageList3 = ''.$page_list.'';

		$varPageListing =$varPageList1.$varPageList2.$varPageList3;

		$page_list .= "";

		echo $varPageListing.'</p>';

	} //end of function
	
	
	/**
	*
	* Function name : displayFrontPaging
	*
	* Return type : String
	*
	* Date created : 15th October 2013
	*
	* Date last modified : 15th October 2013
	*
	* Author : Ashok Singh Negi
	*
	* Last modified by : Ashok Singh Negi
	*
	* Comments : This function return total page
	*
	* User instruction : $objOrder = new displayPaging($page, $num_pages, $limit, $varPageName='', $varPageID='',$arrRequest='')
	*
	*/ 	 

	function displayFrontPaging($page, $num_pages, $limit, $varPageName='', $varPageID='',$arrRequest='' , $argDispName = '')

	{

		$objCore = new Core();

		if($page=="")

		{ 

			$page = 1;

		} 

		$this->page = $page;

		$this->next_page = $page + 1;

		$this->prev_page = $page - 1;

		$this->num_pages = $num_pages;

		$varReques = $_REQUEST;

		//print_r($_REQUEST);

		if(isset($varReques['PHPSESSID']))

		{

		unset($varReques['PHPSESSID']);

		}

		if(isset($varReques['__utmz']))

		{

			unset($varReques['__utmz']);

		}

		if(isset($varReques['__utma']))

		{

			unset($varReques['__utma']);

		}

		if(isset($varReques['__utmc']))

		{

			unset($varReques['__utmc']);

		}

		if(isset($varReques['__utmb']))

		{

			unset($varReques['__utmb']);

		}

		if(isset($varReques['celeb']))

		{

			unset($varReques['celeb']);

		}

	

		if($argDispName == '')

		{

			$varDispName = 'page';

			$varQryStr = $objCore->generateValidateString($varRequest,'',$varDispName);

		}

		else

		{

			$varDispName = $argDispName;

		}

	

		$varQryStr = $this->qryStr($varReques,'cookie_AgentUserPassword');

	

		$varQryStr = str_replace('?&'.$varDispName,'?'.$varDispName,$varQryStr);

		$varQryStr = str_replace('&'.$varDispName,'&amp;'.$varDispName,$varQryStr);

		$varQryStr = $objCore->generateValidateString($varRequest,'',$varDispName);

		$varRequest = $_SERVER['QUERY_STRING'];

		$varQryStr = $_SERVER['QUERY_STRING'];

		

		if(trim($varQryStr) == '')

		{

			$varQryStr = '?'.$varQryStr; 

		}

		else

		{

			$varQryStr = '?'.preg_replace('/&page=([0-9])+/','',$varQryStr).'&amp;';

		}

		

		$page_list ='<p class="paging">';

		/*if($this->page>10)

		{

			if(($this->page-1) > 0)

			{ 

				if($varPageName!='' && $varPageID!='')

				{

					$page_list .= '<a href="'.$PHP_SELF.$varQryStr.$varDispName.'='.($this->page-10).'&amp;PageName='.$varPageName.'&amp;PageId='.$varPageID.'" class="back" >&lt;&lt;&nbsp;Back10</a>';

				}

				else

				{

					$page_list .= '&nbsp;<a href="'.$PHP_SELF.$varQryStr.$varDispName.'='.($this->page-10).'" class="back" >&lt;&lt;&nbsp;Back10</a>&nbsp;';

				}

			}

		}*/

	

		if (($this->page-1) > 0)

		{ 

			if($varPageName!='' && $varPageID!='')

			{

				$page_list .= '&nbsp;<a href="'.$PHP_SELF.$varQryStr.$varDispName.'='.($this->page-1).'&amp;PageName='.$varPageName.'&amp;PageId='.$varPageID.'" class="back" >&lt;&lt;&nbsp;Back</a>&nbsp;'; 
                

			}

			else

			{

				$page_list .= '&nbsp;<a href="'.$PHP_SELF.$varQryStr.$varDispName.'='.($this->page-1).'" class="back" >&lt;&lt;&nbsp;Back</a>&nbsp;';
                //echo $page_list;die;

			}	

		}

		else

		{

			if($varPageName!='' && $varPageID!='')

			{

				$page_list .= '&nbsp;<span class="disabled">&lt;&lt;&nbsp;Back</span>'; 

			}

			else

			{

				$page_list .= '&nbsp;<span class="disabled">&lt;&lt;&nbsp;Back</span>&nbsp;';

			}	

		}

		$varPageList1 =''.$page_list.'';

		$page_list="";

		//code for paging if number of pages are more than 10

		if($this->num_pages>5)

		{

			$i = $this->page;

			$totalpage = $this->page + 4;

			for ($i=$this->page; $i<=$totalpage; $i++)

			{

				//paging by default display l page condition added 

				if($i>$this->num_pages)

				{ break; }

			

				if($this->num_pages>1)

				{

					if ($i == $this->page  )

					{

						// $page_list .= '<span class="text"><strong>'.$i.'</strong></span>';

						$page_list .= '&nbsp;<a><span>'.$i.'</span></a>&nbsp;';

					}

					else

					{

						if($varPageName!='' && $varPageID!='')

						{

							$page_list .= '&nbsp;<a style="text-decoration:underline" href="'.$PHP_SELF.$varQryStr.$varDispName.'='.$i.'&amp;PageName='.$varPageName.'&amp;PageId='.$varPageID.'">'.$i.'</a>&nbsp;';

						}

						else

						{

							$page_list .= '&nbsp;<a style="text-decoration:underline" href="'.$PHP_SELF.$varQryStr.$varDispName.'='.$i.'">'.$i.'</a>&nbsp;';

						}

					}

				}

			}

			

			if($totalpage < $this->num_pages)

			{

				if(($totalpage+1) < $this->num_pages)

				{

					$page_list .= '<a><strong>...</strong></a>';

				}

				$page_list .= '&nbsp;<a style="text-decoration:underline" href="'.$PHP_SELF.$varQryStr.$varDispName.'='.$this->num_pages.'">'.$this->num_pages.'</a>&nbsp;';

			}

		}

		else 

		{

			for($x=1;$x<=$this->num_pages;$x++) 

			{

				if($x == $this->page)

				{

					//shows paging only if number of pages is greater than one 

					if($this->num_pages>1)

					{

						$page_list .=  '&nbsp;<a><span>'.$x.'</span></a>&nbsp;';

					}	 

				} 

				else

				{

					if($varPageName!='' && $varPageID!='')

					{

						$page_list .=  '&nbsp;<a style="text-decoration:underline" href="'.$PHP_SELF.$varQryStr.$varDispName.'='.$x.'&amp;PageName='.$varPageName.'&amp;PageId='.$varPageID.'" >'.$x.'</a>&nbsp;';

					}

					else

					{

						$page_list .=  '&nbsp;<a style="text-decoration:underline" href="'.$PHP_SELF.$varQryStr.$varDispName.'='.$x.'" >'.$x.'</a>&nbsp;';

					}

				} 

			}

		}//end of if else condition

	

		$varPageList2 = ''.$page_list.'';

		$page_list="";

		// Print the Next and Last page links if necessary 

		if (($this->page+1) <= $this->num_pages)

		{	

			if($varPageName!='' && $varPageID!='')

			{

				$page_list .= '&nbsp;<a href="'.$PHP_SELF.$varQryStr.$varDispName.'='.($this->page+1).'&amp;PageName='.$varPageName.'&amp;PageId='.$varPageID.'" class="continue" >Continue&nbsp;&gt;&gt;</a>&nbsp;';

			}

			else

			{

				$page_list .= '&nbsp;<a href="'.$PHP_SELF.$varQryStr.$varDispName.'='.($this->page+1).'" class="continue" >Continue&nbsp;&gt;&gt;</a>&nbsp;';

			}

		}

		else

		{	

			if($varPageName!='' && $varPageID!='')

			{

				$page_list .= '&nbsp;<span class="disabled">Continue&nbsp;&gt;&gt;</span>&nbsp;';

			}

			else

			{

				$page_list .= '&nbsp;<span class="disabled">Continue&nbsp;&gt;&gt;</span>&nbsp;';

			}

		}

		

		/*if($totalpage <= $this->num_pages)

		{

			if(($this->page + 10) <= $this->num_pages)

			{	

				if($varPageName!='' && $varPageID!='')

				{

					$page_list .= '<a href="'.$PHP_SELF.$varQryStr.$varDispName.'='.($this->page+10).'&amp;PageName='.$varPageName.'&amp;PageId='.$varPageID.'" class="continue">Continue10&nbsp;&gt;&gt;</a>';

				}

				else

				{

					$page_list .= '<a href="'.$PHP_SELF.$varQryStr.$varDispName.'='.($this->page+10).'" class="continue" >Continue10&nbsp;&gt;&gt;</a>';

				}

			}

		}*/

		$varPageList3 = ''.$page_list.'';

		$varPageListing =$varPageList1.$varPageList2.$varPageList3;

		$page_list .= "";

		echo $varPageListing.'</p>';

	} //end of function
	
	
	/**
	*
	* Function name : displaySolrPaging
	*
	* Return type : String
	*
	* Date created : 15th October 2013
	*
	* Date last modified : 15th October 2013
	*
	* Author : Ashok Singh Negi
	*
	* Last modified by : Ashok Singh Negi
	*
	* Comments : This function return total page
	*
	* User instruction : $objOrder = new displayPaging($page, $num_pages, $limit, $varPageName='', $varPageID='',$arrRequest='')
	*
	*/ 	 

	function displaySolrPaging($page=0, $num_pages, $limit, $varPageName='', $varPageID='',$arrRequest='' , $argDispName = '')

	{

		$objCore = new Core();

		if($page==0)

		{ 

			$page = 1;

		} 

		$this->page = $page;

		$this->next_page = $page + 1;

		$this->prev_page = $page - 1;

		$this->num_pages = $num_pages;

		$varReques = $_REQUEST;

		//print_r($_REQUEST);

		if(isset($varReques['PHPSESSID']))

		{

		unset($varReques['PHPSESSID']);

		}

		if(isset($varReques['__utmz']))

		{

			unset($varReques['__utmz']);

		}

		if(isset($varReques['__utma']))

		{

			unset($varReques['__utma']);

		}

		if(isset($varReques['__utmc']))

		{

			unset($varReques['__utmc']);

		}

		if(isset($varReques['__utmb']))

		{

			unset($varReques['__utmb']);

		}

		if(isset($varReques['celeb']))

		{

			unset($varReques['celeb']);

		}

	

		if($argDispName == '')

		{

			$varDispName = 'page';

			$varQryStr = $objCore->generateValidateString($varRequest,'',$varDispName);

		}

		else

		{

			$varDispName = $argDispName;

		}

	

		$varQryStr = $this->qryStr($varReques,'cookie_AgentUserPassword');

	

		$varQryStr = str_replace('?&'.$varDispName,'?'.$varDispName,$varQryStr);

		$varQryStr = str_replace('&'.$varDispName,'&amp;'.$varDispName,$varQryStr);

		$varQryStr = $objCore->generateValidateString($varRequest,'',$varDispName);

		$varRequest = $_SERVER['QUERY_STRING'];

		$varQryStr = $_SERVER['QUERY_STRING'];

		$page_list ='<p class="paging">';

		if (($this->page-1) > 0)

		{ 

			if($varPageName!='' && $varPageID!='')

			{

				$page_list .= '&nbsp;<a href="'.($this->page-1).'" class="back ajax_page" >&lt;&lt;&nbsp;Back</a>&nbsp;'; 
                

			}

			else

			{
				$page_list .= '&nbsp;<a href="'.($this->page-1).'" class="back ajax_page" >&lt;&lt;&nbsp;Back</a>&nbsp;';
				if($this->page > ((PAGE_SIZE/2)+1)){
					$page_list .= '<a style="text-decoration:underline" href="1" class="ajax_page">1</a>&nbsp;';
					$page_list .= '<a><strong>...</strong></a>';
				}
				
                //echo $page_list;die;

			}	

		}

		else

		{

			if($varPageName!='' && $varPageID!='')

			{

				$page_list .= '&nbsp;<span class="disabled">Back</span>'; 

			}

			else

			{

				$page_list .= '&nbsp;<span class="disabled">Back</span>&nbsp;';

			}	

		}

		$varPageList1 =''.$page_list.'';

		$page_list="";

		//code for paging if number of pages are more than 10

		if($this->num_pages > PAGE_SIZE)

		{
			if($this->page < 4){
				$startpage = 1;
				$totalpage = PAGE_SIZE;
			}
			else
			{				
				if($this->num_pages==$this->page)
				{
					$startpage = $this->num_pages-(PAGE_SIZE-1);
					$totalpage = $startpage + (PAGE_SIZE-1);
				}
				else
				{
					$startpage = $this->page - (int)(PAGE_SIZE/2);
					$totalpage = $this->page + (int)(PAGE_SIZE/2);
				}	
			}

			for ($i=$startpage; $i<=$totalpage; $i++)

			{

				//paging by default display l page condition added 

				/*if($i>$this->num_pages)

				{ break; }*/


					if ($i == $this->page  )

					{

						// $page_list .= '<span class="text"><strong>'.$i.'</strong></span>';

						$page_list .= '&nbsp;<a><span>'.$i.'</span></a>&nbsp;';

					}

					else

					{
						if($varPageName!='' && $varPageID!='')

						{

							$page_list .= '&nbsp;<a style="text-decoration:underline" href="'.$i.'" class="ajax_page">'.$i.'</a>&nbsp;';

						}

						else

						{

							$page_list .= '&nbsp;<a style="text-decoration:underline" href="'.$i.'" class="ajax_page">'.$i.'</a>&nbsp;';

						}

					}

				

			}

			

			if($totalpage < $this->num_pages)

			{

				if(($totalpage+1) < $this->num_pages)

				{

					$page_list .= '<a><strong>...</strong></a>';

				}

				$page_list .= '&nbsp;<a style="text-decoration:underline" href="'.$this->num_pages.'" class="ajax_page">'.$this->num_pages.'</a>&nbsp;';

			}

		}

		else 

		{
			for($x=1;$x<=$this->num_pages;$x++) 

			{

				if($x == $this->page)

				{

					//shows paging only if number of pages is greater than one 

					if($this->num_pages>1)

					{

						$page_list .=  '&nbsp;<a><span>'.$x.'</span></a>&nbsp;';

					}	 

				} 

				else

				{

					if($varPageName!='' && $varPageID!='')

					{

						$page_list .=  '&nbsp;<a style="text-decoration:underline" href="'.$x.'"  class="ajax_page">'.$x.'</a>&nbsp;';

					}

					else

					{

						$page_list .=  '&nbsp;<a style="text-decoration:underline" href="'.$x.'"  class="ajax_page">'.$x.'</a>&nbsp;';

					}

				} 

			}

		}//end of if else condition

	

		$varPageList2 = ''.$page_list.'';

		$page_list="";

		// Print the Next and Last page links if necessary 

		if (($this->page+1) <= $this->num_pages)

		{	

			if($varPageName!='' && $varPageID!='')

			{

				$page_list .= '&nbsp;<a href="'.($this->page+1).'" class="continue ajax_page">Continue&nbsp;&gt;&gt;</a>&nbsp;';

			}

			else

			{

				$page_list .= '&nbsp;<a href="'.($this->page+1).'" class="continue ajax_page">Continue&nbsp;&gt;&gt;</a>&nbsp;';

			}

		}

		else

		{	

			if($varPageName!='' && $varPageID!='')

			{

				$page_list .= '&nbsp;<span class="disabled">Continue&nbsp;&gt;&gt;</span>&nbsp;';

			}

			else

			{

				$page_list .= '&nbsp;<span class="disabled">Continue&nbsp;&gt;&gt;</span>&nbsp;';

			}

		}

		$varPageList3 = ''.$page_list.'';

		$varPageListing =$varPageList1.$varPageList2.$varPageList3;

		$page_list .= "";

		echo $varPageListing.'</p>';

	} 
    	/**
	*
	* Function name : displayPaging
	*
	* Return type : String
	*
	* Date created : 15th October 2013
	*
	* Date last modified : 15th October 2013
	*
	* Author : Ashok Singh Negi
	*
	* Last modified by : Ashok Singh Negi
	*
	* Comments : This function return total page
	*
	* User instruction : $objOrder = new displayPaging($page, $num_pages, $limit, $varPageName='', $varPageID='',$arrRequest='')
	*
	*/	 

	function displayPendingPaging($pen_page, $num_pen_pages, $limit, $varpen_pageName='', $varpen_pageID='',$arrRequest='' , $argDispName = '')

	{

		$objCore = new Core();

		if($pen_page=="")

		{ 

			$pen_page = 1;

		} 

		$this->pen_page = $pen_page;

		$this->next_pen_page = $pen_page + 1;

		$this->prev_pen_page = $pen_page - 1;

		$this->num_pen_pages = $num_pen_pages;

		$varReques = $_REQUEST;

		//print_r($_REQUEST);

		if(isset($varReques['PHPSESSID']))

		{

		unset($varReques['PHPSESSID']);

		}

		if(isset($varReques['__utmz']))

		{

			unset($varReques['__utmz']);

		}

		if(isset($varReques['__utma']))

		{

			unset($varReques['__utma']);

		}

		if(isset($varReques['__utmc']))

		{

			unset($varReques['__utmc']);

		}

		if(isset($varReques['__utmb']))

		{

			unset($varReques['__utmb']);

		}

		if(isset($varReques['celeb']))

		{

			unset($varReques['celeb']);

		}

	

		if($argDispName == '')

		{

			$varDispName = 'pen_page';

			$varQryStr = $objCore->generateValidateString($varRequest,'',$varDispName);

		}

		else

		{

			$varDispName = $argDispName;

		}

	

		$varQryStr = $this->qryStr($varReques,'cookie_AgentUserPassword');

	

		$varQryStr = str_replace('?&'.$varDispName,'?'.$varDispName,$varQryStr);

		$varQryStr = str_replace('&'.$varDispName,'&amp;'.$varDispName,$varQryStr);

		$varQryStr = $objCore->generateValidateString($varRequest,'',$varDispName);

		$varRequest = $_SERVER['QUERY_STRING'];

		$varQryStr = $_SERVER['QUERY_STRING'];

		

		if(trim($varQryStr) == '')

		{

			$varQryStr = '?'.$varQryStr; 

		}

		else

		{

			$varQryStr = '?'.preg_replace('/&pen_page=([0-9])+/','',$varQryStr).'&amp;';

		}

		

		$pen_page_list ='<p class="paging">';

		/*if($this->pen_page>10)

		{

			if(($this->pen_page-1) > 0)

			{ 

				if($varpen_pageName!='' && $varpen_pageID!='')

				{

					$pen_page_list .= '<a href="'.$PHP_SELF.$varQryStr.$varDispName.'='.($this->pen_page-10).'&amp;pen_pageName='.$varpen_pageName.'&amp;pen_pageId='.$varpen_pageID.'" class="back" >&lt;&lt;&nbsp;Back10</a>';

				}

				else

				{

					$pen_page_list .= '&nbsp;<a href="'.$PHP_SELF.$varQryStr.$varDispName.'='.($this->pen_page-10).'" class="back" >&lt;&lt;&nbsp;Back10</a>&nbsp;';

				}

			}

		}*/

	

		if (($this->pen_page-1) > 0)

		{ 

			if($varpen_pageName!='' && $varpen_pageID!='')

			{

				$pen_page_list .= '&nbsp;<a href="'.$PHP_SELF.$varQryStr.$varDispName.'='.($this->pen_page-1).'&amp;pen_pageName='.$varpen_pageName.'&amp;pen_pageId='.$varpen_pageID.'" class="back" >&lt;&lt;&nbsp;Back</a>&nbsp;'; 

			}

			else

			{

				$pen_page_list .= '&nbsp;<a href="'.$PHP_SELF.$varQryStr.$varDispName.'='.($this->pen_page-1).'" class="back" >&lt;&lt;&nbsp;Back</a>&nbsp;';

			}	

		}

		else

		{

			if($varpen_pageName!='' && $varpen_pageID!='')

			{

				$pen_page_list .= '&nbsp;<span class="disabled">&lt;&lt;&nbsp;Back</span>'; 

			}

			else

			{

				$pen_page_list .= '&nbsp;<span class="disabled">&lt;&lt;&nbsp;Back</span>&nbsp;';

			}	

		}

		$varpen_pageList1 =''.$pen_page_list.'';

		$pen_page_list="";

		//code for paging if number of pen_pages are more than 10

		if($this->num_pen_pages>5)

		{

			$i = $this->pen_page;

			$totalpen_page = $this->pen_page + 4;

			for ($i=$this->pen_page; $i<=$totalpen_page; $i++)

			{

				//paging by default display l pen_page condition added 

				if($i>$this->num_pen_pages)

				{ break; }

			

				if($this->num_pen_pages>1)

				{

					if ($i == $this->pen_page  )

					{

						// $pen_page_list .= '<span class="text"><strong>'.$i.'</strong></span>';

						$pen_page_list .= '&nbsp;<a><span>'.$i.'</span></a>&nbsp;';

					}

					else

					{

						if($varpen_pageName!='' && $varpen_pageID!='')

						{

							$pen_page_list .= '&nbsp;<a style="text-decoration:underline" href="'.$PHP_SELF.$varQryStr.$varDispName.'='.$i.'&amp;pen_pageName='.$varpen_pageName.'&amp;pen_pageId='.$varpen_pageID.'">'.$i.'</a>&nbsp;';

						}

						else

						{

							$pen_page_list .= '&nbsp;<a style="text-decoration:underline" href="'.$PHP_SELF.$varQryStr.$varDispName.'='.$i.'">'.$i.'</a>&nbsp;';

						}

					}

				}

			}

			

			if($totalpen_page < $this->num_pen_pages)

			{

				if(($totalpen_page+1) < $this->num_pen_pages)

				{

					$pen_page_list .= '<a><strong>...</strong></a>';

				}

				$pen_page_list .= '&nbsp;<a style="text-decoration:underline" href="'.$PHP_SELF.$varQryStr.$varDispName.'='.$this->num_pen_pages.'">'.$this->num_pen_pages.'</a>&nbsp;';

			}

		}

		else 

		{

			for($x=1;$x<=$this->num_pen_pages;$x++) 

			{

				if($x == $this->pen_page)

				{

					//shows paging only if number of pen_pages is greater than one 

					if($this->num_pen_pages>1)

					{

						$pen_page_list .=  '&nbsp;<a><span>'.$x.'</span></a>&nbsp;';

					}	 

				} 

				else

				{

					if($varpen_pageName!='' && $varpen_pageID!='')

					{

						$pen_page_list .=  '&nbsp;<a style="text-decoration:underline" href="'.$PHP_SELF.$varQryStr.$varDispName.'='.$x.'&amp;pen_pageName='.$varpen_pageName.'&amp;pen_pageId='.$varpen_pageID.'" >'.$x.'</a>&nbsp;';

					}

					else

					{

						$pen_page_list .=  '&nbsp;<a style="text-decoration:underline" href="'.$PHP_SELF.$varQryStr.$varDispName.'='.$x.'" >'.$x.'</a>&nbsp;';

					}

				} 

			}

		}//end of if else condition

	

		$varpen_pageList2 = ''.$pen_page_list.'';

		$pen_page_list="";

		// Print the Next and Last pen_page links if necessary 

		if (($this->pen_page+1) <= $this->num_pen_pages)

		{	

			if($varpen_pageName!='' && $varpen_pageID!='')

			{

				$pen_page_list .= '&nbsp;<a href="'.$PHP_SELF.$varQryStr.$varDispName.'='.($this->pen_page+1).'&amp;pen_pageName='.$varpen_pageName.'&amp;pen_pageId='.$varpen_pageID.'" class="continue" >Continue&nbsp;&gt;&gt;</a>&nbsp;';

			}

			else

			{

				$pen_page_list .= '&nbsp;<a href="'.$PHP_SELF.$varQryStr.$varDispName.'='.($this->pen_page+1).'" class="continue" >Continue&nbsp;&gt;&gt;</a>&nbsp;';

			}

		}

		else

		{	

			if($varpen_pageName!='' && $varpen_pageID!='')

			{

				$pen_page_list .= '&nbsp;<span class="disabled">Continue&nbsp;&gt;&gt;</span>&nbsp;';

			}

			else

			{

				$pen_page_list .= '&nbsp;<span class="disabled">Continue&nbsp;&gt;&gt;</span>&nbsp;';

			}

		}

		

		/*if($totalpen_page <= $this->num_pen_pages)

		{

			if(($this->pen_page + 10) <= $this->num_pen_pages)

			{	

				if($varpen_pageName!='' && $varpen_pageID!='')

				{

					$pen_page_list .= '<a href="'.$PHP_SELF.$varQryStr.$varDispName.'='.($this->pen_page+10).'&amp;pen_pageName='.$varpen_pageName.'&amp;pen_pageId='.$varpen_pageID.'" class="continue">Continue10&nbsp;&gt;&gt;</a>';

				}

				else

				{

					$pen_page_list .= '<a href="'.$PHP_SELF.$varQryStr.$varDispName.'='.($this->pen_page+10).'" class="continue" >Continue10&nbsp;&gt;&gt;</a>';

				}

			}

		}*/

		$varpen_pageList3 = ''.$pen_page_list.'';

		$varpen_pageListing =$varpen_pageList1.$varpen_pageList2.$varpen_pageList3;

		$pen_page_list .= "";

		echo $varpen_pageListing.'</p>';

	} //end of function
	

	
	
	/**
	*
	* Function name : displayPaging
	*
	* Return type : String
	*
	* Date created : 15th October 2013
	*
	* Date last modified : 15th October 2013
	*
	* Author : Ashok Singh Negi
	*
	* Last modified by : Ashok Singh Negi
	*
	* Comments : This function return total page
	*
	* User instruction : $objOrder = new displayPaging($page, $num_pages, $limit, $varPageName='', $varPageID='',$arrRequest='')
	*
	*/ 	 

	function displayFrontEndPaging($page, $num_pages, $limit, $varPageName='', $varPageID='',$arrRequest='' , $argDispName = '')

	{

		$objCore = new Core();

		if($page=="")

		{ 

			$page = 1;

		} 

		$this->page = $page;

		$this->next_page = $page + 1;

		$this->prev_page = $page - 1;

		$this->num_pages = $num_pages;

		$varReques = $_REQUEST;

		//print_r($_REQUEST);

		if(isset($varReques['PHPSESSID']))

		{

		unset($varReques['PHPSESSID']);

		}

		if(isset($varReques['__utmz']))

		{

			unset($varReques['__utmz']);

		}

		if(isset($varReques['__utma']))

		{

			unset($varReques['__utma']);

		}

		if(isset($varReques['__utmc']))

		{

			unset($varReques['__utmc']);

		}

		if(isset($varReques['__utmb']))

		{

			unset($varReques['__utmb']);

		}

		if(isset($varReques['celeb']))

		{

			unset($varReques['celeb']);

		}

	

		if($argDispName == '')

		{

			$varDispName = 'page';

			$varQryStr = $objCore->generateValidateString($varRequest,'',$varDispName);

		}

		else

		{

			$varDispName = $argDispName;

		}

	

		$varQryStr = $this->qryStr($varReques,'cookie_AgentUserPassword');

	

		$varQryStr = str_replace('?&'.$varDispName,'?'.$varDispName,$varQryStr);

		$varQryStr = str_replace('&'.$varDispName,'&amp;'.$varDispName,$varQryStr);

		$varQryStr = $objCore->generateValidateString($varRequest,'',$varDispName);

		$varRequest = $_SERVER['QUERY_STRING'];

		$varQryStr = $_SERVER['QUERY_STRING'];

		

		if(trim($varQryStr) == '')

		{

			$varQryStr = '?'.$varQryStr; 

		}

		else

		{

			$varQryStr = '?'.preg_replace('/&page=([0-9])+/','',$varQryStr).'&amp;';

		}

		

		//$page_list ='<p class="paging">';

		/*if($this->page>10)

		{

			if(($this->page-1) > 0)

			{ 

				if($varPageName!='' && $varPageID!='')

				{

					$page_list .= '<a href="'.$PHP_SELF.$varQryStr.$varDispName.'='.($this->page-10).'&amp;PageName='.$varPageName.'&amp;PageId='.$varPageID.'" class="back" >&lt;&lt;&nbsp;Back10</a>';

				}

				else

				{

					$page_list .= '&nbsp;<a href="'.$PHP_SELF.$varQryStr.$varDispName.'='.($this->page-10).'" class="back" >&lt;&lt;&nbsp;Back10</a>&nbsp;';

				}

			}

		}*/

	

		if (($this->page-1) > 0)

		{ 

			if($varPageName!='' && $varPageID!='')

			{

				$page_list .= '<li><a href="'.$PHP_SELF.$varQryStr.$varDispName.'='.($this->page-1).'&amp;PageName='.$varPageName.'&amp;PageId='.$varPageID.'" class="back" >&lt;&lt;&nbsp;Back</a></li>'; 

			}

			else

			{

				$page_list .= '<li><a href="'.$PHP_SELF.$varQryStr.$varDispName.'='.($this->page-1).'" class="back" >&lt;&lt;&nbsp;Back</a></li>';

			}	

		}

		else

		{

			if($varPageName!='' && $varPageID!='')

			{

				$page_list .= '<li>Back</li>'; 

			}

			else

			{

				$page_list .= '<li>Back</li>'; 

			}	

		}

		$varPageList1 =''.$page_list.'';

		$page_list="";

		//code for paging if number of pages are more than 10

		if($this->num_pages>5)

		{

			$i = $this->page;

			$totalpage = $this->page + 4;

			for ($i=$this->page; $i<=$totalpage; $i++)

			{

				//paging by default display l page condition added 

				if($i>$this->num_pages)

				{ break; }

			

				if($this->num_pages>1)

				{

					if ($i == $this->page  )

					{

						// $page_list .= '<span class="text"><strong>'.$i.'</strong></span>';

						//$page_list .= '&nbsp;<a><span>'.$i.'</span></a>&nbsp;';
						$page_list .= '<li><a class="active">'.$i.'</a></li>';

					}

					else

					{

						if($varPageName!='' && $varPageID!='')

						{

							//$page_list .= '&nbsp;<a style="text-decoration:underline" href="'.$PHP_SELF.$varQryStr.$varDispName.'='.$i.'&amp;PageName='.$varPageName.'&amp;PageId='.$varPageID.'">'.$i.'</a>&nbsp;';
							$page_list .= '<li><a href="'.$PHP_SELF.$varQryStr.$varDispName.'='.$i.'&amp;PageName='.$varPageName.'&amp;PageId='.$varPageID.'">'.$i.'</a></li>';

						}

						else

						{

							//$page_list .= '&nbsp;<a style="text-decoration:underline" href="'.$PHP_SELF.$varQryStr.$varDispName.'='.$i.'">'.$i.'</a>&nbsp;';
							$page_list .= '<li><a href="'.$PHP_SELF.$varQryStr.$varDispName.'='.$i.'">'.$i.'</a></li>';

						}

					}

				}

			}

			

			if($totalpage < $this->num_pages)

			{

				if(($totalpage+1) < $this->num_pages)

				{

					$page_list .= '<a><strong>...</strong></a>';

				}

				$page_list .= '<li><a href="'.$PHP_SELF.$varQryStr.$varDispName.'='.$this->num_pages.'">'.$this->num_pages.'</a></li>';

			}

		}

		else 

		{

			for($x=1;$x<=$this->num_pages;$x++) 

			{

				if($x == $this->page)

				{

					//shows paging only if number of pages is greater than one 

					if($this->num_pages>1)

					{

						$page_list .=  '<li><a class="active">'.$x.'</a></li>';

					}	 

				} 

				else

				{

					if($varPageName!='' && $varPageID!='')

					{

						$page_list .=  '<li><a href="'.$PHP_SELF.$varQryStr.$varDispName.'='.$x.'&amp;PageName='.$varPageName.'&amp;PageId='.$varPageID.'" >'.$x.'</a></li>';

					}

					else

					{

						$page_list .=  '<li><a href="'.$PHP_SELF.$varQryStr.$varDispName.'='.$x.'" >'.$x.'</a></li>';

					}

				} 

			}

		}//end of if else condition

	

		$varPageList2 = ''.$page_list.'';

		$page_list="";

		// Print the Next and Last page links if necessary 

		if (($this->page+1) <= $this->num_pages)

		{	

			if($varPageName!='' && $varPageID!='')

			{

				$page_list .= '<li class="next"><a href="'.$PHP_SELF.$varQryStr.$varDispName.'='.($this->page+1).'&amp;PageName='.$varPageName.'&amp;PageId='.$varPageID.'" class="continue" >Next</a></li>;';
				
				

			}

			else

			{

				$page_list .= '<li class="next"><a href="'.$PHP_SELF.$varQryStr.$varDispName.'='.($this->page+1).'" class="continue" >Next</a></li>';

			}

		}

		else

		{	

			if($varPageName!='' && $varPageID!='')

			{

				$page_list .= '<li>Next</li>';

			}

			else

			{

				$page_list .= '<li>Next</li>';

			}

		}

		

		/*if($totalpage <= $this->num_pages)

		{

			if(($this->page + 10) <= $this->num_pages)

			{	

				if($varPageName!='' && $varPageID!='')

				{

					$page_list .= '<a href="'.$PHP_SELF.$varQryStr.$varDispName.'='.($this->page+10).'&amp;PageName='.$varPageName.'&amp;PageId='.$varPageID.'" class="continue">Continue10&nbsp;&gt;&gt;</a>';

				}

				else

				{

					$page_list .= '<a href="'.$PHP_SELF.$varQryStr.$varDispName.'='.($this->page+10).'" class="continue" >Continue10&nbsp;&gt;&gt;</a>';

				}

			}

		}*/

		$varPageList3 = ''.$page_list.'';

		$varPageListing =$varPageList1.$varPageList2.$varPageList3;

		$page_list .= "";

		//echo $varPageListing.'</p>';
		echo $varPageListing;

	} //end of function
	
	
	
	

    	/**
	*
	* Function name : displaySingleLinkPaging
	*
	* Return type : String
	*
	* Date created : 15th October 2013
	*
	* Date last modified : 15th October 2013
	*
	* Author : Ashok Singh Negi
	*
	* Last modified by : Ashok Singh Negi
	*
	* Comments : This function return total page
	*
	* User instruction : $objOrder = new displaySingleLinkPaging($argVarBackLinkString, $argVarNextLinkString, $argVarCurrentPage, $argVarTotalPages)
	*
	*/ 	

	function displaySingleLinkPaging($argVarBackLinkString, $argVarNextLinkString, $argVarCurrentPage, $argVarTotalPages)

	{

		$varQryStr = $_SERVER['QUERY_STRING'];

		

		if(trim($varQryStr) == '')

		{

			$varQryStr = '?'.$varQryStr; 

		}

		else

		{

			$varQryStr = '?'.preg_replace('/&page=([0-9]*)/','',$varQryStr).'&amp;';

		}

		

		if($argVarTotalPages > 1)

		{

			//get next page link

			if($argVarCurrentPage == $argVarTotalPages) 

			{

				$varNextPageLink = '<span style="background:transparent none repeat scroll 0 0; color:#A0A0A0;">'.$argVarNextLinkString.'</span>';

			}

			else if($argVarCurrentPage != '' )

			{

				$varNextPageLink = '<a href="'.$PHP_SELF.$varQryStr.'page='.($argVarCurrentPage+1).'">'.$argVarNextLinkString.'</a>';

			}

			else

			{

				$varNextPageLink = '<a href="'.$PHP_SELF.$varQryStr.'page=2">'.$argVarNextLinkString.'</a>';

			}

			

			//get previous page link

			if($argVarCurrentPage == '' || $argVarCurrentPage == '1') 

			{

				$varPreviousPageLink = '<span style="background:transparent none repeat scroll 0 0; color:#A0A0A0;">'.$argVarBackLinkString.'</span>';

			}

			else //if($_GET['page'] != '' )

			{

				$varPreviousPageLink = '<a href="'.$PHP_SELF.$varQryStr.'page='.($argVarCurrentPage-1).'">'.$argVarBackLinkString.'</a>';

			}

			

			$arrLinks['Prev'] = $varPreviousPageLink;

			$arrLinks['Next'] = $varNextPageLink;

			

			return $arrLinks;

		}

	}
    
    	/**
	*
	* Function name : displayPaging
	*
	* Return type : String
	*
	* Date created : 15th October 2013
	*
	* Date last modified : 15th October 2013
	*
	* Author : Ashok Singh Negi
	*
	* Last modified by : Ashok Singh Negi
	*
	* Comments : This function return total page
	*
	* User instruction : $objOrder = new displayPaging($page, $num_pages, $limit, $varPageName='', $varPageID='',$arrRequest='')
	*
	*/ 	 

	function displayAjaxPaging($page, $num_pages, $limit, $varPageName='', $varPageID='',$arrRequest='' , $argDispName = '', $querystring = '')

	{

		$objCore = new Core();

		if($page=="")

		{ 

			$page = 1;

		} 

		$this->page = $page;

		$this->next_page = $page + 1;

		$this->prev_page = $page - 1;

		$this->num_pages = $num_pages;

		$varReques = $_REQUEST;

		//print_r($_REQUEST);

		if(isset($varReques['PHPSESSID']))

		{

		unset($varReques['PHPSESSID']);

		}

		if(isset($varReques['__utmz']))

		{

			unset($varReques['__utmz']);

		}

		if(isset($varReques['__utma']))

		{

			unset($varReques['__utma']);

		}

		if(isset($varReques['__utmc']))

		{

			unset($varReques['__utmc']);

		}

		if(isset($varReques['__utmb']))

		{

			unset($varReques['__utmb']);

		}

		if(isset($varReques['celeb']))

		{

			unset($varReques['celeb']);

		}

	

		if($argDispName == '')

		{

			$varDispName = 'page';

			$varQryStr = $objCore->generateValidateString($varRequest,'',$varDispName);

		}

		else

		{

			$varDispName = $argDispName;

		}

	

		$varQryStr = $this->qryStr($varReques,'cookie_AgentUserPassword');

	

		$varQryStr = str_replace('?&'.$varDispName,'?'.$varDispName,$varQryStr);

		$varQryStr = str_replace('&'.$varDispName,'&amp;'.$varDispName,$varQryStr);

		$varQryStr = $objCore->generateValidateString($varRequest,'',$varDispName);

		$varRequest = $_SERVER['QUERY_STRING'];

		$varQryStr = $_SERVER['QUERY_STRING'];

		

		if(trim($varQryStr) == '')

		{

			$varQryStr = '?'.$varQryStr; 

		}

		else

		{

			$varQryStr = '?'.preg_replace('/&page=([0-9])+/','',$varQryStr).'&amp;';

		}

		

		$page_list ='<p class="paging">';

		

		if (($this->page-1) > 0)

		{ 

			if($varPageName!='' && $varPageID!='')

			{

				$page_list .= '&nbsp;<a onclick="return check(this)" href="'.$PHP_SELF.$varQryStr.$varDispName.'='.($this->page-1).'&amp;PageName='.$varPageName.'&amp;PageId='.$varPageID.'&prequery='.$querystring.'" class="back" >&lt;&lt;&nbsp;Back</a>&nbsp;';
                
//                $page_list .= '&nbsp;<a onclick="load('.$PHP_SELF.$varQryStr.$varDispName.'='.($this->page-1).'&amp;PageName='.$varPageName.'&amp;PageId='.$varPageID.')" class="back" >&lt;&lt;&nbsp;Back</a>&nbsp;';

			}

			else

			{

				$page_list .= '&nbsp;<a onclick="return check(this)" href="'.$PHP_SELF.$varQryStr.$varDispName.'='.($this->page-1).'&prequery='.$querystring.'" class="back" >&lt;&lt;&nbsp;Back</a>&nbsp;';
                
//                $page_list .= '&nbsp;<a onclick="load('.$PHP_SELF.$varQryStr.$varDispName.'='.($this->page-1).')" class="back" >&lt;&lt;&nbsp;Back</a>&nbsp;';

			}	

		}

		else

		{

			if($varPageName!='' && $varPageID!='')

			{

				$page_list .= '&nbsp;<span class="disabled">&lt;&lt;&nbsp;Back</span>'; 

			}

			else

			{

				$page_list .= '&nbsp;<span class="disabled">&lt;&lt;&nbsp;Back</span>&nbsp;';

			}	

		}

		$varPageList1 =''.$page_list.'';

		$page_list="";

		//code for paging if number of pages are more than 10

		if($this->num_pages>5)

		{

			$i = $this->page;

			$totalpage = $this->page + 4;

			for ($i=$this->page; $i<=$totalpage; $i++)

			{

				//paging by default display l page condition added 

				if($i>$this->num_pages)

				{ break; }

			

				if($this->num_pages>1)

				{

					if ($i == $this->page  )

					{

						// $page_list .= '<span class="text"><strong>'.$i.'</strong></span>';

						$page_list .= '&nbsp;<a><span>'.$i.'</span></a>&nbsp;';

					}

					else

					{

						if($varPageName!='' && $varPageID!='')

						{

							$page_list .= '&nbsp;<a onclick="return check(this)" style="text-decoration:underline" href="'.$PHP_SELF.$varQryStr.$varDispName.'='.$i.'&amp;PageName='.$varPageName.'&amp;PageId='.$varPageID.'&prequery='.$querystring.'">'.$i.'</a>&nbsp;';
//                            $page_list .= '&nbsp;<a style="text-decoration:underline" onclick="load('.$PHP_SELF.$varQryStr.$varDispName.'='.$i.'&amp;PageName='.$varPageName.'&amp;PageId='.$varPageID.')">'.$i.'</a>&nbsp;';

						}

						else

						{

							$page_list .= '&nbsp;<a onclick="return check(this)" style="text-decoration:underline" href="'.$PHP_SELF.$varQryStr.$varDispName.'='.$i.'&prequery='.$querystring.'">'.$i.'</a>&nbsp;';
                            
//                            $page_list .= '&nbsp;<a style="text-decoration:underline" onclick="load('.$PHP_SELF.$varQryStr.$varDispName.'='.$i.')">'.$i.'</a>&nbsp;';

						}

					}

				}

			}

			

			if($totalpage < $this->num_pages)

			{

				if(($totalpage+1) < $this->num_pages)

				{

					$page_list .= '<a><strong>...</strong></a>';

				}

				$page_list .= '&nbsp;<a onclick="return check(this)" style="text-decoration:underline" href="'.$PHP_SELF.$varQryStr.$varDispName.'='.$this->num_pages.'&prequery='.$querystring.'" >'.$this->num_pages.'</a>&nbsp;';
                
//                $page_list .= '&nbsp;<a style="text-decoration:underline" onclick="load('.$PHP_SELF.$varQryStr.$varDispName.'='.$this->num_pages.'" on>'.$this->num_pages.')"</a>&nbsp;';

			}

		}

		else 

		{

			for($x=1;$x<=$this->num_pages;$x++) 

			{

				if($x == $this->page)

				{

					//shows paging only if number of pages is greater than one 

					if($this->num_pages>1)

					{

						$page_list .=  '&nbsp;<a><span>'.$x.'</span></a>&nbsp;';

					}	 

				} 

				else

				{

					if($varPageName!='' && $varPageID!='')

					{

						$page_list .=  '&nbsp;<a onclick="return check(this)" style="text-decoration:underline" href="'.$PHP_SELF.$varQryStr.$varDispName.'='.$x.'&amp;PageName='.$varPageName.'&amp;PageId='.$varPageID.'&prequery='.$querystring.'" >'.$x.'</a>&nbsp;';
//                        $page_list .=  '&nbsp;<a style="text-decoration:underline" onclick="load('.$PHP_SELF.$varQryStr.$varDispName.'='.$x.'&amp;PageName='.$varPageName.'&amp;PageId='.$varPageID.')" >'.$x.'</a>&nbsp;';
                        

					}

					else

					{

//						$page_list .=  '&nbsp;<a style="text-decoration:underline" onclick="load('.$PHP_SELF.$varQryStr.$varDispName.'='.$x.')" >'.$x.'</a>&nbsp;';
                        
                        $page_list .=  '&nbsp;<a onclick="return check(this)" style="text-decoration:underline" href="'.$PHP_SELF.$varQryStr.$varDispName.'='.$x.'&prequery='.$querystring.'" >'.$x.'</a>&nbsp;';

					}

				} 

			}

		}//end of if else condition

	

		$varPageList2 = ''.$page_list.'';

		$page_list="";

		// Print the Next and Last page links if necessary 

		if (($this->page+1) <= $this->num_pages)

		{	

			if($varPageName!='' && $varPageID!='')

			{

				$page_list .= '&nbsp;<a onclick="return check(this)" href="'.$PHP_SELF.$varQryStr.$varDispName.'='.($this->page+1).'&amp;PageName='.$varPageName.'&amp;PageId='.$varPageID.'&prequery='.$querystring.'" class="continue" >Next&nbsp;&gt;&gt;</a>&nbsp;';
//                $page_list .= '&nbsp;<a onclick="load('.$PHP_SELF.$varQryStr.$varDispName.'='.($this->page+1).'&amp;PageName='.$varPageName.'&amp;PageId='.$varPageID.')" class="continue" >Continue&nbsp;&gt;&gt;</a>&nbsp;';

			}

			else

			{

				$page_list .= '&nbsp;<a onclick="return check(this)" href="'.$PHP_SELF.$varQryStr.$varDispName.'='.($this->page+1).'&prequery='.$querystring.'" class="continue" >Next&nbsp;&gt;&gt;</a>&nbsp;';
                
//                $page_list .= '&nbsp;<a onclick="load('.$PHP_SELF.$varQryStr.$varDispName.'='.($this->page+1).')" class="continue" >Continue&nbsp;&gt;&gt;</a>&nbsp;';

			}

		}

		else

		{	

			if($varPageName!='' && $varPageID!='')

			{

				$page_list .= '&nbsp;<span class="disabled">Next&nbsp;&gt;&gt;</span>&nbsp;';

			}

			else

			{

				$page_list .= '&nbsp;<span class="disabled">Next&nbsp;&gt;&gt;</span>&nbsp;';

			}

		}

		
		$varPageList3 = ''.$page_list.'';

		$varPageListing =$varPageList1.$varPageList2.$varPageList3;

		$page_list .= "";

		echo $varPageListing.'</p>';

	}
    

}//end of class	   

?>
