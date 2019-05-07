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
        <p> 
            <button type="submit" name="submit" value="Submit" class="w3-button w3-medium primary"><?= $btn_text ?></button>
            <?php 
            $attributes['class'] = 'w3-button w3-white w3-border';
            echo anchor($cancel_url, 'CANCEL', $attributes);
            ?> 
            
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