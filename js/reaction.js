$(document).ready(function() {
    $(".reaction").click(function() {
        var btn_id = this.id;
        var split_id = btn_id.split("_");

        var img_id = split_id[1];
        var reaction = split_id[0];

        if (reaction === "like") {
            var reaction_id = '1';
        } else if (reaction === "dislike") {
            var reaction_id = '2';
        }

        $.ajax({
            url: "inc/update_like.php",
            type: 'post',
            data: {
                img_id: img_id,
                reaction_id: reaction_id
            },
            success: function() {
                if (reaction_id === '1') {
                    $("#" + btn_id).html("<i class='fa fa-thumbs-up'></i>");
                    $("#dislike_" + img_id).html("<i class='fa fa-thumbs-o-down'></i>");
                } else if (reaction_id === '2') {
                    $("#" + btn_id).html("<i class='fa fa-thumbs-down'></i>");
                    $("#like_" + img_id).html("<i class='fa fa-thumbs-o-up'></i>");
                }
                // console.log("Hooyah booyah!");
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