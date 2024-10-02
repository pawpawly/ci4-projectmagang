<?= $this->extend('superadmin/dashboard') ?>

<?= $this->section('content') ?>
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Users</h1>
    <a href="#" class="bg-indigo-500 text-white px-4 py-2 rounded-md hover:bg-indigo-600">Add user</a>
</div>

<p class="mb-6 text-gray-600">A list of all the users in your account including their name, role, and username.</p>

<!-- Tabel User -->
<div class="overflow-x-auto">
    <table class="min-w-full bg-white shadow-md rounded-lg">
        <thead class="bg-gray-100">
            <tr>
                <th class="text-left py-2 px-4">Name</th>
                <th class="text-left py-2 px-4">Title</th>
                <th class="text-left py-2 px-4">Email</th>
                <th class="text-left py-2 px-4">Role</th>
                <th class="text-right py-2 px-4">Action</th>
            </tr>
        </thead>
        <tbody class="text-gray-700">
            <?php foreach ($users as $user): ?>
            <tr class="border-b">
                <td class="py-2 px-4"><?= esc($user['NAMA_USER']); ?></td>
                <td class="py-2 px-4">-</td> <!-- Jika ada Title, tambahkan di database -->
                <td class="py-2 px-4"><?= esc($user['USERNAME']); ?>@example.com</td> <!-- Ubah sesuai field email -->
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
                    <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>
