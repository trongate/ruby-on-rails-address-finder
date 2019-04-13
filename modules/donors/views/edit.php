<?php $cancel_url = ''; ?>
<div class="w3-row">
    <div class="w3-container">   
        <h1><?= $headline ?></h1>
        <div class="w3-card-4">
            <div class="w3-container primary">
                <h4>Options</h4>
            </div>

            <div class="w3-container">
            <p>
                <a href="<?= BASE_URL ?>donors/manage"><button class="w3-button w3-white w3-border">VIEW ALL DONORS</button></a> 
                <a href="<?= BASE_URL ?>donors/create/<?= $update_id ?>"><button class="w3-button w3-white w3-border">UPDATE DETAILS</button></a>
                <a href="<?= BASE_URL ?>donors/create/<?= $update_id ?>"><button class="w3-button w3-red w3-hover-black w3-border w3-right">DELETE</button></a> 
            </p>        
            </div>
        </div>
    </div>
</div>

<div class="w3-row">
    <div class="w3-third w3-container">    
        <div class="w3-card-4 edit-block" style="margin-top: 1em;">
            <div class="w3-container primary">
                <h4>Donor Details</h4>
            </div>

            <ul class="w3-ul">
              <li><b>First Name:</b> <span class="w3-right w3-text-grey">David Connelly</span></li>
              <li><b>Eve:</b> <span class="w3-right w3-text-grey">David Connelly</span></li>
              <li><b>Email:</b> <span class="w3-right w3-text-grey">David Connelly</span></li>
                <li><b>First Name:</b> <span class="w3-right w3-text-grey">David Connelly</span></li>
              <li><b>Eve:</b> <span class="w3-right w3-text-grey">David Connelly</span></li>
              <li><b>Email:</b> <span class="w3-right w3-text-grey">David Connelly</span></li>
              <li><b>Description:</b> <br><span class="w3-right w3-text-grey">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fuga omnis ipsa incidunt repellat eveniet, ipsum saepe dolore, impedit quo quidem beatae autem fugit sunt delectus odio non aspernatur. Fugit, magnam.</span></li>
            </ul>

        </div>

    </div>
    <div class="w3-third w3-container">    
        <div class="w3-card-4 edit-block" style="margin-top: 1em;">
            <div class="w3-container primary">
                <h4>Pictures</h4>
            </div>
            <p class="w3-container">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium repellat illum vero, quisquam, blanditiis neque velit laborum quidem pariatur placeat id voluptatem aspernatur voluptatum alias fuga itaque laboriosam. Expedita, dignissimos.</p>
        </div>
    </div>
    <div class="w3-third w3-container">    
        <div class="w3-card-4 edit-block" style="margin-top: 1em;">
            <div class="w3-container primary">
                <h4>Comments</h4>
            </div>
            <p class="w3-container">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium repellat illum vero, quisquam, blanditiis neque velit laborum quidem pariatur placeat id voluptatem aspernatur voluptatum alias fuga itaque laboriosam. Expedita, dignissimos.</p>
        </div>
    </div>
</div>