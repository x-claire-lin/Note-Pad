<?php
include 'connection.php';


function getMemoCount($conn, $userid) {
    $countSql = "SELECT COUNT(*) AS memoCount FROM notes WHERE userid = ?";
    $stmt = $conn->prepare($countSql);
    $stmt->bind_param("i", $userid);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    return $result['memoCount'];
}

function getDaysRegistered($conn, $userid) {
    $regSql = "SELECT registration_date FROM user WHERE userid = ?";
    $stmt = $conn->prepare($regSql);
    $stmt->bind_param("i", $userid);
    $stmt->execute();
    $regResult = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    $registrationDate = new DateTime($regResult['registration_date']);
    $today = new DateTime();
    $interval = $today->diff($registrationDate);
    return $interval->days;
}

function fetchNotes($conn, $userid, $search = null, $startDate = null, $endDate = null) {
    $sql = "SELECT * FROM notes WHERE userid = ?";
    $params = [$userid];
    $types = "i";
    
    if (!is_null($search)) {
        $sql .= " AND note LIKE ?";
        $params[] = "%$search%";
        $types .= "s";
    }
    
    if (!is_null($startDate) && !is_null($endDate)) {
        $sql .= " AND DATE(timestamp) BETWEEN ? AND ?";
        $params[] = $startDate;
        $params[] = $endDate;
        $types .= "ss";
    }

    $sql .= " ORDER BY timestamp DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    return $stmt->get_result();  
}

?>