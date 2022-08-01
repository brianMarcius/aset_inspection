<header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div class="page-heading">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-md-6 order-md-1 order-last">
                            <h3><?php echo $menu ?></h3>
                            <p class="text-subtitle text-muted"><?php echo $description ?></p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="<?php echo $menu_link ?>"><?php echo $menu ?></a></li>
                                    <li class="breadcrumb-item active" aria-current="page"><?php echo $submenu ?></li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
                <section class="section">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title float-start">Log Inspections</h4>
                        </div>
                        <div class="card-body">
                                    <div class="table-responsive pt-4">
                                        <table class="table table-hover" id="table-inspection">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>User Name</th>
                                                    <th>Date</th>
                                                    <th>Operating System</th>
                                                    <th>Join Domain</th>
                                                    <th>Bios</th>
                                                    <th>Anti Virus</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody-inspection">

                                            </tbody>

                                        </table>
                                    </div>
                                
                        </div>
                    </div>
                </section>
            </div>
<script>
 
    $(function(){
        getData()
    });



    function getData(){
        $.ajax({
            url : "app/form_inspections/form_inspections.php?f_name=get_all_inspection",
            type : "GET",
            success : function(result){
                $("#tbody-inspection").html(result);
                $('#table-inspection').DataTable();
            }
        })
    }




</script>
