<?php $cancel_url = ''; ?>
<div class="w3-row">
    <div class="w3-container">   
        <h1><?= $headline ?> <span style="margin-top: 1em;" class="w3-large w3-rigxht">(ID: <?= $update_id ?>)</span></h1>
        <?= flashdata() ?>
        <div class="w3-card-4">
            <div class="w3-container primary">
                <h4>Options</h4>
            </div>

            <div class="w3-container">
            <p>
                <a href="<?= BASE_URL ?>donors/manage"><button class="w3-button w3-white w3-border"><i class="fa fa-list-alt"></i> VIEW ALL DONORS</button></a> 
                <a href="<?= BASE_URL ?>donors/create/<?= $update_id ?>"><button class="w3-button w3-white w3-border"><i class="fa fa-pencil"></i> UPDATE DETAILS</button></a>
                <button onclick="document.getElementById('delete-record-modal').style.display='block'" class="w3-button w3-red w3-hover-black w3-border w3-right"><i class="fa fa-trash-o"></i> DELETE</button>

                <div id="delete-record-modal" class="w3-modal w3-center" style="padding-top: 7em;">
                    <div class="w3-modal-content w3-animate-right w3-card-4" style="width: 30%;">
                        <header class="w3-container w3-red w3-text-white">
                            <h4><i class="fa fa-trash-o"></i> DELETE RECORD</h4>
                        </header>
                        <div class="w3-container">
                    
                            <h5>Are you sure?</h5>
                            <p>You are about to delete a donor record.  This cannot be undone. <br>
                                        Do you really want to do this?</p>
                            <p class="w3-rigxht modal-btns">
                                <button onclick="document.getElementById('delete-record-modal').style.display='none'" type="button" name="submit" value="Submit" class="w3-button w3-small 3-white w3-border">CANCEL</button> 

                                <button type="submit" name="submit" value="Submit" class="w3-button w3-small w3-red w3-hover-black">YES - DELETE IT NOW!</button> 
                            </p>
                        </div>
                    </div>
                </div>
            </p>        
            </div>
        </div>
    </div>
</div>

<div class="w3-row">
    <div class="w3-half w3-container">    
        <div class="w3-card-4 edit-block" style="margin-top: 1em;">
            <div class="w3-container primary">
                <h4>Donor Details</h4>
            </div>
            <div class="edit-block-content">
            
              <div class="w3-border-bottom"><b>First Name:</b> <span class="w3-right w3-text-grey"><?= $first_name ?></span></div>
              <div class="w3-border-bottom"><b>Price:</b> <span class="w3-right w3-text-grey"><?= $price ?></span></div>
              <div class="w3-border-bottom"><b>Email:</b> <span class="w3-right w3-text-grey"><?= $email ?></span></div>
              <div class="w3-border-bottom"><b>Introduction:</b> <br><span class="w3-text-grey"><?= $introduction ?></span> </div>

            </div>
        </div>
    </div>

    <div class="w3-half w3-container">    
        <div class="w3-card-4 edit-block" style="margin-top: 1em;">
            <div class="w3-container primary">
                <h4>Comments</h4>
            </div>
            <div class="w3-container w3-center edit-block-content">

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

                <script type="text/javascript">
                    var modals = document.getElementsByClassName("w3-modal");

                    window.onclick = function(event) {
                      for (var i = 0; i < modals.length; i++) {
                          if (event.target == modals[i]) {
                            modals[i].style.display = "none";
                          }
                      }
                    }
                </script>

                <div class="comments">
                    <?= Modules::run('comments/_display_comments') ?>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
function submitNewComment() {
    document.getElementById('create-comment-modal').style.display='none';
    var newComment = document.getElementById('new-comment').value;

    if (newComment != '') {
        
        const params = {
            token: '<?= $token ?>',
            comment: newComment
        }

        document.getElementById('new-comment').value = '';

        const http = new XMLHttpRequest()
        http.open('POST', '<?= BASE_URL ?>comments-api/submit')
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
    http.open('POST', '<?= BASE_URL ?>comments-api/get')
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