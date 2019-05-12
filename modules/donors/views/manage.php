<div class="w3-row">
    <div class="w3-container">
        <h1><?= $headline ?></h1>
        <?= flashdata() ?>

        <p>
            <a href="<?= BASE_URL ?>donors/create"><button class="w3-button w3-medium primary">
                <i class="fa fa-pencil"></i> CREATE NEW RECORD</button>
            </a>
        </p>
        <div id="loader" class="loadersmall"></div>
        <p id="showing-statement"></p>
        <div class="pagination" id="pagination"></div>
        <table class="w3-table results-tbl" id="results-tbl" style="margin-left: -2000em;">
            <thead>
                <tr class="primary">
                    <th colspan="5">
                        <div class="table-top">
                            <div>   
                                <input type="text" id="searchPhrase" placeholder="Search records..." >
                                <button onclick="submitSearch()"><i class="fa fa-search"> Search</i></button>
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
        <div class="pagination" id="pagination-btm"></div>
    </div>
</div>

<script>
var token = '<?= $token ?>';
var limit = 10; //FIXTHIS
var offset = 0;
var pageNum = 1;
var totalRows = <?= $total_rows ?>;
var recordNamePlural = '<?= $record_name_plural ?>';

function fetchRecords(pageNum) {
    buildPagination(pageNum);
    getRecords();
}

function submitSearch() {

    pageNum = 1;
    document.getElementById("loader").style.display = 'block';
    document.getElementById("results-tbl").style.marginLeft = '-2000em';
    document.getElementById("showing-statement").innerHTML = '';
    document.getElementById("pagination").innerHTML = '';
    document.getElementById("pagination-btm").innerHTML = '';

    //count the number of rows returned THEN get the results for this page
    totalRows = 88;

    fetchRecords(1);
}

function getRecords() {

    var searchValue = document.getElementById('searchPhrase').value;
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
        document.getElementById("perPage").innerHTML = limit;
    }
}

function buildPagination(pageNum) {

    if (pageNum == 1) {
        offset = 0;
    } else {
        offset = limit*(pageNum-1);
    }

    if (totalRows <= limit) {
        return;
    }

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

    if (endPoint>endPointLimit) {
        endPoint = endPointLimit;
    }

    for (var i = startPoint; i < endPoint; i++) {
        pagination.push(i);
    }

    if (addNext == true) {
        pagination.push("Next");
    }

    if (addLast == true) {
        pagination.push("Last");
    }

    drawPagination(pagination, pageNum, totalPages);

}

function drawPagination(pagination, pageNum, totalPages) {


    var paginationHtml = '';

    for (var i = 0; i < pagination.length; i++) {

        switch(pagination[i]) {
          case "First":
            linkLabel = 'First';
            linkValue = 1;
            break;
          case "Last":
            linkLabel = 'Last';
            linkValue = totalPages;
            break;
          case "Prev":
            linkLabel = '&laquo;';
            linkValue = pageNum-1;
            break;
          case "Next":
            linkLabel = '&raquo;';
            linkValue = pageNum+1;
            break;
          default:
            linkLabel = pagination[i];
            linkValue = pagination[i];
            break;
        }

        if (linkValue == pageNum) {
            paginationHtml = paginationHtml.concat('<a href="#" class="active" onclick="fetchRecords(' + linkValue + ')">' + linkLabel + '</a>');
        } else {
            paginationHtml = paginationHtml.concat('<a href="#" onclick="fetchRecords(' + linkValue + ')">' + linkLabel + '</a>');
        }

    }

    document.getElementById("pagination").innerHTML = paginationHtml;
    document.getElementById("pagination-btm").innerHTML = paginationHtml;
    addShowingStatement(limit, pageNum, totalRows, recordNamePlural);
}

fetchRecords(pageNum);

function addShowingStatement(limit, pageNum, totalRows, recordNamePlural) {
    
    var value1 = offset+1;
    var value2 = offset+limit;
    var value3 = totalRows;

    if (value2>value3) {
        value2 = value3;
    }

    showingStatement = `Showing ${value1} to ${value2} of ${value3} ${recordNamePlural}.`;
    document.getElementById("showing-statement").innerHTML = showingStatement;
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
    pageNum = 1;
    limit = perPage;
    fetchRecords(1);
}

//When the user clicks anywhere outside of the dropdown btn, close it
window.onclick = function(event) {
    if (event.target !== perPage) {
        var x = document.getElementById("per-page-options");
        x.className = x.className.replace(" w3-show", "");
    }
}

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

#pagination-btm, #showing-statement {
    margin-top: 2em;
}
</style>