<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <script>

        var searchPhrase = '';
        
        var params = [
            { first_name : 'David' }, 
            { orderBy : 'first_name desc' }
        ]

        var initParams = params;

        console.log(JSON.stringify(params));

        var searchColumns = [
            { id :searchPhrase }, 
            { email :searchPhrase }, 
            { date_joined : searchPhrase }
        ];

        function addSearchColumns() {
            if (params.length<3) {
                params = params.concat(searchColumns);
                console.log(JSON.stringify(params));                
            }
        }

        function removeSearchColumns() {
            params = initParams;
            console.log(JSON.stringify(params));
        }

    </script>

    <p>
        <button onclick="addSearchColumns()">Add Search Columns</button> 
        <button onclick="removeSearchColumns()">Remove Search Columns</button>
    </p>











</body>
</html>