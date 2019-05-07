<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary panel-dark">
            <div class="panel-heading">
                <div class="panel-title">Options</div>
            </div>
            <div class="panel-body">
                <?php
                if (isset($flash)) {
                  echo $flash;
                }
                ?>
                <a href="<?= base_url() ?>donors/manage"><button type="button" class="btn btn-default">View All Donors</button></a>
                <a href="<?= base_url() ?>donors/create/<?= $update_id ?>"><button type="button" class="btn btn-default">Update Details</button></a>

                <!-- Button to trigger delete modal -->
                <span style="text-align: right; float: right; position: relative;">
                    <form action="<?= $form_location ?>" method="post" style="display: inline-block;">
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-danger">Delete</button>&nbsp;&nbsp;

                        <div id="modal-danger" class="modal fade modal-alert modal-danger">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header"><i class="fa fa-warning"></i></div>
                                    <div class="modal-title">Confirm Delete</div>
                                    <div class="modal-body">You are about to delete a donor record.  This cannot be undone. <br>
                                        Do you really want to do this?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" name="submit" value="Delete" class="btn btn-danger">Yes - Delete it now!</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </span>

            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-primary panel-dark">
            <div class="panel-heading">
                <div class="panel-title">Donor Details</div>
            </div>
            <div class="panel-body standard-panel-height">
                <table class="info-table">
                    <tr>
                        <td><span>First Name</span></td>
                        <td><span><?= $first_name ?></span></td>
                    </tr>
                    <tr>
                        <td><span>Email</span></td>
                        <td><span><?= $email ?></span></td>
                    </tr>
                    <tr>
                        <td><span>Introduction</span></td>
                        <td><span><?= $introduction ?></span></td>
                    </tr>
                    <tr>
                        <td><span>Price</span></td>
                        <td><span><?= $price ?></span></td>
                    </tr>
                    <tr>
                        <td><span>Date of Birth</span></td>
                        <td><span><?= Modules::run('timedate/get_nice_date_from_datepicker', $date_of_birth, 'cool') ?></span></td>
                    </tr>
                    <tr>
                        <td><span>Next Appointment</span></td>
                        <td><span><?= $next_appointment ?></span></td>
                    </tr>
                    <tr>
                        <td><span>Active</span></td>
                        <td><span><?php
if ($active == 1) {
    echo 'Yes';
} else {
    echo 'No';
}
?>
</span></td>
                    </tr>
                </table>
            </div>
        </div>
    </div><!-- end of details-panel -->

    <div class="col-md-6"><!-- comments start -->
        <div class="panel panel-primary panel-dark">
            <div class="panel-heading">
                <div class="panel-title">Comments</div>
            </div>

            <?php
            $target_table = 'donors';
            $update_id = $this->uri->segment(3);
            $this->load->module('comments');
            $query_comments = $this->comments->_fetch_comments($target_table, $update_id);
            ?>

            <div class="panel-body standard-panel-height">
                <p style="text-align: center;">
                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-comment">Create New Comment</button>
                </p>
                <!-- Modal -->
                <div class="modal fade" id="modal-comment" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">×</button>
                                <h4 class="modal-title" id="myModalLabel">Create New Comment</h4>
                            </div>
                            <form class="panel-body" novalidate="novalidate" name="theForm" action="<?= base_url() ?>comments/submit" method="post">
                                <div class="modal-body">

                                    <textarea cols="70" rows="7" placeholder="Enter comment here..." id="comment" name="comment"></textarea>
                                    <?php
                                    echo form_hidden('target_table', $target_table);
                                    echo form_hidden('update_id', $update_id);
                                    ?>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" name="submit" value="Submit">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div><!-- end of modal -->

                <table class="table table-striped table-bordered" id="datatables">
                    <tbody>
                    <?php
                    foreach($query_comments->result() as $row_comments) { ?>
                        <tr>
                            <td>
                                <span class="small"><?php
                                    $date_posted = date('l jS \of F Y \a\t h:i:s A', $row_comments->date_posted);
                                    echo $date_posted; ?><br>
                                </span>
                                <span><?= nl2br($row_comments->comment) ?></span>
                            </td>
                        </tr>
                    <?php
                    }

                    $num_rows = $query_comments->num_rows();
                    if ($num_rows<1) {
                    ?>
                        <tr>
                            <td style="text-align: center;"><span class="small">No comments have been posted so far.</span><br></td>
                        </tr>
                    <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div><!-- comments end -->
</div>