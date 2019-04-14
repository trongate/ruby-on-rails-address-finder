<div class="w3-row">
    <div class="w3-container">

        <h1><?= $headline ?></h1>
        <p><a href="<?= BASE_URL ?>donors/create"><button class="w3-button w3-medium primary"><i class="fa fa-pencil"></i>  CREATE NEW DONOR</button></a></p>
        <p><?= Pagination::display($data) ?></p>

        <table class="w3-table">
            <tr class="primary">
                <th colspan="4">
                    Search Donors ....per page dd
                </th>
            </tr>
            <tr class="secondary">
                <th>First Name</th>
                <th>Last Name</th>
                <th>Points</th>
                <th style="width: 20px;">Action</th>
            </tr>
            <?php
            unset($data['include_showing_statement']); //since not required for btm pagination
            $attributes['class'] = 'w3-button w3-small w3-button w3-white w3-border'; //styling for 'view' links
            foreach($donors as $donor) {
            ?>
            <tr>
                <td><?= $donor->first_name ?></td>
                <td><?= $donor->email ?></td>
                <td>Points</td>
                <td><?= anchor('donors/edit/'.$donor->id, '<i class="fa fa-eye"></i> VIEW', $attributes) ?></td>
            </tr>
            <?php
            }
            ?>
        </table>

        <p><?= Pagination::display($data) ?></p>

    </div>
</div>