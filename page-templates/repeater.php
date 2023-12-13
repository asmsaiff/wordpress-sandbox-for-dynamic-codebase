<?php
    /**
     * Template Name: Repeater
     */

    get_header();
?>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<div class="w-8/12 mx-auto py-12">
<div class="container">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <!-- Repeater Html Start -->
                <div id="repeater">
                    <!-- Repeater Heading -->
                    <div class="repeater-heading">
                        <h5 class="pull-left">Repeater</h5>
                        <button class="btn btn-primary pt-5 pull-right repeater-add-btn">
                            Add
                        </button>
                    </div>
                    <div class="clearfix"></div>
                    <!-- Repeater Items -->
                    <div class="items" data-group="test">
                        <!-- Repeater Content -->
                        <div class="item-content">
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-2 control-label">Name</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="inputName" placeholder="Name" data-name="name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-2 control-label">Email</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="inputEmail" placeholder="Email" data-skip-name="true" data-name="email">
                                </div>
                            </div>
                        </div>
                        <!-- Repeater Remove Btn -->
                        <div class="pull-right repeater-remove-btn">
                            <button class="btn btn-danger remove-btn">
                                Remove
                            </button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="items" data-group="test">
                        <!-- Repeater Content -->
                        <div class="item-content">
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-2 control-label">Name</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="inputName" placeholder="Name" data-name="name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-2 control-label">Email</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="inputEmail" placeholder="Email" data-skip-name="true" data-name="email">
                                </div>
                            </div>
                        </div>
                        <!-- Repeater Remove Btn -->
                        <div class="pull-right repeater-remove-btn">
                            <button class="btn btn-danger remove-btn">
                                Remove
                            </button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="items" data-group="test">
                        <!-- Repeater Content -->
                        <div class="item-content">
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-2 control-label">Name</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="inputName" placeholder="Name" data-name="name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-2 control-label">Email</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="inputEmail" placeholder="Email" data-skip-name="true" data-name="email">
                                </div>
                            </div>
                        </div>
                        <!-- Repeater Remove Btn -->
                        <div class="pull-right repeater-remove-btn">
                            <button class="btn btn-danger remove-btn">
                                Remove
                            </button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <!-- Repeater End -->
            </div>
        </div>
    </div>
</div>


<?php
    get_footer();