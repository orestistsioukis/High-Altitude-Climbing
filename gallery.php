<?php
require "header.php";
?>

	<main class="main-gallery">
		<section class="gallery-links">
            <div class="wrapper">
                <h2>Gallery</h2>
                <div class="gallery-container">
					<?php
					include_once 'includes/dbh.inc.php';

					$sql = "SELECT * FROM gallery ORDER BY orderGallery DESC";
					$stmt = mysqli_stmt_init($conn);
					if (!mysqli_stmt_prepare($stmt, $sql)) {
						echo "SQL statement failed!";
					} else {
						mysqli_stmt_execute($stmt);
						$result = mysqli_stmt_get_result($stmt);

						while ($row = mysqli_fetch_assoc($result)) {
							echo '<a href="img/gallery/'.$row["imgFullNameGallery"].'" target="_blank">
								<div id="imgF" style="background-image: url(img/gallery/'.$row["imgFullNameGallery"].');"></div>
								<h3>'.$row["titleGallery"].'</h3>
								<p>'.$row["descGallery"].'</p>
								</a>';
						}
					}
					if (isset($_GET['error'])) {
						if ($_GET['error'] == "sqlerror") {
							$message = '<p class="error">SQL statement failed!</p>';
						}
						else if ($_GET['error'] == "error") {
							$message = '<p class="error">You had an error!</p>';
						}
						else if ($_GET['error'] == "oversizedfile") {
							$message = '<p class="error">File size exides 4MB!</p>';
						}
						else if ($_GET['error'] == "filetype") {
							$message = '<p class="error">Allowed file types are jpg, jpeg, png!</p>';
						}
					}
					else if (@$_GET['upload'] == "empty") {
						$message = '<p class="error">Image description or title is empty!</p>';
					}
					else if (@$_GET['upload'] == "success") {
						$message = '<p class="success">Image uploaded successfully!</p>';
					}
					?>
                </div>
				<?php
				if (isset($_SESSION['userId'])) {
					echo '<div class="gallery-upload">
					<h1>Upload</h1>
					'.@$message.'
					<form action="includes/gallery-upload.inc.php" method="post" enctype="multipart/form-data">
						<label for="filename">File name: </label>
						<input type="text" name="filename" placeholder="File name...">
						<label for="filetitle">Image title: </label>
						<input type="text" name="filetitle" placeholder="Image title...">
						<label for="filedesc">Image description: </label>
						<input type="text" name="filedesc" placeholder="Image description...">
						<label for="file">Pick a file: </label>
						<input type="file" name="file">
						<button type="submit" name="submit">UPLOAD</button>
					</form>
					</div>';	
				}
				?>
            </div>
        </section>
	</main>
<?php
require "footer.php";
?>