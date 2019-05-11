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
        <div class="pagination" id="pagination"></div>
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
</script>


























<script>

function drawPagination(pagination, pageNum) {


    var paginationHtml = '';

    for (var i = 0; i < pagination.length; i++) {



        if (pagination[i] == pageNum) {
            paginationHtml = paginationHtml.concat('<a href="#" onclick="buildPagination(\'' + pagination[i] + '\')" class="active">' + pagination[i] + '</a>');
            console.log(`WE HAVE A MATCH since pagination i is ${pagination[i]} and pageNum is ${pageNum}`)            
        } else {
            paginationHtml = paginationHtml.concat('<a href="#" onclick="buildPagination(\'' + pagination[i] + '\')">' + pagination[i] + '</a>');

           // console.log(`no match since pagination i is ${pagination[i]} and pageNum is ${pageNum}`)
        }
    }

    document.getElementById("pagination").innerHTML = paginationHtml;
}

function buildPagination(num) {

    console.log('pagenum is ', pageNum);

    if(isNaN(pageNum)) {
        console.log('pageNum of ' + pageNum + ' is not a number!');
    }

    switch(pageNum) {
      case "First":
        pageNum = 1; //needs work!
        break;
      case "Last":
        pageNum = pageNum+1; //needs work!
        break;
      case "Prev":
        pageNum = pageNum-1; //needs work!
        break;
      case "Next":
        pageNum = 30; //needs work!
        break;
      default:
        pageNum = pageNum;
    }

console.log('assuming', pageNum);


    offset = pageNum;

    fetchRecords();

    var totalRows = '<?= $total_rows ?>';
    var recordNamePlural = '<?= $record_name_plural ?>';
    var maxLinks = 10;
    var addFirst = true;
    var addLast = true;
    var addPrev = true;
    var addNext = true;

    //calculate number of pages
    var totalPages = Math.ceil(totalRows / limit);
    var currentPage = pageNum;

    //figure out startPoint
    var startPoint = currentPage - (maxLinks - 1);

    if (startPoint < 1) {
        startPoint = 1;
    }

    var numBeforeLinks = currentPage - startPoint;

    //figure out endPoint
    var endPoint = currentPage + maxLinks;
    var numAfterLinks = endPoint - currentPage;

    if (endPoint > totalPages) {
        endPoint = totalPages + 1;
    }

    //modify number of before links
    var totalLinksRequired = numBeforeLinks + numAfterLinks;

    if (totalLinksRequired > maxLinks) {
        //too many links!

        //modify the startPoint
        startPoint = currentPage - Math.ceil(maxLinks / 2);

        if (startPoint < 1) {
            startPoint = 1;
        }

        //modify the endPoint
        endPoint = currentPage + Math.ceil(maxLinks / 2);

        if (endPoint > totalPages) {
            endPoint = totalPages + 1;
        }

    }

    if (endPoint - startPoint < maxLinks) {
        var numAfterLinks = endPoint - currentPage;
        endPoint = endPoint + Math.ceil(maxLinks / 2);
        if (endPoint > totalPages) {
            endPoint = totalPages + 1;
        }
    }

    if (currentPage < 2) {
        addPrev = false;
        addFirst = false;
    }

    if (currentPage >= totalPages) {
        addNext = false;
        addLast = false;
    }

    var pagination = [];

    if (addFirst == true) {
        pagination.push("First");
    }

    if (addPrev == true) {
        pagination.push("Prev");
    }

    var halfMax = Math.ceil(maxLinks);
    var endPointLimit = startPoint+halfMax;

    console.log('endPointLimit is ' + endPointLimit);

    if (endPoint>endPointLimit) {
        endPoint = endPointLimit;
    }

    console.log("ENDPOINT IS " + endPoint);

    for (var i = startPoint; i < endPoint; i++) {
        pagination.push(i);
    }

    if (addNext == true) {
        pagination.push("Next");
    }

    if (addLast == true) {
        pagination.push("Last");
    }

    drawPagination(pagination, pageNum);

}

var pageNum = 1;
buildPagination(1);
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