<!-- Image gallery include file -->

<?php
    $dir = "imgloads/";

    $a = scandir($dir);
?>
<div class="gallery">
    <?php
        if (count($a) > 2) {
            for ($i = 2; $i < count($a); $i++) {
                if (!is_dir($a[$i])) {
                    echo '<div class="card" onclick="document.getElementById(\'modal' . $i . '\').style.display = \'flex\'">';
                    echo '<img class="card-img" src="imgloads/' . $a[$i] . '" alt="AN IMG">';
                    echo '<div class="card-info">';
                    echo '<div class="card-head">';
                    echo '<h2 class="card-title">Fake Plastic Furries</h2>';
                    echo '</div>'; // End of card-head div
                    echo '<div class="card-foot">';
                    echo '<p class="card-author">foxfile</p>';
                    echo '<p class="card-faves">&#9829; 27</p>';
                    echo '</div>'; // End of card-foot div
                    echo '</div>'; // End of card-info div
                    echo '</div>'; // End of card div
                }
            }
        }
    ?>
</div>
<?php
    if (count($a) > 2) {
        for ($i = 2; $i < count($a); $i++) {
            echo '<div class="modal" id="modal' . $i . '" onclick="modalClose(' . $i . ')">';
            echo '<div class="modal-content">';
            echo '<img class="modal-img" src="imgloads/' . $a[$i] . '" alt="AN IMG">';
            echo '<div class="modal-aside">';
            echo '<div class="modal-head">';
            echo '<h2 class="modal-title">Fake Plastic Furries</h2>';
            echo '<p class="modal-close" title="PROTIP: You can always click outside the window to close it." onclick="document.getElementById(\'modal' . $i . '\').style.display = \'none\'">&times;</p>';
            echo '</div>'; // End of modal-head div
            echo '<div class="modal-body">';
            echo '<p class="modal-description">If we could be, who the world wanted, all the time...</p>';
            echo '<p class="modal-author">foxfile</p>';
            echo '<p class="modal-faves">&#9829; 27</p>';
            echo '</div>'; // End of modal-body div
            echo '</div>'; // End of modal-aside div
            echo '</div>'; // End of modal-content div
            echo '</div>'; // End of modal div
        }
    }
?>
<script src="js/gallery.js"></script>