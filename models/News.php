<?php

/**
* 
*/
class News
{

	/**
	* Reutrns single news item with specified id
	* @param integer $id
	*/
	public static function getNewsItemById($id)
	{
		$id = intval($id);

		if ($id) {
			$db = DBConnection::getConnection();

			$result = $db->query('SELECT *
				FROM News
				WHERE id_news=' . $id);
			$result->setFetchMode(PDO::FETCH_ASSOC);

			$newsItem = $result->fetch();

			return $newsItem;
		}
		
	}

	public static function getNewsList()
	{
		$db = DBConnection::getConnection();

		$newsList = array();

		$result = $db->query('SELECT id_news, article, text
			FROM News');

		$i = 0;
		while($row = $result->fetch()) {
			$newsList[$i]['id_news'] = $row['id_news'];
			$newsList[$i]['article'] = $row['article'];
			$newsList[$i]['text'] = $row['text'];
			$i++;
		}

		return $newsList;
	}	

	function __construct()
	{
		# code...
	}
}