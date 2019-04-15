<?php 
if ($comments == false) {
    echo '<p id="comments-info">No comments have been posted so far.</p>';
}
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