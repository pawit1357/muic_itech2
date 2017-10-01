<?php
ini_set('max_execution_time', 0);

class MenuUtil {

	var $menu = "";

	// 	public function genMenu_tmp($app_id)
	// 	{
	// 		$rootPath  = Yii::app()->request->baseUrl.'/';
	// 		$menu = "<ul id=\"browser\" class=\"b1\">";

	// 		mysql_connect(ConfigUtil::getHostName(), ConfigUtil::getUsername(), ConfigUtil::getPassword());
	// 		mysql_select_db(ConfigUtil::getDbName());

	// 		$sql = "select id,menu_icon,menu_item,menu_item_src,menu_type from tb_menu where app_id=".$app_id." order by menu_order asc";
	// 		$res = mysql_query($sql);


	// 		$messages = array();

	// 		if (mysql_num_rows($res))
		// 		{
		// 			while ($result = mysql_fetch_assoc($res))
			// 			{
			// 				$messages["$result[id]"] = $result;
			// 			}
			// 			mysql_free_result($res);

			// 			if (count($messages))
				// 			{
				// 				/* Check Have Child */
				// 				$childsMenu = XMLUtil::getChild($messages,$app_id,-1);
		
				// 				foreach ($childsMenu AS $id => $data)
					// 				{
					// 					/* Check Have Child */
					// 					$childsLv1 = XMLUtil::getChild($messages,$app_id,$data['id']);

					// 					$menu.="<li><span class=\"folder\"><img src=\"".$rootPath.'/'.$data['menu_icon']."\" width=\"16px;\" height=\"16px;\" />&nbsp;&nbsp;<a class=\"icon config\" href=\"AppMenu\createSubmenu\id\\".$data['id']."\menu_type\\".$data['menu_type']."\">".$data['menu_item'].(($data['menu_type'] == "3"||$data['menu_type'] == "5"||$data['menu_type'] == "41"||$data['menu_type'] == "42"||$data['menu_type'] == "43")? "": ((count($childsLv1))? "":(XMLUtil::checkHaveContent($data['id'],$app_id )? "":"<b style=\"color:red\">[!]</b>") ))."</span></a>";

					// 					if( count($childsLv1)  ){
					// 						$menu.="<ul>";
					// 						foreach ($childsLv1 AS $id => $data_submenuLv1)
						// 						{
						// 							/* Check Have Child */
						// 							$childsLv2 = XMLUtil::getChild($messages,$app_id,$data_submenuLv1['id']);

						// 							$menu.="<li><span class=\"folder\"><img src=\"".$rootPath.'/'.$data_submenuLv1['menu_icon']."\" width=\"16px;\" height=\"16px;\" />&nbsp;&nbsp;<a class=\"icon config\" href=\"AppMenu\createSubmenu\id\\".$data_submenuLv1['id']."\menu_type\\".$data_submenuLv1['menu_type']."\">".$data_submenuLv1['menu_item'].(($data['menu_type'] == "3"||$data['menu_type'] == "5"||$data['menu_type'] == "41"||$data['menu_type'] == "42"||$data['menu_type'] == "43")? "": ((count($childsLv2))? "":(XMLUtil::checkHaveContent($data_submenuLv1['id'],$app_id )? "":"<b style=\"color:red\">[!]</b>") ))."</span></a>";



						// 							/* Submenu LV2 */

						// 							if( count($childsLv2)  ){
						// 								$menu.="<ul>";
						// 								foreach ($childsLv2 AS $id => $data_submenuLv2)
							// 								{
							// 									/* Check Have Child */
							// 									$childsLv3 = XMLUtil::getChild($messages,$app_id,$data_submenuLv2['id']);
							// 									$menu.="<li><span class=\"folder\"><img src=\"".$rootPath.'/'.$data_submenuLv2['menu_icon']."\" width=\"16px;\" height=\"16px;\" />&nbsp;&nbsp;<a class=\"icon config\" href=\"AppMenu\createSubmenu\id\\".$data_submenuLv2['id']."\menu_type\\".$data_submenuLv2['menu_type']."\">".$data_submenuLv2['menu_item'].(($data['menu_type'] == "3"||$data['menu_type'] == "5"||$data['menu_type'] == "41"||$data['menu_type'] == "42"||$data['menu_type'] == "43")? "": ((count($childsLv3))? "":(XMLUtil::checkHaveContent($data_submenuLv2['id'],$app_id )? "":"<b style=\"color:red\">[!]</b>")) )."</span></a>";


							// 									/* Submenu LV3 */

							// 									if( count($childsLv3)  ){
							// 										$menu.="<ul>";
							// 										foreach ($childsLv3 AS $id => $data_submenuLv3)
								// 										{
								// 											$menu.="<li><span class=\"file\"><img src=\"".$rootPath.'/'.$data_submenuLv3['menu_icon']."\" width=\"16px;\" height=\"16px;\" />&nbsp;&nbsp;<a class=\"icon config\" href=\"AppMenu\createSubmenu\id\\".$data_submenuLv3['id']."\menu_type\\".$data_submenuLv3['menu_type']."\">".$data_submenuLv3['menu_item'].(($data['menu_type'] == "3"||$data['menu_type'] == "5"||$data['menu_type'] == "41"||$data['menu_type'] == "42"||$data['menu_type'] == "43")? "": (XMLUtil::checkHaveContent($data_submenuLv3['id'],$app_id )? "":"<b style=\"color:red\">[!]</b>") )."</span></a></li>";
								// 										}
								// 										$menu.="</ul>";
								// 									}
								// 									$menu.="</li>";
								// 								}
								// 								$menu.="</ul>";
								// 							}
								// 							$menu.="</li>";
								// 						}
								// 						$menu.="</ul>";
								// 					}
								// 					$menu .="</li>";
								// 				}
								// 			}
								// 		}
								// 		$menu .="</ul>";
								// 		return $menu;
								// 	}


	public function getMenu($app_id){

		$menu = array();
		mysql_connect(ConfigUtil::getHostName(), ConfigUtil::getUsername(), ConfigUtil::getPassword());
		mysql_select_db(ConfigUtil::getDbName());

		$sql = "select id,app_id,menu_icon,menu_item,menu_item_src,menu_type,parent,menu_status from tb_menu where app_id=".$app_id." and menu_status='A' order by menu_order asc";

		$res = mysql_query($sql);

		if(mysql_num_rows($res)!=0)
		{
			while($row = mysql_fetch_assoc($res)){

				$menu[$row['id']] = array("app_id" => $row['app_id'],"id" => $row['id'],"parentID" => $row['parent'], "text" =>$row['menu_item'], "type" =>$row['menu_type'], "icon" =>$row['menu_icon'], "status" =>$row['menu_status'] );
			}
		}

		$addedAsChildren = array();

		foreach ($menu as $id => &$menuItem) { // note that we use a reference so we don't duplicate the array
			if ($menuItem['parentID']!= -1) {
				$addedAsChildren[] = $id;

				if (!isset($menu[$menuItem['parentID']]['children'])) {
					$menu[$menuItem['parentID']]['children'] = array($id => &$menuItem);
				} else {
					$menu[$menuItem['parentID']]['children'][$id] = &$menuItem;
				}
			}

			unset($menuItem['parentID']); // we don't need this any more
		}

		unset($menuItem); // unset the reference

		foreach ($addedAsChildren as $itemID) {
			unset($menu[$itemID]); // remove it from root so it's only in the ['children'] subarray
		}

		echo MenuUtil::makeTree($menu);

	}

	function makeTree($menu) {
		//$rootPath  = Yii::app()->request->baseUrl.'/';
		$tree = '<ul>';

		foreach ($menu as $id => $menuItem) {
			//$tree .="<li>&nbsp;&nbsp;[" .$menuItem['status']."]".
			$tree .="<li>".
					"<img src=\"".$menuItem['icon']."\" width=\"16px;\" height=\"16px;\" />&nbsp;&nbsp;".
					MenuUtil::getContentLink($menuItem['id'],$menuItem['text'],$menuItem['type']).
					MenuUtil::toolBar($menuItem['id'],$menuItem['type'],$menuItem['app_id']);
			//(($menuItem['type']=="0")? "":(XMLUtil::checkHaveContent($menuItem['id'],$menuItem['app_id'] )? "":"<b style=\"color:red\">[!]</b>"));


			if (!empty($menuItem['children'])) {
				$tree .= MenuUtil::makeTree($menuItem['children']);
			}
			$tree .= '</li>';
		}
		return $tree . '</ul>';
	}

	function getContentLink($id,$name,$menu_type){
		$link = "";

		switch($menu_type)
		{
			case "0":
			case "1"://news & event
			case "2"://Announce
			case "3"://Gallery
			case "4"://Promotion
				$link = "".$name;
				break;
			case "11"://Content
			case "21"://Content
			case "31"://Content
			case "41"://Content

			case "5"://Content
				$content = new AppContent();
				$content = AppContent::model()->findAll(array('condition'=>" menu_id=".$id));
				if(count($content)){
					$link = "<a class=\"\" href=\"appContent\update\id\\".$content[0]->id."\">".$name."</a>";
				}else
				{
					$link = "<a class=\"\" href=\"appContent\create\menu_id\\".$id."\">".$name."</a>";
				}
				break;
			case "6"://Book
			case "7"://Thesis
				$link = "".$name;
				break;
			case "8"://Ask
				$link = "".$name;
				break;
		}
		return $link;
	}

	function toolBar($id,$menu_type,$app_id){
		/*
		 *
		-----------------
		menu_type
		-----------------
		0	= menu
		1 	= news & event
		11 	= new_event-content
		2 	= announce
		21 	= anounce-content
		3 	= gallery
		31 	= gallery-content
		4 	= promotion
		41 	= promotion-content
		5 	= content(html)
		6 	= book
		61	= book-content
		7 	= thesis
		71	= thesis-content
		8 	= ask
		*
		*/

		switch($menu_type)
		{
			case "0":
			case "1":
			case "2":
			case "3":
			case "4":
				$toolbar = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".
						"<a class=\"\" href=\"AppMenu\createSubmenu\id\\".$id."\">&nbsp;+&nbsp;</a>|".
						"<a class=\"\" href=\"AppMenu\deleteMenu\id\\".$id."\">&nbsp;-&nbsp;</a>|".
						"<a class=\"\" href=\"AppMenu\update\id\\".$id."\">&nbsp;edit&nbsp;</a>";
				break;
			default:
				$toolbar = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".
						//"<a class=\"\" href=\"AppMenu\createSubmenu\id\\".$id."\">&nbsp;+&nbsp;</a>|".
				"<a class=\"\" href=\"AppMenu\deleteMenu\id\\".$id."\">&nbsp;-&nbsp;</a>|".
				"<a class=\"\" href=\"AppMenu\update\id\\".$id."\">&nbsp;edit&nbsp;</a>";
				break;

		}

		return $toolbar;
	}
}
