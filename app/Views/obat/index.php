<?= view('layouts/header', ['title' => 'Rekam Obat', 'active' => 'obat']) ?>

<div class="page-header">
    <h5 class="mb-0">Data Obat</h5>
    <a href="<?= site_url('obat/create') ?>" class="btn btn-primary">
        <i class="fa-solid fa-plus"></i> Tambah Obat
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table id="table-obat" class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Obat</th>
                    <th>Periode Stok</th>
                    <th>Stok Awal</th>
                    <th>Stok Masuk</th>
                    <th>Stok Keluar</th>
                    <th>Stok Akhir</th>
                    <th>Tgl Expired</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($obat as $o): ?>
                    <?php $st = status_expired($o['tanggal_expired']); ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= esc($o['nama_obat']) ?></td>
                        <td><?= esc($o['periode_stok']) ?></td>
                        <td><?= esc($o['stok_awal']) ?></td>
                        <td><?= esc($o['stok_masuk']) ?></td>
                        <td><?= esc($o['stok_keluar']) ?></td>
                        <td class="fw-semibold"><?= esc($o['stok_akhir']) ?></td>
                        <td><?= esc($o['tanggal_expired']) ?></td>
                        <td><span class="badge text-bg-<?= $st['badge'] ?>"><?= $st['label'] ?></span></td>
                        <td class="text-nowrap">
                            <a href="<?= site_url('obat/edit/' . $o['id']) ?>" class="btn btn-sm btn-outline-primary">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form action="<?= site_url('obat/delete/' . $o['id']) ?>" method="post" class="d-inline delete-form">
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#table-obat').DataTable({
            order: [[0, 'asc']],
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/id.json'
            }
        });

        $('.delete-form').on('submit', function (e) {
            e.preventDefault();
            var form = this;
            Swal.fire({
                title: 'Hapus data obat?',
                text: 'Data yang dihapus tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>

<?= view('layouts/footer') ?>
