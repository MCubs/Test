<?php

class testModel extends Model{
	
	public function getEducationList(){

		return DB::assoc("SELECT * FROM Образование;");

	}
	public function getCityList(){

		return DB::assoc("SELECT * FROM Города;");

	}

	public function getUserList(){

		//return DB::assoc("SELECT u.name AS username, Образование.name AS ename, user_id, Города.name AS cname FROM Пользователи u join Образование ON u.qualification_id = Образование.qualification_id LEFT JOIN Города ON u.user_id = Города.user_id;");
		return DB::assoc("SELECT u.name AS uname, e.name AS ename, GROUP_CONCAT(c.name SEPARATOR ', ') AS cname FROM Пользователи u join `Города пользователей` cu on cu.user_id = u.user_id join Города c on cu.city_id=c.city_id join Образование e ON u.qualification_id = e.qualification_id GROUP BY uname;");
	}


}

?>