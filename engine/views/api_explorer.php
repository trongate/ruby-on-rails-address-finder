<!DOCTYPE html>
<html lang="en">
<head>

  <!-- Basic Page Needs
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta charset="utf-8">
  <title>API Explorer</title>
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- Mobile Specific Metas
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- FONT
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">

  <!-- CSS
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="api_module/css/normalize.css">
  <link rel="stylesheet" href="api_module/css/skeleton.css">
  <link rel="stylesheet" href="api_module/css/api.css">

  <!-- Favicon
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->

</head>
<body>

  <!-- Primary Page Layout
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->

<div class="top-row w3-row">
    <div class="container" id="top-block">
        <div class="w3-col s5 w3-center logo">Trongate API - Explorer
<div id="show-golden-token"></div>
<div id="show-current-token"></div>
        </div>
        <div class="w3-col s2 w3-center trhs"><p id="token-status">Token Not Set!</p></div>
        <div class="w3-col s3 w3-center trhs"><p>
            <input id="input-token" class="w3-input w3-border" type="text" placeholder="Enter Authorization Token">
        </p></div>
        <div class="w3-col s2 w3-center trhs"><p>
            <button onclick="setToken()" class="w3-button button-primary default">Set Token</button>
        </p></div>
    </div>
</div>

<script>

function clearParams() {
    //isChecked = document.getElementById('bypass').checked;
    alert("hello");
}

function clearContent()
{
    document.getElementById("params").value='';

    setTimeout(function(){
      document.getElementById("clearParams").checked = false;
    }, 600);
}

var golden_token = '<?= $golden_token ?>';
var token = '';


function setToken() {
    token = document.getElementById('input-token').value;
    document.getElementById('token-value').innerHTML = token;

    if (token == '') {
        document.getElementById('token-status').innerHTML = 'Token Not Set!';    
    } else {
        document.getElementById('token-status').innerHTML = 'Token is set.';
    }   

}







</script>



<style>

.default:hover {
    background: #22abd6 !important;
    color: white !important;
}

.trhs {
    top: 0.8em;
    position: relative;
}

.logo {
    font-size: 1.6em;
    margin: 0 !important;
    padding: 0 !important;
    font-weight: bold;
}


.top-row {
    background: #50459b;
    color: #eee;
    min-height: 5em;
    line-height: 5em;
}

.top-row .w3-button {
    width: 96%;
}

.top-row > .container {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
}


</style>





<style>

.w3-quarter {
    min-height: 6em;
    background: orange;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.button.button-primary, 
button.button-primary, 
input[type="submit"].button-primary, 
input[type="reset"].button-primary, 
input[type="button"].button-primary {
    padding: 0em 1em;
    min-width: 94px;
    font-size: 0.9em;
    margin: 0;
    padding: 0;
}

.purple {
    background-color: #BB9FE0 !important;
    border: 1px #BB9FE0 solid !important;
}

.purple:hover {
    background-color: #a791c4 !important;
    border: 1px #a791c4 solid !important;
}

.deep-purple {
    background-color: #470B59 !important;
    border: 1px #470B59 solid !important;
}

.deep-purple:hover {
    background-color: #3b0a49 !important;
    border: 1px #3b0a49 solid !important;
}

.green {
    background-color: #0285A1 !important;
    border: 1px #0285A1 solid !important;
}

.green:hover {
    background-color: #02738c !important;
    border: 1px #02738c solid !important;
}

.red {
    background-color: #a11e02 !important;
    border: 1px #a11e02 solid !important;
}

.red:hover {
    background-color: #6f1501 !important;
    border: 1px #6f1501 solid !important;
}

td {
    padding: 8px;
    vertical-align: center !important;
}

.star {
    font-size: 1.4em;
}

.generate-btn {
    min-width: 180px !important;
    margin-left: 1em !important;
}

.white-btn {
    background-color: #fff !important;
}

.alt-font {
    font-family: "Lucida Console", Monaco, monospace;
}

.w3-display-topright {
    font-size: 2em;
    padding: 0 0.6em;
}

</style>

<div>
    <div class="container" id="stage" style="margin-top: 5em;">
        <div class="row">
            <div>
                <h4>donors</h4>
                <table class="u-full-width" style="font-size: 1.4em;">
                  <thead>
                    <tr>
                      <th class="go-left">Request Type</th>
                      <th class="go-left">Endpoint Name</th>
                      <th class="go-left">URL segments</th>
                      <th class="go-right">Description</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach($endpoints as $endpoint_name => $endpoint) {
                        $endpoint_json = json_encode($endpoint);

                        switch($endpoint['request_type']) {
                          case 'GET':
                            $btn_theme = 'green';
                            break;
                          case 'POST':
                            $btn_theme = 'purple';
                            break;
                          case 'PUT':
                            $btn_theme = 'deep-purple';
                            break;
                          case 'DELETE':
                            $btn_theme = 'red';
                            break;
                          default:
                            $btn_theme = 'green';
                            break;
                        }

                        $endpoint_data = json_encode($endpoint);
                        $ditch = '"';
                        $replace = '&quot;';
                        $endpoint_data = str_replace($ditch, $replace, $endpoint_data);

                        $ditch = '}';
                        $replace = '<span class="alt-font">}</span>';
                        $endpoint['url_segments'] = str_replace($ditch, $replace, $endpoint['url_segments']);
                        $ditch = '{';
                        $replace = '<span class="alt-font">{</span>';
                        $endpoint['url_segments'] = str_replace($ditch, $replace, $endpoint['url_segments']);
                    ?>
                    <tr>
                      <td style="font-size: 0.8em;"><input onclick="openModal('<?= $endpoint_name ?>', '<?= $endpoint_data ?>')" type="submit" value="<?= $endpoint['request_type'] ?>" class="button-primary <?= $btn_theme ?>"></td>
                      <td><?= $endpoint_name ?></td>
                      <td><?= $endpoint['url_segments'] ?></td>
                      <td class="go-right"><?= $endpoint['description'] ?></td>
                    </tr>
                    <?php 
                    } 
                    ?>
                  </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="id01" class="w3-modal">
    <div class="w3-modal-content w3-animate-zoom w3-card-4">
        <header id="modal-header" class="w3-container theme-b white-text">
            <span onclick="document.getElementById('id01').style.display='none'" class="w3-button w3-display-topright">&times;</span>
            <h2 id="endpointName"></h2>
        </header>
        <div id="modal-content" class="w3-container modal-content-get">
            <h4 style="margin-top: 0.4em;">Test Your API Endpoint</h4>

            <form>
                <div class="row">
                    <div class="six columns">
                        <div class="twelve columns">
                            <div id="extra-required-fields"></div>
                            <label for="exampleMessage">Parameters</label>
                            <textarea onkeydown="if(event.keyCode===9){var v=this.value,s=this.selectionStart,e=this.selectionEnd;this.value=v.substring(0, s)+'   '+v.substring(e);this.selectionStart=this.selectionEnd=s+3;return false;}" class="u-full-width" placeholder="Enter parameters in JSON format" id="params"></textarea>
                             
                                <div class="w3-row">
                                  <div class="w3-col s6">
                                    Bypass authorization <input onclick="initBypassAuth()" type="checkbox" id="bypass" value="1">
                                  </div>
                                  <div class="w3-col s6 w3-center" id="clearParamsBox">
                                    Clear Parameters <input onclick="clearContent()" type="checkbox" id="clearParams" value="1">
                                  </div>
                                </div>

                            <input onclick="submitRequest()" class="button-primary" type="button" value="Submit"> 
                            
                        </div>
                    </div>
                    <div class="six columns">
                        <label for="exampleMessage">Server Response <span id="http-status-code"></span></label>
                        <textarea disabled class="u-full-width server-response" id="serverResponse"></textarea>
                        <label class="example-send-yourself-copy">
                            <input onclick="displayHeaders()" type="checkbox" id="display-headers-checkbox" value="1">
                            <span class="label-body">Display Response Header Values</span>
                        </label>

                        <p id="header-info"></p>
                        <p class="go-right">
                            <input onclick="viewSettings()" class="button-default white-btn go-right" style="float-right; position: relative;" type="button" value="View Settings">
                            <input onclick="copyText()" class="button-default white-btn go-right" style="float-right; position: relative;" type="button" value="Copy Response BODY">
                        </p>

                        

                        
                    </div>
                </div>
            </form>

            <p style="font-size: 0.9em;"><b>URL Segments:</b> /<span id="endpointUrl"></span>
                <br>
                <b>Required HTTP Request Type: </b> <span id="requestType"></span>
                <br>
                <b>Endpoing Settings: </b>
                <?= $endpoint_settings_location ?><br>
                <b>Your Current Token: </b><span id="token-value"></span>
            </p>

        </div>
        <footer id="modal-footer">
            <p style="text-align: center;">For full documentation and tutorials visit <a href="https://trongate.io/" target="_blank">Trongate.io</a></p>
        </footer>
    </div>
</div>

<script>
var requestType = 'GET';
var url_segments;
var endpoint;
var extraFieldsHtml = '';
var extraRequiredFields = [];

//setTimeout(expiredGoldenToken, 2000);

function expiredGoldenToken() {
    document.getElementById("stage").innerHTML = '';
    var altConent = '<h4 style="text-align:center;">Login Expired</h4>';
    altConent = altConent.concat('<p style="text-align:center;">Your session has expired.  Please login again.</p>');

    document.getElementById("stage").innerHTML = altConent;
    document.getElementById("top-block").innerHTML = '<div class="w3-col s5 w3-center logo">Trongate API - Explorer</div>';
    document.getElementById("top-block").style.minHeight = '6.66em';
    document.getElementById("id01").style.display = 'none';
}

var isObj = function(a) {
  if ((!!a) && (a.constructor === Object)) {
    return true;
  }
  return false;
};
var _st = function(z, g) {
  return "" + (g != "" ? "[" : "") + z + (g != "" ? "]" : "");
};
var fromObject = function(params, skipobjects, prefix) {
  if (skipobjects === void 0) {
    skipobjects = false;
  }
  if (prefix === void 0) {
    prefix = "";
  }
  var result = "";
  if (typeof(params) != "object") {
    return prefix + "=" + encodeURIComponent(params) + "&";
  }
  for (var param in params) {
    var c = "" + prefix + _st(param, prefix);
    if (isObj(params[param]) && !skipobjects) {
      result += fromObject(params[param], false, "" + c);
    } else if (Array.isArray(params[param]) && !skipobjects) {
      params[param].forEach(function(item, ind) {
        result += fromObject(item, false, c + "[" + ind + "]");
      });
    } else {
      result += c + "=" + encodeURIComponent(params[param]) + "&";
    }
  }

  result = result.slice(0, -1); 
  return result;
};

function replacePlaceholders(targetUrl) {

    for (var i = 0; i < extraRequiredFields.length; i++) {
        var targetId = 'extra-required-field-' + extraRequiredFields[i].name;
        var fieldValue = document.getElementById(targetId).value;

        fieldValue = fieldValue.replace(/ /g, '');
        if (fieldValue == '') {
            alert("You did not enter a value for " + extraRequiredFields[i].name);
            document.getElementById(targetId).value = '';
            return false;
        } else {
            var ditch = '{' + extraRequiredFields[i].name + '}';
            var replace = fieldValue;
            targetUrl = targetUrl.replace(ditch, replace);
            console.log(targetUrl);
        }

    }

    return targetUrl;
}


var HTTP_STATUS_CODES = {
        'CODE_200' : 'OK',
        'CODE_201' : 'Created',
        'CODE_202' : 'Accepted',
        'CODE_203' : 'Non-Authoritative Information',
        'CODE_204' : 'No Content',
        'CODE_205' : 'Reset Content',
        'CODE_206' : 'Partial Content',
        'CODE_300' : 'Multiple Choices',
        'CODE_301' : 'Moved Permanently',
        'CODE_302' : 'Found',
        'CODE_303' : 'See Other',
        'CODE_304' : 'Not Modified',
        'CODE_305' : 'Use Proxy',
        'CODE_307' : 'Temporary Redirect',
        'CODE_400' : 'Bad Request',
        'CODE_401' : 'Unauthorized',
        'CODE_402' : 'Payment Required',
        'CODE_403' : 'Forbidden',
        'CODE_404' : 'Not Found',
        'CODE_405' : 'Method Not Allowed',
        'CODE_406' : 'Not Acceptable',
        'CODE_407' : 'Proxy Authentication Required',
        'CODE_408' : 'Request Timeout',
        'CODE_409' : 'Conflict',
        'CODE_410' : 'Gone',
        'CODE_411' : 'Length Required',
        'CODE_412' : 'Precondition Failed',
        'CODE_413' : 'Request Entity Too Large',
        'CODE_414' : 'Request-URI Too Long',
        'CODE_415' : 'Unsupported Media Type',
        'CODE_416' : 'Requested Range Not Satisfiable',
        'CODE_422' : 'Unprocessable Entity',
        'CODE_417' : 'Expectation Failed',
        'CODE_500' : 'Internal Server Error',
        'CODE_501' : 'Not Implemented',
        'CODE_502' : 'Bad Gateway',
        'CODE_503' : 'Service Unavailable',
        'CODE_504' : 'Gateway Timeout',
        'CODE_505' : 'HTTP Version Not Supported'
    };

function submitRequest() {
    var params = document.getElementById('params').value;
    document.getElementById('endpointUrl').innerHTML = initialSegments;

    setTimeout(function(){
      document.getElementById("bypass").checked = false;

      if (token == golden_token) {
        token = '';
      }

    }, 600);

    var targetUrl = '<?= BASE_URL ?>' + document.getElementById('endpointUrl').innerHTML;

    if (params != '') {
        isValidJson = myfunction(params);

        if (isValidJson == false) {
            alert("Invalid JSON");
            return;
        }
    }

    if ((requestType == 'GET') && (params != '')) { //

        params = params.replace(/>/g, '*!gt!*');
        params = params.replace(/</g, '*!lt!*');
        params = params.replace(/=/g, '*!equalto!*');
        params = params.replace(/_/g, '*!underscore!*');
        
        params = JSON.parse(params);
        var extraUrlSegment = '/?' + fromObject(params);
        extraUrlSegment=extraUrlSegment.replace(/ /gi,'%20');
        targetUrl = targetUrl.concat(extraUrlSegment);
    }

    targetUrl = targetUrl.replace(/<(.|\n)*?>/g, '');
    targetUrl = replacePlaceholders(targetUrl);

    if (targetUrl == false) {
        return; //user left out a required field, so end this
    }

    const http = new XMLHttpRequest()
    http.open(requestType, targetUrl)
    http.setRequestHeader('Content-type', 'application/json')
    http.setRequestHeader('trongateToken', token)
    http.send(params)
    http.onload = function() {
        document.getElementById('endpointUrl').innerHTML = targetUrl.replace('<?= BASE_URL ?>', '');
        responseHeaders = http.getAllResponseHeaders();
        responseHeaders = responseHeaders.replace(/(?:\r\n|\r|\n)/g, '<br>');
        headerInfo = '<p style="font-weight: bold;">HTTP Header Values </p><span style="font-size: 0.8em;">' + responseHeaders + '</span>';

        var showHeaders = document.getElementById('display-headers-checkbox').checked;

        if (showHeaders == true) {
            document.getElementById("header-info").innerHTML = headerInfo;        
        }

        if (http.status == 200) {
            document.getElementById("http-status-code").style.color = "green";
        } else {
            document.getElementById("http-status-code").style.color = "purple";
        }

        document.getElementById("http-status-code").innerHTML = http.status + ' ' + HTTP_STATUS_CODES['CODE_' + http.status];
        document.getElementById("serverResponse").disabled = false;
        document.getElementById('serverResponse').value = http.responseText;
    }

}

function drawRequiredFields(required_fields) {
    extraFieldsHtml = '';
    for (var i = 0; i < required_fields.length; i++) {
        var fieldName = required_fields[i]['name'];
        var fieldLabel = required_fields[i]['label'];
        extraFieldsHtml = extraFieldsHtml.concat('<label for="text_field">' + fieldLabel + '</label>');
        extraFieldsHtml = extraFieldsHtml.concat('<input type="text" name="' + fieldName + '" id="extra-required-field-' + fieldName + '" class="u-full-width" placeholder="Enter ' + fieldLabel + ' here">');

        var extraField = {
            "name": fieldName,
            "label": fieldLabel
        }

        extraRequiredFields.push(extraField);

    }

    document.getElementById("extra-required-fields").innerHTML = extraFieldsHtml;
}

var endpoint_settings = '';
var initialSegments = '';

function openModal(endpointName, endpoint_json) {

    document.getElementById("serverResponse").value = '';
    document.getElementById("http-status-code").innerHTML = '';
    document.getElementById("header-info").innerHTML = '';
    document.getElementById("extra-required-fields").innerHTML = '';
    document.getElementById("bypass").checked = false;
    extraRequiredFields = [];
    
    endpoint_data = JSON.parse(endpoint_json);
    endpoint_settings = endpoint_json;


    if (endpoint_data.enableParams == true) {
        document.getElementById("params").disabled = false;
        document.getElementById("params").style.backgroundColor = '#fff';
        document.getElementById("params").style.minHeight = '200px';
        document.getElementById("clearParamsBox").style.display = 'inline';
    } else {
        document.getElementById("params").value = '';
        document.getElementById("params").disabled = true;
        document.getElementById("params").style.backgroundColor = '#ddd';
        document.getElementById("params").style.minHeight = '118px';
        document.getElementById("clearParamsBox").style.display = 'none';
    }

    if (endpoint_data.required_fields) {
        setTimeout(drawRequiredFields, 100, endpoint_data.required_fields);
    }

    console.log(endpointName);
    console.log(endpoint_data);
    console.log(endpoint_settings);
    
    url_segments = endpoint_data.url_segments.replace(/{/g, "<span class=\"alt-font\">{</span>");
    url_segments = url_segments.replace(/}/g, "<span class=\"alt-font\">}</span>");

    initialSegments = url_segments;

    requestType = endpoint_data.request_type;
    var description = endpoint_data.description;

    if (requestType == 'POST') {
        document.getElementById('modal-header').className = 'w3-container theme-a white-text';
        document.getElementById('modal-footer').className = 'w3-container theme-a white-text';
        document.getElementById('modal-content').className = 'w3-container modal-content';
    }

    if (requestType == 'GET') {
        document.getElementById('modal-header').className = 'w3-container theme-b white-text';
        document.getElementById('modal-footer').className = 'w3-container theme-b white-text';
        document.getElementById('modal-content').className = 'w3-container modal-content-get';
    }

    if (requestType == 'PUT') {
        document.getElementById('modal-header').className = 'w3-container theme-c white-text';
        document.getElementById('modal-footer').className = 'w3-container theme-c white-text';
        document.getElementById('modal-content').className = 'w3-container modal-content-put';
    }

    if (requestType == 'DELETE') {
        document.getElementById('modal-header').className = 'w3-container theme-d white-text';
        document.getElementById('modal-footer').className = 'w3-container theme-d white-text';
        document.getElementById('modal-content').className = 'w3-container modal-content-delete';
    }
    

    document.getElementById('id01').style.display='block';
    document.getElementById('endpointName').innerHTML = endpointName;
    document.getElementById('requestType').innerHTML = requestType;
    document.getElementById('endpointUrl').innerHTML = url_segments;
}

function viewSettings() {
    alert(endpoint_settings);
}



function copyText() {
  /* Get the text field */
  var copyText = document.getElementById("serverResponse");

  /* Select the text field */
  copyText.select();

  /* Copy the text inside the text field */
  document.execCommand("copy");

  /* Alert the copied text */
  alert("Copied the text: " + copyText.value);
}
    </script>




<style>

#http-status-code {
    color: green;
}

#header-info p {
    margin: 0;
}

footer a:link { color: white; }
footer a:active { color: white; }
footer a:visited { color: white; }
footer a:hover { color: white; }

textarea {
    min-height: 200px;
    font-family: "Lucida Console", Monaco, monospace;
}

.server-response {
    background: #fcfbe3;
}

.modal-content {
    background: #f3f2ff;
}

.modal-content-get {
    background: #eaf9fc;
}

.modal-content-put {
    background: #f7eff9;
}

.modal-content-delete {
    background: #fff;
}

.theme-a p, .theme-b p, .theme-c p, .theme-d p {
    padding: 1em 0;
    margin: 0;
}

.w3-modal h2 {
    padding: 0.2em 0em;
    margin: 0;
    font-size: 2em;
}

.theme-a {
    background-color: #50459b;
}

.theme-b {
    background-color: #0285A1;
}

.theme-c {
    background-color: #470B59;
}

.theme-d {
    background-color: #a11e02;
}

.white-text {
    color: #fff;
}
</style>



<script>
// Get the modal
var modal = document.getElementById('id01');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>










<script>
var headerInfo = '';


function initBypassAuth() {

    isChecked = document.getElementById('bypass').checked;
    
    if (isChecked == true) {

        token = golden_token;

        var expiry = new Date();
        expiry.setHours(expiry.getHours() + 4);
        expiryDate = Date.parse(expiry)/1000;

        const http = new XMLHttpRequest()
        http.open('POST', '<?= BASE_URL ?>trongate_tokens/regenerate/' + token + '/' + expiryDate);
        http.setRequestHeader('Content-type', 'application/json')
        http.send(JSON.stringify(params)) // Make sure to stringify
        http.onload = function() {
            //fetch new 'bypass' token

            if (http.responseText == 'false') {
                expiredGoldenToken();
            } else {

                token = http.responseText;
                golden_token = token;
                document.getElementById("input-token").value = token;
                document.getElementById("token-value").innerHTML = token;

            }

        }

    }

}

function displayHeaders() {
    isChecked = document.getElementById('display-headers-checkbox').checked;

    if (isChecked == true) {
        document.getElementById("header-info").innerHTML = headerInfo;
    } else {
        document.getElementById("header-info").innerHTML = "";
    }

}







    function myfunction(text){

       //function for validating json string
        function testJSON(text){
            try{
                if (typeof text!=="string"){
                    return false;
                }else{
                    JSON.parse(text);
                    return true;                            
                }
            }
            catch (error){
                return false;
            }
        }

        //content of your real function   
        if(testJSON(text)){
            return true;
        }else{
            return false; //not valid json
        }
    }

</script>

<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>
