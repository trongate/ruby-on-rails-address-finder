<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-body">
          	    <?php 
          	    if (isset($previous_url)) { ?>
      	        <p>
                    <a href="<?= $previous_url ?>"><button type="button" class="btn btn-default">Return To Previous Page</button></a>
                </p>
          	    <?php 
          	    }
          	    ?>
		            <p>Your search produced no results.</p>
	          </div>
	      </div>
    </div>
</div>