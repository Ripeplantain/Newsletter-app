<?php 

function insertData($conn, $email, $name, $occupation, $skills) {
    $sql = "INSERT INTO subscribers (email, name, occupation, skills) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param('ssss', $email, $name, $occupation, $skills);

    if ($stmt->execute()) {
        return 'New record created successfully';
    } else {
        return 'Error: ' . $sql . '<br>' . $conn->error;
    }
}

function fetchData($conn) {
    $sql = "SELECT * FROM subscribers";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return $result;
    } else {
        return '0 results';
    }
}

function deleteData($conn, $id) {
    $sql = "DELETE FROM subscribers WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        return 'Record deleted successfully';
    } else {
        return 'Error: ' . $stmt->error;
    }
}

function updateData($conn, $id, $email, $name, $occupation, $skills) {
    $sql = "UPDATE subscribers SET email = ?, name = ?, occupation = ?, skills = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssi', $email, $name, $occupation, $skills, $id);

    if ($stmt->execute()) {
        return 'Record updated successfully';
    } else {
        return 'Error: ' . $sql . '<br>' . $conn->error;
    }
}
