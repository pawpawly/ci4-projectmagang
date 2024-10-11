sadmin manajemen user


<?= $this->extend('superadmin/dashboard') ?>

<?= $this->section('content') ?>
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Users</h1>
    <<a href="<?= site_url('superadmin/user-management/add') ?>" class="bg-indigo-500 text-white px-4 py-2 rounded-md hover:bg-indigo-600">Tambah Pengguna</a>
</div>

<p class="mb-6 text-gray-600">Daftar semua pengguna di Website Anda termasuk nama, role, dan password mereka.</p>

<!-- Tabel User -->
<div class="overflow-x-auto">
    <table class="min-w-full bg-white shadow-md rounded-lg">
        <thead class="bg-gray-100">
            <tr>
                <th class="text-left py-2 px-4">Nama Lengkap</th>
                <th class="text-left py-2 px-4">Role</th>
                <th class="text-right py-2 px-4">Aksi</th>
            </tr>
        </thead>
        <tbody class="text-gray-700">
            <?php foreach ($users as $user): ?>
            <tr class="border-b">
                <td class="py-2 px-4"><?= esc($user['NAMA_USER']); ?></td>
                <td class="py-2 px-4">
                    <?php if ($user['LEVEL_USER'] == '1'): ?>
                        Admin
                    <?php elseif ($user['LEVEL_USER'] == '2'): ?>
                        Superadmin
                    <?php else: ?>
                        Member
                    <?php endif; ?>
                </td>
                <td class="py-2 px-4 text-right">
                    <!-- Button Edit -->
                    <a href="#" class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-green-600 mr-2">
                        Edit
                    </a>

                    <!-- Button Delete -->
                    <a href="#" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">
                        Delete
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>
