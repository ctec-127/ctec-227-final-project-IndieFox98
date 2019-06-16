<!-- Image gallery include file -->

<?php
    require_once "inc/new_mysqli.php";

    // $id = $_SESSION['id'];

    // sql to return information about image
    $image_info = [];

    $sql = "SELECT user.user_name, image.image_id, image.file_name, image.title, image.description, image.alt_text, image.image_date 
            FROM user 
            INNER JOIN image 
            ON user.user_id = image.user_id 
            ORDER BY image.title";
    $result = $db->query($sql);

    while ($row = mysqli_fetch_assoc($result)) {
        $image_info[] = $row;
    }

    // sql to display number of likes per image
    $image_likes = [];

    $sql_like = "SELECT COUNT(image_reaction.reaction_id) AS image_likes 
                FROM image_reaction 
                RIGHT JOIN image 
                ON image_reaction.image_id = image.image_id 
                AND image_reaction.reaction_id = '1' 
                GROUP BY image.image_id 
                ORDER BY image.title";
    $result = $db->query($sql_like);

    while ($row = mysqli_fetch_assoc($result)) {
        $image_likes[] = $row;
    }

    // sql to display number of dislikes per image
    $image_dislikes = [];

    $sql_dislike = "SELECT COUNT(image_reaction.reaction_id) AS image_dislikes 
                    FROM image_reaction 
                    RIGHT JOIN image 
                    ON image_reaction.image_id = image.image_id 
                    AND image_reaction.reaction_id = '2' 
                    GROUP BY image.image_id 
                    ORDER BY image.title";
    $result = $db->query($sql_dislike);

    while ($row = mysqli_fetch_assoc($result)) {
        $image_dislikes[] = $row;
    }

    // sql to display comments per image
    $image_comments = [];

    for ($i = 0; $i < count($image_info); $i++) {
        $comments = [];
        $image_id = $image_info[$i]['image_id'];

        $sql_comment = "SELECT comment.comment_string, comment.comment_date, user.user_name 
                        FROM comment 
                        INNER JOIN user 
                        ON comment.user_id = user.user_id 
                        AND comment.image_id = $image_id 
                        ORDER BY comment.comment_date DESC";
        
        $result = $db->query($sql_comment);

        while ($row = mysqli_fetch_assoc($result)) {
            $comments[] = $row;
        }

        $image_comments['comments'] = $comments;
        $image_info[$i] = array_merge($image_info[$i], $image_comments);
    }

    // merge arrays into gallery containing all image information
    $gallery = [];

    for ($i = 0; $i < count($image_info); $i++) {
        $gallery[] = array_merge($image_info[$i], $image_likes[$i], $image_dislikes[$i]);
    }

    // print_r($image_info);
    // print_r($image_likes);
    // echo '<pre>';
    // print_r($gallery);
    // echo '</pre>';
    // print_r($image_comments);
?>
<?php
    if (count($gallery) > 0) {
        echo '<div class="gallery">';
        foreach ($gallery as $image) {
            // Gallery images will go here
            echo '<div class="card" onclick="document.getElementById(\'modal' . $image['image_id'] . '\').style.display = \'flex\'">';
            echo '<img class="card-img" src="imgloads/' . $image['file_name'] . '" alt="' . $image['alt_text'] . '">';
            echo '<div class="card-info">';
            echo '<div class="card-head">';
            echo '<h2 class="card-title">' . $image['title'] . '</h2>';
            echo '</div>'; // End of card-head div
            echo '<div class="card-foot">';
            echo '<p class="card-author">' . $image['user_name'] . '</p>';
            echo '<p class="card-faves"><i class="fa fa-thumbs-up"></i> ' . $image['image_likes'] . ' <i class="fa fa-thumbs-down"></i> ' . $image['image_dislikes'] . '</p>';
            echo '</div>'; // End of card-foot div
            echo '</div>'; // End of card-info div
            echo '</div>'; // End of card div
        }
        echo '</div>'; // End of gallery div
    } else {
        echo '<h1>No images to be found here...</h1>';
        echo '<p>Sheets of empty canvas<br>Untouched sheets of clay</p>';
    }

    if (count($gallery) > 0) {
        foreach ($gallery as $image) {
            // Modals of images here
            $img_date = new DateTime($image['image_date']);
            echo '<div class="modal" id="modal' . $image['image_id'] . '" onclick="modalClose(' . $image['image_id'] . ')">';
            echo '<div class="modal-content">';
            echo '<img class="modal-img" src="imgloads/' . $image['file_name'] . '" alt="' . $image['alt_text'] . '">';
            echo '<div class="modal-aside">';
            echo '<div class="modal-head">';
            echo '<h2 class="modal-title">' . $image['title'] . '</h2>';
            echo '<p class="modal-close" title="PROTIP: You can always click outside the window to close it." onclick="document.getElementById(\'modal' . $image['image_id'] . '\').style.display = \'none\'">&times;</p>';
            echo '</div>'; // End of modal-head div
            echo '<div class="modal-body">';
            echo '<p class="modal-description">' . $image['description'] . '</p>';
            echo '<p class="modal-author">Uploaded by ' . $image['user_name'] . ' on ' . $img_date->format('F jS, Y') . '</p>';

            # The old like system
            // echo '<p class="modal-faves"><i class="fa fa-thumbs-o-up"></i> ' . $image['image_likes'] . ' <i class="fa fa-thumbs-o-down"></i> ' . $image['image_dislikes'] . '</p>';
            // echo '<p class="">Uploaded on: ' . $img_date->format('F jS, Y') . '</p>';
            // if (isset($_SESSION['login'])) {
            //     echo '<button type="button" class="button reaction" id="like_' . $image['image_id'] . '" title="Thank you for liking!">Like</button>';
            // } else {
            //     echo '<button class="button" title="You need to log in if you wanna like!">Like</button>';
            // }
            // if (isset($_SESSION['login'])) {
            //     echo '<button type="button" class="button reaction" id="dislike_' . $image['image_id'] . '" title="I so sorry u no likey.">Dislike</button>';
            // } else {
            //     echo '<button class="button" title="You need to log in if you wanna dislike!">Dislike</button>';
            // }

            # The new like system
            echo '<p class="modal-faves">';

            // Do you like it?
            echo '<div class="reaction-card">';
            echo isset($_SESSION['login']) ? '<button class="button reaction" id="like_' . $image['image_id'] . '" title="Thank you for liking!"><i class="fa fa-thumbs-o-up"></i></button>' : '<i class="fa fa-thumbs-o-up"></i>';
            echo '<span class="reaction-display" id="number-likes_' . $image['image_id'] . '">' . $image['image_likes'] . '</span>';
            echo '</div>';

            // Or dislike it?
            echo '<div class="reaction-card">';
            echo isset($_SESSION['login']) ? '<button class="button reaction" id="dislike_' . $image['image_id'] . '" title="I\'m sorry to hear you don\'t like it."><i class="fa fa-thumbs-o-down"></i></button>' : '<i class="fa fa-thumbs-o-up"></i>';
            echo '<span class="reaction-display" id="number-dislikes_' . $image['image_id'] . '">' . $image['image_dislikes'] . '</span>';
            echo '</div>';

            echo '<h2>Comments</h2>';
            echo '<input type="text" id="comment_' . $image['image_id'] . '">';
            if (isset($_SESSION['login'])) {
                echo '<button type="button" class="button comment" id="comment-btn_' . $image['image_id'] . '" title="Time to comment!">Send</button>';
            } else {
                echo '<button class="button" title="You need to log in if you wanna comment!">Send</button>';
            }
            echo '<div class="modal-comments">';
            foreach ($image['comments'] as $comment) {
                $comment_date = new DateTime($comment['comment_date']);
                echo '<p>' . $comment['comment_string'] . '<br>' . $comment['user_name'] . ' on ' . $comment_date->format('F jS, Y') . ' at ' . $comment_date->format('H:i:s') . '</p>';
            }
            // print_r($image['comments']);
            echo '</div>';
            echo '</div>'; // End of modal-body div
            echo '</div>'; // End of modal-aside div
            echo '</div>'; // End of modal-content div
            echo '</div>'; // End of modal div
        }
    }
?>
<script src="js/gallery.js"></script>
<script src="js/reaction.js"></script>
<script src="js/comment.js"></script>