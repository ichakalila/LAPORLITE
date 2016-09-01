<?php
set_time_limit(0);

class Laporan extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('upload');
        $this->load->library('session');
        $this->load->library('parser');
        date_default_timezone_set("Asia/Jakarta");
    }

    function getNotif($token){
        $url = 'https://www.lapor.go.id/index.php/api/lapor/notification_count';
        $notif = json_decode($this->getCurl($url,$token));
        if($notif->status==1){
            return $notif->notifications;
        }else{
            return;
        }
    }

    public function index(){
        $sesi = $this->session->all_userdata();
        if($sesi['KEYTOKEN'] != null){
            $url = 'https://www.lapor.go.id/index.php/api/lapor/streams';
            $result = json_decode($this->getCurl($url,$sesi['KEYTOKEN']));

            if(isset($result->status)){
                redirect('./logout/2');
            }
            //print_r($result);
            foreach ($result as $res) {
            // Potong Konten Untuk Baca Selengkapnya
               $res->content = $this->readmore($res->content);

               //$url2 = 'https://www.lapor.go.id/index.php/api/lapor/streamClaim?nid='.$res->nid;
               //$result3 = json_decode($this->getCurl($url,$sesi['KEYTOKEN']));
               //echo "TEST : ";
               //print_r($result3);
               $next = $res->last_activity;
           }
           $nextlaporan = ($next)?'&nid='.$next."&opt=old":"";
           $url = 'https://www.lapor.go.id/index.php/api/lapor/streams?user_id=0'.$nextlaporan;
           $result2 = json_decode($this->getCurl($url,$sesi['KEYTOKEN']));
           if(count($result2)==0){
            $sesi['nextempty'] = true;
        }else{
            $sesi['nextempty'] = false;
        }
        //print_r($result);
        $sesi['stream'] = $result;
        $sesi['gotowhere'] = "main";
        $sesi['notif'] = $this->getNotif($sesi['KEYTOKEN']);
        //print_r($sesi);
        $this->load->view('home',$sesi);
    }else{
        $this->session->set_flashdata('alertTitle', 'Akses Ilegal !');
        $this->session->set_flashdata('alertType','danger');
        $this->session->set_flashdata('alert', 'Silahkan Login dahulu.');
        redirect('/');
    }
}

public function laporanselanjutnya($topik,$id){
    $sesi = $this->session->all_userdata();
    if($sesi['KEYTOKEN'] != null){
        $url = 'https://www.lapor.go.id/index.php/api/lapor/streams?nid='.$id."&kat=".$topik."&user_id=0&opt=old";
            //echo $url;
        $result = json_decode($this->getCurl($url,$sesi['KEYTOKEN']));
        if(isset($result->status)){
            redirect('./logout/2');
        }
        foreach ($result as $res) {
           $res->content = $this->readmore($res->content);
           $next = $res->last_activity;
       }

       $nextlaporan = ($next)?'&nid='.$next."&opt=old":"";
       $url = 'https://www.lapor.go.id/index.php/api/lapor/streams?user_id=0'.$nextlaporan;
       $result2 = json_decode($this->getCurl($url,$sesi['KEYTOKEN']));
       $sesi['gotowhere'] = "next_".$id;
       if(count($result2)==0){
        $sesi['nextempty'] = true;
    }else{
        $sesi['nextempty'] = false;
    }
            //print_r($result);
    $sesi['stream'] = $result;
    $sesi['notif'] = $this->getNotif($sesi['KEYTOKEN']);
            //print_r($sesi);
    $this->load->view('read',$sesi);

}else{
    $this->session->set_flashdata('alertTitle', 'Akses Ilegal !');
    $this->session->set_flashdata('alertType','danger');
    $this->session->set_flashdata('alert', 'Silahkan Login dahulu.');
    redirect('/');
}

}

public function kirimkomentar(){
    $sesi = $this->session->all_userdata();
    //print_r($sesi);
    $url = 'https://www.lapor.go.id/index.php/api/lapor/streamcomment';
    $nid = $this->input->post('nid');
    $variable = "user_id=".$sesi['user_id']."&content=".$this->input->post('komentar')."&source=LaporLite"."&reply_nid=".$nid;
    echo $variable;
    $result = $this->postCurl($url,$sesi['KEYTOKEN'],$variable);
    if($result['status']==0){
        $this->session->set_flashdata('alertTitle', 'Kirim Komentar Gagal !');
        $this->session->set_flashdata('alertType','danger');
        $this->session->set_flashdata('alert', $result['error']);
        redirect(base_url().'laporan/'.$nid);   
    }else{
        $this->session->set_flashdata('alertTitle', 'Kirim Komentar Berhasil !');
        $this->session->set_flashdata('alertType','success');
        $this->session->set_flashdata('alert', $result['error']);
        redirect(base_url().'laporan/'.$nid);   

    }
}

public function bacalaporan($id){
    $sesi = $this->session->all_userdata();
    if($sesi['KEYTOKEN'] != null){
        $url = 'https://www.lapor.go.id/index.php/api/lapor/stream?nid='.$id;
        $url2 = 'https://www.lapor.go.id/index.php/api/lapor/streamComments?nid='.$id;
            //echo $url;
        $result = json_decode($this->getCurl($url,$sesi['KEYTOKEN']));
        $result2 = json_decode($this->getCurl($url2,$sesi['KEYTOKEN']));

        if(isset($result->status)){
            redirect('./logout/2');
        }
        //print_r($result);
        $sesi['stream'] = $result;
        $sesi['komen'] = $result2;
        $sesi['notif'] = $this->getNotif($sesi['KEYTOKEN']);

        $sesi['gotowhere'] = "baca_".$id;
        //print_r($sesi);
        $this->load->view('read',$sesi);

    }else{
        $this->session->set_flashdata('alertTitle', 'Akses Ilegal !');
        $this->session->set_flashdata('alertType','danger');
        $this->session->set_flashdata('alert', 'Silahkan Login dahulu.');
        redirect('/');
    }
}

public function bacatindaklanjut($id){
    $sesi = $this->session->all_userdata();
    if($sesi['KEYTOKEN'] != null){
        $url = 'https://www.lapor.go.id/index.php/api/lapor/stream?nid='.$id;
        $url2 = 'https://www.lapor.go.id/index.php/api/lapor/claims?nid='.$id;
            //echo $url;
        $result = json_decode($this->getCurl($url,$sesi['KEYTOKEN']));
        $result2 =json_decode($this->getCurl($url2,$sesi['KEYTOKEN']));

        if(isset($result->status)){
            redirect('./logout/2');
        }
        //print_r($result2);
        $sesi['stream'] = $result;
        $sesi['tindaklanjut'] = $result2;
        $sesi['notif'] = $this->getNotif($sesi['KEYTOKEN']);

        $sesi['gotowhere'] = "tl_".$id;
        //print_r($sesi);
        $this->load->view('read',$sesi);

    }else{
        $this->session->set_flashdata('alertTitle', 'Akses Ilegal !');
        $this->session->set_flashdata('alertType','danger');
        $this->session->set_flashdata('alert', 'Silahkan Login dahulu.');
        redirect('/');
    }
}

public function kirimLaporan(){
    $sesi = $this->session->all_userdata();
    $url = "https://www.lapor.go.id/index.php/api/lapor/stream";
    $userid = $sesi['user_id'];
    $content = $this->input->post('laporan');
    $countKonten = strlen($content);
    $rahasia = ($this->input->post('rahasia')=="on")?2:1;
    $anonim = ($this->input->post('anonim')=="on")?2:0;
    $source = "LaporLite";
    $variable = array(
        'user_id' => $userid,
        'content' => $content,
        'report_type' => $rahasia,
        'is_anonim' => $anonim,
        'source' => $source,
        'topik_nid' => 0
        );
    if (!empty($_FILES['userfile']['name'][0])) {
        $files = $this->reArrayFiles($_FILES['userfile']);
        $totalfiles = count($_FILES['userfile']['name']);
        $variable['photo'] = 1;
        //print_r($files);
        for($i = 0;$i < $totalfiles;$i++){
            $file = explode(".",$files[$i]['name']);
            //$variable['photo'.$i] = $files[$i];
            $variable['photo'.$i] = curl_file_create($files[$i]['tmp_name'],$file[1],$files[$i]['name']);
            //$variable['photo'.$i] = $files[$i]['tmp_name'].".".$file[1];
        }
    }

    if ($countKonten > 10) {
        $res = $this->postMultiform2($url,$sesi['KEYTOKEN'],$variable);
        //echo $variable;
    }else{
        $this->session->set_flashdata('alertTitle', 'Lapor Gagal!');
        $this->session->set_flashdata('alertType','danger');
        $this->session->set_flashdata('alert', 'Isi laporan minimal 10 karakter');
        redirect('./beranda');
    }
    
    //print_r($res);
    if($res["status"]==0){
        $this->parser->parse('thank_you',$res);
    }else{
        $this->session->set_flashdata('alertTitle', 'Lapor Gagal!');
        $this->session->set_flashdata('alertType','danger');
        $this->session->set_flashdata('alert', $res['error']);
        //redirect('./beranda');
    }
}


public function kirimTindakLanjut(){
    $sesi = $this->session->all_userdata();
    $url = "https://www.lapor.go.id/index.php/api/lapor/claim";
    $userid = $sesi['user_id'];
    $content = $this->input->post('tindaklanjut');
    $nid = $this->input->post('nid');
    $source = "LaporLite";
    $variable = array(
        'claim_text' => $content,
        'nid' => $nid,
        'source' => $source
        );
    //echo "TESAT MASUK ".empty($_FILES['userfile']['name']);
    $filez = $_FILES['userfile'];
    //print_r(count($filez['name']));
    //print_r($filez);
    //print_r($filez['name']);
    if (!empty($_FILES['userfile']['name'][0])) {
        $files = $this->reArrayFiles($_FILES['userfile']);
        $totalfiles = count($_FILES['userfile']['name']);
        $variable['photo'] = 1;
        //echo "TESAT MASUK2 ".empty($_FILES['userfile']['name']);
        //print_r($files);
        for($i = 0;$i < $totalfiles;$i++){
            $file = explode(".",$files[$i]['name']);
            //$variable['photo'.$i] = $files[$i];
            $variable['photo'.$i] = curl_file_create($files[$i]['tmp_name'],$file[1],$files[$i]['name']);
            //$variable['photo'.$i] = $files[$i]['tmp_name'].".".$file[1];
        }
    }
    //print_r($variable);
    $res = $this->postMultiform($url,$sesi['KEYTOKEN'],$variable);
    //$res = json_decode($res,true);
    print_r($res);
    if($res["code"]==1){
        $this->session->set_flashdata('alertTitle', 'Berhasil!');
        $this->session->set_flashdata('alertType','success');
        $this->session->set_flashdata('alert', 'Tindak Lanjut berhasil dikirimkan');
        redirect('./tindaklanjut/'.$nid);
    }else{
        $this->session->set_flashdata('alertTitle', 'Kirim Tindak lanjut Gagal!');
        $this->session->set_flashdata('alertType','danger');
        $this->session->set_flashdata('alert', $res['txt']);
        redirect('./tindaklanjut/'.$nid);
    }
}

public function gantiAvatar(){
    $sesi = $this->session->all_userdata();
    $url = 'https://www.lapor.go.id/index.php/api/lapor/change_avatar';
    $files = $_FILES['userfile'];
    $file = explode(".",$files['name']);
    //print_r($_FILES['userfile']);
    $variable = array(
        //'file' => $files
        'file' => curl_file_create($files['tmp_name'],$file[1],$files['name'])
        );
    $res = $this->postMultiform($url,$sesi['KEYTOKEN'],$variable);
    //print_r($res);
    if($res["code"]==1){
        $url = 'https://www.lapor.go.id/index.php/api/lapor/userprofile?id='.$sesi['user_id'];
        $result = $this->getCurl($url,$sesi['KEYTOKEN']);
        $result = json_decode($result);
        $this->session->set_userdata('img', $result->hash_photo);

        $this->session->set_flashdata('alertTitle', 'Berhasil!');
        $this->session->set_flashdata('alertType','success');
        $this->session->set_flashdata('alert', 'Sukses Ganti Avatar'); 
        redirect('./profil/ubah');       
    }else{
        $this->session->set_flashdata('alertTitle', 'Gagal!');
        $this->session->set_flashdata('alertType','danger');
        $this->session->set_flashdata('alert', "Ganti Avatar Bermasalah");
        redirect('./profil/ubah');
    }
}

public function gantiPassword(){
    $sesi = $this->session->all_userdata();
    $url = 'https://www.lapor.go.id/index.php/api/lapor/change_password';
    $oldp = $this->input->post('passwordold');
    $newp = $this->input->post('passwordnew');
    $konfp = $this->input->post('passwordkonf');
    if(empty($oldp) || $oldp= ""){
        $this->session->set_flashdata('alertTitle', 'Error !');
        $this->session->set_flashdata('alertType','danger');
        $this->session->set_flashdata('alert', 'Tolong Input Password Lama');
        redirect('./profil/ubah');
    }
    else if(empty($newp) || $newp = ""){
        $this->session->set_flashdata('alertTitle', 'Error !');
        $this->session->set_flashdata('alertType','danger');
        $this->session->set_flashdata('alert', 'Tolong Input Password Baru');
        redirect('./profil/ubah');

    } 
    else if(empty($konfp) || $konfp = ""){
        $this->session->set_flashdata('alertTitle', 'Error !');
        $this->session->set_flashdata('alertType','danger');
        $this->session->set_flashdata('alert', 'Tolong Input Konfirmasi Password');
        redirect('./profil/ubah');
    }
    else{   
        $variable = array(
            'old_password' => $this->input->post('passwordold'),
            'new_password' => $this->input->post('passwordnew'),
            'confirm_new_password' => $this->input->post('passwordkonf')
            );
        $res = $this->postCurl($url,$sesi['KEYTOKEN'],$variable);
        print_r($res);
        if($res['status'] == 1){
            $this->session->set_flashdata('alertTitle', 'Success !');
            $this->session->set_flashdata('alertType','success');
            $this->session->set_flashdata('alert', $res['msg']);
            redirect('./profil/ubah');
        }else if($res['errors']){
            $this->session->set_flashdata('alertTitle', 'Error !');
            $this->session->set_flashdata('alertType','danger');
            $this->session->set_flashdata('alert', $res['msg']);
            redirect('./profil/ubah');
        }
    }
}

public function gantiEmail(){
    $sesi = $this->session->all_userdata();
    $url = 'https://www.lapor.go.id/index.php/api/lapor/change_email';
    $newe = $this->input->post('emailnew');
    $konfe = $this->input->post('emailkonf');
    $pass = $this->input->post('password');
    if(empty($newe) || $newe= ""){
        $this->session->set_flashdata('alertTitle', 'Error !');
        $this->session->set_flashdata('alertType','danger');
        $this->session->set_flashdata('alert', 'Tolong Input Email Baru');

    }
    else if(empty($konfe) || $konfe = ""){
        $this->session->set_flashdata('alertTitle', 'Error !');
        $this->session->set_flashdata('alertType','danger');
        $this->session->set_flashdata('alert', 'Tolong Input Email Konfirmasi');
        redirect('./profil/ubah');

    } 
    else if(empty($pass) || $pass = ""){
        $this->session->set_flashdata('alertTitle', 'Error !');
        $this->session->set_flashdata('alertType','danger');
        $this->session->set_flashdata('alert', 'Tolong Input Password');
        redirect('./profil/ubah');
    }
    else if($konfe != $newe){
        $this->session->set_flashdata('alertTitle', 'Error !');
        $this->session->set_flashdata('alertType','danger');
        $this->session->set_flashdata('alert', 'Tolong Input Email Baru Sama dengan Email Konfirmasi');
        redirect('./profil/ubah');
    }
    else{   
        $variable = array(
            'email' => $this->input->post('emailnew'),
            'password' => $this->input->post('password')
            );
        $res = $this->postCurl($url,$sesi['KEYTOKEN'],$variable);
        print_r($res);
        if($res['status'] == 1){
            $this->session->set_flashdata('alertTitle', 'Success !');
            $this->session->set_flashdata('alertType','success');
            $this->session->set_flashdata('alert', $res['msg']);
            redirect('./profil/ubah');
        }else if($res['errors']){
            $this->session->set_flashdata('alertTitle', 'Error !');
            $this->session->set_flashdata('alertType','danger');
            $this->session->set_flashdata('alert', $res['msg']);
            redirect('./profil/ubah');
        }
    }

}

public function lihatnotif(){
    $sesi = $this->session->all_userdata();
    if($sesi['KEYTOKEN'] != null){
        $url = "https://www.lapor.go.id/index.php/api/lapor/notification";
        $result = json_decode($this->getCurl($url,$sesi['KEYTOKEN']));
        //print_r($result);
        if(isset($result->status)){
            if($result->status == -1){
                redirect('./logout/2');
            }
        }
        $sesi['notifications']=$result;
        $sesi['notif'] = $this->getNotif($sesi['KEYTOKEN']);
        //print_r($sesi);
        $this->load->view('notifikasi',$sesi);  
    }
}

public function hapuslaporan($id){
    $sesi = $this->session->all_userdata();
    if($sesi['KEYTOKEN'] != null){
        $url = "https://www.lapor.go.id/index.php/api/lapor/delete_stream";
        $variable = "nid=".$id;
        $result = $this->postCurl($url,$sesi['KEYTOKEN'],$variable);
        if($result['status']==1){
            echo "TEST";
            $this->session->set_flashdata('alertTitle', 'Hapus Berhasil!');
            $this->session->set_flashdata('alertType','success');
            $this->session->set_flashdata('alert', $result['msg']." Laporan.");
        }else{
            echo "TEST1";
            $this->session->set_flashdata('alertTitle', 'Hapus Gagal!');
            $this->session->set_flashdata('alertType','danger');
            $this->session->set_flashdata('alert', $result['msg']);
        }
        redirect('./laporanku');
    }
}

public function test($num){
    $d = date_create(date("Y-m-d",($num)));
    print_r($d);
}

public function teststring(){
    $string = 'HTTP/1.1 100 Continue HTTP/1.1 200 OK Date: Sat, 12 Mar 2016 13:24:12 GMT Server: Apache Set-Cookie: cisession=soCFudZLlXQp5hglcpNyeIgap2lkpbGm3oOW6TSTsiZUhl2%2BOMZKBCm9NQtOYo4tMHh3E4WMV6dX4KHZq%2BqP8bYuUVdkNWHvO79Zs9Nlt4NclvYvj5lw8PI8qzBLC7NyACrAdGV%2FI8QE1LG1gs7GoesM1JF2tbuEDCJ0sE8zTe%2BzfGwWENKZEYVtEiCv0RDdMCw6EM%2BpzGIFOnm%2Bn4kElQTkFlipbz%2ByqVr6u%2BSISCDZxY3OoysknRIr10STxLUANc76LRTVCTNGVlJNjxH5rpoeNfMS7JlKpwsBagBa33o%3D; expires=Sat, 12-Mar-2016 15:54:21 GMT; path=/ Set-Cookie: cisession=VG3HEb%2BstAsyL4hEj06crRCzzylTW65SH3MetwnUzSMnTaPotYJBEqhQzOdhBqnSQGGEfIYuUOhtHWCNpcVhkcU1EqXjxHJlaPuTyAwYYDKjxLkhhxNqdMeqe0gUBOqlFdMZghzLlAGGdboqQ411vPu9YBfHMkNDv8Q4%2FuoVXJ7CA7SwoagulwuVX%2BHNUKzjH3RofMmjcfYx0RlCCEJSZU7wmXIHxIwAJh2pWlqMm2b6pSW2tcN%2Bx8W3W2k8GqoPTAtxFXdMplcRrgygmUgDPwA%3D; expires=Sat, 12-Mar-2016 15:54:21 GMT; path=/ Set-Cookie: cisession=b9MzKEtUshuX1dPHgV%2Byv7NmY5Z5ZDz%2B3Yu87eiScZDA5u3mwF9cgE3%2FWFVVz%2F4MsWlNRJONRVBIoCND6TDZurRXSt1Kbmwm4V%2Fs1f63XVi35igbhInirr6kkc0iKtG4dnKHs0tiRtboA4dO6An3zJn%2FP%2BwRyQvlU3hw17p1gtLGj%2FmHOpuu5%2FqJ75Ad%2FDr%2BesuiZqB%2Fk6cQK0bwiO23Oi%2BFbjG%2BM%2BiebOw9MZn2edWaZ3ldhEYDGSbRD01xhDvcgWCFESR%2BPvviiGbrR8LjIs7Ro7WukeLGYhlQTEeOt3V3wmJwyhXZ1XDwE5E%3D; expires=Sat, 12-Mar-2016 15:54:21 GMT; path=/ Set-Cookie: cisession=zjAmjjOm2HaQBbs9DzyxXbsdX5BUkD19YptSOGoV8lFuatSbusLUW1aqlq%2BNhU8N81a3cpR%2FyODuNfnp3mZp84NzZ5zVpom1ceoni61EcdLmS1ALogls3OAkpuXdnTEjOxS4MLYmGoQ7MkITKFJej9kIuHtz%2F9icbKdBGlWkRaRSpzAhz6B%2FcBE85ElDtCt4GqGbMWNOYAnFw8q9V9C%2B6UZlRZ%2BFkiOgyDLP%2BD6wnMZT9kFbVCW1PnVCkrTb6LPKIzu6mF4r4uR40FygAVYiNL8fySbegTc%2BkFAv7jwrhqi%2FXg7wws0qkSkjiL3WlOChSpFT010DSZ%2BeIYJVw3jsjAuK; expires=Sat, 12-Mar-2016 15:54:21 GMT; path=/ Set-Cookie: cisession=RraGbghxGIo1DtJgIS0JNeAQm2P0hL6IK%2F0MnjLRlqNhXelMMRHRe%2B3orNP2K7OLNQ7VphZM66ERtl%2F6S0D2g3StP4GMMvlL42SaAcAdACWthAbm47202EBueDyiaWR%2BIOSpZdKI2Jx938jlMdUXQQ97dXaZAMzd6CItnxJQgnl%2Bzxo757ak82frfSZKqTJ9qCtYHrZWDEcS1KBwhtKYzwsJwhAaD1hbCfExV82bIIGT%2FW7o62FodPyUVv2Jo4XOkY6ql672EwsHNzpsCf6KnikhKYsjvtOxS%2BEJQi41hUFg7AKYz%2B14%2B1oQoZl0pXD8%2Bg1moufoodia64LPXNZ2TSt37Cn0j9UvFELbP2TktReCvua74Ek%2FeIM7A9fNpiEgC3extKJb4wq5MaTr0J4JBotNjZBrKscGbQD0AA%3D%3D; expires=Sat, 12-Mar-2016 15:54:21 GMT; path=/ Set-Cookie: cisession=fy%2FUl9%2FRAAlgB8%2F9%2BbhDUojSH8mnLnqqmTiIYlAZ9yz2cOTwJsoqy%2FE2jk2%2BnQgFTtjQQZPJUp71miSwIQIkpjVW3%2FEwcVsTgi06L24KjGbNBRD17hPDsWIB4Q0ayj8ciS9H%2FYDZseVMEW0KPRgNMSnE3eIsnoowAhr5VpkTab4mG9MER%2FUHZ31996g9gLMrlf37FM8VB%2FTVl%2Bn%2BSltXTQi94lI9eba9LW6AB9CfnAAJKHb7iQCNDMNtLqbU8loFTpdV3qQ0f7q%2FILStz2oPW7xUmDoejgcUkRK2Jee7H2mEwVK3h6IZ47iD5gUaXDWspmNd5fbWz8EemDdd0V4E7frz4EigAJNxGJxm6WbiVHgM9S6LimqGrTCxe33Vc6Y3%2FrU8kvwmj5xWp9JzBiXvDB4TpMSOdN%2FGpAPQdCKpiNI1il0RZLUHxG5jUa4docZM; expires=Sat, 12-Mar-2016 15:54:21 GMT; path=/ Set-Cookie: cisession=Z67%2FI0SWIVa5onGJJnf%2BAx%2BIIHR2xxZaPQchUvxoGmTD2TOMOIY0wuDWUY%2Bm1HFSrZp4lVr6E5M3FGvZ7yDX4WTruuzt6KKMDHP8q4zzplM3%2BJbFBxIpS8JsAZVP2Zu65JfdzcXBzV9FYjMoma52Kdl%2BZ%2F3owcyFWUZ1i9xzSk0gaOXnCtaxQc4z6LaFOSxKj128Yllnq%2BIWLAIl5bXC%2F3rH0wqu%2B96MfweXI%2Bo45geMMdMsEgfLHnkf83F4stFI1QdioQsOqkaCUIi4EU1AqGtng9bbm5yXJg7W%2BleCZjqQSniT9Mqm8m7hTUHFhaBkqCmJBMN25eBPecB5sQoDrOTcH7fFa2dc%2BSctloY%2FlCmBrHUtYsVAiuCIbakvqy2%2Fm2EU1KpPUvTrItDMgnWfCsYxypTsd770k2D7vggvHDoZNlTXKHLjgBmPlSGbjNoC7aLk7eC%2Be30n6WGIQmwiB3J0SuFg; expires=Sat, 12-Mar-2016 15:54:21 GMT; path=/ Set-Cookie: cisession=QMIs6Phm8qbpxcysmu86Fpn0jEB8Pf7hrRkk20kfLlTLkEQv%2BH9IpWNAR3qyUQPdZhXhH6OyBm26W68PD2smNSrtNoeKkC1jdI1wL73ByJFcs%2BORDNu8XGrhz7VMzra%2BzRnXkNc6DmK1MGVuRsqTDrEA0zIyPUM7FgnDgNjxCmQ7N452XPq29q5kXw7r3%2BtGSENE0Qd52yEDBo1HfCI0qHeKWCZbZKRYbwniYgcFVEHNMWeK85kav3veNaQM%2F4XM%2FyPvoWKco9gj91v3Sa7tw055FfsA7%2BprjvXDMU2tY1XBZfuIOuF8%2BbEz%2B%2FbwQ%2FIuWeDmolxNeuR77v%2FQcUQ907EVLQucd7x4YYX3%2Fmwq6a6mfnpqua7vVUbtMBBVHCBEkEVnwPVYFrNwfecUbQRvze1b1UEGL3seRJWF8uebpFxn7TyjoDIP4VOak0A%2F8KJHtjNtHZv0cLK6ZJ01hw0HXjxyKCpgFRCImcbflYSGIUmWSDWf3doWTsW%2BH6rGR5lwMw%3D%3D; expires=Sat, 12-Mar-2016 15:54:21 GMT; path=/ Set-Cookie: cisession=%2FYhhJkYU0RPih1OuPHpHtAR7pKei8UsdQjSqmtxb2OTBgwl%2BXp8QPO%2BnLVChy7W%2Fi4MYjNgsKY%2FM7sz%2FB2ZdKwK%2Ft2zMIprY1yZZ6jQeewEd%2FcV6mIBLYpTOcKjxELltNdHH9X%2BCExEHCOHDyP5XgbyDz9slRis0kUXKyKurugRwPusezFJJFbIk6iTTEPBYypipt45959%2FYUGEONwSJz8QUzWuZDy%2BwzCUp3CeoItnjtOnPxjYTOig8Eq1TPxnQJI3NVKHvwCtFzDcAukD5%2BN9dbay7sZ3c%2Bic31EHvTJDfk7C7BZ1D9jfbx3OUNsayg5rmnR%2BBZkocnI5s%2BLCk%2BcBc7h3JYDlnhRSESO42JGqmuRkePgDl%2F8%2FLc7TWa1aYj2ZdfgaHX0pQZoYMhJlRxpPMU6%2FJ3GIo1JRpwZ%2BkLaJ%2BoNRhH1fflfXxbQBb7ZNkg8BX%2Ba5dLr3MculHf%2BTfqHGkTaLjRZ1jZm9ibi8AT5l9NyfQEJbFIaZWw6Shy3kxB2ZjDvkxsoN%2BTgoSs407Ckuz9h7zxjPROMI%3D; expires=Sat, 12-Mar-2016 15:54:21 GMT; path=/ Content-Length: 37 Content-Type: application/json {"status":0,"error":"","nid":1438651}';
    $this->processMultiformResult($string);
}

public function stream(){
    $sesi = $this->session->all_userdata();
    if(!isset($sesi['KEYTOKEN'])){
        redirect('/');
    }else{
        $userid = $sesi['user_id'];
        $url = 'https://www.lapor.go.id/index.php/api/lapor/streams?user_id='.$sesi['user_id'];
        $result = json_decode($this->getCurl($url,$sesi['KEYTOKEN']));
        if(isset($result->status)){
            redirect('./logout/2');
        }
        //print_r($result);
        foreach ($result as $res) {
           $res->content = $this->readmore($res->content);
           $next = $res->last_activity;
       }
       if(isset($next)){
           $nextlaporan = ($next)?'&nid='.$next."&opt=old":"";
           $url = 'https://www.lapor.go.id/index.php/api/lapor/streams?user_id='.$sesi['user_id'].$nextlaporan;
           $result2 = json_decode($this->getCurl($url,$sesi['KEYTOKEN']));
           if(count($result2)==0){
            $sesi['nextempty'] = true;
        }else{
            $sesi['nextempty'] = false;
        }
    }else{
        $sesi['nextempty'] = false;

    }
    $sesi['stream'] = $result;
    $sesi['gotowhere'] = "laporanku";
    $sesi['notif'] = $this->getNotif($sesi['KEYTOKEN']);
    $sesi['laporanku']=$sesi['user_id'];
    //print_r($sesi);
    $this->parser->parse('laporanku',$sesi);
}
}

public function streamnext($next){
    $sesi = $this->session->all_userdata();
    if(!isset($sesi['KEYTOKEN'])){
        redirect('/');
    }else{
        $userid = $sesi['user_id'];
        $nextlaporan = ($next)?'&nid='.$next."&opt=old":"";
        $url = 'https://www.lapor.go.id/index.php/api/lapor/streams?user_id='.$sesi['user_id'].$nextlaporan;
        $result = json_decode($this->getCurl($url,$sesi['KEYTOKEN']));
        if(isset($result->status)){
            redirect('./logout/2');
        }
        foreach ($result as $res) {
           $res->content = $this->readmore($res->content);
           $next = $res->last_activity;
       }

       $nextlaporan = ($next)?'&nid='.$next."&opt=old":"";
       $url = 'https://www.lapor.go.id/index.php/api/lapor/streams?user_id='.$sesi['user_id'].$nextlaporan;
       $result2 = json_decode($this->getCurl($url,$sesi['KEYTOKEN']));
       if(count($result2)==0){
        $sesi['nextempty'] = true;
    }else{
        $sesi['nextempty'] = false;
    }
    $sesi['stream'] = $result;
    $sesi['notif'] = $this->getNotif($sesi['KEYTOKEN']);

    $sesi['gotowhere'] = "nextlap_".$next;
    $sesi['laporanku']=$sesi['user_id'];
     //print_r($sesi);
    $this->parser->parse('laporanku',$sesi);
}
}

public function profil($pilihan){
    $sesi = $this->session->all_userdata();
    if(!isset($sesi['KEYTOKEN'])){
        redirect('/');
    }else{
        $url = 'https://www.lapor.go.id/index.php/api/lapor/userprofile?id='.$sesi['user_id'];
        $result = $this->getCurl($url,$sesi['KEYTOKEN']);
        $result = json_decode($result);

        if(isset($result->status)){
            redirect('./logout/2');
        }
        $result->birthday = ($result->birthday==0)?null:date("Y-m-d",($result->birthday));
        $result->phone = ($result->phone==0)?null:$result->phone;
        $sesi['profil'] = array($result);
        $sesi['notif'] = $this->getNotif($sesi['KEYTOKEN']);
        //print_r($sesi);
        if($pilihan == "main"){
            $this->parser->parse('profile',$sesi);
        }else if($pilihan == "ubah"){
            $this->parser->parse('ubahprofile',$sesi);
        }else{
            redirect('./profil/main');
        }
    }
}

public function dukung($where,$id){
    $sesi = $this->session->all_userdata();
    $url = 'https://www.lapor.go.id/index.php/api/lapor/streamrate';
    $kemana = explode("_",$where);
    $variable = array(
        'user_id' => $sesi['user_id'],
        'nid' => $id,
        'agree' => 1
        );
    $res = $this->postCurl($url,$sesi["KEYTOKEN"],$variable);
    if($res['status']==1){
        $this->session->set_flashdata('alertTitle', 'Sukses!');
        $this->session->set_flashdata('alertType','success');
        $this->session->set_flashdata('alert', 'Anda Telah Mendukung Laporan dengan <strong>Tracking ID : '.$id.'</strong>'); 

    }else{
        $this->session->set_flashdata('alertTitle', 'Gagal!');
        $this->session->set_flashdata('alertType','danger');
        $this->session->set_flashdata('alert','Anda Sudah Pernah Mendukung Laporan dengan <strong>Tracking ID : '.$id.'</strong>'); 

    }
    switch ($kemana[0]) {
        case 'main':
            redirect(base_url().'beranda');
        break;
        
        case 'laporanku':
            redirect(base_url().'laporanku');
        break;

        case 'baca':
            redirect(base_url().'laporan/'.$where[1]);
        break;

        case 'tl':
            redirect(base_url().'tindaklanjut/'.$where[1]);
        break;

        case 'next':
            redirect(base_url().'streams/0/'.$where[1]);
        break;

        case 'nextlap':
            redirect(base_url().'laporanku/'.$where[1]);
        break;
    } 
}

public function gantiprofil(){
    $sesi = $this->session->all_userdata();
    if(!isset($sesi['KEYTOKEN'])){
        redirect('/');
    }else{
        $url = 'https://www.lapor.go.id/index.php/api/lapor/userprofile';
        $email = ($this->input->post('email'))?"&email=".$this->input->post('email'):"";
        $firstname = ($this->input->post('firstname'))?"&first_name=".$this->input->post('firstname'):"";
        $lastname = ($this->input->post('lastname'))?"&last_name=".$this->input->post('lastname'):"";
        $phone = ($this->input->post('phone'))?"&phone=".$this->input->post('phone'):"";
        $sex = ($this->input->post('sex'))?"&sex=".$this->input->post('sex'):"";
        $birthday = ($this->input->post('birthday'))?"&birthday=".($this->input->post('birthday')):"";
        $no_id = ($this->input->post('no_id'))?"&no_id=".$this->input->post('no_id'):"";
        //echo $this->input->post('birthday');
        $var = "user_id=".$this->input->post('userid').$email.$firstname.$lastname.$phone.$sex.$birthday.$no_id;
        //echo $var;
        $result = $this->postCurl($url,$sesi['KEYTOKEN'],$var);
        //print_r($result);
        if($result['status']==0){
            $this->session->set_flashdata('alertTitle', 'Ganti Profil Gagal!');
            $this->session->set_flashdata('alertType','danger');
            $this->session->set_flashdata('alert', $result['msg']);    
        }else if($result['status']==1){
            $this->session->set_flashdata('alertTitle', 'Ganti Profil Berhasil!');
            $this->session->set_flashdata('alertType','success');
            $this->session->set_flashdata('alert', $result['msg']);
            $this->session->set_userdata('firstname', $this->input->post('firstname')); 
            $this->session->set_userdata('lastname', $this->input->post('lastname'));  

        }
        redirect('./profil/main');
    }
}

function postCurl($url,$token,$variable){
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL,$url);
    if($token != null){
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'KEYTOKEN: '.$token
            )); 
    }
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,$variable);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $out = curl_exec($ch);

    $info = curl_getinfo($ch);
    if($out === false)
    {
       print_r(curl_error($ch));
       echo 'Curl error: ' . curl_error($ch);
       curl_close($ch);

       return;

   }else{

    $out = json_decode($out,true);
        //print_r($info);

    curl_close ($ch);
    return $out;

}
}


function postMultiform($url,$token,$variable){
    //print_r($variable);
    $headers = array("Content-Type:multipart/form-data",'KEYTOKEN: '.$token); 
    $ch = curl_init();
    $options = array(
        CURLOPT_URL => $url,
        CURLOPT_HEADER => true,
        CURLOPT_POST => 1,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_POSTFIELDS => $variable,
            //CURLOPT_INFILESIZE => $filesize,
        CURLOPT_RETURNTRANSFER => true
        ); // cURL options
    curl_setopt_array($ch, $options);
    $out = curl_exec($ch);
    if(!curl_errno($ch))
    {
        $info = curl_getinfo($ch);
        if ($info['http_code'] == 200)
            $msg['code'] = 1;
        $msg['txt'] = "Sukses";
    }
    else
    {
        $msg['code'] = 0;
        $msg['txt'] = curl_error($ch);
    }
    curl_close($ch);
    return $msg;
}

function postMultiform2($url,$token,$variable){
    //print_r($variable);
    $headers = array("Content-Type:multipart/form-data",'KEYTOKEN: '.$token); 
    $ch = curl_init();
    $options = array(
        CURLOPT_URL => $url,
        CURLOPT_HEADER => true,
        CURLOPT_POST => 1,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_POSTFIELDS => $variable,
            //CURLOPT_INFILESIZE => $filesize,
        CURLOPT_RETURNTRANSFER => true
        ); // cURL options
    curl_setopt_array($ch, $options);
    $out = curl_exec($ch);
    if(!curl_errno($ch))
    {
        $info = curl_getinfo($ch);
        //print_r($info);
        if ($info['http_code'] == 200)
            $msg['code'] = 1;
        $msg['txt'] = "Sukses";
    }
    else
    {
        $msg['code'] = 0;
        $msg['txt'] = curl_error($ch);
    }
    curl_close($ch);
    $out = $this->processMultiformResult($out);
    return $out;
}

function processMultiformResult($string){
        $exploded = explode("{", $string);
        $exploded = explode("}", $exploded[1]);
        $exploded = explode(",", $exploded[0]);

        $out = array();
        $new;
        for($i = 0; $i < count($exploded); $i++){
            $newploded = explode(":",$exploded[$i]);
            $newploded[0] = substr($newploded[0],1,-1);
            $new[$newploded[0]]  = $newploded[1];

        }
        return $new;
}

function getCurl($url,$token){
        // Get cURL resource
    $curl = curl_init();
        // Set some options - we are passing in a useragent too here
    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $url,
        CURLOPT_HTTPHEADER => array('KEYTOKEN: '.$token)
        ));
        // Send the request & save response to $resp
    $resp = curl_exec($curl);

    $info = curl_getinfo($curl);
    //print_r($info);
    if($resp === false){
        echo 'Curl error: ' . curl_error($curl);
        curl_close($curl);
        //print_r($info);
        
        return;
    }else{
        // Close request to clear up some resources
        curl_close($curl);

        return $resp;
    }
}

function readmore($string){
    $array = array();
    $string = strip_tags($string);

    if (strlen($string) > 200) {

    // truncate string
        $stringCut = substr($string, 0, 200);

    // make sure it ends in a word so assassinate doesn't become ass...
        $array['isi'] = substr($stringCut, 0, strrpos($stringCut, ' '))."...";
        $array['isLong'] = true; 
    }else{

        $array['isi'] = $string;
        $array['isLong'] = false; 

    }
    return $array;
}

function reArrayFiles(&$file_post) {

    $file_ary = array();
    $file_count = count($file_post['name']);
    $file_keys = array_keys($file_post);

    for ($i=0; $i<$file_count; $i++) {
        foreach ($file_keys as $key) {
            $file_ary[$i][$key] = $file_post[$key][$i];
        }
    }

    return $file_ary;
}

}
