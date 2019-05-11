<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <script>

        var searchPhrase = 'yes';
        var params = {}

        function addSearchColumns() {
            params['this has spaces'] = '%' + searchPhrase + '%';
            params.id = searchPhrase;
            params.email = searchPhrase;
            params.date_of_birth = searchPhrase;
            params.city = searchPhrase;
            console.log(JSON.stringify(params));
        }

        function initParams() {

            params = {
                first_name : 'David',
                orderBy : 'first_name desc'
            }

            console.log(JSON.stringify(params));
        }

        initParams();

    </script>

    <p>
        <button onclick="addSearchColumns()">Add Search Columns</button> 
        <button onclick="initParams()">Remove Search Columns</button>
    </p>











</body>
</html>