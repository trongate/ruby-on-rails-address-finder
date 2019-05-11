<div class="w3-row">
    <div class="w3-container">

        <h1><?= $headline ?></h1>
        <?= flashdata() ?>

        <p><a href="<?= BASE_URL ?>donors/create"><button class="w3-button w3-medium primary"><i class="fa fa-pencil"></i>  CREATE NEW DONOR RECORD</button></a></p>




            
                <table class="w3-table results-tbl" id="test-table">
                    <tr>
                        <td>Hello</td>
                        <td>How are you?</td>
                        <td>I am good</td>
                    </tr>
                </table>

<script>
function testFunction() {

  var table = document.getElementById("test-table");
  var header = table.createTHead();
  var row = header.insertRow(0);
  var cell = row.insertCell(0);
  cell.colSpan = "3";
  cell.innerHTML = `
                    <tr class="primary">
                        <th colspan="5">
                            <div class="table-top">
                                <div>
                                    <form action="<?= BASE_URL ?>donors/submit_search" method="post" style="display: inline;">
                                        <input type="text" name="search_string" placeholder="Search records..." >
                                        <button type="submit"><i class="fa fa-search"> Search</i></button>
                                    </form>
                                </div>
                                <div>Records Per Page:
                                    <div class="w3-dropdown-click">
                                        <button onclick="myFunction()"><?= $limit_pref ?></button>
                                        <div id="per-page-options" class="w3-dropdown-content w3-bar-block w3-border" style="right:0">
                                            <a href="#" class="w3-bar-item w3-button" onClick="sayPerPageLimit(10)">10</a>
                                            <a href="#" class="w3-bar-item w3-button" onClick="sayPerPageLimit(20)">20</a>
                                            <a href="#" class="w3-bar-item w3-button" onClick="sayPerPageLimit(50)">50</a>
                                            <a href="#" class="w3-bar-item w3-button" onClick="sayPerPageLimit(100)">100</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </th>
                    </tr>
                    <tr class="secondary">
                        <th>First Name</th>
                        <th>Email</th>
                        <th>Introduction</th>
                        <th>Price</th>
                        <th style="width: 20px;">Action</th>
                    </tr>
                    `;
}

function rockAndRoll() {
    alert("rock and roll");
}

function dynamicEvent() {
  alert("dynamic event rocks");
}

testFunction();
</script>






            <div id="result-table" style="margin-left: 3em;">
                <table class="w3-table results-tbl" id="myTable">
                    <thead>
                        <tr class="primary">
                            <th colspan="5">
                                <div class="table-top">
                                    <div>
                                        <form action="<?= BASE_URL ?>donors/submit_search" method="post" style="display: inline;">
                                            <input type="text" name="search_string" placeholder="Search records..." >
                                            <button type="submit"><i class="fa fa-search"> Search</i></button>
                                        </form>
                                    </div>
                                    <div>Records Per Page: 





<div class="w3-dropdown-click">
  <button onclick="myFunction()"><?= $limit_pref ?></button>
  <div id="per-page-options" class="w3-dropdown-content w3-bar-block w3-border" style="right:0">
    <a href="#" class="w3-bar-item w3-button" onClick="sayPerPageLimit(10)">10</a>
    <a href="#" class="w3-bar-item w3-button" onClick="sayPerPageLimit(20)">20</a>
    <a href="#" class="w3-bar-item w3-button" onClick="sayPerPageLimit(50)">50</a>
    <a href="#" class="w3-bar-item w3-button" onClick="sayPerPageLimit(100)">100</a>
  </div>
</div>











<?php
/* 



*/
?>

                                    </div>
                                </div>
                            </th>
                        </tr>

                        <tr class="secondary">
                            <th>First Name</th>
                            <th>Email</th>
                            <th>Introduction</th>
                            <th>Price</th>
                            <th style="width: 20px;">Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>


        

        <div id="records"><div class="loadersmall"></div></div>



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

                .loadersmall {
                    border: 5px solid #f3f3f3;
                    -webkit-animation: spin 1s linear infinite;
                    animation: spin 1s linear infinite;
                    border-top: 5px solid #555;
                    border-radius: 50%;
                    width: 50px;
                    height: 50px;
                    margin: 5em auto;
                }

                @keyframes spin {
                  0% { transform: rotate(0deg); }
                  100% { transform: rotate(360deg); }
                }

            </style>







































    
<script>
var token = '<?= $token ?>';
var orderBy = '<?= $order_by ?>';
var limit = '<?= $limit ?>';
var offset = '<?= $offset ?>';

function fetchRecords() {

    var target_url = '<?= BASE_URL ?>api/get/donors/?orderBy=first*!underscore!*name&limit=' + limit + '&offset=' + offset;

    const http = new XMLHttpRequest()
    http.open('GET', target_url)
    http.setRequestHeader('Content-type', 'application/json')
    http.setRequestHeader("trongateToken", token)
    http.send()
    http.onload = function() {
        var records = JSON.parse(http.responseText);
        document.getElementById("result-table").style.marginLeft = '0em';
        document.getElementById("records").innerHTML = 'finished';
        // var resultsTable = document.getElementById("result-table").innerHTML;
        // document.getElementById("records").innerHTML = resultsTable;

        // var newData = '';

        // for (var i = 0; i < records.length; i++) {

        //     var recordUrl = '<?= BASE_URL ?>donors/edit/' + records[i]['id'];
        //     var editBtn = '<a href="' + recordUrl + '"><button type="button" class="btn btn-xs">View</button></a>';

        //     var newRow = '<tbody><tr><td>' + records[i]['first_name'] + '</td><td>' + records[i]['email'] + ' </td><td>' + records[i]['introduction'] + '</td><td>' + records[i]['price'] + '</td><td>' + editBtn + '</td></tr></tbody>'; 
        //     newData = newData.concat(newRow);
        //     records[i]
        // }


        // var newRow = '<tbody><tr><td>xxx hello</td><td>two</td><td>three</td><td>four</td></tr></tbody>'; 
        // var resultsContent = document.getElementById("records").innerHTML;
        // resultsContent = resultsContent.replace('<tbody></tbody>', newData);
        // document.getElementById("records").innerHTML = resultsContent;
        



        // document.getElementById('hello').addEventListener('click', function() {
        //     alert("you clicked the vibe");
        // });



    }

}

fetchRecords();
</script>


































































    </div>
</div>




<script>
// function myFunction() {
//   var x = document.getElementById("per-page-options");
//   if (x.className.indexOf("w3-show") == -1) {  
//     x.className += " w3-show";
//   } else { 
//     x.className = x.className.replace(" w3-show", "");
//   }
// }     

// function initPerPage() {
//   setTimeout(function(){ 
//     alert("Hello"); 
//         document.getElementById("per-page-options").addEventListener("click", function(){
//       alert("rock the click");
//     });
// }, 3000);
// }

// initPerPage();

// function myFunction() {

//     document.getElementById("per-page-options").addEventListener("click", function(){
//       alert("rock the click")
//     });

// }


                                       
                                        // function myFunction() {
                                        //   var x = document.getElementById("per-page-options");
                                        //   if (x.className.indexOf("w3-show") == -1) {  
                                        //     x.className += " w3-show";
                                        //   } else { 
                                        //     x.className = x.className.replace(" w3-show", "");
                                        //   }
                                        // }

                                        // // Get the dropdown btn
                                        // var x = document.getElementById("per-page-options");
                                        // var perPage = document.getElementById("per-page");

                                        // // When the user clicks anywhere outside of the dropdown btn, close it
                                        // window.onclick = function(event) {
                                        //   if (event.target !== perPage) {
                                        //     console.log(event.target);
                                        //     console.log('close');
                                        //     x.className = x.className.replace(" w3-show", "");
                                        //   }
                                        // }

                                        // function sayPerPageLimit(value) {
                                        //     var targetUrl = '<?= BASE_URL ?>donors/set_pref/' + value;
                                        //     window.location.href = targetUrl;
                                        // }







</script>




<script>
function myFunction() {
  var x = document.getElementById("per-page-options");
  if (x.className.indexOf("w3-show") == -1) {  
    x.className += " w3-show";
  } else { 
    x.className = x.className.replace(" w3-show", "");
  }
}
</script>