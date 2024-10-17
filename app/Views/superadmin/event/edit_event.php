<?= $this->extend('superadmin/sidebar') ?>

<?= $this->section('content') ?>
<div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
    <h1 class="text-2xl font-bold mb-6">Edit Event</h1>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="bg-red-500 text-white p-4 rounded mb-4">
            <?= session()->getFlashdata('error'); ?>
        </div>
    <?php endif; ?>

    <form action="<?= site_url('event/update') ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id_event" value="<?= $event['ID_EVENT'] ?>">

        <div class="mb-4">
            <label for="nama_event" class="block text-sm font-medium text-gray-700">Nama Event</label>
            <input type="text" id="nama_event" name="nama_event" 
                   value="<?= esc($event['NAMA_EVENT']) ?>" 
                   class="mt-1 px-4 py-2 w-full border rounded-md" required>
        </div>

        <div class="mb-4">
            <label for="kategori_id" class="block text-sm font-medium text-gray-700">Kategori Acara</label>
            <select id="kategori_id" name="kategori_id" 
                    class="mt-1 px-4 py-2 w-full border rounded-md" required>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['ID_KEVENT'] ?>" 
                        <?= $category['ID_KEVENT'] == $event['ID_KEVENT'] ? 'selected' : '' ?>>
                        <?= esc($category['KATEGORI_KEVENT']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-4">
            <label for="tanggal_event" class="block text-sm font-medium text-gray-700">Tanggal Event</label>
            <input type="date" id="tanggal_event" name="tanggal_event" 
                   value="<?= date('Y-m-d', strtotime($event['TANGGAL_EVENT'])) ?>" 
                   class="mt-1 px-4 py-2 w-full border rounded-md" required>
        </div>

        <div class="mb-4">
    <label for="jam_event" class="block text-sm font-medium text-gray-700">Jam Mulai</label>
    <input type="time" id="jam_event" name="jam_event" 
           value="<?= date('H:i', strtotime($event['JAM_EVENT'])) ?>" 
           class="mt-1 px-4 py-2 w-full border rounded-md" required>
</div>



        <div class="mb-4">
            <label for="deskripsi_event" class="block text-sm font-medium text-gray-700">Deskripsi Event</label>
            <textarea id="deskripsi_event" name="deskripsi_event" rows="4" 
                      class="mt-1 px-4 py-2 w-full border rounded-md"><?= esc($event['DEKSRIPSI_EVENT']) ?></textarea>
        </div>

        <div class="mb-4">
            <label for="foto_event" class="block text-sm font-medium text-gray-700">Poster Acara</label>
            <input type="file" id="foto_event" name="foto_event" 
                   class="mt-1 px-4 py-2 w-full border rounded-md" accept=".jpg,.jpeg,.png">
            <?php if ($event['FOTO_EVENT']): ?>
                <img src="<?= base_url('uploads/poster/' . $event['FOTO_EVENT']) ?>" 
                     alt="Poster Acara" class="w-16 h-24 mt-2 object-cover rounded-md">
            <?php endif; ?>
        </div>

        <div class="mt-6 flex justify-end space-x-4">
            <a href="<?= site_url('event/manage') ?>" 
               class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">Batal</a>
            <button type="submit" 
                    class="bg-indigo-500 text-white px-4 py-2 rounded-md hover:bg-indigo-600">Simpan</button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
