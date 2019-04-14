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
            
              <div class="w3-border-bottom"><b>First Name:</b> <span class="w3-right w3-text-grey">David Connelly</span></div>
              <div class="w3-border-bottom"><b>Eve:</b> <span class="w3-right w3-text-grey">David Connelly</span></div>
              <div class="w3-border-bottom"><b>Email:</b> <span class="w3-right w3-text-grey">David Connelly</span></div>
              <div class="w3-border-bottom"><b>First Name:</b> <span class="w3-right w3-text-grey">David Connelly</span></div>
              <div class="w3-border-bottom"><b>Eve:</b> <span class="w3-right w3-text-grey">David Connelly</span></div>
              <div class="w3-border-bottom"><b>Email:</b> <span class="w3-right w3-text-grey">David Connelly</span></div>
              <div class="w3-border-bottom"><b>Description:</b> <br><span class="w3-text-grey">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nam ea expedita numquam voluptatem alias eveniet, amet, repudiandae labore distinctio aliquam dicta at blanditiis facilis? Ad omnis, aliquam explicabo aspernatur illo.</span> </div>

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
                                <textarea name="introduction" class="w3-input w3-border w3-sand" placeholder="Enter comment here..." ></textarea>
                            </p>
                            <p class="w3-right modal-btns">
                                <button onclick="document.getElementById('create-comment-modal').style.display='none'" type="button" name="submit" value="Submit" class="w3-button w3-small 3-white w3-border">CANCEL</button> 

                                <button type="submit" name="submit" value="Submit" class="w3-button w3-small primary">ADD COMMENT</button> 
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



                <p>No comments have been posted so far.</p>

    <table class="w3-table w3-striped">
        <tr>
            <td>
                <p class="w3-small">Thursday 20th November at 8:30pm</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Qui esse aut eveniet, adipisci, voluptatibus laboriosam deserunt. Suscipit porro, maxime? Ea fugit necessitatibus nihil magnam incidunt deleniti aut pariatur alias sint!</p>
            </td>
        </tr>
        <tr>
            <td>
                <p class="w3-small">Thursday 20th November at 8:30pm</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Qui esse aut eveniet, adipisci, voluptatibus laboriosam deserunt. Suscipit porro, maxime? Ea fugit necessitatibus nihil magnam incidunt deleniti aut pariatur alias sint!</p>
            </td>
        </tr>
        <tr>
            <td>asdf</td>
        </tr>
        <tr>
            <td>asdf</td>
        </tr>
        <tr>
            <td>asdf</td>
        </tr>
        <tr>
            <td>asdf</td>
        </tr>
    </table>


            </div>
        </div>
    </div>
</div>