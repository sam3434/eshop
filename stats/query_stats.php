<?php 
/*
Запросы для извлечения из таблиц статистики информации
которая используется в страницах результатов
*/

function all_pages()
{
	$query = "SELECT p.address,
        count(*)
		FROM stats AS s
		JOIN pages AS p ON s.id_page=p.id
		GROUP BY s.id_page";
	return mysql_query($query);
}

 ?>