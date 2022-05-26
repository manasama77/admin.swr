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
            Setting Perusahaan
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">User Management</a></li>
            <li class="active">Setting Perusahaan</li>
        </ol>
    </section>

    <form class="form-horizontal" id="form" enctype="multipart/form-data">
        <section class="content">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Ubah Data</h3>
                </div>
                <div class="box-body">
                    <div class="row">

                        <input type="hidden" class="form-control" id="islogofilename" name="islogofilename" value="0">
                        <input type="hidden" class="form-control" id="strlogofilename" name="strlogofilename" value="">
                        <input type="hidden" class="form-control" id="strlogopreview" name="strlogopreview" value="">
                        <input type="hidden" class="form-control" id="strsalesnotes" name="strsalesnotes" value="">

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Nama Perusahaan</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="companyname" name="companyname" value="<?php echo $header->company_name; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Alamat</label>
                            <div class="col-sm-4">
                                <textarea style="width:100%" rows="4" id="address" name="address"><?php echo $header->address; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Kota</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="city" name="city" value="<?php echo $header->city; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Telepon</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $header->phone; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Mobile</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="mobile" name="mobile" value="<?php echo $header->mobile; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="email" name="email" value="<?php echo $header->email; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Batas Penukarang Barang (hari)</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="salesexchangelimit" name="salesexchangelimit" value="<?php echo $header->sales_exchange_limit; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Minimal Pembelian Grosir</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="wholesalelimit" name="wholesalelimit" value="<?php echo $header->wholesale_limit; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Logo Perusahaan</label>
                            <div class="col-sm-4">
                                <input id="logo" name="logo" type="file">
                                <br />* Gambar dengan format .jpg / .jpeg / .png
                                <br />
                                <div id="logodownload"></div>
                                <div id="logopreview"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Catatan Struk Penjualan</label>
                            <div class="col-sm-8">
                                <textarea style="width:100%" rows="10" cols="9" id="salesnotes" name="salesnotes"><?php echo $header->sales_notes; ?></textarea>
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
    $(".select2").select2();

    $(document).ready(function() {
        CKEDITOR.replace('salesnotes');
    });

    function save_data() {
        var strsalesnotes = CKEDITOR.instances.salesnotes.getData();
        $('#strsalesnotes').val(strsalesnotes);

        var islogofilename = $('#islogofilename').html();
        var logodownload = $('#logodownload').html();

        var filename1 = $('#logo').val().replace(/.*(\/|\\)/, '');
        var extension1 = filename1.replace(/^.*\./, '');
        if (extension1 == filename1) {
            extension1 = '';
        } else {
            extension1 = extension1.toLowerCase();
        }

        var isvalid = false;
        if (
            (
                (islogofilename == 1) && (
                    (extension1 == "jpg") || (extension1 == "jpeg") || (extension1 == "png")
                )
            ) || (logodownload.length > 0) || (islogofilename == 0)) {
            isvalid = true;
        }

        if (!isvalid) {
            alert('logo yang diupload tidak menggunakan format yang diharuskan');
        } else {
            $('#btnSave').text('saving...'); //change button text
            $('#btnSave').attr('disabled', true); //set button disable 

            var url = "<?php echo site_url() ?>user_management/settings/ajax_update";
            var formtype = $('#formtype').val();

            $('#formtype').val("");
            var frm = $('#form');
            var frmData = new FormData(frm[0]);
            // ajax adding data to database
            $.ajax({
                url: url,
                type: "POST",
                data: frmData,
                contentType: false,
                processData: false,
                dataType: "JSON",
                success: function(data) {
                    if (data.status) //if success close modal and reload ajax table
                    {
                        Swal.fire({
                            icon: 'success',
                            title: "Notifikasi",
                            text: data.message,
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
        }
    }
</script>

<?php $this->load->view('template/footer'); ?>