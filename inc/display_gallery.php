<!-- Image gallery include file -->

<?php
    require_once "inc/new_mysqli.php";

    $id = $_SESSION['id'];
    $gallery = [];

    $sql = "SELECT user.user_name, image.image_id, image.file_name, image.title, image.description 
            FROM user 
            INNER JOIN image 
            ON user.user_id = image.user_id 
            WHERE user.user_id = '$id'";
    $result = $db->query($sql);

    while ($row = mysqli_fetch_assoc($result)) {
        $gallery[] = $row;
    }

    // print_r($gallery);
?>
<div class="gallery">
    <?php
        if (count($gallery) > 0) {
            foreach ($gallery as $image) {
                echo '<div class="card" onclick="document.getElementById(\'modal' . $image['image_id'] . '\').style.display = \'flex\'">';
                echo '<img class="card-img" src="imgloads/' . $image['file_name'] . '" alt="AN IMG">';
                echo '<div class="card-info">';
                echo '<div class="card-head">';
                echo '<h2 class="card-title">' . $image['title'] . '</h2>';
                echo '</div>'; // End of card-head div
                echo '<div class="card-foot">';
                echo '<p class="card-author">' . $image['user_name'] . '</p>';
                echo '<p class="card-faves">&#9829; 27</p>';
                echo '</div>'; // End of card-foot div
                echo '</div>'; // End of card-info div
                echo '</div>'; // End of card div
            }
        }
    ?>
</div>
<?php
    if (count($gallery) > 0) {
        foreach ($gallery as $image) {
            echo '<div class="modal" id="modal' . $image['image_id'] . '" onclick="modalClose(' . $image['image_id'] . ')">';
            echo '<div class="modal-content">';
            echo '<img class="modal-img" src="imgloads/' . $image['file_name'] . '" alt="AN IMG">';
            echo '<div class="modal-aside">';
            echo '<div class="modal-head">';
            echo '<h2 class="modal-title">' . $image['title'] . '</h2>';
            echo '<p class="modal-close" title="PROTIP: You can always click outside the window to close it." onclick="document.getElementById(\'modal' . $image['image_id'] . '\').style.display = \'none\'">&times;</p>';
            echo '</div>'; // End of modal-head div
            echo '<div class="modal-body">';
            echo '<p class="modal-description">' . $image['description'] . '</p>';
            echo '<p class="modal-author">' . $image['user_name'] . '</p>';
            echo '<p class="modal-faves">&#9829; 27</p>';
            echo '</div>'; // End of modal-body div
            echo '</div>'; // End of modal-aside div
            echo '</div>'; // End of modal-content div
            echo '</div>'; // End of modal div
        }
    }
?>
<script src="js/gallery.js"></script>