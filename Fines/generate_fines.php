<?php
include '../config/db.php';
include '../config/auth.php';
checkRole(['admin', 'staff']); // Let admin or staff run this

$fine_rate_per_day = 5; // Customize as needed

// Find overdue borrow records with no fine yet
$sql = "
    SELECT br.id AS borrow_id, br.member_id, br.return_date, br.actual_return_date
    FROM borrow_records br
    LEFT JOIN fines f ON f.borrow_id = br.id
    WHERE 
        (br.status = 'overdue' OR (br.actual_return_date IS NOT NULL AND br.actual_return_date > br.return_date))
        AND f.id IS NULL
";

$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    $borrow_id = $row['borrow_id'];
    $member_id = $row['member_id'];
    $return_date = new DateTime($row['return_date']);
    $actual_return = $row['actual_return_date'] ? new DateTime($row['actual_return_date']) : new DateTime();

    $days_overdue = $return_date->diff($actual_return)->days;
    if ($actual_return < $return_date) continue; // Not overdue

    $amount = $days_overdue * $fine_rate_per_day;

    // Insert the fine
    $insert_sql = "INSERT INTO fines (member_id, borrow_id, amount) VALUES ('$member_id', '$borrow_id', '$amount')";
    mysqli_query($conn, $insert_sql);
}

echo "Fines generated based on overdue records.";
?>
