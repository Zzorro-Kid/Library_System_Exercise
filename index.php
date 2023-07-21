<!DOCTYPE html>
<html>
<head>
    <title>Library Management System</title>
</head>
<body>
    <h1>Library Management System</h1>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <label for="title">Book Title:</label>
        <input type="text" id="title" name="title" required>
        <label for="author">Author:</label>
        <input type="text" id="author" name="author" required>
        <input type="submit" value="Add Book">
    </form>

    <br>

    <h2>Available Books</h2>
    <?php
        // Database connection
        $servername = "localhost";
        $username = "your_db_username";
        $password = "your_db_password";
        $dbname = "your_db_name";

        // Create a connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Function to add a book to the database
        function add_book($title, $author) {
            global $conn;
            $sql = "INSERT INTO books (title, author) VALUES ('$title', '$author')";
            $conn->query($sql);
        }

        // Function to get all available books
        function get_available_books() {
            global $conn;
            $sql = "SELECT * FROM books";
            $result = $conn->query($sql);
            $books = [];

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $books[] = $row;
                }
            }

            return $books;
        }

        // Process form submission
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = $_POST["title"];
            $author = $_POST["author"];
            add_book($title, $author);
            header("Location: index.php");
            exit();
        }

        // Display available books
        $books = get_available_books();

        if (count($books) > 0) {
            echo '<ul>';
            foreach ($books as $book) {
                echo '<li>' . $book['title'] . ' by ' . $book['author'] . '</li>';
            }
            echo '</ul>';
        } else {
            echo 'No books available in the library.';
        }

        // Close the database connection
        $conn->close();
    ?>
</body>
</html>
