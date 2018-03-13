<html>
    <head>
        <title>
        Aplikasi penjualan
        </title>
    </head>
    <!--
      Joviandro
      plugin wNumb, jQuery
    -->
    <script src="assets/jquery.3.2.1.min.js"></script>
    <script src="assets/wNumb.js"></script>
    <script src="assets/bootstrap.min.js"></script>
    <script src="assets/jquery-ui.min.js"></script>
    <link rel="stylesheet" type="text/css" href="assets/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/jquery-ui.min.css">
    <link rel="stylesheet" type="text/css" href="assets/custom.css">
    <script>
    var moneyFormat = wNumb({
	mark: ',',
	thousand: '.',
	prefix: 'Rp. ',
	suffix: ' -,'
});
    // Inisialisasi ppn
sum_total_a = 0;
sum_ppn = 0;
    ppn = parseInt(1000);
    a=0
    function sum_total(a){
      jQuery.each(a, function(){ var t = moneyFormat.to( sum_total_a+=parseInt(a) )
        jQuery("#harga_total").text(t)
      })

    }
    function sum_total_ppn(a){
      jQuery.each(a, function(){ var t = moneyFormat.to( sum_ppn+=parseInt(a) + ppn)
        jQuery("#harga_total_ppn").text(t)
        }
      )
    }
    function sum_min(a){
      jQuery.each(a, function(){ var t = moneyFormat.to( sum_total_a -= parseInt(a) )
        jQuery("#harga_total").text(t)
      })
    }
    function sum_total_min_ppn(a){
      jQuery.each(a, function(){ var t = moneyFormat.to( sum_ppn -= parseInt(a) + ppn)
        jQuery("#harga_total_ppn").text(t)
        }
      )
    }
    function sum_kembalian(a){
      var y = moneyFormat.from( $("#harga_total_ppn").text() );
      var s = moneyFormat.from( $("#uang").val());
      if (s >= y){
        var g = s - y;
        var t = moneyFormat.to( g )
        $("#kembalian").html(t+"<button onclick='bayar()' class='btn btn-primary btn-sm ml-3'>Bayar</button>");
      }else{
        $("#kembalian").text("<span style='color:red;'>*Uang yang diberikan kurang</span>");
      }

    }
    function bayar(){
      alert("Terimakasih sudah membayar");
      var kod_bar = $("#tb_list").attr("data-tr");
      var gg = 
      console.log(kod_bar);
      $.ajax({
        type : "post",
        url: "php/add_transaksi",
        data : {kode_barang : kod_bar },
        success: function(data){
          console.log(data);
        }
      })
      hapus_list();

    }
    function add_tot(a){
      tot = new Array()
      tot.push(a);
      sum_total(tot);
      sum_total_ppn(tot);
    }
    function min_tot(a){
      // pEnuh dengan keajaiban
    }
    function hapus_list(){
      $("#barang_list").empty();
      $("#harga_total").empty();
      $("#harga_total_ppn").empty();
      $("#kembalian").empty();
      sum_total_a = 0;
      sum_ppn = 0;
    }
  function get_data(){

    var kode_barang = $("#kode_barang").val();
    var total= parseInt(0);
     $.ajax({
       type: "post",
       dataType: "json",
       url : "php/get_data.php",
       data : {kod_barang : kode_barang},
       success : function(data){
          $.each(data, function(i, n){
            var t = parseInt(n.harga_barang);

            add_tot(t);
            b = a++

            $("#barang_list").append(
              '<tr data='+b+' data-tr='+n.kode_barang+'><td>'+n.kode_barang+'</td><td>'+n.nama_barang+'</td><td>'+moneyFormat.to(t)+'</td><td><button class="btn btn-danger btn-sm" onclick="hapus_barang('+b+')">Hapus</button></td></tr>'
            )
          })
          $("#err").empty();
       },
       error : function(xhr, Status, err){
         $("#err").text("*Kode barang tidak terdaftar di database setempat");
       }
     });
  }

  function hapus_barang(a){
    var yy = $('tr[data='+a+']');
    var hapus = yy.empty();
    tot.splice(1,1);
    sum_min(tot);
    sum_total_min_ppn(tot);
  }
  function tambah_barang(){
    var nama_barang = $("#nama_barang").val();
    var harga_barang = moneyFormat.from($("#harga_barang").val());
    console.log(nama_barang)
      $.ajax({
        type: 'post',
        url : 'php/tambah_barang.php',
        data : {nama_bar : nama_barang, harga_bar : harga_barang},
        success : function(data){
            $("#hasil_tambah").text(nama_barang+" dengan harga "+harga_barang+" Berhasil ditambah");
        },
        error: function(xhr, Status, err){
          alert("Gagal");
        }
      })
  }

  function get_listbarang(){
    $.ajax({
      type: "get",
      url : 'php/list_barang.php',
       dataType: "json",
      success : function(data){
        console.log(data);

        $.each(data, function(i, n){
          var gg = parseInt(n.harga_barang);
          $("#jumlah_data").text(data.length);
          $("#tb_list").append('<tr><td>'+n.kode_barang+'</td><td>'+n.nama_barang+'</td><td>'+moneyFormat.to(gg)+'</td></tr>');
        })


        //var tt = JSON.stringify(data);

      },
      error: function(xhr, Status, err){
        console.log(err);
      }
    })
    $("#tb_list").empty();
  }
  $( function() {
      $( ".draggable1" ).draggable();
      $( "#draggable2" ).draggable();
      $( "#draggable3" ).draggable();
      $( ".draggable4" ).draggable();
      $( ".draggable5" ).draggable();

    } );
    </script>
    <body>
    <p id="as"></p>
        <div class="container-fluid m-2">
      <form action="javascript:void(0)" method="post">
        <div class="form-inline">
        <input type="text" maxlength="12" id="kode_barang" class="form-control w-70 draggable1" placeholder="Masukkan kode barang" value="">
        <button id="button" onclick="get_data()" class="btn btn-primary ml-2 draggable4">Ok</button><button id="hapus" onclick="hapus_list()" class="btn btn-danger ml-2 draggable5">Hapus list</button>
        <a href="" id="draggable2" class="btn btn-success ml-5" data-toggle="modal" data-target="#exampleModal">Tambah barang</a>
        <a href="" id="draggable3" class="btn btn-success ml-1" data-toggle="modal" data-target="#exampleModalListBarang">List barang</a>
        </div>
        <p class="mt-2" id="err" style="color:red;"></p>
      </form>
        <p class="mt-2">Daftar yang di input akan ditampilkan disini</p>
        <div class="row">
            <div class="col-md-6">
            <table border="1" class="table w-100">
                <thead>
                    <tr>
                        <th>Kode barang</th>
                        <th>Nama barang</th>
                        <th>Harga barang</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="barang_list">

                </tbody>
            </table>
            </div>
                <div class="col-md-6">
                    Total harga barang : <span id="harga_total"></span><br>
                    Total harga barang +(Ppn) : <span id="harga_total_ppn"></span><br>
                    <div class="form-inline">
                      Uang diberikan :
                      <input type="text" class="form-control form-control-sm ml-4 mr-3" id="uang" value=""><button class="btn btn-success btn-sm" onclick="sum_kembalian()">Hitung</button>
                    </div>
                    Jumlah kembalian : <span id="kembalian"></span><br>
                </div>
            </div>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambahkan barang</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="form-group">
    <label for="exampleInputEmail1">Nama barang</label>
    <input type="text" class="form-control" id="nama_barang" aria-describedby="emailHelp" placeholder="Masukkan nama barang">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Harga barang</label>
    <input type="number" class="form-control" id="harga_barang" aria-describedby="emailHelp" placeholder="Masukkan harga barang">
  </div>
  <p id="hasil_tambah"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="tambah_barang()" >Save changes</button>
      </div>
    </div>
  </div>
</div>

<!--kddfstysakldhgadjf -->

<div class="modal fade" id="exampleModalListBarang" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalListBarang">List barang</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">
<button onclick="get_listbarang()" class="btn btn-primary mb-2">Refresh</button>
<p class="float-right">Jumlah data : <span id="jumlah_data"></span></p>
<table class="table">
  <thead>
    <tr>
      <th>Kode barang</th>
      <th>Nama barang</th>
      <th>Harga barang</th>
    </tr>
  </thead>
  <tbody id="tb_list">
  </tbody>

</table>
<p id="list_barang"></p>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>
    </body>
</html>
