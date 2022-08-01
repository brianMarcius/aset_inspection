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
                            <h4 class="card-title float-start">Form Inspections</h4>
                            <a class="btn btn-sm btn-primary float-end" id="info" href="assets/Petunjuk.docx" download><i class="fa fa-info"></i> Petunjuk</a>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <form class="form form-horizontal" id="form-inspections">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>User Name</label>
                                            </div>
                                            <div class="col-md-8 form-group">
                                                <input type="text" id="username" class="form-control" name="username" placeholder="User Name">
                                            </div>
                                            <div class="col-md-4">
                                                <label>Operating System</label>
                                            </div>
                                            <div class="col-md-8 form-group">
                                                <select id="os" class="form-control" name="os">
                                                    
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Join Domain</label>
                                            </div>
                                            <div class="col-md-8 form-group">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="join_domain" name="domain">
                                                    <label class="form-check-label" for="join_domain">Cek apakah sudah join domain</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Bios</label>
                                            </div>
                                            <div class="col-md-8 form-group">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="bios" name="bios">
                                                    <label class="form-check-label" for="bios">Cek apakah bios sudah terkunci</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Anti Virus</label>
                                            </div>
                                            <div class="col-md-8 form-group">
                                                <div class="form-check" id="container-av">
                                                        
                                                </div>
                                            </div>
                                                
                                            <div class="col-sm-12 d-flex justify-content-end">
                                                <div id="button_container">
                                                    <button type="button" onclick="store()" class="btn btn-primary me-1 mb-1">Submit</button>
                                                    <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <div id="container_alert" style="display:none">
                                    <div class="alert alert-success" role="alert" id="layak">
                                        <h4 class="alert-heading">Layak !</h4>
                                        <p>Harap menemui Jati atau Menghubungi Lewat Whatsapp dibawah ini. Untuk dilakukan Standarisasi sebagai syarat pengaktifan pengaktifan Captive Portal dan VPN</p>
                                        <hr>
                                        <p class="mb-0"><a href="https://wa.me/081343269268" target="_blank"><i class="bi bi-whatsapp"> Noviyan Jati Waluyo</i></a></p>
                                    </div>
                                    <div class="alert alert-danger" role="alert" id="tidak_layak">
                                        <h4 class="alert-heading">Tidak Layak !</h4>
                                        <p>Harap mengubungi vendor penyedia laptop untuk melakukan standarisasi sesuai regulasi perusahaan.</p>
                                        <hr>
                                        <p class="mb-0"><a href="https://wa.me/081343269268" target="_blank"><i class="bi bi-whatsapp"> Noviyan Jati Waluyo</i></a></p>
                                    </div>
                                    <button type="button" onclick="window.location.reload()" class="btn btn-primary me-1 mb-1">Oke</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            



<script>
    $(function(){
        get_av()
        get_os()
        $("#container_alert").hide();
    });

    function get_av(){
        $.ajax({
            url : "app/form_inspections/form_inspections.php?f_name=get_av",
            type : "GET",
            dataType : "JSON",
            success : function(response){
                var check = "";
                for (let i = 0; i < response.length; i++) {
                    check += "<div class='custom-control custom-checkbox'><input type='checkbox' class='form-check-input form-check-primary form-check-glo' checked name='av[]' id='"+response[i].id+"' value='"+response[i].id+"'><label class='form-check-label' for='"+response[i].id+"'>"+response[i].name+"</label></div>";
                }
                $("#container-av").html(check);
            }
        })
    }

    function get_os(){
        $.ajax({
            url : "app/form_inspections/form_inspections.php?f_name=get_os",
            type : "GET",
            dataType : "JSON",
            success : function(response){
                var option;
                for (let i = 0; i < response.length; i++) {
                    option += "<option value='"+response[i].id+"'>"+response[i].name+"</option>"
                }
                $("#os").html(option);
            }
        })
    }

    function store(){
        var formData = new FormData($("#form-inspections")[0]);
        $.ajax({
            url : "app/form_inspections/form_inspections.php?f_name=store",
            type : "POST",
            data : formData,
            cache: false,
            contentType: false,
            processData: false,
            dataType : "JSON",
            success : function(response){
                $("#container_alert").show();
                $("#button_container").hide();
                if (response.result==1) {
                    $("#layak").show();
                    $("#tidak_layak").hide();

                }else{
                    $("#tidak_layak").show();
                    $("#layak").hide();

                }
            }
        })
    }

</script>
