<?= validation_errors("<p style='color: red;'>", "</p>") ?>
<div class="row">
    <div class="col-md-6">
        <?php
        if (isset($flash)) {
            echo $flash;
        }
        ?>
        <div class="panel">
            <div class="panel-heading">
                <div class="panel-title">Donor Details</div>
            </div>
            <form class="panel-body" action="<?= $form_location ?>" method="post">

                <fieldset class="form-group">
	        		<label>First Name</label>
	        		<input type="text" class="form-control" value="<?= $first_name ?>" name="first_name" placeholder="Enter First Name">
	    		</fieldset>

                <fieldset class="form-group">
	        		<label>Email</label>
	        		<input type="text" class="form-control" value="<?= $email ?>" name="email" placeholder="Enter Email">
	    		</fieldset>
                
				<fieldset class="form-group">
  					<label>Introduction</label>
    				<textarea name="introduction" placeholder="Enter introduction here..." id="grid-input-15" class="form-control"><?= $introduction ?></textarea>
                </fieldset>

                <fieldset class="form-group">
	        		<label>Price</label>
	        		<input type="text" class="form-control" value="<?= $price ?>" name="price" placeholder="Enter Price">
	    		</fieldset>

                <fieldset class="form-group">
					<label>Date of Birth <span style="color: green;">(optional)</span></label>
					<input type="text" name="date_of_birth" value="<?= $date_of_birth ?>" autocomplete="off" class="form-control" id="datepicker-date_of_birth" placeholder="Select Date of Birth">
				</fieldset>
                
                <fieldset class="form-group">
                    <label>Next Appointment </label><br>

                    <div style="padding: 0px;" class="input-group date form_datetime col-md-5" data-date="2019-04-13T01:02:04Z" data-date-format="dd MM yyyy - HH:ii p" data-link-field="dtp_input1">
                        <input class="form-control" name="next_appointment" value="<?= $next_appointment ?>" size="16" type="text" readonly>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                    </div>
                </fieldset>
                
				<fieldset class="form-group">
	          		<label>Active</label>
						<input name="active" value="1" type="checkbox"<?php

                        if ($active==1) {
                            echo " checked";
                        }

                        ?>>
	        	</fieldset>

                <fieldset class="form-group">
                    <button type="submit" name="submit" value="Submit" class="btn btn-primary">Submit</button> 
                    <a href="<?= $cancel_url ?>"><button type="button" class="btn btn-default">Cancel</button></a> 
                    <?php
                    if ($update_id>0) {
                    ?>
                    <span style="float: right; position: relative;"><!-- start of delete conf modal -->
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-danger">Delete</button> 

                        <div id="modal-danger" class="modal fade modal-alert modal-danger">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header"><i class="fa fa-warning"></i></div>
                                    <div class="modal-title">Confirm Delete</div>
                                    <div class="modal-body">You are about to delete a donor record.  This cannot be undone.<br>
                                        Do you really want to do this?</div>
                                    <div class="modal-footer">
                                        <button type="submit" name="submit" value="Delete" class="btn btn-danger">Yes - Delete it now!</button> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </span><!-- end of delete conf modal -->
                    <?php
                    }
                    ?>
                </fieldset>

            </form>
        </div>
    </div>
</div>

<script>

  window.onload = function() {

    $(function() {
      $('#datepicker-date_of_birth').datepicker({
        calendarWeeks:         true,
        todayBtn:              'linked',
        clearBtn:              true,
        todayHighlight:        true,
        multidate:             false,
        daysOfWeekHighlighted: '0,6',
        orientation:           'bottom right',
				format: 'dd/mm/yyyy'
      });

		});

  }
</script>