<?php

function getPropertyPriceRange()
{
	$price = array();
	$price[] = 500;
	$price[] = 1000;
	$price[] = 2000;
	$price[] = 3000;
	$price[] = 4000;
	$price[] = 5000;
	$price[] = 7000;
	$price[] = 9000;
	$price[] = 10000;
	$price[] = 15000;
	$price[] = 20000;
	$price[] = 25000;
	return $price;
}

function getPropertyAreaRange()
{
	$size = array();
	$size[] = 25;
	$size[] = 50;
	$size[] = 75;
	$size[] = 100;
	$size[] = 125;
	$size[] = 150;
	$size[] = 175;
	$size[] = 200;
	$size[] = 250;
	return $size;
}

function pagination($page,$per_page=10,$total,$scriptName='')
{
	if($scriptName=='message')
	{
		$scriptName = "/message";
	}
	else
	{
		$scriptName = "/property";
	}
	//echo '<br>===>'.$url;
	$adjacents = "2";
	$page = ($page == 0 ? 1 : $page);
	$start = ($page - 1) * $per_page;
	$prev = $page - 1;
	$next = $page + 1;
	$lastpage = ceil($total/$per_page);
	$lpm1 = $lastpage - 1;
	//$pagination = "";
	$arrOfPagination = array();

	if($lastpage > 1)
	{
		if ($page > 1)
		{
			//$pagination.= "<ul id='previous'><li><a href='".url($scriptName.$prev.$url)."'><i class='fa fa-chevron-left'></i></a></li></ul>";
			$arrOfPagination['previous'] = $prev;
		}
		else
		{
			//$pagination.= "<ul id='previous'><li class='active'><a href='javascript:void(0);'><i class='fa fa-chevron-left'></i></a></li></ul>";
			$arrOfPagination['previous'] = '';
		}

		//$pagination .= "<ul>";
		if ($lastpage < 7 + ($adjacents * 2))
		{
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
				{
					//$pagination.= "<li class='active'><a href='javascript:void(0);'>$counter</a></li>";
					$arrOfPagination['page'][] = array(
							'page'=>$counter,
							'url'=>''
					);
				}
				else
				{
					//$pagination.= "<li><a href='".url($url.$counter)."'>$counter</a></li>";
					$arrOfPagination['page'][] = array(
							'page'=>$counter,
							'url'=>url($scriptName)
					);
				}
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))
		{
			if($page < 1 + ($adjacents * 2))
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
					{
						//$pagination.= "<li class='active'><a href='javascript:void(0);'>$counter</a></li>";
						$arrOfPagination['page'][] = array(
								'page'=>$counter,
								'url'=>''
						);
					}
					else
					{
						//$pagination.= "<li><a href='".url($url.$counter)."'>$counter</a></li>";
						$arrOfPagination['page'][] = array(
								'page'=>$counter,
								'url'=>url($scriptName)
						);
					}
				}

				/* $pagination.= "<li class='dot'>...</li>";
					$pagination.= "<li><a href='".url($scriptName.$lpm1.$url)."'>$lpm1</a></li>";
				$pagination.= "<li><a href='".url($scriptName.$lastpage.$url)."'>$lastpage</a></li>"; */

				$arrOfPagination['last_dot'] = '...';
				$arrOfPagination['lpm1'] = array(
						'page'=>$lpm1,
						'url'=>url($scriptName)
				);
				$arrOfPagination['lastpage'] = array(
						'page'=>$lastpage,
						'url'=>url($scriptName)
				);
			}
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				/* $pagination.= "<li><a href='".url($url.'1')."'>1</a></li>";
				 $pagination.= "<li><a href='".url($url.'2')."'>2</a></li>";
				$pagination.= "<li class='dot'>...</li>"; */

				$arrOfPagination['firstpage'] = array(
						'page'=>1,
						'url'=>url($scriptName)
				);
				$arrOfPagination['secondpage'] = array(
						'page'=>2,
						'url'=>url($scriptName)
				);
				$arrOfPagination['first_dot'] = '...';
					
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
					{
						//$pagination.= "<li class='active'><a href='javascript:void(0);'>$counter</a></li>";
						$arrOfPagination['page'][] = array(
								'page'=>$counter,
								'url'=>''
						);
					}
					else
					{
						//$pagination.= "<li><a href='".url($url.$counter)."'>$counter</a></li>";
						$arrOfPagination['page'][] = array(
								'page'=>$counter,
								'url'=>url($scriptName)
						);
					}
				}
				/* $pagination.= "<li class='dot'>..</li>";
				 $pagination.= "<li><a href='".url($scriptName.$lpm1.$url)."'>$lpm1</a></li>";
				$pagination.= "<li><a href='".url($scriptName.$lastpage.$url)."'>$lastpage</a></li>"; */
					
				$arrOfPagination['last_dot'] = '...';
				$arrOfPagination['lpm1'] = array(
						'page'=>$lpm1,
						'url'=>url($scriptName)
				);
				$arrOfPagination['lastpage'] = array(
						'page'=>$lastpage,
						'url'=>url($scriptName)
				);
			}
			else
			{
				/* $pagination.= "<li><a href='".url($scriptName.'1'.$url)."'>1</a></li>";
				 $pagination.= "<li><a href='".url($scriptName.'2'.$url)."'>2</a></li>";
				$pagination.= "<li class='dot'>..</li>"; */

				$arrOfPagination['firstpage'] = array(
						'page'=>1,
						'url'=>url($scriptName)
				);
				$arrOfPagination['secondpage'] = array(
						'page'=>2,
						'url'=>url($scriptName)
				);
				$arrOfPagination['first_dot'] = '...';

				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
					{
						//$pagination.= "<li class='active'><a href='javascript:void(0);'>$counter</a></li>";
						$arrOfPagination['page'][] = array(
								'page'=>$counter,
								'url'=>''
						);
					}
					else
					{
						//$pagination.= "<li><a href='".url($url.$counter)."'>$counter</a></li>";
						$arrOfPagination['page'][] = array(
								'page'=>$counter,
								'url'=>url($scriptName)
						);
					}
				}
			}
		}
		//$pagination.= "</ul>";

		if ($page < $counter - 1)
		{
			//$pagination.= "<ul id='next'><li><a href='".url($url.$next)."'><i class='fa fa-chevron-right'></i></a></li></ul>";
			$arrOfPagination['next'] = $next;
		}
		else
		{
			//$pagination.= "<ul id='next'><li class='active'><a href='javascript:void(0);'><i class='fa fa-chevron-right'></i></a></li></ul>";
			$arrOfPagination['next'] = '';
		}

	}
	return $arrOfPagination;
}
