<p><button onclick="document.getElementById('create-comment-modal').style.display='block'" class="w3-button w3-white w3-border"><i class="fa fa-commenting-o"></i> ADD NEW COMMENT</button></p>

<div id="create-comment-modal" class="w3-modal" style="padding-top: 7em;">
    <div class="w3-modal-content w3-animate-top w3-card-4" style="width: 30%;">
        <header class="w3-container primary w3-text-white">
            <h4><i class="fa fa-commenting-o"></i> ADD NEW COMMENT</h4>
        </header>
        <div class="w3-container">
            <p>
                <textarea name="comment" id="new-comment" class="w3-input w3-border w3-sand" placeholder="Enter comment here..." ></textarea>
            </p>
            <p class="w3-right modal-btns">
                <button onclick="document.getElementById('create-comment-modal').style.display='none'" type="button" name="submit" value="Submit" class="w3-button w3-small 3-white w3-border">CANCEL</button> 

                <button onclick="submitNewComment()" type="button" name="submit" value="Submit" class="w3-button w3-small primary">ADD COMMENT</button> 
            </p>
        </div>
    </div>
</div>

<script>
var token = '<?= $token ?>';
var target_table = '<?= $target_table ?>';
var update_id = '<?= $update_id ?>';

function fetch_comments() {
    //alert(`fetching comments, token is ${token} and target table is ${target_table} and update_id is ${update_id}`);

        var target_url = '<?= BASE_URL ?>api/get/comments/?target*!underscore!*table=donors&update*!underscore!*id=1&orderBy=date*!underscore!*created';

        console.log(target_url);

        const http = new XMLHttpRequest()
        http.open('GET', target_url)
        http.setRequestHeader('Content-type', 'application/json')
        http.send()
        http.onload = function() {
            // Do whatever with response
            alert(http.responseText)
        }




}


fetch_comments();
</script>