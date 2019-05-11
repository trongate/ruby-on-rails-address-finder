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
                                <input type="text" id="searchTest" placeholder="Search records..." >
                                <button onclick="fetchRecords()"><i class="fa fa-search"> Search</i></button>
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


<input type="text" id="searchTesxt" placeholder="Search records..." >
<button onclick="fetchRecords()">Try Again</button>

<script>
var token = '<?= $token ?>';
var searchPhrase = '';
var params = {};

function initParams() {
    params = {
        orderBy: '<?= $order_by ?>',
        limit: <?= $limit ?>,
        offset: <?= $offset ?>
    }
}

initParams();



function fetchRecords() {

    var searchValue = document.getElementById('searchTest').value;

    if (searchValue !== '') {

        document.getElementById("results-tbl").tBodies[0].innerHTML = '';

        var params = {
            'first_name LIKE':'%' + searchValue + '%',
            'OR email LIKE':'%' + searchValue + '%',
            orderBy: '<?= $order_by ?>',
            limit: <?= $limit ?>,
            offset: <?= $offset ?>
        }         
    } else {

        var params = {
            orderBy: '<?= $order_by ?>',
            limit: <?= $limit ?>,
            offset: <?= $offset ?>
        } 

    }

    console.log('search value is ' + searchValue);
    console.log(JSON.stringify(params));

    var target_url = '<?= BASE_URL ?>api/get/donors';
    console.log('submitting to ', target_url);

    const http = new XMLHttpRequest()
    http.open('POST', target_url)
    http.setRequestHeader('Content-type', 'application/json')
    http.setRequestHeader("trongateToken", token)
    http.send(JSON.stringify(params))
    http.onload = function() {

        console.log(http.responseText)

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


        console.log(document.getElementById("results-tbl").innerHTML);

        var resultsTable = document.getElementById("results-tbl").innerHTML;
        document.getElementById("results-tbl").innerHTML = resultsTable.replace('<tbody></tbody>', newData);
        document.getElementById("loader").style.display = 'none';
        document.getElementById("results-tbl").style.marginLeft = '0em';


    }

}



function fetchRecordsX() {

    console.log('<?= time() ?> -> running fetch records.  Here we go....');

    if (document.getElementById("search-string").value !== '') {
        // params['first_name LIKE'] = '%' + searchPhrase + '%';
        // params['OR email LIKE'] = '%' + searchPhrase + '%';

        var paramsAlt = {
            orderBy: '<?= $order_by ?>',
            limit: <?= $limit ?>,
            offset: <?= $offset ?>
        }

        console.log('hello');
    } else {
        console.log('no search vibes here');


        var paramsAlt = {
            orderBy: '<?= $order_by ?>',
            limit: <?= $limit ?>,
            offset: <?= $offset ?>
        }

    }

    var target_url = '<?= BASE_URL ?>api/get/donors';

    console.log('sending ' + JSON.stringify(paramsAlt));

    const http = new XMLHttpRequest()
    http.open('POST', target_url)
    http.setRequestHeader('Content-type', 'application/json')
    http.setRequestHeader("trongateToken", token)
    http.send(JSON.stringify(paramsAlt))
    http.onload = function() {




        // var records = JSON.parse(http.responseText);
        // var newData = '<tbody>';

        // for (var i = 0; i < records.length; i++) {
        //     records[i];
        //     var recordUrl = '<?= BASE_URL ?>donors/edit/' + records[i]['id'];
        //     var editBtn = '<a href="' + recordUrl + '"><button type="button" class="btn btn-xs">View</button></a>';
        //     var newRow = `  <tr>
        //                         <td>${records[i]['first_name']}</td>
        //                         <td>${records[i]['email']}</td>
        //                         <td>${records[i]['introduction']}</td>
        //                         <td>${records[i]['price']}</td>
        //                         <td>${editBtn}</td>
        //                     </tr>`;

        //     newData = newData.concat(newRow);
        // }

        // newData = newData.concat('</tbody>');


        var newData = '<tbody><tr><td colspan=5>' + http.responseText + '</td></tbody>';

        var resultsTable = document.getElementById("results-tbl").innerHTML;
        document.getElementById("results-tbl").innerHTML = resultsTable.replace('<tbody></tbody>', newData);
        document.getElementById("loader").style.display = 'none';
        document.getElementById("results-tbl").style.marginLeft = '0em';
    }
}

function submitSearch() {
    fetchRecords();
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
    params.limit = perPage;
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