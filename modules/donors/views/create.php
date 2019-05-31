<h1><?= $headline ?></h1>
<?= validation_errors() ?>
<div class="w3-card-4">
    <div class="w3-container primary">
        <h4>Donor Details</h4>
    </div>
    <form class="w3-container" action="<?= $form_location ?>" method="post">
        <p>
            <label class="w3-text-dark-grey"><b>First Name</b> <span class="w3-text-green">(optional)</span></label>
            <input type="text" name="first_name" value="<?= $first_name ?>" class="w3-input w3-border w3-sand" placeholder="Enter First Name">
        </p>
        <p>
            <label class="w3-text-dark-grey"><b>Email</b></label>
            <input type="email" name="email" value="<?= $email ?>" class="w3-input w3-border w3-sand" placeholder="Enter Email">
        </p>
        <p>
            <label class="w3-text-grey">Introduction</label>
            <textarea name="introduction" class="w3-input w3-border w3-sand" placeholder="Enter introduction here..." ><?= $introduction ?></textarea>
        </p>
        <p>
            <label class="w3-text-dark-grey"><b>Price</b></label>
            <input type="text" name="price" value="<?= $price ?>" class="w3-input w3-border w3-sand" placeholder="Enter Price">
        </p>

                <fieldset class="form-group">
                    <label>Next Appointment </label><br>

                    <div style="padding: 0px;" class="input-group date form_datetime col-md-5" data-date="2019-04-13T01:02:04Z" data-date-format="dd MM yyyy - HH:ii p" data-link-field="dtp_input1">
                        <input class="form-control" name="next_appointment" value="<?= $next_appointment ?>" size="16" type="text" readonly>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                    </div>
                </fieldset>
        
        <p>
            <label class="w3-text-dark-grey"><b>Date Range</b></label>
            <input type="text" name="date" value="<?= $price ?>" class="w3-input w3-border w3-sand" placeholder="Enter Price">
        </p>

                <p>
                    <label>Date of Birth <span style="color: green;">(optional)</span></label>
                    <input type="text" name="date_of_birth" value="<?= $date_of_birth ?>" autocomplete="off" class="w3-input w3-border w3-sand"  id="datepicker-date_of_birth" placeholder="Select Date of Birth">
                </p>


        <p>
            <label class="w3-text-dark-grey"><b>Date</b></label>
            <input type="text" name="date" value="<?= $price ?>" class="w3-input w3-border w3-sand" placeholder="Enter Price">
        </p>
        <p> 
            <?php 
            $attributes['class'] = 'w3-button w3-white w3-border';
            echo anchor($cancel_url, 'CANCEL', $attributes);
            ?> 
            <button type="submit" name="submit" value="Submit" class="w3-button w3-medium primary"><?= $btn_text ?></button>
        </p>
        <?php 
        echo form_hidden('date_of_birth', time());
        echo form_hidden('next_appointment', time());
        echo form_hidden('active', 1);
        ?>
    </form>
</div>

<script type="text/javascript">
    $(function() {

        $('input[name="date"]').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });

        $('input[name="date"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        });

        $('input[name="date"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

    });
</script>



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

<script src="http://code.jquery.com/jquery-1.10.0.js"></script>
<script src="http://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
