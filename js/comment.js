$(document).ready(function() {
    $(".comment").click(function() {
        var btn_id = this.id;
        var split_id = btn_id.split("_");

        var img_id = split_id[1];
        var comment = document.getElementById("comment_" + img_id).value;
        $.ajax({
            url: "inc/new_comment.php",
            type: 'post',
            data: {
                img_id: img_id,
                comment: comment
            },
            success: function() {
                $(".comment").html("Sent!");
                console.log(comment);
            },
            error: function (jqXHR, exception) {
                var msg = '';
                if (jqXHR.status === 0) {
                    msg = 'Not connect.\n Verify Network.';
                } else if (jqXHR.status == 404) {
                    msg = 'Requested page not found. [404]';
                } else if (jqXHR.status == 500) {
                    msg = 'Internal Server Error [500].';
                } else if (exception === 'parsererror') {
                    msg = 'Requested JSON parse failed.';
                } else if (exception === 'timeout') {
                    msg = 'Time out error.';
                } else if (exception === 'abort') {
                    msg = 'Ajax request aborted.';
                } else {
                    msg = 'Uncaught Error.\n' + jqXHR.responseText;
                }
                console.log(msg);
            }
        });
    });
});