<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - Windmill Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../../assets/css/tailwind.output.css" />
  <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
  <script src="../../assets/js/init-alpine.js"></script>
</head>

<?php
session_start();

if (isset($_POST['submit'])) {
    include '../../config/database.php';

    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $pesan_error = "Username atau password harus diisi.";
    } else {
        $query = "SELECT password FROM kasir WHERE username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            $pesan_error = "Username tidak terdaftar.";
        } else {
            $row = $result->fetch_assoc();
            $hashed_password = $row['password'];

            if (password_verify($password, $hashed_password)) {
                header("Location: ../../index.php");
                exit;
            } else {
                $pesan_error = "Password tidak sesuai.";
            }
        }
    }
}
?>

<body>
  <div class="flex items-center min-h-screen p-6 bg-gray-50 dark:bg-gray-900">
    <div class="flex-1 h-full max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl dark:bg-gray-800">
      <div class="flex flex-col overflow-y-auto md:flex-row">
        <div class="h-32 md:h-auto md:w-1/2">
          <img aria-hidden="true" class="object-cover w-full h-full dark:hidden"
            src="../../assets/img/login-office.jpeg" alt="Office" />
          <img aria-hidden="true" class="hidden object-cover w-full h-full dark:block"
            src="../../assets/img/login-office-dark.jpeg" alt="Office" />
        </div>
        <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
          <div class="w-full">
            <form action="" method="post">
              <h1 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200">
                Login
              </h1>

              <?php if (isset($pesan_error)): ?>
                <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
                  <p class="text-sm text-red-600 dark:text-red-400">
                    <?php echo $pesan_error; ?>
                  </p>
                </div>
              <?php endif; ?>

              <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">Username</span>
                <input
                  class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder="Jane Doe" name="username" />
              </label>
              <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Password</span>
                <input
                  class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                  placeholder="***************" type="password" name="password" />
              </label>

              <button
                class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                type="submit" name="submit">
                Log in
              </button>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>