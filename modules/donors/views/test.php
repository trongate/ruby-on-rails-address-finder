<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>

    <div id="pagination"></div>

<script>
var offset = 0;

function switchPage(pageNum) {

    var totalRows = '888';
    var recordNamePlural = 'donors';
    var maxLinks = 10;
    var limit = 10;
    var addFirst = true;
    var addLast = true;
    var addPrev = true;
    var addNext = true;

    //calculate number of pages
    var totalPages = Math.ceil(totalRows / limit);

    if (document.getElementById("pageNum").value == '') {
        currentPage = 1;
    } else {
        currentPage = document.getElementById("pageNum").value;
        currentPage = parseInt(currentPage);
    }

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

    for (var i = startPoint; i < endPoint; i++) {
        pagination.push(i);
    }

    if (addNext == true) {
        pagination.push("Next");
    }

    if (addLast == true) {
        pagination.push("Last");
    }

    console.log(pagination);

    document.getElementById("pagination").innerHTML = pagination;

}


    </script>

    <p>
        <input id="pageNum" type="text" name="">
        <button onclick="switchPage()">Switch Page</button> 
    </p>











</body>
</html>