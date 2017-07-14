<style>
	
	select{display: block;width:300px;margin-bottom: 10px;}
	
	#users{
		width: 800px;
	}
	
	#users td, #users th{
		border: 1px solid black;
	}

	#users td:nth-child(1){
		width: 350px;
	}

	#users td:nth-child(2){
		width: 190px;
	}

	#users td:nth-child(3){
		width: 260px;
	}	

</style>
<?php 
	// Подготовка данных для массива объектов JS Users
	$arrJsObj = array();
    foreach ($data['UserList'] as $item){
    	$city = explode(",", $item['cname']);
    	$arrJsObj[] = '{
    		\'name\' : \''. $item["uname"] .'\', \'city\' : [\''. implode('\',\'', array_map("trim", $city)) .'\'], \'education\' : \''. $item["ename"] .'\'
    	}';
	} 
?>
<script type="text/javascript">

	function reloadData(obj){

		// если получили не объект, обновляем весь список
		if(typeof obj !== "object"){
			
			obj = {'c' : [], 'e' : []};
			
			var arrEducation = $("select#education option");
			for(var i=0; i<arrEducation.length;i++){
				obj.e[i] = arrEducation[i].value;
			}

			var arrCity = $("select#city option");
			for(var i=0; i<arrCity.length;i++){
				obj.c[i] = arrCity[i].value;
			}

		}

		var result;

		for(var i=0; i<Users.length; i++){

			// выбрано хоть одно образование? нет - запускаем цикл по городам
			// проверять на наличие города, т.к. может быть выбрано еще и образование, 
			// а здесь подразумевается, что выбраны только города
			if(obj.e.length == 0){

				for(var j=0; j<Users[i].city.length; j++){
					if(obj.c.indexOf(Users[i].city[j]) != -1){
						result += '<tr><td>'+ Users[i].name +'</td><td>'+ Users[i].education +'</td><td>'+ Users[i].city.join(', ') +'</td></tr>';
						// нашли юзера по одному из городов, второй раз он в таблице не нужен, выходим из вложенного цикла
						break;
					}
				}

			//тут наоборот - проверка на города; если нет вбранных - цикл по образованию
			} else if(obj.c.length == 0){

				if(obj.e.indexOf(Users[i].education) != -1){
					result += '<tr><td>'+ Users[i].name +'</td><td>'+ Users[i].education +'</td><td>'+ Users[i].city.join(', ') +'</td></tr>';
				}

			} else {

				// тут есть и города, и образования; опять проходим по всем городам пользователя
				for(var j=0; j<Users[i].city.length; j++){
					if(obj.c.indexOf(Users[i].city[j]) != -1 && obj.e.indexOf(Users[i].education) != -1){
						result += '<tr><td>'+ Users[i].name +'</td><td>'+ Users[i].education +'</td><td>'+ Users[i].city.join(', ') +'</td></tr>';
						// опять выходим
						break;
					}
				}				

			}

		}
		$("#users tbody").html(result);
	}

	function loadTable(){

		var selectEducation = $("select#education").val(), selectCity = $("select#city").val();

		if(selectEducation.length == 0 && selectCity.length == 0){
			return reloadData();
		}

		return reloadData({'e' : selectEducation, 'c' : selectCity});

	};


	var Users = [<?=implode(',', $arrJsObj)?>];

	$(document).ready(function(){

		$("select").change(function(){
			loadTable(); 
		});

		reloadData();

	});
</script>

<div class="grid-container" style="width: 800px; margin: 20px auto;">

<form>
	<select id="education" multiple="multiple" style="height: 60px;"> 
	<?php foreach ($data['EducationList'] as $item): ?>
		<option value="<?=$item['name']?>"><?=$item['name']?></option>
	<?php endforeach; ?>
	</select>

	<select id="city" multiple="multiple" style="height: 150px;">
	<?php foreach ($data['CityList'] as $item): ?>
		<option value="<?=$item['name']?>"><?=$item['name']?></option>
	<?php endforeach; ?>
	</select>

</form>


<table id="users">
	<thead>
		<tr><th>ФИО</th><th>Образование</th><th>Город</th></tr>
	</thead>
	<tbody>
		
	</tbody>
</table>