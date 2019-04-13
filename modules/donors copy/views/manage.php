<div class="row">
    <div class="col-md-12">
        <?= Modules::run('flash_helper/_get_flashdata') ?>
        <div class="panel">
            <div class="panel-heading" style="margin-top: 1px;">
                <div class="panel-body" style="padding-left: 0px;">
                    <?php
                    if ($headline == 'Search Results') { ?>
                        <a href="<?= $this_module_root ?>manage"><button type="button" class="btn btn-default">View All Donors</button></a><?php
                    }
                    ?>
                    <a href="<?= $this_module_root ?>create"><button type="button" class="btn btn-primary">Create New Donor</button></a> 
                </div>
            </div>

            <div class="panel-body">
                <?php
                if ($num_rows<1) {
                    echo "<p>There are currently no donors on the database.</p>";
                } else {
                    echo "<p>".$showing_statement.'</p>';
                    echo $pagination;
                }
                ?>

                <div class="table-primary">
                    <div class="table-header clearfix">
                        <div class="table-caption" style="color: black; display: inline;">
                            <form action="<?= $this_module_root ?>submit_search" method="post" style="display: inline;">
                                <input type="text" name="search_string" placeholder="Search donors..." class="input-sm">
                                <button type="submit" class="btn btn-default btn-sm"><i class="fa fa-search"> Search</i></button>
                            </form>
                        </div>

                        <div class="DT-lf-right">
                            <div class="DT-lf-right">
                                <div class="DT-per-page">
                                    <div class="dataTables_length" id="datatables_length">
                                        <form class="form-inline">
                                            <div class="form-group">
                                                <div class=btn-toolbar role=toolbar>
                                                    <div class=btn-group><span style="float: left;">Per page: </span>
                                                        <button style="margin-left: 4px; border-radius: 4px; background-color: #fff;" class="btn btn-default btn-xs dropdown-toggle" type=button data-toggle=dropdown aria-haspopup=true aria-expanded=false> <?= $limit_pref ?> </button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1" style="margin-left: 40px; min-width: 30px;">
                                                            <li><a href="#" onClick="sayPerPageLimit(10)">10</a></li>
                                                            <li><a href="#" onClick="sayPerPageLimit(20)">20</a></li>
                                                            <li><a href="#" onClick="sayPerPageLimit(50)">50</a></li>
                                                            <li><a href="#" onClick="sayPerPageLimit(100)">100</a></li>
                                                        </ul>

                                                        <script type="text/javascript">
                                                            function sayPerPageLimit(value) {
                                                                var targetUrl = '<?= base_url() ?>limit_pref/set_pref/' + value;
                                                                window.location.href = targetUrl;
                                                            }
                                                        </script>

                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <table class="table table-striped table-bordered" id="datatables">
                        <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Email</th>
                                <th>Date of Birth</th>
                                <th>Next Appointment</th>
                                <th>Active</th>
                                <th style="width: 80px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach($query->result() as $row) {
                        ?>
                            <tr>
                                <td><?= $row->first_name ?></td>
                                <td><?= $row->email ?></td>
                                <td><?= Modules::run('timedate/get_nice_date', $row->date_of_birth, 'cool') ?></td>
                                <td><?= Modules::run('timedate/get_nice_date', $row->next_appointment, 'full') ?></td>
                                <td><?php
                                if ($row->active == 1) {
                                    echo 'Yes';
                                } else {
                                    echo 'No';
                                }
                                ?>
                                </td>
                                <td class="center">
                                    <a href="<?= $this_module_root ?>view/<?= $row->id ?>"><button type="button" class="btn btn-xs" ng-click="viewRecordOnPage(row.id)">View</button></a>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                <?php
                if ($num_rows>0) {
                    echo $pagination;
                }
                ?>
            </div>
        </div>
    </div>
</div>