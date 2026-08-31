<?php
$resep = $resep ?? null;
$isEdit = $resep !== null;
?>
<?= view('layouts/header', ['title' => $isEdit ? 'Edit Resep' : 'Tambah Resep', 'active' => 'resep']) ?>

<div class="page-header">
    <h5 class="mb-0"><?= $isEdit ? 'Edit Resep' : 'Tambah Resep' ?></h5>
    <a href="<?= site_url('resep') ?>" class="btn btn-outline-secondary">
        <i class="fa-solid fa-arrow-left"></i> Kembali
    </a>
</div>

<?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach (session()->getFlashdata('errors') as $err): ?>
                <li><?= esc($err) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="<?= esc($action) ?>" method="post" autocomplete="off" id="form-resep">
    <div class="row g-3 mb-3">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white fw-semibold">Data Resep</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Nomor Resep</label>
                            <input type="text" class="form-control bg-light" readonly
                                   value="<?= esc($isEdit ? $resep['nomor_resep'] : ($nomor_resep ?? '')) ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Tanggal Resep <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_resep" class="form-control" required
                                   value="<?= esc($isEdit ? $resep['tanggal_resep'] : (old('tanggal_resep') ?: date('Y-m-d'))) ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Nama Apoteker <span class="text-danger">*</span></label>
                            <input type="text" name="nama_apoteker" class="form-control" required
                                   value="<?= esc($isEdit ? $resep['nama_apoteker'] : (old('nama_apoteker') ?: session()->get('username'))) ?>">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Nama Pasien <span class="text-danger">*</span></label>
                            <input type="text" name="nama_pasien" class="form-control" required
                                   value="<?= esc($isEdit ? $resep['nama_pasien'] : old('nama_pasien')) ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama Dokter <span class="text-danger">*</span></label>
                            <input type="text" name="nama_dokter" class="form-control" required
                                   value="<?= esc($isEdit ? $resep['nama_dokter'] : old('nama_dokter')) ?>">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Diagnosa</label>
                            <input type="text" name="diagnosa" class="form-control"
                                   value="<?= esc($isEdit ? ($resep['diagnosa'] ?? '') : old('diagnosa')) ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status Resep <span class="text-danger">*</span></label>
                            <select name="status" class="form-select" required>
                                <option value="Belum Diambil" <?= ($isEdit ? $resep['status'] : (old('status') ?: 'Belum Diambil')) === 'Belum Diambil' ? 'selected' : '' ?>>Belum Diambil</option>
                                <option value="Sudah Diambil" <?= ($isEdit ? $resep['status'] : old('status')) === 'Sudah Diambil' ? 'selected' : '' ?>>Sudah Diambil</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Catatan</label>
                            <textarea name="catatan" class="form-control" rows="2"><?= esc($isEdit ? ($resep['catatan'] ?? '') : old('catatan')) ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white fw-semibold">Panduan Stok</div>
                <div class="card-body small">
                    <ul class="mb-0 ps-3">
                        <li>Pilih obat lalu isi jumlah resep.</li>
                        <li>Stok obat akan <b>berkurang otomatis</b> sesuai jumlah.</li>
                        <li>Jika jumlah melebihi stok, resep <b>tidak dapat disimpan</b>.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <span class="fw-semibold">Detail Obat Resep</span>
            <button type="button" class="btn btn-sm btn-success" id="btn-tambah-obat">
                <i class="fa-solid fa-plus"></i> Tambah Obat
            </button>
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width:30%">Obat</th>
                        <th style="width:12%">Jumlah</th>
                        <th style="width:18%">Dosis</th>
                        <th>Aturan Pakai</th>
                        <th style="width:6%"></th>
                    </tr>
                </thead>
                <tbody id="detail-rows">
                </tbody>
            </table>
        </div>
        <div class="card-body border-top">
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-floppy-disk"></i> <?= $isEdit ? 'Simpan Perubahan' : 'Simpan Resep' ?>
            </button>
        </div>
    </div>
</form>

<?php
// =====================================================================
// Bagian JavaScript dipindah ke footer (setelah jQuery di-load)
// supaya tidak error "$ is not defined". Disusun lewat $inlineScript.
// =====================================================================
$scriptRows = '';
if ($isEdit) {
    foreach ($detail as $d) {
        $scriptRows .= "addRow(" . (int) $d['obat_id'] . ", " . (int) $d['jumlah'] . ", "
            . json_encode($d['dosis'] ?? '') . ", " . json_encode($d['aturan_pakai'] ?? '') . ");\n";
    }
} else {
    $oldObat = old('obat_id');
    if ($oldObat) {
        $oldJumlah = old('jumlah') ?: [];
        $oldDosis  = old('dosis') ?: [];
        $oldAturan = old('aturan_pakai') ?: [];
        foreach ($oldObat as $i => $oid) {
            if ((int) $oid > 0) {
                $scriptRows .= "addRow(" . (int) $oid . ", " . (int) ($oldJumlah[$i] ?? 0) . ", "
                    . json_encode($oldDosis[$i] ?? '') . ", " . json_encode($oldAturan[$i] ?? '') . ");\n";
            }
        }
    }
    if ($scriptRows === '') {
        $scriptRows = "addRow(null, null, null, null);\n";
    }
}

$obatJson = json_encode($obat);
$inlineScript = <<<EOS
    var obatList = {$obatJson};

    function obatOptions(selectedId) {
        var html = '';
        obatList.forEach(function (o) {
            var sel = String(selectedId) === String(o.id) ? 'selected' : '';
            html += '<option value="' + o.id + '" data-stok="' + o.stok_akhir + '" ' + sel + '>' +
                o.nama_obat + ' (Stok: ' + o.stok_akhir + ')</option>';
        });
        return html;
    }

    function addRow(obatId, jumlah, dosis, aturan) {
        var tr = \$('<tr>');
        tr.html(
            '<td>' +
                '<select name="obat_id[]" class="form-select">' +
                    '<option value="">-- Pilih Obat --</option>' + obatOptions(obatId) +
                '</select>' +
                '<div class="form-text text-muted small stok-info">Stok tersedia: -</div>' +
            '</td>' +
            '<td><input type="number" name="jumlah[]" class="form-control" min="1" value="' + (jumlah || '') + '" placeholder="0"></td>' +
            '<td><input type="text" name="dosis[]" class="form-control" value="' + (dosis || '') + '"></td>' +
            '<td><input type="text" name="aturan_pakai[]" class="form-control" value="' + (aturan || '') + '"></td>' +
            '<td class="text-center">' +
                '<button type="button" class="btn btn-sm btn-outline-danger btn-hapus-baris"><i class="fa-solid fa-xmark"></i></button>' +
            '</td>'
        );
        tr.find('select').on('change', function () {
            var opt = \$(this).find(':selected');
            var stok = opt.data('stok');
            tr.find('.stok-info').text('Stok tersedia: ' + (stok !== undefined ? stok : '-'));
            tr.find('input[name="jumlah[]"]').attr('max', stok !== undefined ? stok : '');
        });
        tr.find('.btn-hapus-baris').on('click', function () {
            tr.remove();
        });
        \$('#detail-rows').append(tr);

        if (obatId) {
            tr.find('select').trigger('change');
        }
    }

    \$(document).ready(function () {
        \$('#btn-tambah-obat').on('click', function () {
            addRow(null, null, null, null);
        });
{$scriptRows}    });
EOS;
?>

<?= view('layouts/footer', ['inlineScript' => $inlineScript]) ?>
