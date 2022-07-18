<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container-fluid p-4">
        <div class="row mt-4">
            <div class="col-md-12">
                <h6>PT Rangkai Utama Berjaya</h6>
                <hr>
                <h3>Laporan Kehadiran Per Pegawai</h3>
                <table>
                    <tr>
                        <td width="40%">Periode</td>
                        <td>: <?= date('d F Y', strtotime($date1)) ?> sd. <?= date('d F Y', strtotime($date2)) ?></td>
                    </tr>
                    <tr>
                        <td width="40%">Nama Pegawai</td>
                        <td>: <?= count($laporan) > 0 ? $laporan[0]->name : '' ?></td>
                    </tr>
                    <tr>
                        <td width="40%">Jabatan</td>
                        <td>: <?= count($laporan) > 0 ? $laporan[0]->nama_jabatan : '' ?></td>
                    </tr>
                </table>
                <table class="table table-striped table-bordered mt-2">
                    <thead>
                        <tr>
                            <td>Tanggal</td>
                            <td>Jam Masuk</td>
                            <td>Ket.</td>
                            <td>Jam Pulang</td>
                            <td>Ket.</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($laporan as $v)
                            <tr>
                                <td>{{ date('d F Y, H:i', strtotime($v->created_at)) }}</td>
                                <td>{{ $v->jam_masuk }}</td>
                                <td>{{ $v->status_masuk == 'NOT_YET' ? 'Belum Absen' : ($v->status_masuk == 'ONTIME' ? 'Tepat Waktu' : 'LATE') }}</td>
                                <td>{{ $v->jam_pulang }}</td>
                                <td>{{ $v->status_pulang == 'NOT_YET' ? 'Belum Absen' : ($v->status_pulang == 'EARLYTIME' ? 'Terlalu Cepat' : ($v->status_pulang == 'ONTIME' ? 'Tepat Waktu' : 'Lembur')) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
		window.load = print_d();
		function print_d(){
			window.print();
		}
	</script>
</body>
</html>