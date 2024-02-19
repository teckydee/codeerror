<?php
session_start();
if(!isset($_SESSION['id']))header('Location: login.php')
// if (!isset($_SESSION['username'])) {
//     header("location: login.php");
//     exit;
// }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_FILES['blog_image']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "uploads/images/";
        $target_file = $target_dir . basename($_FILES["blog_image"]["name"]);

        // Move uploaded image file to desired location
        if (move_uploaded_file($_FILES["blog_image"]["tmp_name"], $target_file)) {
            $image_path = $target_file;
        } else {
            echo "Sorry, there was an error uploading your image.";
            exit;
        }
    } else {
        echo "Error: " . $_FILES["blog_image"]["error"];
        exit;
    }

    // Extracting blog title and content
    $blog_title = $_POST['blog_title'];
    $blog_content = $_POST['blog_content'];

    // Creating the blog post with proper HTML formatting
    $blog_post = "<div class='blog-post'><h2>$blog_title</h2><p>$blog_content</p>";
    $blog_post .= "<img src='$image_path' alt='Blog Image'></div>\n";

    // Append the blog post to blog.html
    file_put_contents("blog.html", $blog_post, FILE_APPEND | LOCK_EX);

    // Optionally, redirect to a success page or display a success message
    header("location: upload.php?success=true");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload Blog</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .upload-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .upload-container h2 {
            text-align: center;
        }

        .upload-form {
            margin-top: 20px;
        }

        .upload-form input[type="text"],
        .upload-form textarea,
        .upload-form input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .upload-form textarea {
            height: 150px;
        }

        .upload-form button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="upload-container">
        <h2>Upload Blog</h2>
        <form class="upload-form" method="post" enctype="multipart/form-data">
            <input type="text" name="blog_title" placeholder="Blog Title" required>
            <textarea name="blog_content" placeholder="Blog Content" required></textarea>
            <input type="file" name="blog_image" accept="image/*" required>
            <button type="submit">Upload</button>
        </form>
    </div>
</body>
</html>
