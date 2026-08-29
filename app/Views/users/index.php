<?= view('layouts/header', ['title' => 'Data User', 'active' => 'users']) ?>

<div class="page-header">
    <h5 class="mb-0">Data User</h5>
    <a href="<?= site_url('users/create') ?>" class="btn btn-primary">
        <i class="fa-solid fa-plus"></i> Tambah User
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table id="table-users" class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Dibuat Pada</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($users as $u): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= esc($u['username']) ?></td>
                        <td>
                            <span class="badge text-bg-<?= $u['role'] === 'admin' ? 'danger' : 'success' ?>"><?= ucfirst($u['role']) ?></span>
                        </td>
                        <td><?= esc($u['created_at'] ?? '-') ?></td>
                        <td class="text-nowrap">
                            <a href="<?= site_url('users/edit/' . $u['id']) ?>" class="btn btn-sm btn-outline-primary">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form action="<?= site_url('users/delete/' . $u['id']) ?>" method="post" class="d-inline delete-form">
                                <button type="submit" class="btn btn-sm btn-outline-danger" <?= $u['id'] === (int) session()->get('user_id') ? 'disabled' : '' ?>>
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
        $('#table-users').DataTable({
            order: [[0, 'asc']],
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/id.json'
            }
        });

        $('.delete-form').on('submit', function (e) {
            e.preventDefault();
            var form = this;
            Swal.fire({
                title: 'Hapus user?',
                text: 'User yang dihapus tidak dapat dikembalikan.',
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
