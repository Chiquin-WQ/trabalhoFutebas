<?php
require_once __DIR__ . '/../repository/TimeRepository.php';


$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($id) {
    $timeRepository = new TimeRepository();
    
    
    $timeRepository->deletar($id);
}


header("Location: times.php");
exit;