<?php 
    include_once('./src/includes/header.php'); 
    include_once('./src/helperFunctions/subscriber_helper.php');
?>

<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])){
        $email = $_POST['email'];
        $name = $_POST['name'];
        $occupation = $_POST['occupation'];
        $skills = $_POST['skills'];

        try {
            $result = insertData($conn, $email, $name, $occupation, $skills);
            echo "<script>alert('$result')</script>";
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    $conn->close();
?>

    <main class="flex mt-20 justify-center h-screen">
        <div class="w-1/2 flex flex-col gap-12">
            <img src="./assets/me.jpg" alt="newsletter" class="w-[300px] h-[300px] object-cover mx-auto rounded-full">
            <h1 class="text-4xl font-mono text-center">Join my newsletter</h1>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);  ?>" method="post" class="flex flex-col gap-4">
                <input type="email" name="email" placeholder="Enter your email" class="p-2 border-2 border-gray-300 rounded-md" required>
                <input type="text" name="name" placeholder="Enter your name" class="p-2 border-2 border-gray-300 rounded-md" required>
                <input type="occupation" name="occupation" placeholder="Enter your occupation" class="p-2 border-2 border-gray-300 rounded-md" required>
                <input type="skills" name="skills" placeholder="Enter your tech skils eg: python, javascript" class="p-2 border-2 border-gray-300 rounded-md" required>
                <button type="submit" name="submit" class="bg-blue-500 text-white p-2 rounded-md">Join</button>
            </form>
        </div>
    </main>

<?php include_once('./src/includes/footer.php') ?>