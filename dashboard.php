<?php
    include_once('./src/includes/header.php'); 
    include_once('./src/config/database.php');
    include_once('./src/helperFunctions/subscriber_helper.php');
    include_once('./src/helperFunctions/sendmail.php');

    session_start();

    if (!isset($_SESSION['username'])) {
        header("location: ./auth.php");
    }

    try {
        $users = fetchData($conn);
    } catch (Exception $e) {
        echo $e->getMessage();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])){
        try {
            session_unset();
            session_destroy();
            header("location: ./auth.php");
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])){
        $id = $_POST['id'];
        try {
            $result = deleteData($conn, $id);
            echo "<script>alert('$result')</script>";
            header("location: ./dashboard.php");
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_mail'])){
        $id = $_POST['id'];
        try {
            $result = send_mail('Welcome', 'You have been added to the newsletter list', $_POST['email']);
            echo "<script>alert('$result')</script>";
            header("location: ./dashboard.php");
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    $conn->close();
?>

<div class="h-screen flex flex-col items-center mt-20 gap-5">
    <h1 class="text-3xl font-bold font-mono">Dashboard</h1>
    <p class="text-xl font-mono">Welcome to the dashboard</p>
    <form
        method="post"
        action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
        <input 
            type="submit" 
            name="logout"  
            value="logout"  
            class="bg-black hover:bg-gray-800 delay-100 ease-in-out p-3 text-lg text-white cursor-pointer">
    </form>

    <!-- user table -->
    <table class="table-auto">
        <thead>
            <tr>
                <th class="px-4 py-2">ID</th>
                <th class="px-4 py-2">Username</th>
                <th class="px-4 py-2">Email</th>
                <th class="px-4 py-2">Occupation</th>
                <th class="px-4 py-2">Skills</th>
                <th class="px-4 py-2"></th>
            </tr>
        </thead>
        <tbody>
            <?php
                if ($users) {
                    foreach ($users as $user) {
                        echo "<tr>";
                        echo "<td class='border px-4 py-2'>" . $user['id'] . "</td>";
                        echo "<td class='border px-4 py-2'>" . $user['name'] . "</td>";
                        echo "<td class='border px-4 py-2'>" . $user['email'] . "</td>";
                        echo "<td class='border px-4 py-2'>" . $user['occupation'] . "</td>";
                        echo "<td class='border px-4 py-2'>" . $user['skills'] . "</td>";
                        echo "<td class='border px-4 py-2 flex gap-2'>
                            <form action='" . htmlspecialchars($_SERVER['PHP_SELF']) ."' method='post'>
                                <input type='hidden' name='id' value='" . $user['id'] . "'>
                                <button
                                    type='submit'
                                    name='delete'
                                    class='bg-red-500 hover:bg-red-800 delay-100 ease-in-out text-white p-2 rounded-md'>Delete</button>
                            </form>

                            <form action='". htmlspecialchars($_SERVER['PHP_SELF']) ."' method='post'>
                                <input type='hidden' name='email' value='" . $user['email'] . "'>
                                <button
                                    type='submit'
                                    name='send_mail'
                                    class='bg-blue-500 hover:bg-blue-800 delay-100 ease-in-out text-white p-2 rounded-md'>Send Mail</button>
                            </form>
                        </td>";
                        echo "</tr>";
                    }
                }
            ?> 
</div>

<?php include_once('./src/includes/footer.php'); ?>
