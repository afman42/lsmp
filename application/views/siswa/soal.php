<?php

if (empty($_SESSION['level']) AND empty($_SESSION['email'])){
  echo "<center><br><br><br><br><br><br>Maaf, untuk masuk <b>Halaman</b><br>
  <center>anda harus <b>Login</b> dahulu!<br><br>";
 echo "<div> <a href='index.php'><img src='images/kunci.png'  height=176 width=143></a>
             </div>";
  echo "<input type=button class='btn btn-primary' value='LOGIN DI SINI' onclick=location.href='".site_url('utama/login')."'></a></center>";
}
else{
?>

<html>
<header>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<meta name="description"  content=""/>
<meta name="keywords" content=""/>
<meta http-equiv="imagetoolbar" content="no"/>
<title>.::Halaman Ujian / Quiz ::.</title>
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.png">
  <link href="<?= base_url();?>/RuangAdmin/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="<?= base_url();?>/RuangAdmin/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <style type="text/css">
      table td, table td * {
    vertical-align: top;
}
  </style>
<script>
var waktunya;
waktunya = <?php echo "$_POST[waktu]"; ?> * 60;
var waktu;
var jalan = 0;
var habis = 0;
function init(){
    checkCookie()
    mulai();
}
function keluar(){
    if(habis==0){
        setCookie('waktux',waktu,365);
    }else{
        setCookie('waktux',0,-1);
    }
}
function mulai(){
    jam = Math.floor(waktu/3600);
    sisa = waktu%3600;
    menit = Math.floor(sisa/60);
    sisa2 = sisa%60
    detik = sisa2%60;
    if(detik<10){
        detikx = "0"+detik;
    }else{
        detikx = detik;
    }
    if(menit<10){
        menitx = "0"+menit;
    }else{
        menitx = menit;
    }
    if(jam<10){
        jamx = "0"+jam;
    }else{
        jamx = jam;
    }
    document.getElementById("divwaktu").innerHTML = jamx+" H : "+menitx+" M : "+detikx +" S";
    waktu --;
    if(waktu>0){
        t = setTimeout("mulai()",1000);
        jalan = 1;
    }else{
        if(jalan==1){
            clearTimeout(t);
        }
        habis = 1;
        // document.getElementById("formulir").submit();
    }
}
function selesai(){    
    if(jalan==1){
            clearTimeout(t);
        }
        habis = 1;
    // document.getElementById("formulir").submit();
}
function getCookie(c_name){
    if (document.cookie.length>0){
        c_start=document.cookie.indexOf(c_name + "=");
        if (c_start!=-1){
            c_start=c_start + c_name.length+1;
            c_end=document.cookie.indexOf(";",c_start);
            if (c_end==-1) c_end=document.cookie.length;
            return unescape(document.cookie.substring(c_start,c_end));
        }
    }
    return "";
}

function setCookie(c_name,value,expiredays){
    var exdate=new Date();
    exdate.setDate(exdate.getDate()+expiredays);
    document.cookie=c_name+ "=" +escape(value)+((expiredays==null) ? "" : ";expires="+exdate.toGMTString());
}

function checkCookie(){
    waktuy=getCookie('waktux');
    if (waktuy!=null && waktuy!=""){
        waktu = waktuy;
    }else{
        waktu = waktunya;
        setCookie('waktux',waktunya,7);
    }
}

</script>
<script type="text/javascript">
    window.history.forward();
    function noBack(){ window.history.forward(); }
</script>
<script type="text/javascript">
function tombol()
{
document.getElementById("tombol").innerHTML= "<input type=button value=Simpan onclick=selesai()>";
}
</script>
</header>
<body onload="init(),noBack();" onpageshow="if (event.persisted) noBack();" onunload="keluar()">
    <div class="container" style="margin-top: 50px;">
        <div class="row">
            <div class="col-md-4">
                <div class="card" style="width: 18rem; background-color: #a2b9de;">
                  <img class="card-img-top" src="<?= base_url('uploads/kelas.png');?>" alt="Card image cap">
                  <div class="card-body">
                    <h5 class="card-title">Sekolah</h5>
                    <p class="card-text">Sisa Waktu
                          <div id=divwaktu></div>
                    </p>
                  </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form action=nilai.php method=post id=formulir>

<?php
$user_id = $this->db->get_where('user',['level' => $_SESSION['level']])->row();
$cek_siswa = $this->db->query("SELECT * FROM siswa_mengerjakan WHERE ujian_id='$_POST[id]' AND siswa_id='$user_id->is_siswa'");
$info_siswa = $cek_siswa->row_array();
if ($info_siswa['hits']<= 0){
    $this->db->query("INSERT INTO siswa_mengerjakan (siswa_id,hits,ujian_id)
                                        VALUES ('$user_id->is_siswa',1,'$_POST[id]')");
}
elseif ($info_siswa[hits] > 0){
}

$soal = $this->db->query("SELECT *,soal.id as soal_id FROM ujian INNER JOIN soal ON ujian.id = soal.ujian_id where ujian.id='$_POST[id]' ORDER BY rand()");
$pilganda = $soal->num_rows();
// $soal_esay = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM quiz_esay WHERE id_tq='$_POST[id]'");
// $esay = mysqli_num_rows($soal_esay);
if (!empty($pilganda)){
echo "<b>Daftar Soal Pilihan Ganda</b>
    <table border=1>
    <input type=hidden name=id_topik value='$_POST[id]'>";

$no = 1;
// while($s = mysqli_fetch_array($soal)){
    foreach ($soal->result_array() as $s ) {
    // if ($s[gambar]!=''){
    echo "<tr>
            <td rowspan=5><h3>$no.</h3></td>
            <td><h3>".$s['pertanyaan']."</h3></td>
         </tr>";
    // echo "<tr><td><img src='foto_soal_pilganda/medium_$s[gambar]'></td></tr>";    
    echo "<tr>
            <td><input type=radio name=soal_pilganda[".$s['soal_id']."] value='A' required>".$s['pg_a']."</td>
          </tr>";
    echo "<tr>
            <td><input type=radio name=soal_pilganda[".$s['soal_id']."] value='B'>".$s['pg_b']."</td>
          </tr>";
    echo "<tr>
            <td><input type=radio name=soal_pilganda[".$s['soal_id']."] value='C'>C. ".$s['pg_c']."</td>
          </tr>";
    echo "<tr>
            <td><input type=radio name=soal_pilganda[".$s['soal_id']."] value='D'>D. ".$s['pg_d']."</td>
          </tr>";
    // }else{
    //     echo "<tr><td rowspan=5><h3>$no.</h3></td><td><h3>".$s['pertanyaan']."</h3></td></tr>";        
    //     echo "<tr><td><input type=radio name=soal_pilganda[".$s['id_quiz']."] value='A'>".$s['pil_a']."</td></tr>";
    //     echo "<tr><td><input type=radio name=soal_pilganda[".$s['id_quiz']."] value='B'>B. ".$s['pil_b']."</td></tr>";
    //     echo "<tr><td><input type=radio name=soal_pilganda[".$s['id_quiz']."] value='C'>C. ".$s['pil_c']."</td></tr>";
    //     echo "<tr><td><input type=radio name=soal_pilganda[".$s['id_quiz']."] value='D'>D. ".$s['pil_d']."</td></tr>";
    // }
    $no++;
}
echo "</table>";
$jumlahsoal = $no - 1;
echo "<input type=hidden name=jumlahsoalpilganda value=$jumlahsoal>";
}

elseif (empty($pilganda)){
    echo "<script>window.alert('Maaf belum ada soal di Topik Ini.');
            window.location.href='".site_url('siswa/ujian')."'</script>";
}
?>
<br>
<h5>
    Apakah anda sudah yakin dengan jawaban anda dan ingin menyimpannya?  
    <button type=button class="btn btn-sm btn-primary" onclick="tombol()">Ya</button></h5>
<h5 id="tombol"></h5>
</form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="<?= base_url();?>RuangAdmin/vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url();?>RuangAdmin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php } ?>