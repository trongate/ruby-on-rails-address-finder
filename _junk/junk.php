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
                    <?= Modules::run('comments/_display_comments', $token) ?>
                </div>


                <?= Modules::run('comments/_display_comments_block', $target_table, $user_id, $token) ?>