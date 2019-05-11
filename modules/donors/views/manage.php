<div class="w3-row">
    <div class="w3-container">
        <h1><?= $headline ?></h1>
        <?= flashdata() ?>
        <p>
            <a href="<?= BASE_URL ?>donors/create"><button class="w3-button w3-medium primary">
                <i class="fa fa-pencil"></i> CREATE NEW DONOR RECORD</button>
            </a>
        </p>
        <div id="loader" class="loadersmall"></div>
        <table class="w3-table results-tbl" id="results-tbl" style="margin-left: -2000em;">
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
                                    <button id="perPage" onclick="togglePerPage()"><?= $limit_pref ?></button>
                                    <div id="per-page-options" class="w3-dropdown-content w3-bar-block w3-border" style="right:0">
                                        <a href="#" class="w3-bar-item w3-button" onClick="setPerPage(10)">10</a>
                                        <a href="#" class="w3-bar-item w3-button" onClick="setPerPage(20)">20</a>
                                        <a href="#" class="w3-bar-item w3-button" onClick="setPerPage(50)">50</a>
                                        <a href="#" class="w3-bar-item w3-button" onClick="setPerPage(100)">100</a>
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
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<script>
var token = '<?= $token ?>';
var orderBy = '<?= $order_by ?>';
var limit = '<?= $limit ?>';
var offset = '<?= $offset ?>';

var searchPhrase = '';
var params = {}

function addSearchColumns() {
    params.id = searchPhrase;
    params.email = searchPhrase;
    params.date_of_birth = searchPhrase;
    params.city = searchPhrase;
    console.log(JSON.stringify(params));
}

function initParams() {

    params = {
        first_name : 'David',
        orderBy : 'first_name desc',
        limit: 1
    }

    console.log(JSON.stringify(params));
}

initParams();









function fetchRecords() {

    var target_url = '<?= BASE_URL ?>api/get/donors';

    const http = new XMLHttpRequest()
    http.open('POST', target_url)
    http.setRequestHeader('Content-type', 'application/json')
    http.setRequestHeader("trongateToken", token)
    http.send(JSON.stringify(params))
    http.onload = function() {

        


        var records = JSON.parse(http.responseText);
        var newData = '<tbody>';

        for (var i = 0; i < records.length; i++) {
            records[i];
            var recordUrl = '<?= BASE_URL ?>donors/edit/' + records[i]['id'];
            var editBtn = '<a href="' + recordUrl + '"><button type="button" class="btn btn-xs">View</button></a>';
            var newRow = `  <tr>
                                <td>${records[i]['first_name']}</td>
                                <td>${records[i]['email']}</td>
                                <td>${records[i]['introduction']}</td>
                                <td>${records[i]['price']}</td>
                                <td>${editBtn}</td>
                            </tr>`;

            newData = newData.concat(newRow);
        }

        newData = newData.concat('</tbody>');

        var resultsTable = document.getElementById("results-tbl").innerHTML;
        document.getElementById("results-tbl").innerHTML = resultsTable.replace('<tbody></tbody>', newData);
        document.getElementById("loader").style.display = 'none';
        document.getElementById("results-tbl").style.marginLeft = '0em';
    }
}

function togglePerPage() {
    var x = document.getElementById("per-page-options");
    if (x.className.indexOf("w3-show") == -1) {  
        x.className += " w3-show";
    } else { 
        x.className = x.className.replace(" w3-show", "");
    }
}

function setPerPage(perPage) {
    document.getElementById("results-tbl").tBodies[0].innerHTML = '';
    limit = perPage;
    fetchRecords();
}

//When the user clicks anywhere outside of the dropdown btn, close it
window.onclick = function(event) {
    if (event.target !== perPage) {
        var x = document.getElementById("per-page-options");
        x.className = x.className.replace(" w3-show", "");
    }
}

fetchRecords();
</script>



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