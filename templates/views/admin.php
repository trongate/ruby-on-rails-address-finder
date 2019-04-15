<!DOCTYPE html>
<html lang="en">
<title>Admin Template</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-black.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
</head>
<body>

    <!-- Navbar -->
    <div class="w3-top">
        <div class="w3-bar w3-theme w3-top w3-left-align w3-large">
            <a class="w3-bar-item w3-button w3-right w3-hide-large w3-hover-white w3-large w3-theme-l1" href="javascript:void(0)" onclick="w3_open()"><i class="fa fa-bars"></i></a>
            <a href="#" class="w3-bar-item w3-button w3-theme-l1">Logo</a>
            <a href="#" class="w3-bar-item w3-button w3-hide-small w3-hover-white">About</a>
            <a href="#" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Values</a>
            <a href="#" class="w3-bar-item w3-button w3-hide-small w3-hover-white">News</a>
            <a href="#" class="w3-bar-item w3-button w3-hide-small w3-hover-white">Contact</a>
            <a href="#" class="w3-bar-item w3-button w3-hide-small w3-hide-medium w3-hover-white">Clients</a>
            <a href="#" class="w3-bar-item w3-button w3-hide-small w3-hide-medium w3-hover-white">Partners</a>
        </div>
    </div>

    <!-- Sidebar -->
    <nav class="w3-sidebar w3-bar-block w3-collapse w3-large w3-theme-l5 w3-animate-left" id="mySidebar">
        <a href="javascript:void(0)" onclick="w3_close()" class="w3-right w3-xlarge w3-padding-large w3-hover-black w3-hide-large" title="Close Menu">
            <i class="fa fa-remove"></i>
        </a>
        <h4 class="w3-bar-item"><b>Menu</b></h4>
        <a class="w3-bar-item w3-button w3-hover-black" href="#"><i class="fa fa-home"></i> Link</a>
        <a class="w3-bar-item w3-button w3-hover-black" href="<?= BASE_URL ?>donors/manage"><i class="fa fa-search"></i> Manage Donors</a>
        <a class="w3-bar-item w3-button w3-hover-black" href="#"><i class="fa fa-cloud"></i> Link</a>
        <a class="w3-bar-item w3-button w3-hover-black" href="#"><i class="fa fa-trash"></i> Link</a>
    </nav>

    <!-- Overlay effect when opening sidebar on small screens -->
    <div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

    <!-- Main content: shift it to the right by 250 pixels when the sidebar is visible -->
    <div class="w3-main" style="margin-left:250px">
        <div class="center-stage">

            <div class="w3-row w3-padding-64">
                <div class="w3-container">
                <?= Template::display($data) ?>
                </div>
            </div>

        </div>
        <?php Template::partial('admin_files/footer') ?>

        <!-- END MAIN -->
    </div>

    <style>
    html,body,h1,h2,h3,h4,h5,h6 {font-family: "Roboto", sans-serif;}
    .w3-sidebar {
      z-index: 3;
      width: 250px;
      top: 43px;
      bottom: 0;
      height: inherit;
    }

    .center-stage {
      min-height: 89vh;
    }
    </style>



<style>
    .w3-button, .w3-btn, .w3-hover-black {
        transition: 0.4s;
    }

    .w3-button.w3-small.primary:hover, .w3-button.w3-medium.primary:hover {
        background-color: #4ba787 !important;
        color: #fff !important;
    }

    .primary, .primary th {
        color: #fff;
        background-color: #51bf99;
        border: 1px #488a74 solid !important;
    }

    .secondary th {
      color: #fff;
      background-color: #4ba787;
      border: 1px #488a74 solid !important;
    }

    .w3-table {
        border-color: #488a74 !important;
        border: 1px #488a74 solid !important;
    }

    .w3-table td {
        border: 1px #ddd solid !important;
    }

    .edit-block-content {
        height: 50vh; 
        overflow: auto;
    }

    .edit-block-content > div {
        padding: 0.6em;
    }

    .w3-modal textarea {
        min-height: 12vh;
        resize: none;
    }

    .modal-btns {
        margin-top: 0;
    }

    .w3-modal header h4 {
        top: 2px;
        position: relative;
    }

.pagination {
  display: inline-block;
}

.pagination a {
  color: black;
  float: left;
  padding: 8px 16px;
  text-decoration: none;
  border: 1px solid #ddd;
}

.pagination a.active {
  background-color: #aaa;
  color: white;
  border: 1px solid #aaa;
}

.pagination a:hover:not(.active) {background-color: #ddd;}

.pagination a:first-child {
  border-top-left-radius: 5px;
  border-bottom-left-radius: 5px;
}

.pagination a:last-child {
  border-top-right-radius: 5px;
  border-bottom-right-radius: 5px;
}

.w3-button {
    text-transform: uppercase;
}


</style>

    <script>
        // Get the Sidebar
        var mySidebar = document.getElementById("mySidebar");

        // Get the DIV with overlay effect
        var overlayBg = document.getElementById("myOverlay");

        // Toggle between showing and hiding the sidebar, and add overlay effect
        function w3_open() {
            if (mySidebar.style.display === 'block') {
                mySidebar.style.display = 'none';
                overlayBg.style.display = "none";
            } else {
                mySidebar.style.display = 'block';
                overlayBg.style.display = "block";
            }
        }

        // Close the sidebar with the close button
        function w3_close() {
            mySidebar.style.display = "none";
            overlayBg.style.display = "none";
        }
    </script>

</body>

</html>