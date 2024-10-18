<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="container mx-auto px-8 py-12">
    <div class="border rounded-lg shadow-lg overflow-hidden">
        <img 
            src="<?= base_url('uploads/poster/' . (!empty($event['FOTO_EVENT']) ? $event['FOTO_EVENT'] : 'default.png')); ?>" 
            alt="<?= esc($event['NAMA_EVENT']); ?>" 
            class="object-cover w-full aspect-[2/3]">
        <div class="p-6">
            <h1 class="text-4xl font-bold"><?= esc($event['NAMA_EVENT']); ?></h1>
            <p class="text-gray-500">
                <?= formatTanggalIndonesia($event['TANGGAL_EVENT']); ?> - <?= date('H:i', strtotime($event['JAM_EVENT'])); ?>
            </p>
            <p class="mt-4"><?= esc($event['DEKSRIPSI_EVENT']); ?></p>
            <p class="mt-4"><strong>Kategori:</strong> <?= esc($event['KATEGORI_KEVENT']); ?></p>
            <a href="<?= site_url('event/index'); ?>" class="mt-4 block text-blue-500">← Back to home</a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
