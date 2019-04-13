<h1><?= $headline ?></h1>
<div class="w3-card-4">
    <div class="w3-container w3-dark-grey">
        <h4><i class="fa fa-calendar"></i> Booking Details</h4>
    </div>
    <form class="w3-container" action="/action_page.php">
        <p>
            <label class="w3-text-dark-grey"><b>First Name</b></label>
            <input class="w3-input w3-border w3-sand" name="first" type="text">
        </p>
        <p>
            <label class="w3-text-dark-grey"><b>Last Name</b></label>
            <input class="w3-input w3-border w3-sand" name="last" type="text">
        </p>
        <p>
            <label class="w3-text-grey">Subject</label>
            <textarea class="w3-input w3-border" style="resize:none;"></textarea>
        </p>
        <p>
            <input id="milk" class="w3-check" type="checkbox" checked="checked">
            <label>Milk</label>
        </p>

        <p>
            <label class="w3-text-dark-grey"><b>Last Name</b></label>
            <input class="w3-input w3-border w3-sand" type="text" name="date" value="" />
        </p>

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

        <p>
            <button class="w3-btn w3-dark-grey">Submit</button>
            <button class="w3-btn w3-white w3-border">Cancel</button>
        </p>
    </form>
</div>
    