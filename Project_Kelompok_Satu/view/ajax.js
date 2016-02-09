
            $('document').ready(function() {
                $('#btn').click(function() {
                    var nama = $('#nama').val();
                    var alamat = $('#alamat').val();
                    var umur = $('#umur').val();
                    var pendidikan = $('#pendidikan').val();
                    var data = 'nama=' + nama + '&alamat=' + alamat + '&umur=' + umur + '&pendidikan=' + pendidikan;
                    $.ajax({
                        type: 'POST',
                        url: "aksi-form.php",
                        data: data,
                        success: function() {
                            $('#tampil').load("proses.php");
                        }
                    });
                });
            });