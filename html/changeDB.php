<?php

require_once("../vendor/autoload.php");

use Strict\Date\Days\YMDDay;


const SQL_TB = 'CREATE TABLE IF NOT EXISTS plan
	(
		id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		task VARCHAR(255),
		day DATE
	)';

if(!isset($_GET['year']) || !isset($_GET['month']) || !isset($_GET['day'])){
    die('値が取得できません');
}

$year = $_GET['year'];
$month = $_GET['month'];
$day = $_GET['day'];

try {
    $inst_taskrepository = new Goodlife\Calender\TaskRepository(Goodlife\Calender\PDOMaker::getPDO(), SQL_TB);

    if(isset($_POST['new_task'])){
        $inst_taskmodel = $inst_taskrepository->create($_POST['new_task'], new YMDDay($year, $month, $day));
    }

    if(isset($_POST['delete_task'])){
        $task_array = $inst_taskrepository->get(new YMDDay($year, $month, $day));
        $delete_judge = $inst_taskrepository->delete($task_array[$_POST['delete_task']]);
    }

    if(isset($_POST['change_task']) && isset($_POST['change_target'])){
        $task_array = $inst_taskrepository->get(new YMDDay($year, $month, $day));
        $update_judge = $inst_taskrepository->update($task_array[$_POST['change_target']], $_POST['change_task']);
    }

    header("Location: /?year={$year}&month={$month}");
    die;

} catch (\PDOException $e) {
    echo "ErrorMessage : " . $e->getMessage() . "<br>";
    echo "ErrorCode : " . $e->getCode() . "<br>";
    echo "ErrorFile : " . $e->getFile() . "<br>";
    echo "ErrorLine : " . $e->getLine() . "<br>";
}