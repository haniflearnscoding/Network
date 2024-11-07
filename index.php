<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gallery</title>
    <link rel="stylesheet" href="css/stylesheet.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/ScrollTrigger.min.js"></script>
</head>
<body>    
     <form action="upload.php?access_key=YOUR_SECRET_KEY_1" method="post" enctype="multipart/form-data">
        <label for="fileToUpload">Select an image to upload:</label>
        <input type="file" name="fileToUpload" id="fileToUpload" required>
        <br><br>
        <input type="submit" value="Upload Image" name="submit">
    </form>
    <div class="gallery-container">
            <!-- Modal Structure -->
            <div id="imageModal" class="modal">
                <span class="close">&times;</span>
                <img class="modal-content" id="modalImage">
                <div class="comment-section">
                    <textarea id="commentInput" placeholder="Leave a comment..."></textarea>
                    <button id="submitComment">Submit</button>
                </div>
                 <div id="commentsList"></div> <!-- Container for displaying comments -->
            </div>
            <button id="backBtn">←</button>
            <div class="gallery">
                <?php
                // Display uploaded images
                $images = glob("uploads/*.{jpg,jpeg,png,gif}", GLOB_BRACE);
                foreach ($images as $image) {
                    echo "<img class='gallery-image' src='$image' alt='Gallery Image' width='200'>";
                }
                ?>
            </div>

            <button id="nextBtn">→</button>
         
        </div>

</body>
</html>
