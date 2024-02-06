<?php 
    include_once('./src/includes/header.php'); 
    include_once('./src/helperFunctions/auth_helper.php');


    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])){
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (empty($email) || empty($password) || empty($username)) {
            echo "<script>alert('Please fill in all the fields')</script>";
        } else {
            try {
                register_user($conn, $username, $password, $email);
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
    }

    $conn->close();
?>

<main class="h-screen flex justify-center mt-[20vh]">
    <div class="w-1/2 flex flex-col gap-12">
        <h1 class="text-4xl font-mono text-center">Register Page</h1>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);  ?>" method="post" class="flex flex-col gap-4">
            <input type="email" name="email" placeholder="Enter your email" class="p-2 border-2 border-gray-300 rounded-md" required>
            <input type="text" name="username" placeholder="Enter your username" class="p-2 border-2 border-gray-300 rounded-md" required>
            <input type="password" name="password" placeholder="Enter your Password" class="p-2 border-2 border-gray-300 rounded-md" required>
            <button type="submit" name="submit" class="bg-blue-500 text-white p-2 rounded-md">Join</button>
        </form>

        <a href="./login.php" class="text-center text-blue-500">Already have an account? Login here</a>
    </div>
</main>

<?php include_once('./src/includes/footer.php') ?>