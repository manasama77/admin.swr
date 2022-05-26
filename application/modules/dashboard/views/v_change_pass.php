<?php
$this->load->view('template/header');
?>
<!--tambahkan custom css disini-->
<?php
$this->load->view('template/topbar');
$this->load->view('template/sidebar');
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Ubah Password
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">User Management</a></li>
            <li class="active">Ubah Password</li>
        </ol>
    </section>

    <form action="#" id="form" class="form-horizontal">
        <section class="content">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Ubah Data</h3>
                </div>
                <div class="box-body">
                    <div class="row">

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Password Baru</label>
                            <div class="col-sm-4">
                                <input type="password" class="form-control" id="password1" name="password1">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Ketik Ulang Password Baru</label>
                            <div class="col-sm-4">
                                <input type="password" class="form-control" id="password2" name="password2">
                            </div>
                        </div>

                    </div>
                </div>
                <div class="box-footer">
                    <button type="button" id="btnSave" onclick="save_data()" class="btn btn-danger pull-right">Simpan</button>
                </div>
            </div>
        </section>
    </form>

</div>

<?php $this->load->view('template/js'); ?>

<script>
    function save_data() {
        $('#btnSave').text('saving...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable 
        var url = "<?php echo site_url() ?>dashboard/change_pass/ajax_update";
        var formtype = $('#formtype').val();

        $('#formtype').val("");
        var frm = $('#form');
        // ajax adding data to database
        $.ajax({
            url: url,
            type: "POST",
            data: frm.serialize(),
            dataType: "JSON",
            success: function(data) {
                if (data.status) //if success close modal and reload ajax table
                {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: "Notifikasi",
                        text: data.message,
                        toast: true,
                        timer: 2000,
                        showConfirmButton: false,
                    }).then(() => {
                        location.reload();
                    })
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: "Notifikasi",
                        text: data.message,
                    })
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('#btnSave').text('save');
                $('#btnSave').attr('disabled', false);
                Swal.fire({
                    icon: 'warning',
                    title: "Peringatan",
                    text: "Gagal Memproses Data",
                })
            }
        });

        $('#btnSave').text('Simpan'); //change button text
        $('#btnSave').attr('disabled', false); //set button disable 
    }
</script>

<?php $this->load->view('template/footer'); ?>