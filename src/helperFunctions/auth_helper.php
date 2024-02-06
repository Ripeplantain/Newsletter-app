<?php 

function register_user($conn, $username, $password, $email) {
    $sql = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../register.php?error=stmtfailed");
        exit();
    }
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, "sss", $username, $hashed_password, $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../auth.php?error=none");
    exit();
}


function login_user($conn, $username, $password) {
    $sql = "SELECT * FROM users WHERE username = ? OR email = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../auth.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ss", $username, $username);
    mysqli_stmt_execute($stmt);
    $result_data = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($result_data)) {
        $password_hashed = $row['password'];
        $check_password = password_verify($password, $password_hashed);
        if ($check_password === false) {
            header("location: ../auth.php?error=wrongpassword");
            exit();
        } else if ($check_password === true) {
            session_start();
            $_SESSION['userid'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            header("location: ../dashboard.php");
            exit();
        } else {
            header("location: ../auth.php?error=wrongpassword");
            exit();
        }
    } else {
        header("location: ../auth.php?error=nouser");
        exit();
    }
}
