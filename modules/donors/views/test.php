<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>

    <div id="pagination"></div>

    <div id="params"></div>

<script>




var a = ['','one ','two ','three ','four ', 'five ','six ','seven ','eight ','nine ','ten ','eleven ','twelve ','thirteen ','fourteen ','fifteen ','sixteen ','seventeen ','eighteen ','nineteen '];
var b = ['', '', 'twenty','thirty','forty','fifty', 'sixty','seventy','eighty','ninety'];


var htmlStr = '[';

function inWords (num) {
    if ((num = num.toString()).length > 9) return 'overflow';
    n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
    if (!n) return; var str = '';
    str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'crore ' : '';
    str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'lakh ' : '';
    str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'thousand ' : '';
    str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'hundred ' : '';
    str += (n[5] != 0) ? ((str != '') ? 'and ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) : '';
    return str;
}


for (var i = 1; i < 201; i++) {

    var first_name = inWords(i);
    
    var email = first_name.concat('@email.com');
    var introduction = 'Introduction for record ' + first_name;


    var rowData = `{"first_name": "` + first_name + `",

                    "email": "${email}", 

                    "introduction": "${introduction} " 
    },`;


console.log(rowData);

//     var rowData = `"first_name": the_first_name, 
//                    "email": "${email}", 
//                    "introduction": "${introduction}" 



//     `;

//     var theName = inWords(i);
//     rowData = rowData.replace("the_first_name", theName);

// console.log(`I think the first name is ${first_name}`);


htmlStr = htmlStr.concat(rowData);

   
}

htmlStr = htmlStr.concat(']');

htmlStr = htmlStr.replace('},]', '}]');

document.getElementById("params").innerHTML = htmlStr;






// document.getElementById('number').onkeyup = function () {
//     document.getElementById('words').innerHTML = inWords(document.getElementById('number').value);
// };






























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