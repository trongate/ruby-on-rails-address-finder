<div class="w3-row">
    <div class="w3-container">

        <h1><?= $headline ?></h1>
        <?= flashdata() ?>
        
        <p><a href="<?= BASE_URL ?>donors/create"><button class="w3-button w3-medium primary"><i class="fa fa-pencil"></i>  CREATE NEW DONOR RECORD</button></a></p>
        <p><?= Pagination::display($data) ?></p>


        <style> 
            .table-top {
                display: flex;
                flex-direction: row;
                align-items: stretch;
                justify-content: space-between;
            }

            .w3-dropdown-content {
                min-width: 50px;
            }

        </style>

        <table class="w3-table">

            <tr class="primary">
                <th colspan="4">
                    <div class="table-top">
                        <div>
                            <form action="<?= BASE_URL ?>donors/submit_search" method="post" style="display: inline;">
                                <input type="text" name="search_string" placeholder="Search records..." >
                                <button type="submit"><i class="fa fa-search"> Search</i></button>
                            </form>
                        </div>
                        <div>Records Per Page: 

                            <div class="w3-dropdown-click">
                              <button onclick="myFunction()" id="per-page"><?= $limit_pref ?></button>
                              <div id="per-page-options" class="w3-dropdown-content w3-bar-block w3-border" style="right:0">
                                <a href="#" class="w3-bar-item w3-button" onClick="sayPerPageLimit(10)">10</a>
                                <a href="#" class="w3-bar-item w3-button" onClick="sayPerPageLimit(20)">20</a>
                                <a href="#" class="w3-bar-item w3-button" onClick="sayPerPageLimit(50)">50</a>
                                <a href="#" class="w3-bar-item w3-button" onClick="sayPerPageLimit(100)">100</a>
                              </div>
                            </div>

                            <script>
                            function myFunction() {
                              var x = document.getElementById("per-page-options");
                              if (x.className.indexOf("w3-show") == -1) {  
                                x.className += " w3-show";
                              } else { 
                                x.className = x.className.replace(" w3-show", "");
                              }
                            }

                            // Get the dropdown btn
                            var x = document.getElementById("per-page-options");
                            var perPage = document.getElementById("per-page");

                            // When the user clicks anywhere outside of the dropdown btn, close it
                            window.onclick = function(event) {
                              if (event.target !== perPage) {
                                console.log(event.target);
                                console.log('close');
                                x.className = x.className.replace(" w3-show", "");
                              }
                            }

                            function sayPerPageLimit(value) {
                                var targetUrl = '<?= BASE_URL ?>donors/set_pref/' + value;
                                window.location.href = targetUrl;
                            }
                            </script>


                        </div>
                    </div>
                </th>
            </tr>

            <tr class="secondary">
                <th>First Name</th>
                <th>Last Name</th>
                <th>Points</th>
                <th style="width: 20px;">Action</th>
            </tr>
            <?php
            unset($data['include_showing_statement']); //since not required for btm pagination
            $attributes['class'] = 'w3-button w3-small w3-button w3-white w3-border'; //styling for 'view' links
            foreach($donors as $donor) {
            ?>
            <tr>
                <td><?= $donor->first_name ?></td>
                <td><?= $donor->email ?></td>
                <td>Points</td>
                <td><?= anchor('donors/edit/'.$donor->id, '<i class="fa fa-eye"></i> VIEW', $attributes) ?></td>
            </tr>
            <?php
            }
            ?>
        </table>

        <p><?= Pagination::display($data) ?></p>

    </div>
</div>