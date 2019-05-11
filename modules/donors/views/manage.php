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
        <div id="pagination"></div>
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
                                    <button id="perPage" onclick="togglePerPage()"></button>
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
var limit = '<?= $limit ?>';
var offset = '<?= $offset ?>';

function fetchRecords() {

    var searchValue = document.getElementById('searchTest').value;
    document.getElementById("results-tbl").tBodies[0].innerHTML = '';

    if (searchValue !== '') {

        var params = {
            'first_name LIKE':'%' + searchValue + '%',
            'OR email LIKE':'%' + searchValue + '%',
            orderBy: '<?= $order_by ?>',
            limit,
            offset
        }  


    } else {

        var params = {
            orderBy: '<?= $order_by ?>',
            limit,
            offset
        } 

    }

    console.log(JSON.stringify(params));
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
                                <td>&pound;${records[i]['price']}</td>
                                <td>${editBtn}</td>
                            </tr>`;

            newData = newData.concat(newRow);
        }

        newData = newData.concat('</tbody>');

        var resultsTable = document.getElementById("results-tbl").innerHTML;
        document.getElementById("results-tbl").innerHTML = resultsTable.replace('<tbody></tbody>', newData);
        document.getElementById("loader").style.display = 'none';
        document.getElementById("results-tbl").style.marginLeft = '0em';
        document.getElementById("perPage").innerHTML = limit;
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

function buildPagination() {

    var pagination = `

                    <div class="pagination">
                    <a onclick="switchPage(1)" href="#" class="active">1</a>
                    <a onclick="switchPage(2)" href="#">2</a>
                    <a onclick="switchPage(3)" href="#">3</a>
                    <a onclick="switchPage(4)" href="#">4</a>
                    <a onclick="switchPage(5)" href="#">5</a>
                    <a onclick="switchPage(6)" href="#">6</a>
                    <a onclick="switchPage(7)" href="#">»</a>
                    <a onclick="switchPage('last')" href="#">Last</a>
                    </div>

    `;


    document.getElementById("pagination").innerHTML = pagination;
}

var currentPage = 1;

function switchPage(pageNum) {

    var totalRows = '<?= $total_rows ?>';
    var recordNamePlural = '<?= $record_name_plural ?>';
    var maxPages = 10;

    //calculate number of pages
    var totalPages = Math.ceil(totalRows / limit);


    /*

        FIGURING OUT THE LINKS TO DRAW BEFORE AND AFTER THE CURRENT PAGE
        

    */












    console.log('we need ' + totalPages + ' pages');
    console.log('this is page ' + currentPage);
    // offset = pageNum;
    // fetchRecords();
}

buildPagination();
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