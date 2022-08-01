<?php 
if (function_exists($_GET['f_name'])) {
    $_GET['f_name']();
}

function get_av(){
    require_once "../../config/connection.php";
    $sql = "SELECT * from anti_virus";
    $query = mysqli_query($connect,$sql);
    $data = [];
    while ($r = mysqli_fetch_array($query)) {
        $fetch = [];
        $fetch['id'] = $r['id'];
        $fetch['name'] = $r['av_name'];
        $data[] = $fetch;
    }

    echo json_encode($data);
}

function get_os(){
    require_once "../../config/connection.php";
    $sql = "SELECT * from operating_system";
    $query = mysqli_query($connect,$sql);
    $data = [];
    while ($r = mysqli_fetch_array($query)) {
        $fetch = [];
        $fetch['id'] = $r['id'];
        $fetch['name'] = $r['os_name'];
        $data[] = $fetch;
    }

    echo json_encode($data);
}


function store(){
    require_once "../../config/connection.php";

    $user_name = $_POST['username'];
    $os = $_POST['os'];

    $os_condition = 1;
    //jika os other maka tidak layak
    if ($os == 3) {
        $os_condition = 0;
    }

    //cek domain apakah on atau tidak
    $domain = isset($_POST['domain']) ? 1 : 0;

    //cek bios apakah on atau tidak
    $bios = isset($_POST['bios']) ? 1 : 0;

    //cek av
    $av = $_POST['av'] ?? 0;

    //set av condition = 0
    $av_condition = 0;
    $av_implode = '';
    
    if ($av != 0) {
        for ($i=0; $i < sizeof($av); $i++) { 
                //cek apakah ada av selain windows defender 
                if ($av[$i]!=1) {
                    //jika ya maka set av condition = 1
                    $av_condition = 1;
                    break;
                }

            }

        //menggabungkan av menjadi 1 record comma separated
        $av_implode = implode(",",$av);    
    }
    

    //menghitung result
    $result = 1;
    //ketika domain = 0, bios = 0, av = 0 maka result tidak layak
    if ($domain == 0 && $bios == 0 && $av_condition == 0) {
        $result = 0;
    }

    $query_input = mysqli_query($connect,"INSERT into inspections(user_name, bios, os, join_domain, av, bios_condition, os_condition, join_domain_condition, av_condition, result) 
                                                values('$user_name',$bios,$os,$domain,'$av_implode',$bios,$os_condition,$domain,$av_condition,$result)");




    $data['result'] = $result;
    echo json_encode($data);

}

function get_all_inspection(){
    require_once "../../config/connection.php";
    $sql = "SELECT * from inspections";
    $query = mysqli_query($connect,$sql);
    $html = "";
    $no = 0;

    while ($r = mysqli_fetch_array($query)) {
        $get_os_name = mysqli_fetch_array(mysqli_query($connect, "SELECT * from operating_system where id='".$r['os']."'"));
        $os_name = $get_os_name['os_name'];


        $av_name = "";
        if ($r['av'] != '') {
            $av_explode = explode(',',$r['av']);
            for ($i=0; $i < sizeof($av_explode) ; $i++) { 
                $get_av_name = mysqli_fetch_array(mysqli_query($connect, "SELECT * from anti_virus where id='".$av_explode[$i]."'"));
                $and = "";
                if ($i > 0) {
                    $and = " dan ";
                }
                $av_name .= $and.$get_av_name['av_name'];
            }
        }

        $status = '<span class="badge bg-danger">Tidak Layak</span>';

        if ($r['result'] == 1) {
            $status = '<span class="badge bg-success">Layak</span>';
        }

        $join_domain = ($r['join_domain']==1) ? 'yes' : 'no';
        $bios = ($r['bios']==1) ? 'yes' : 'no';


        $html .= "<tr>
                        <td>".++$no."</td>
                        <td>".$r['user_name']."</td>
                        <td>".$r['tanggal']."</td>
                        <td>".$os_name."</td>
                        <td>".$join_domain."</td>
                        <td>".$bios."</td>
                        <td>".$av_name."</td>
                        <td>$status</td>
        
        </tr>";
    }

    echo $html;
}


?>