<?php 
if ($comments == false) {
    echo '<p id="comments-info">No comments have been posted so far.</p>';
} else {
    echo '<p id="comments-info"></p>';
?>
    <table class="w3-table w3-striped" id="comments-tbl">
        <?php
        foreach ($comments as $row) {
        ?>
            <tr>
                <td>
                    <p class="w3-small"><?= $row->comment ?></p>
                    <p><?= $row->comment ?></p>
                </td>
            </tr>
        <?php
        }
        ?>
    </table>
<?php
}
?>



<script>
function submitNewComment() {
    document.getElementById('create-comment-modal').style.display='none';
    var newComment = document.getElementById('new-comment').value;

    if (newComment != '') {
        
        const params = {
            target_table: '<?= $target_table ?>',
            update_id: '<?= $update_id ?>',
            token: '<?= $token ?>',
            comment: newComment
        }

        document.getElementById('new-comment').value = '';

        const http = new XMLHttpRequest()
        http.open('POST', '<?= BASE_URL ?>comments/submit')
        http.setRequestHeader('Content-type', 'application/json')
        http.send(JSON.stringify(params)) // Make sure to stringify
        http.onload = function() {
            // Update the comments table
            refreshComments();
        }
    }
}

function refreshComments() {
    var commentsTblInnerHTML = '';

    const params = {
        token: '<?= $token ?>'
    }

    const http = new XMLHttpRequest()
    http.open('POST', '<?= BASE_URL ?>comments/get')
    http.setRequestHeader('Content-type', 'application/json')
    http.send(JSON.stringify(params)) // Make sure to stringify
    http.onload = function() {
        // Display the comments
        var comments = JSON.parse(http.responseText);

        if (comments.length > 0) {
            for (var i = 0; i < comments.length; i++) {
                commentsTblInnerHTML+= '<tr><td><p class="w3-small">' + comments[i]['date_created'] + '</p><p>' + comments[i]['comment'] + '</p></td></tr>';
            }
        }

        document.getElementById('comments-tbl').innerHTML = commentsTblInnerHTML;
        document.getElementById('comments-info').style.display = 'none';
    }
}
</script>