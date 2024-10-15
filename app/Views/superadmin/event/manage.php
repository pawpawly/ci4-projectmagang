<?= $this->extend('superadmin/dashboard'); ?>

<?= $this->section('content'); ?>
<div class="bg-white p-6 rounded-lg shadow-md mt-6">
    <h1 class="text-2xl font-bold mb-4">Manajemen Event</h1>
    <p class="text-gray-600">Ini adalah halaman untuk mengelola event yang ada.</p>
    <table class="min-w-full mt-4 bg-white border">
        <thead>
            <tr class="bg-gray-100">
                <th class="px-4 py-2">Nama Event</th>
                <th class="px-4 py-2">Tanggal</th>
                <th class="px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr class="border-t">
                <td class="px-4 py-2">Event 1</td>
                <td class="px-4 py-2">2024-10-15</td>
                <td class="px-4 py-2">
                    <button class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600">Edit</button>
                    <button class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">Delete</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<?= $this->endSection(); ?>
