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
    
    console.log('total pages required is ' + totalPages);

    if (document.getElementById("pageNum").value == '') {
        currentPage = 1;
    } else {
        currentPage = document.getElementById("pageNum").value;
        currentPage = parseInt(currentPage);
    }

console.log('it is ', currentPage);

    //figure out startPoint
    var startPoint = currentPage-(maxLinks-1);

    if (startPoint<1) {
        startPoint = 1;
    }

    console.log('start point is ' + startPoint);
    var numBeforeLinks = currentPage-startPoint;
    console.log('num before links required: ' + numBeforeLinks);

    //figure out endPoint
    var endPoint = currentPage+maxLinks;
    var numAfterLinks = endPoint-currentPage;
    console.log('num after links required: ' + numAfterLinks);

    if (endPoint>totalPages) {
        endPoint = totalPages+1;
    }

    console.log('end point is ' + endPoint);


    //modify number of before links
    var totalLinksRequired = numBeforeLinks + numAfterLinks;
    console.log('this page requires links: ', totalLinksRequired);


    if (totalLinksRequired > maxLinks) {
        //too many links!

        //modify the startPoint
        startPoint = currentPage - Math.ceil(maxLinks / 2);
        console.log('corrected startPoint is ' + startPoint);

        if (startPoint<1) {
            startPoint = 1;
        }

        //modify the endPoint
        endPoint = currentPage + Math.ceil(maxLinks / 2);

        if (endPoint>totalPages) {
            endPoint = totalPages+1;
        }

        console.log('corrected endPoint is ' + endPoint);
    } 

    if(endPoint-startPoint < maxLinks) {
        //do nothing yet
        console.log("NOT ENOUGH LINKS!");
        var numAfterLinks = endPoint-currentPage;
        console.log('num after links is  ', numAfterLinks);

        endPoint = endPoint + Math.ceil(maxLinks / 2);
        if (endPoint>totalPages) {
            endPoint = totalPages+1;
        }        
    }

    console.log('total required is ', totalLinksRequired);









    /*

        FIGURING OUT THE LINKS TO DRAW BEFORE AND AFTER THE CURRENT PAGE
    

    X L L L L L  <--- DUFFF!

    X L L L L L L L L L L <--- good!

    L L L L L L L L L L X <--- good!

    L L L L L X L L L L L <--- good!

    */

    if (currentPage<2) {
        addPrev = false;
        addFirst = false;
    }

    if (currentPage >= totalPages) {
        addNext = false;
        addLast = false;
    }








    var pagination = '';

    if (addFirst == true) {
        var linkText = '<b>First</b>';
        pagination = pagination.concat(linkText)
    }

    if (addPrev == true) {
        var linkText = '<b>Prev</b>';
        pagination = pagination.concat(linkText)
    }


    for (var i = startPoint; i < endPoint; i++) {





        if (i == currentPage) {
            var linkText = '<b>' + currentPage + '</b>';
        } else {
            var linkText = ' ' + i + ' ';
        }


        pagination = pagination.concat(linkText)
    }

    if (addNext == true) {
        var linkText = '<b>Next</b>';
        pagination = pagination.concat(linkText)
    }

    if (addLast == true) {
        var linkText = '<b>Last</b>';
        pagination = pagination.concat(linkText)
    }


    document.getElementById("pagination").innerHTML = pagination;




    //console.log(currentPage);
}

    </script>

    <p>
        <input id="pageNum" type="text" name="">
        <button onclick="switchPage()">Switch Page</button> 
    </p>











</body>
</html>