<?php
    /*
    	 服务器接收数据类型 type = 1;
    	   1. 应用提交用户名 在完成游戏后提交 用户名+分数 
    	    1.1 使用post传输 判断当前用户名是否存在 如果不存在则创建数据，如果存在则判断分数 如果超出往期最高分数则修改分数并显示排名
    	 服务器接受数据类型 type = 2;
    	   2. 应用提交查询排名指令 post/get 调取数据库信息并排名 显示出前10名玩家的分数返回 在html界面创建DOM对象显示排名
     */
    if($_POST["type"] == 1){
//    		执行提交操作
    		$mysqli = new mysqli("localhost:3306","root","","airPlane");
    		if($mysqli->connect_errno){
    			echo "验证";
    			die($mysqli->connect_errno);
    		}
    		$user = $_POST["name"];
    		$score = $_POST["score"];
//  		查询操作
    		$sql = "SELECT*FROM class1";
    		$mysqli->query("set names utf-8");
    		$result = $mysqli->query($sql);
    		$str = $result->fetch_all(MYSQLI_ASSOC);
    		$find = 0;
    		for($i = 0; $i<count($str);$i++){
    			foreach($str[$i] as $key=>$value){
    				if($user == $str[$i]["name"] && $find == 0){
    					if($score > $str[$i]["score"]){
    						$sqlUpDate = "UPDATE class1 SET score={$score} WHERE name='{$user}'";
    						$mysqli->query("set names utf-8");
    						$result = $mysqli->query($sqlUpDate);
    						$mysqli->close();
    					}
    					$find = 1;
    				}
    			}
    		}
    		if($find == 0){
    				$sql = "INSERT INTO class1(name,score) VALUES('{$user}','{$score}')";
    				$mysqli->query("set names utf-8");
    				$result = $mysqli->query($sql);
    				if($result){
    					echo "插入成功";
    				}else {
    					echo "插入失败";
    				}
    				$mysqli->close();
    		}
    }
    if($_POST["type"] == 2){
    		$mysqli = new mysqli("localhost:3306","root","","airPlane");
    		if($mysqli->connect_errno){
    			echo "验证";
    			die($mysqli->connect_errno);
    		}
    		$user = $_POST["name"];
    		$score = $_POST["score"];
//  		查询操作
    		$sql = "SELECT*FROM class1";
    		$mysqli->query("set names utf-8");
    		$result = $mysqli->query($sql);
    		$str = $result->fetch_all(MYSQLI_ASSOC);
    		$str = json_encode($str);
    		echo $str;
    		$mysqli->close();
    		
    }
?>