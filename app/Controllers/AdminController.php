<?php

namespace App\Controllers;

use App\Models\UserModel; 
use App\Models\EventModel;
use App\Models\KategoriEventModel;
use App\Models\BeritaModel;
use App\Models\KoleksiModel;
use App\Models\KategoriKoleksiModel;
use App\Models\ReservasiModel;
use App\Models\BukuTamuModel;
use App\Models\BukuDigitalModel;    
use App\Models\SaranModel;
use CodeIgniter\Controller;
use App\Validation\CustomValidation;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class AdminController extends Controller
{
    protected $userModel;
    protected $beritaModel;
    protected $eventModel;
    protected $kategoriEventModel;
    protected $koleksiModel;
    protected $kategoriKoleksiModel;
    protected $reservasiModel;
    protected $bukuTamuModel;
    protected $bukuDigitalModel;
    protected $saranModel;
    protected $db;

    public function __construct()
    {
        $this->userModel = new UserModel(); 
        $this->eventModel = new EventModel();
        $this->kategoriEventModel = new KategoriEventModel();
        $this->beritaModel = new BeritaModel();
        $this->koleksiModel = new KoleksiModel();
        $this->kategoriKoleksiModel = new KategoriKoleksiModel();
        $this->reservasiModel = new ReservasiModel();
        $this->bukuTamuModel = new BukuTamuModel();
        $this->bukuDigitalModel = new BukuDigitalModel();
        $this->saranModel = new SaranModel();

        $this->db = \Config\Database::connect();

        helper(['url', 'form', 'month']);
        header("Cache-Control: no-cache, must-revalidate, max-age=0");
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    }


    public function dashboard()
    {
        
        $session = session();

        if ($session->get('LEVEL_USER') !== '1') {
            return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        $userModel = new \App\Models\UserModel();
    
        // Ambil USER_TOKEN dan USERNAME dari sesi
        $username = $session->get('username');
        $userToken = $session->get('USER_TOKEN');
    
        // Validasi sesi dan token di database
        $user = $userModel->where('USERNAME', $username)
                          ->where('USER_TOKEN', $userToken)
                          ->first();
        

        if (!$session->get('isLoggedIn') || !$user) {
            $session->destroy();
            return redirect()->to(site_url('login'))->with('error', 'Sesi Anda tidak valid atau telah berakhir.');
        }
    
        // Tangkap data statistik bulanan dan harian
        $year = $this->request->getGet('year') ?? date('Y');
        $date = $this->request->getGet('date') ?? date('Y-m-d');
    
        // Ambil tahun yang ada pada data
        $yearsQuery = $this->db->query("SELECT DISTINCT YEAR(TGLKUNJUNGAN_TAMU) AS tahun FROM bukutamu");
        $years = array_column($yearsQuery->getResultArray(), 'tahun');
        sort($years);
    
        // Statistik Bulanan
        $resultBulanan = $this->db->query("
            SELECT 
                MONTH(TGLKUNJUNGAN_TAMU) AS bulan, 
                SUM(JKL_TAMU) AS laki, 
                SUM(JKP_TAMU) AS perempuan
            FROM bukutamu 
            WHERE YEAR(TGLKUNJUNGAN_TAMU) = ?
            GROUP BY MONTH(TGLKUNJUNGAN_TAMU)
        ", [$year])->getResultArray();
    
        $dataBulanan = [
            'laki' => array_fill(0, 12, 0),
            'perempuan' => array_fill(0, 12, 0),
        ];
    
        foreach ($resultBulanan as $row) {
            $dataBulanan['laki'][$row['bulan'] - 1] = (int) $row['laki'];
            $dataBulanan['perempuan'][$row['bulan'] - 1] = (int) $row['perempuan'];
        }
    
        // Statistik Harian
        $resultHarian = $this->db->query("
            SELECT 
                SUM(JKL_TAMU) AS laki, 
                SUM(JKP_TAMU) AS perempuan 
            FROM bukutamu 
            WHERE DATE(TGLKUNJUNGAN_TAMU) = ?
        ", [$date])->getRowArray();
    
        $dataHarian = [
            'laki' => (int) ($resultHarian['laki'] ?? 0),
            'perempuan' => (int) ($resultHarian['perempuan'] ?? 0),
        ];
    
        // Tambahkan logika untuk statistik grid
        $pendingReservations = $this->reservasiModel->where('STATUS_RESERVASI', 'pending')->countAllResults();
        $totalCollections = $this->koleksiModel->countAllResults();
        $upcomingEvents = $this->eventModel->where('TANGGAL_EVENT >=', date('Y-m-d'))->countAllResults();
    
        // Kirim data ke view dashboard
        return view('admin/dashboard', [
            'dataBulanan' => $dataBulanan,
            'dataHarian' => $dataHarian,
            'year' => $year,
            'date' => $date,
            'years' => $years,
            'pendingReservations' => $pendingReservations,
            'totalCollections' => $totalCollections,
            'upcomingEvents' => $upcomingEvents,
        ]);
    }

    // ==========================
    // FUNGSI UNTUK MANAJEMEN BERITA
    // ==========================
    
    public function beritaManage()
    {
        $session = session();

        if ($session->get('LEVEL_USER') !== '1') {
            return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        // Ambil parameter filter dari request
        $search = $this->request->getGet('search');
        $month = $this->request->getGet('month');
        $year = $this->request->getGet('year');
    
        $perPage = 5; // Jumlah data per halaman
        $page = $this->request->getGet('page') ?? 1;
    
        // Query utama untuk berita dengan filter
        $beritaQuery = $this->beritaModel->select('berita.*');
    
        if (!empty($search)) {
            $beritaQuery->like('NAMA_BERITA', $search);
        }
    
        if (!empty($month)) {
            $beritaQuery->where('MONTH(TANGGAL_BERITA)', $month);
        }
    
        if (!empty($year)) {
            $beritaQuery->where('YEAR(TANGGAL_BERITA)', $year);
        }
    
        // Ambil data dengan paging
        $totalRecords = $beritaQuery->countAllResults(false); // Hitung total data dengan filter
        $totalPages = ceil($totalRecords / $perPage); // Total halaman
        $beritaQuery->orderBy('TANGGAL_BERITA', 'DESC');
        $berita = $beritaQuery->findAll($perPage, ($page - 1) * $perPage);
    
        // Ambil semua tahun unik dari database (terlepas dari paging dan filter)
        $allYears = $this->beritaModel
            ->select("DISTINCT YEAR(TANGGAL_BERITA) AS tahun", false)
            ->orderBy("tahun", "ASC")
            ->findAll();
    
        $uniqueYears = array_map(function ($item) {
            return $item['tahun'];
        }, $allYears);
    
        return view('admin/berita/manage', [
            'berita' => $berita,
            'search' => $search,
            'month' => $month,
            'year' => $year,
            'yearsRange' => $uniqueYears, // Tahun diambil dari semua data di database
            'page' => (int)$page,
            'totalPages' => $totalPages
        ]);
    }
    

    
    
    
    public function detailBerita($id)
    {
        $session = session();

        if ($session->get('LEVEL_USER') !== '1') {
            return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        // Ambil data berita berdasarkan ID
        $beritaModel = new BeritaModel();
        $berita = $beritaModel->find($id);
    
        if (!$berita) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Berita dengan ID $id tidak ditemukan.");
        }
    
        // Render view detail_berita
        return view('admin/berita/detail_berita', ['berita' => $berita]);
    }
    
    
    

    public function addBeritaForm()
    {
        $session = session();

        if ($session->get('LEVEL_USER') !== '1') {
            return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        return view('admin/berita/add_berita');
    }

    public function saveBerita()
    {
        // Validasi input
        $session = session();

        if ($session->get('LEVEL_USER') !== '1') {
            return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        $validation = \Config\Services::validation();
    
        $validation->setRules([
            'nama_berita' => 'required',
            'deskripsi_berita' => 'required',
            'sumber_berita' => 'required',
            'foto_berita' => 'uploaded[foto_berita]|is_image[foto_berita]|mime_in[foto_berita,image/jpg,image/jpeg,image/png]'
        ]);
    
        // Jika validasi gagal
        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Validasi gagal. ' . json_encode($validation->getErrors())
            ]);
        }
    
        // Ambil USERNAME dari session
        $username = session()->get('username');
    
        // Ambil NAMA_USER berdasarkan USERNAME
        $user = $this->userModel->where('USERNAME', $username)->first();
        if (!$user) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'User tidak ditemukan.'
            ]);
        }
    
        // Siapkan data berita untuk disimpan
        $data = [
            'USERNAME' => $username,
            'PENYIAR_BERITA' => $user['NAMA_USER'],
            'NAMA_BERITA' => $this->request->getPost('nama_berita'),
            'DESKRIPSI_BERITA' => $this->request->getPost('deskripsi_berita'),
            'SUMBER_BERITA' => $this->request->getPost('sumber_berita'),
            'TANGGAL_BERITA' => date('Y-m-d'),
        ];
    
        // Proses upload foto
        $foto = $this->request->getFile('foto_berita');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            try {
                $fotoName = $foto->getRandomName();
                $foto->move(FCPATH . 'uploads/berita/', $fotoName);
                $data['FOTO_BERITA'] = $fotoName;
            } catch (\Exception $e) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal memindahkan foto: ' . $e->getMessage()
                ]);
            }
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Foto tidak valid atau sudah dipindahkan.'
            ]);
        }
    
        // Simpan berita ke database
        try {
            $this->beritaModel->insert($data);
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Berita berhasil ditambahkan.'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal menyimpan berita: ' . $e->getMessage()
            ]);
        }
    }
    
    

    public function editBerita($id_berita)
    {
        $session = session();

        if ($session->get('LEVEL_USER') !== '1') {
            return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        $berita = $this->beritaModel->find($id_berita);

        if (!$berita) {
            return redirect()->to('admin/berita/manage')->with('error', 'Berita tidak ditemukan!');
        }

        return view('admin/berita/edit_berita', ['berita' => $berita]);
    }

    public function updateBerita()
    {
        $session = session();

        if ($session->get('LEVEL_USER') !== '1') {
            return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        $id_berita = $this->request->getPost('id_berita');
    
        // Aturan validasi
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama_berita' => 'required',
            'deskripsi_berita' => 'required',
            'sumber_berita' => 'required',
            'foto_berita' => 'permit_empty|is_image[foto_berita]|mime_in[foto_berita,image/jpg,image/jpeg,image/png]'
        ]);
    
        // Jika validasi gagal
        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Mohon isi semua field dengan benar.'
            ]);
        }
    
        // Data yang akan diperbarui
        $data = [
            'NAMA_BERITA' => $this->request->getPost('nama_berita'),
            'DESKRIPSI_BERITA' => $this->request->getPost('deskripsi_berita'),
            'SUMBER_BERITA' => $this->request->getPost('sumber_berita'),
        ];
    
        // Proses foto jika ada
        $foto = $this->request->getFile('foto_berita');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            // Hapus foto lama jika ada
            $fotoLama = $this->beritaModel->find($id_berita)['FOTO_BERITA'];
            if (is_file(FCPATH . 'uploads/berita/' . $fotoLama)) {
                unlink(FCPATH . 'uploads/berita/' . $fotoLama);
            }
    
            // Simpan foto baru
            $fotoName = $foto->getRandomName();
            $foto->move(FCPATH . 'uploads/berita/', $fotoName);
            $data['FOTO_BERITA'] = $fotoName;
        }
    
        // Update berita di database
        try {
            $this->beritaModel->update($id_berita, $data);
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Berita berhasil diperbarui.',
                'redirect' => site_url('admin/berita/manage')
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui berita: ' . $e->getMessage()
            ]);
        }
    }
    
    
    

    public function deleteBerita($id_berita)
    {
        $session = session();

        if ($session->get('LEVEL_USER') !== '1') {
            return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        try {
            $berita = $this->beritaModel->find($id_berita);
    
            if (!$berita) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Berita tidak ditemukan.'
                ]);
            }
    
            if (is_file(FCPATH . 'uploads/berita/' . $berita['FOTO_BERITA'])) {
                unlink(FCPATH . 'uploads/berita/' . $berita['FOTO_BERITA']);
            }
    
            $this->beritaModel->delete($id_berita);
    
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Berita berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }
    

    // ==========================
    // FUNGSI UNTUK MANAJEMEN KATEGORI EVENT
    // ==========================

    public function eventCategory()
    {
        $session = session();

        if ($session->get('LEVEL_USER') !== '1') {
            return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        $search = $this->request->getGet('search'); // Filter pencarian (opsional)
        $perPage = 10; // Jumlah data per halaman
        $page = $this->request->getGet('page') ?? 1; // Halaman saat ini, default halaman 1
    
        $categoryQuery = $this->kategoriEventModel;
    
        if (!empty($search)) {
            $categoryQuery->like('KATEGORI_KEVENT', $search); // Filter berdasarkan nama kategori
        }
    
        $totalRecords = $categoryQuery->countAllResults(false); // Total data tanpa reset query
        $totalPages = ceil($totalRecords / $perPage); // Total halaman
        $categoryQuery->orderBy('id_kevent', 'ASC'); // Urutkan berdasarkan id_kvent
        $categories = $categoryQuery->findAll($perPage, ($page - 1) * $perPage); // Ambil data dengan offset
    
        // Base URL untuk pagination
        $baseUrl = site_url('admin/event/category');
    
        // Query params untuk pagination
        $queryParams = [
            'search' => $search,
        ];
    
        return view('admin/event/category', [
            'categories' => $categories,
            'search' => $search,
            'page' => (int)$page,
            'totalPages' => $totalPages,
            'baseUrl' => $baseUrl,
            'queryParams' => $queryParams, // Kirim query params ke view
        ]);
    }
    

    public function addCategory()
    {
        $session = session();

        if ($session->get('LEVEL_USER') !== '1') {
            return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        // Ambil semua kategori dari database
        $categories = $this->kategoriEventModel->findAll();
    
        // Kirim data kategori ke view
        return view('admin/event/add_category', ['categories' => $categories]);
    }
    

    public function saveCategory()
    {
        $session = session();

        if ($session->get('LEVEL_USER') !== '1') {
            return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        $validation = \Config\Services::validation();
    
        $validation->setRules([
            'kategori_kevent' => 'required',
            'deskripsi_kevent' => 'required'
        ], [
            'kategori_kevent' => [
                'required' => 'Kategori event harus diisi.'
            ],
            'deskripsi_kevent' => [
                'required' => 'Deskripsi event harus diisi.'
            ]
        ]);
    
        if (!$validation->withRequest($this->request)->run()) {
            // Kembalikan JSON jika validasi gagal
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Semua field wajb diisi!'
            ]);
        }
    
        // Data yang akan disimpan
        $data = [
            'KATEGORI_KEVENT' => $this->request->getPost('kategori_kevent'),
            'DESKRIPSI_KEVENT' => $this->request->getPost('deskripsi_kevent')
        ];
    
        // Simpan ke database
        $this->kategoriEventModel->insert($data);
    
        // Kembalikan respons sukses
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Kategori berhasil ditambahkan.'
        ]);
    }
    
    
    
    public function editCategory($id_kevent)
    {
        $session = session();

        if ($session->get('LEVEL_USER') !== '1') {
            return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        $category = $this->kategoriEventModel->find($id_kevent);
    
        if (!$category) {
            return redirect()->to('admin/event/category')->with('error', 'Kategori tidak ditemukan.');
        }
    
        return view('admin/event/edit_category', ['category' => $category]);
    }
    
    public function updateCategory()
    {
        $session = session();

        if ($session->get('LEVEL_USER') !== '1') {
            return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        $id_kevent = $this->request->getPost('id_kevent');
        $data = [
            'KATEGORI_KEVENT' => $this->request->getPost('kategori_kevent'),
            'DESKRIPSI_KEVENT' => $this->request->getPost('deskripsi_kevent'),
        ];
    
        try {
            $this->kategoriEventModel->update($id_kevent, $data);
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Kategori berhasil diperbarui.'
            ]);
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal memperbarui kategori.'
            ]);
        }
    }
    
    
    public function deleteCategory($id_kevent)
    {
        $session = session();

        if ($session->get('LEVEL_USER') !== '1') {
            return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        try {
            // Cek apakah kategori masih digunakan di tabel event
            $eventCount = $this->db->table('event')
                ->where('ID_KEVENT', $id_kevent)
                ->countAllResults();
    
            if ($eventCount > 0) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Tidak bisa menghapus karena ada event yang terkait.'
                ]);
            }
    
            // Hapus kategori jika tidak ada event terkait
            $this->kategoriEventModel->delete($id_kevent);
    
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Kategori berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
    
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus kategori.'
            ]);
        }
    }
    


    // ==========================
    // FUNGSI UNTUK MANAJEMEN  EVENT
    // ==========================

    public function eventManage()
    {
        $session = session();

        if ($session->get('LEVEL_USER') !== '1') {
            return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        // Ambil filter dari request
        $search = $this->request->getGet('search');
        $category = $this->request->getGet('category');
        $month = $this->request->getGet('month');
        $year = $this->request->getGet('year');
        $perPage = 5;
        $page = $this->request->getGet('page') ?? 1;
    
        // Query untuk data event
        $eventsQuery = $this->eventModel
            ->select('event.*, kategori_event.KATEGORI_KEVENT as NAMA_KATEGORI')
            ->join('kategori_event', 'kategori_event.ID_KEVENT = event.ID_KEVENT', 'left');
    
        if (!empty($search)) {
            $eventsQuery->like('NAMA_EVENT', $search);
        }
        if (!empty($category)) {
            $eventsQuery->where('event.ID_KEVENT', $category);
        }
        if (!empty($month)) {
            $eventsQuery->where('MONTH(TANGGAL_EVENT)', $month);
        }
        if (!empty($year)) {
            $eventsQuery->where('YEAR(TANGGAL_EVENT)', $year);
        }
    
        // Pagination
        $totalRecords = $eventsQuery->countAllResults(false);
        $totalPages = ceil($totalRecords / $perPage);
        $events = $eventsQuery->orderBy('TANGGAL_EVENT', 'DESC')->findAll($perPage, ($page - 1) * $perPage);
    
        // Ambil semua tahun unik dari database
        $allYears = $this->eventModel
            ->select("DISTINCT YEAR(TANGGAL_EVENT) AS tahun", false)
            ->orderBy("tahun", "ASC")
            ->findAll();
    
        $yearsRange = array_map(function ($item) {
            return $item['tahun'];
        }, $allYears);
    
        // Ambil kategori event untuk filter kategori
        $categories = $this->kategoriEventModel->findAll();
    
        // Kirim data ke view
        return view('admin/event/manage', [
            'events' => $events,
            'search' => $search,
            'category' => $category,
            'categories' => $categories,
            'month' => $month,
            'year' => $year,
            'yearsRange' => $yearsRange, // Semua tahun dari database
            'page' => (int)$page,
            'totalPages' => $totalPages
        ]);
    }
    
    
    
    
    public function eventDetail($id)
    {
        $session = session();

        if ($session->get('LEVEL_USER') !== '1') {
            return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        $eventModel = new \App\Models\EventModel();
        $event = $eventModel->select('event.*, kategori_event.KATEGORI_KEVENT as NAMA_KATEGORI')
                            ->join('kategori_event', 'kategori_event.ID_KEVENT = event.ID_KEVENT', 'left')
                            ->where('event.ID_EVENT', $id)
                            ->first();
    
        if (!$event) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Event with ID $id not found");
        }
    
        return view('admin/event/detail_event', ['event' => $event]);
    }
    


    public function addEventForm()
    {
        $session = session();

        if ($session->get('LEVEL_USER') !== '1') {
            return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        $categories = $this->kategoriEventModel->findAll();
        return view('admin/event/add_event', ['categories' => $categories]);
    }

    public function saveEvent()
    {
        $session = session();
    
        if ($session->get('LEVEL_USER') !== '1') {
            return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
    
        // Ambil input tanggal event
        $tanggalEvent = date('Y-m-d', strtotime($this->request->getPost('tanggal_event')));
        
        // Cek konflik dengan reservasi yang sudah ada
        $existingReservation = $this->db->table('reservasi')
            ->where('TANGGAL_RESERVASI', $tanggalEvent)
            ->get()
            ->getRow();
    
        // Cek konflik dengan event yang sudah ada
        $existingEvent = $this->eventModel
            ->where('TANGGAL_EVENT', $tanggalEvent)
            ->first();
    
        // Jika ada konflik
        if ($existingReservation || $existingEvent) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Tanggal tersebut sudah ada event atau reservasi yang terjadwal.'
            ]);
        }
    
        // Proses upload poster
        $poster = $this->request->getFile('poster_event');
        $posterName = '';
        if ($poster->isValid() && !$poster->hasMoved()) {
            $posterName = $poster->getRandomName();
            $poster->move(FCPATH . 'uploads/poster/', $posterName);
        }
    
        // Data untuk disimpan
        $data = [
            'ID_KEVENT' => $this->request->getPost('kategori_acara'),
            'USERNAME' => session()->get('username'),
            'NAMA_EVENT' => $this->request->getPost('nama_event'),
            'DEKSRIPSI_EVENT' => $this->request->getPost('deskripsi_event'),
            'TANGGAL_EVENT' => $tanggalEvent,
            'JAM_EVENT' => $this->request->getPost('jam_event'),
            'FOTO_EVENT' => $posterName,
        ];
    
        // Simpan data ke database
        $this->eventModel->insert($data);
    
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Event berhasil ditambahkan.'
        ]);
    }
    
    
    public function editEvent($id_event)
    {
        $session = session();

        if ($session->get('LEVEL_USER') !== '1') {
            return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        $event = $this->eventModel->find($id_event);
        $categories = $this->kategoriEventModel->findAll();

        if (!$event) {
            return redirect()->to('admin/event/manage')->with('error', 'Event tidak ditemukan.');
        }

        return view('admin/event/edit_event', [
            'event' => $event,
            'categories' => $categories
        ]);
    }

    public function updateEvent()
    {
        $session = session();
    
        if ($session->get('LEVEL_USER') !== '1') {
            return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
    
        $id_event = $this->request->getPost('id_event');
        $tanggalEvent = date('Y-m-d', strtotime($this->request->getPost('tanggal_event')));
    
        // Validasi Konflik dengan Reservasi
        $existingReservation = $this->db->table('reservasi')
            ->where('TANGGAL_RESERVASI', $tanggalEvent)
            ->get()
            ->getRow();
    
        // Validasi Konflik dengan Event Lain (selain event yang sedang diupdate)
        $existingEvent = $this->eventModel
            ->where('TANGGAL_EVENT', $tanggalEvent)
            ->where('ID_EVENT !=', $id_event) // Abaikan event yang sedang diupdate
            ->first();
    
        // Jika terjadi konflik, kirim respon error
        if ($existingReservation || $existingEvent) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Tanggal tersebut sudah ada event atau reservasi yang terjadwal.'
            ]);
        }
    
        // Data untuk di-update
        $data = [
            'ID_KEVENT' => $this->request->getPost('kategori_id'),
            'NAMA_EVENT' => $this->request->getPost('nama_event'),
            'DEKSRIPSI_EVENT' => $this->request->getPost('deskripsi_event'),
            'TANGGAL_EVENT' => $tanggalEvent,
            'JAM_EVENT' => $this->request->getPost('jam_event'),
        ];
    
        // Cek apakah ada file foto yang diunggah
        $file = $this->request->getFile('foto_event');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Hapus foto lama jika ada
            $oldEvent = $this->eventModel->find($id_event);
            if (!empty($oldEvent['FOTO_EVENT'])) {
                $oldPosterPath = FCPATH . 'uploads/poster/' . $oldEvent['FOTO_EVENT'];
                if (is_file($oldPosterPath)) {
                    unlink($oldPosterPath);
                }
            }
    
            // Simpan foto baru
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/poster/', $newName);
            $data['FOTO_EVENT'] = $newName;
        }
    
        try {
            // Update data event di database
            $this->eventModel->update($id_event, $data);
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Event berhasil diperbarui.'
            ]);
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal memperbarui event.'
            ]);
        }
    }
    
    
    public function deleteEvent($id_event)
    {
        $session = session();

        if ($session->get('LEVEL_USER') !== '1') {
            return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        try {
            // Temukan event berdasarkan ID
            $event = $this->eventModel->find($id_event);
    
            if (!$event) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Event tidak ditemukan.'
                ]);
            }
    
            // Hapus file foto jika ada
            if (!empty($event['FOTO_EVENT'])) {
                $posterPath = FCPATH . 'uploads/poster/' . $event['FOTO_EVENT'];
                if (is_file($posterPath) && !unlink($posterPath)) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Gagal menghapus poster event.'
                    ]);
                }
            }
    
            // Hapus data event dari database
            $this->eventModel->delete($id_event);
    
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Event berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan pada server.'
            ]);
        }
    }
    
    



    // ==========================
    // FUNGSI UNTUK MANAJEMEN KATEGORI KOLEKSI
    // ==========================

    public function kategoriKoleksi()
    {
        $session = session();

        if ($session->get('LEVEL_USER') !== '1') {
            return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        // Konfigurasi pagination
        $perPage = 10; // Jumlah item per halaman
        $page = $this->request->getGet('page') ?? 1; // Halaman saat ini
        $search = $this->request->getGet('search'); // Parameter pencarian (opsional)
    
        // Query data kategori koleksi dengan pagination
        $categoriesQuery = $this->kategoriKoleksiModel;
    
        if (!empty($search)) {
            $categoriesQuery->like('nama_kategori', $search); // Sesuaikan dengan nama kolom di tabel
        }
    
        $totalRecords = $categoriesQuery->countAllResults(false); // Total data tanpa reset query builder
        $categories = $categoriesQuery->orderBy('id_kkoleksi', 'ASC') // Ganti 'id_koleksi' sesuai nama kolom di tabel Anda
                                       ->findAll($perPage, ($page - 1) * $perPage);
    
        $totalPages = ceil($totalRecords / $perPage); // Total halaman
    
        // Kirim data ke view
        return view('admin/koleksi/category', [
            'categories' => $categories,
            'page' => (int)$page,
            'totalPages' => $totalPages,
            'baseUrl' => site_url('admin/koleksi/category'),
            'queryParams' => '&search=' . ($search ?? '') // Tambahkan query params ke pagination
        ]);
    }
    

    // Menampilkan form tambah kategori koleksi
    public function addKategoriKoleksiForm()
    {
        $session = session();

        if ($session->get('LEVEL_USER') !== '1') {
            return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        return view('admin/koleksi/add_category');
    }

    // Menyimpan kategori koleksi baru
    public function saveKategoriKoleksi()
    {
        $session = session();

        if ($session->get('LEVEL_USER') !== '1') {
            return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        $validation = \Config\Services::validation();
    
        $validation->setRules([
            'kategori_kkoleksi' => 'required',
            'deskripsi_kkoleksi' => 'required'
        ], [
            'kategori_kkoleksi' => [
                'required' => 'Nama kategori tidak boleh kosong.'
            ],
            'deskripsi_kkoleksi' => [
                'required' => 'Deskripsi kategori tidak boleh kosong.'
            ]
        ]);
    
        // Jika validasi gagal
        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Semua field wajib diisi!'
            ]);
        }
    
        $data = [
            'KATEGORI_KKOLEKSI' => $this->request->getPost('kategori_kkoleksi'),
            'DESKRIPSI_KKOLEKSI' => $this->request->getPost('deskripsi_kkoleksi')
        ];
    
        // Simpan ke database
        $this->kategoriKoleksiModel->insert($data);
    
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Kategori berhasil ditambahkan.'
        ]);
    }
    
    // Menampilkan form edit kategori koleksi
    public function editKategoriKoleksi($id_kkoleksi)
    {
        $session = session();

        if ($session->get('LEVEL_USER') !== '1') {
            return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        $category = $this->kategoriKoleksiModel->find($id_kkoleksi);
    
        if (!$category) {
            return redirect()->to('admin/koleksi/category')->with('error', 'Kategori tidak ditemukan.');
        }
    
        return view('admin/koleksi/edit_category', ['category' => $category]);
    }
    
    public function updateKategoriKoleksi()
    {
        $session = session();

        if ($session->get('LEVEL_USER') !== '1') {
            return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        $validation = \Config\Services::validation();
    
        $validation->setRules([
            'kategori_kkoleksi' => 'required',
            'deskripsi_kkoleksi' => 'required',
        ], [
            'kategori_kkoleksi' => [
                'required' => 'Nama kategori tidak boleh kosong.',
            ],
            'deskripsi_kkoleksi' => [
                'required' => 'Deskripsi kategori tidak boleh kosong.',
            ],
        ]);
    
        // Jika validasi gagal, kembalikan respons JSON untuk SweetAlert2
        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Semua field wajib diisi!'
            ]);
        }
    
        $id_kkoleksi = $this->request->getPost('id_kkoleksi');
        $data = [
            'KATEGORI_KKOLEKSI' => $this->request->getPost('kategori_kkoleksi'),
            'DESKRIPSI_KKOLEKSI' => $this->request->getPost('deskripsi_kkoleksi'),
        ];
    
        try {
            $this->kategoriKoleksiModel->update($id_kkoleksi, $data);
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Kategori berhasil diperbarui.'
            ]);
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal memperbarui kategori.'
            ]);
        }
    }
    
    public function deleteKategoriKoleksi($id_kkoleksi)
    {
        $session = session();

        if ($session->get('LEVEL_USER') !== '1') {
            return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        try {
            // Cek apakah kategori ada
            $category = $this->kategoriKoleksiModel->find($id_kkoleksi);
            if (!$category) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Kategori tidak ditemukan.'
                ]);
            }
    
            // Cek apakah kategori masih digunakan di tabel koleksi
            $koleksiCount = $this->db->table('koleksi')
                ->where('ID_KKOLEKSI', $id_kkoleksi)
                ->countAllResults();
    
            if ($koleksiCount > 0) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Tidak bisa menghapus karena ada koleksi yang terkait.'
                ]);
            }
    
            // Hapus kategori jika tidak ada koleksi terkait
            $this->kategoriKoleksiModel->delete($id_kkoleksi);
    
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Kategori berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
    
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus kategori.'
            ]);
        }
    }
    


    
// ==========================
// FUNGSI UNTUK MANAJEMEN KOLEKSI
// ==========================

public function koleksiManage()
{
    $session = session();

    if ($session->get('LEVEL_USER') !== '1') {
        return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
    // Dapatkan nilai pencarian dan kategori dari request
    $search = $this->request->getGet('search');
    $category = $this->request->getGet('category');
    $perPage = 5; // Jumlah item per halaman
    $page = $this->request->getGet('page') ?? 1;

    // Query dasar dengan join ke tabel kategori
    $koleksiQuery = $this->koleksiModel
        ->select('koleksi.*, kategori_koleksi.KATEGORI_KKOLEKSI as NAMA_KATEGORI')
        ->join('kategori_koleksi', 'kategori_koleksi.ID_KKOLEKSI = koleksi.ID_KKOLEKSI', 'left');

    // Tambahkan pencarian jika ada input search
    if ($search) {
        $koleksiQuery = $koleksiQuery->like('koleksi.NAMA_KOLEKSI', $search);
    }

    // Tambahkan filter kategori jika ada input category
    if ($category) {
        $koleksiQuery = $koleksiQuery->where('kategori_koleksi.ID_KKOLEKSI', $category);
    }

    // Hitung total data dan total halaman
    $totalRecords = $koleksiQuery->countAllResults(false);
    $totalPages = ceil($totalRecords / $perPage);

    // Ambil data dengan limit dan offset
    $koleksi = $koleksiQuery->orderBy('koleksi.NAMA_KOLEKSI', 'ASC')
                            ->findAll($perPage, ($page - 1) * $perPage);

    // Ambil kategori untuk filter
    $categories = $this->kategoriKoleksiModel->findAll();

    return view('admin/koleksi/manage', [
        'koleksi' => $koleksi,
        'categories' => $categories,
        'search' => $search,
        'category' => $category,
        'page' => (int)$page,
        'totalPages' => $totalPages,
    ]);
}


public function koleksiDetail($id)
{
    $session = session();

    if ($session->get('LEVEL_USER') !== '1') {
        return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
    $koleksiModel = new \App\Models\KoleksiModel();

    // Ensure correct join with kategori_koleksi to get the KATEGORI_KKOLEKSI
    $collection = $koleksiModel->select('koleksi.*, kategori_koleksi.KATEGORI_KKOLEKSI')
                               ->join('kategori_koleksi', 'kategori_koleksi.ID_KKOLEKSI = koleksi.ID_KKOLEKSI', 'left')
                               ->where('koleksi.ID_KOLEKSI', $id)
                               ->first();

    if (!$collection) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Koleksi dengan ID $id tidak ditemukan.");
    }

    return view('admin/koleksi/detail_collection', ['collection' => $collection]);
}

public function addKoleksiForm()
{
    $session = session();

    if ($session->get('LEVEL_USER') !== '1') {
        return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
    $categories = $this->kategoriKoleksiModel->findAll();
    return view('admin/koleksi/add_collection', ['categories' => $categories]);
}

public function saveKoleksi()
{
    $session = session();

    if ($session->get('LEVEL_USER') !== '1') {
        return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
    $validation = \Config\Services::validation();

    $validation->setRules([
        'nama_koleksi' => 'required',
        'kategori_koleksi' => 'required',
        'deskripsi_koleksi' => 'required',
        'foto_koleksi' => 'uploaded[foto_koleksi]|is_image[foto_koleksi]|mime_in[foto_koleksi,image/jpg,image/jpeg,image/png]'
    ]);

    if (!$validation->withRequest($this->request)->run()) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Semua field wajib diisi!',
            'errors' => $validation->getErrors()
        ]);
    }

    $foto = $this->request->getFile('foto_koleksi');
    $fotoName = '';
    if ($foto->isValid() && !$foto->hasMoved()) {
        $fotoName = $foto->getRandomName();
        $foto->move(FCPATH . 'uploads/koleksi/', $fotoName);
    }

    $data = [
        'ID_KKOLEKSI' => $this->request->getPost('kategori_koleksi'),
        'NAMA_KOLEKSI' => $this->request->getPost('nama_koleksi'),
        'DESKRIPSI_KOLEKSI' => $this->request->getPost('deskripsi_koleksi'),
        'FOTO_KOLEKSI' => $fotoName
    ];

    $this->koleksiModel->insert($data);

    return $this->response->setJSON([
        'success' => true,
        'message' => 'Koleksi berhasil ditambahkan.'
    ]);
}


public function editKoleksi($id_koleksi)
{
    $session = session();

    if ($session->get('LEVEL_USER') !== '1') {
        return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
    $koleksi = $this->koleksiModel->find($id_koleksi);
    $categories = $this->kategoriKoleksiModel->findAll();

    if (!$koleksi) {
        return redirect()->to('admin/koleksi/manage')->with('error', 'Koleksi tidak ditemukan.');
    }

    return view('admin/koleksi/edit_collection', [
        'koleksi' => $koleksi,
        'categories' => $categories
    ]);
}



public function updateKoleksi()
{
    $session = session();

    if ($session->get('LEVEL_USER') !== '1') {
        return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
    $id_koleksi = $this->request->getPost('id_koleksi');

    // Konfigurasi validasi
    $validation = \Config\Services::validation();
    $validation->setRules([
        'nama_koleksi' => 'required',
        'kategori_koleksi' => 'required',
        'deskripsi_koleksi' => 'required',
        'foto_koleksi' => 'permit_empty|is_image[foto_koleksi]|mime_in[foto_koleksi,image/jpg,image/jpeg,image/png]'
    ]);

    // Jika validasi gagal
    if (!$validation->withRequest($this->request)->run()) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Semua field wajib diisi!',
            'errors' => $validation->getErrors()
        ]);
    }

    // Siapkan data untuk update
    $data = [
        'ID_KKOLEKSI' => $this->request->getPost('kategori_koleksi'),
        'NAMA_KOLEKSI' => $this->request->getPost('nama_koleksi'),
        'DESKRIPSI_KOLEKSI' => $this->request->getPost('deskripsi_koleksi')
    ];

    // Proses upload foto (jika ada)
    $file = $this->request->getFile('foto_koleksi');
    if ($file && $file->isValid() && !$file->hasMoved()) {
        // Hapus foto lama jika ada
        $oldKoleksi = $this->koleksiModel->find($id_koleksi);
        if (!empty($oldKoleksi['FOTO_KOLEKSI'])) {
            $oldFotoPath = FCPATH . 'uploads/koleksi/' . $oldKoleksi['FOTO_KOLEKSI'];
            if (is_file($oldFotoPath)) {
                unlink($oldFotoPath);
            }
        }

        // Simpan foto baru
        $newName = $file->getRandomName();
        $file->move(FCPATH . 'uploads/koleksi/', $newName);
        $data['FOTO_KOLEKSI'] = $newName;
    }

    // Update koleksi di database
    try {
        $this->koleksiModel->update($id_koleksi, $data);
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Koleksi berhasil diperbarui.'
        ]);
    } catch (\Exception $e) {
        log_message('error', $e->getMessage());
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Gagal memperbarui koleksi.'
        ]);
    }
}


public function deleteKoleksi($id_koleksi)
{
    $session = session();

    if ($session->get('LEVEL_USER') !== '1') {
        return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
    try {
        // Cek apakah koleksi ditemukan
        $koleksi = $this->koleksiModel->find($id_koleksi);

        if (!$koleksi) {
            log_message('error', 'Koleksi tidak ditemukan dengan ID: ' . $id_koleksi);
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Koleksi tidak ditemukan.'
            ]);
        }

        // Hapus foto jika ada
        if (!empty($koleksi['FOTO_KOLEKSI'])) {
            $fotoPath = FCPATH . 'uploads/koleksi/' . $koleksi['FOTO_KOLEKSI'];
            if (is_file($fotoPath)) {
                unlink($fotoPath);
            }
        }

        // Hapus koleksi dari database
        $this->koleksiModel->delete($id_koleksi);
        log_message('info', 'Koleksi berhasil dihapus dengan ID: ' . $id_koleksi);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Koleksi berhasil dihapus.'
        ]);
    } catch (\Exception $e) {
        log_message('error', 'Gagal menghapus koleksi: ' . $e->getMessage());
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Gagal menghapus koleksi.'
        ]);
    }
}




// ==========================
// FUNGSI UNTUK MANAJEMEN RESERVASI
// ==========================

public function reservationManage()
{
    $session = session();

    if ($session->get('LEVEL_USER') !== '1') {
        return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
    $search = $this->request->getGet('search');
    $status = $this->request->getGet('status');
    $bulan = $this->request->getGet('bulan');
    $tahun = $this->request->getGet('tahun');
    $perPage = 10; // Jumlah data per halaman
    $page = $this->request->getGet('page') ?? 1;

    $reservasiQuery = $this->reservasiModel;

    if ($search) {
        $reservasiQuery->like('NAMA_RESERVASI', $search)
                       ->orLike('INSTANSI_RESERVASI', $search);
    }

    if ($status) {
        $reservasiQuery->where('STATUS_RESERVASI', $status);
    }

    if ($bulan) {
        $reservasiQuery->where('MONTH(TANGGAL_RESERVASI)', $bulan);
    }

    if ($tahun) {
        $reservasiQuery->where('YEAR(TANGGAL_RESERVASI)', $tahun);
    }

    $totalRecords = $reservasiQuery->countAllResults(false);
    $totalPages = ceil($totalRecords / $perPage);
    $reservasiQuery->orderBy('TANGGAL_RESERVASI', 'DESC');
    $reservasi = $reservasiQuery->findAll($perPage, ($page - 1) * $perPage);

    // Ambil semua tahun unik untuk filter dropdown
    $allYears = $this->reservasiModel
        ->select("DISTINCT YEAR(TANGGAL_RESERVASI) AS tahun", false)
        ->orderBy("tahun", "ASC")
        ->findAll();

    $yearsRange = array_map(function ($item) {
        return $item['tahun'];
    }, $allYears);

    // Base URL untuk pagination
    $baseUrl = site_url('admin/reservasi/manage');

    // Query params
    $queryParams = [
        'search' => $search,
        'bulan' => $bulan,
        'tahun' => $tahun,
    ];

    return view('admin/reservasi/manage', [
        'reservasi' => $reservasi,
        'search' => $search,
        'status' => $status,
        'bulan' => $bulan,
        'tahun' => $tahun,
        'yearsRange' => $yearsRange,
        'page' => (int)$page,
        'totalPages' => $totalPages,
        'baseUrl' => $baseUrl,
        'queryParams' => $queryParams, // Kirim query params ke view
    ]);
}


public function detail_reservasi($id)
{
    $session = session();

    if ($session->get('LEVEL_USER') !== '1') {
        return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
    // Mengambil data reservasi berdasarkan ID
    $reservasi = $this->reservasiModel->find($id);

    // Jika data reservasi tidak ditemukan, tampilkan halaman 404
    if (!$reservasi) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Reservasi dengan ID $id tidak ditemukan.");
    }

    // Mengirim data ke view detail_reservasi.php
    return view('admin/reservasi/detail_reservasi', [
        'reservasi' => $reservasi
    ]);
}

public function updateStatus($id_reservasi)
{
    $session = session();

    if ($session->get('LEVEL_USER') !== '1') {
        return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
    $status = $this->request->getVar('status_reservasi');

    if (!in_array($status, ['setuju', 'tolak', 'pending'])) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Status tidak valid.'
        ]);
    }

    $reservasi = $this->reservasiModel->find($id_reservasi);

    if (!$reservasi) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Data reservasi tidak ditemukan.'
        ]);
    }

    // Update status reservasi
    $this->reservasiModel->update($id_reservasi, ['STATUS_RESERVASI' => $status]);

    return $this->response->setJSON([
        'success' => true,
        'message' => 'Status reservasi berhasil diperbarui.',
        'status' => $status
    ]);
}



public function deleteReservation($id_reservasi)
{
    $session = session();

    if ($session->get('LEVEL_USER') !== '1') {
        return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
    try {
        // Ambil data reservasi untuk mendapatkan path file sebelum menghapus
        $reservasi = $this->reservasiModel->find($id_reservasi);

        // Periksa apakah data reservasi ditemukan
        if (!$reservasi) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data reservasi tidak ditemukan.'
            ]);
        }

        // Hapus file terkait jika ada
        if (!empty($reservasi['SURAT_RESERVASI'])) {
            $filePath = FCPATH . 'uploads/surat_kunjungan/' . $reservasi['SURAT_RESERVASI'];
            if (is_file($filePath)) {
                unlink($filePath); // Hapus file dari server
            }
        }

        // Hapus data dari database
        $deleted = $this->reservasiModel->delete($id_reservasi);

        if ($deleted) {
            return $this->response->setJSON(['success' => true, 'message' => 'Reservasi berhasil dihapus.']);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal menghapus data reservasi.'
            ]);
        }
    } catch (\Exception $e) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Terjadi kesalahan: ' . $e->getMessage()
        ]);
    }
}




// ==========================
// FUNGSI UNTUK MANAJEMEN BUKU TAMU
// ==========================


public function manageBukuTamu()
{
    $session = session();

    if ($session->get('LEVEL_USER') !== '1') {
        return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
    $search = $this->request->getGet('search');
    $tipeTamu = $this->request->getGet('tipe_tamu');
    $bulan = $this->request->getGet('bulan');
    $tahun = $this->request->getGet('tahun');
    $perPage = 15;
    $page = $this->request->getGet('page') ?? 1;

    $bukuTamuQuery = $this->bukuTamuModel;

    if ($search) {
        $bukuTamuQuery->like('NAMA_TAMU', $search);
    }
    if ($tipeTamu) {
        $bukuTamuQuery->where('TIPE_TAMU', $tipeTamu);
    }
    if ($bulan) {
        $bukuTamuQuery->where('MONTH(TGLKUNJUNGAN_TAMU)', $bulan);
    }
    if ($tahun) {
        $bukuTamuQuery->where('YEAR(TGLKUNJUNGAN_TAMU)', $tahun);
    }

    // Jika ada parameter export, lakukan ekspor ke Excel
    if ($this->request->getGet('export')) {
        $data = $bukuTamuQuery->orderBy('TGLKUNJUNGAN_TAMU', 'DESC')->findAll();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $sheet->setCellValue('A1', 'ID Tamu');
        $sheet->setCellValue('B1', 'Nama Tamu');
        $sheet->setCellValue('C1', 'Tipe Tamu');
        $sheet->setCellValue('D1', 'Alamat Tamu');
        $sheet->setCellValue('E1', 'No HP');
        $sheet->setCellValue('F1', 'Tanggal Kunjungan');
        $sheet->setCellValue('G1', 'Jumlah Tamu Laki-Laki');
        $sheet->setCellValue('H1', 'Jumlah Tamu Perempuan');

        // Data
        $row = 2;
        $id = 1; // Mulai dari 1
        foreach ($data as $tamu) {
            $sheet->setCellValue('A' . $row, $id);
            $sheet->setCellValue('B' . $row, $tamu['NAMA_TAMU']);
            $sheet->setCellValue('C' . $row, $tamu['TIPE_TAMU'] == '1' ? 'Individual' : 'Instansi');
            $sheet->setCellValue('D' . $row, $tamu['ALAMAT_TAMU']);
            $sheet->setCellValue('E' . $row, $tamu['NOHP_TAMU']);
            $sheet->setCellValue('F' . $row, $tamu['TGLKUNJUNGAN_TAMU']);
            $sheet->setCellValue('G' . $row, $tamu['JKL_TAMU']);
            $sheet->setCellValue('H' . $row, $tamu['JKP_TAMU']);
            $row++;
            $id++;
        }

        // Generate file
        $writer = new Xlsx($spreadsheet);
        $fileName = 'Data_Buku_Tamu.xlsx';

        // Send file to browser for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    $totalRecords = $bukuTamuQuery->countAllResults(false);
    $totalPages = ceil($totalRecords / $perPage);
    $bukuTamuQuery->orderBy('TGLKUNJUNGAN_TAMU', 'DESC');
    $bukutamu = $bukuTamuQuery->findAll($perPage, ($page - 1) * $perPage);

    // Ambil semua tahun unik dari tabel bukutamu
    $allYears = $this->bukuTamuModel
        ->select("DISTINCT YEAR(TGLKUNJUNGAN_TAMU) AS tahun", false)
        ->orderBy("tahun", "ASC")
        ->findAll();

    $uniqueYears = array_map(function ($item) {
        return $item['tahun'];
    }, $allYears);

    return view('admin/bukutamu/manage', [
        'bukutamu' => $bukutamu,
        'search' => $search,
        'tipeTamu' => $tipeTamu,
        'bulan' => $bulan,
        'tahun' => $tahun,
        'page' => (int)$page,
        'totalPages' => $totalPages,
        'uniqueYears' => $uniqueYears // Kirim semua tahun ke view
    ]);
}




    // Hapus data buku tamu
    public function deleteBukuTamu($id_tamu)
    {
        $session = session();

        if ($session->get('LEVEL_USER') !== '1') {
            return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        try {
            // Find the guest data
            $tamu = $this->bukuTamuModel->find($id_tamu);
    
            if (!$tamu) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Data tamu tidak ditemukan.'
                ]);
            }
    
            // Check if the photo is not the default photo and delete it
            $fotoTamu = $tamu['FOTO_TAMU']; // Assuming 'FOTO_TAMU' contains the photo path
            
            // Do not delete if the photo is the default one
            if ($fotoTamu !== 'uploads/foto_tamu/default.png' && file_exists(FCPATH . $fotoTamu)) {
                // Delete the photo file
                unlink(FCPATH . $fotoTamu);
            }
    
            // Delete the guest data
            $this->bukuTamuModel->delete($id_tamu);
    
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Data tamu berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
    
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan pada server.'
            ]);
        }
    }
    
    public function detailGuestBook($id_tamu)
    {
        $session = session();

        if ($session->get('LEVEL_USER') !== '1') {
            return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        // Load model
        $bukuTamuModel = new BukuTamuModel();
    
        // Find guest by ID
        $tamu = $bukuTamuModel->find($id_tamu);
    
        if (!$tamu) {
            return redirect()->to('/admin/bukutamu/manage')->with('error', 'Data tamu tidak ditemukan.');
        }
    
        // Pass the data to the view
        return view('admin/bukutamu/detail_guestbook', [
            'tamu' => $tamu
        ]);
    }
    


public function grantGuestbookAccess()
{
    $session = session();

    if ($session->get('LEVEL_USER') !== '1') {
        return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
    // Set session khusus untuk autentikasi buku tamu
    session()->set('guestbook_auth', true);

    // Hapus sesi login untuk mencegah akses kembali ke halaman admin
    session()->remove('isLoggedIn');
    
    // Redirect langsung ke form buku tamu
    return redirect()->to('/bukutamu/form');
}


public function form()
{
    $session = session();

    if ($session->get('LEVEL_USER') !== '1') {
        return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
    // Tampilkan form buku tamu tanpa menghapus sesi guestbook_auth
    return view('bukutamu/form_guestbook');
}

    
// ==========================
// FUNGSI UNTUK MANAJEMEN BUKU DIGITAL
// ==========================


public function manageBukuDigital()
{
    $session = session();

    if ($session->get('LEVEL_USER') !== '1') {
        return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
    // Ambil parameter filter dari request
    $search = $this->request->getGet('search');
    $perPage = 5; // Jumlah data per halaman
    $page = $this->request->getGet('page') ?? 1;

    // Query untuk data buku digital
    $bukudigitalQuery = $this->bukuDigitalModel;

    // Jika ada input pencarian, filter berdasarkan judul dan penulis
    if ($search) {
        $bukudigitalQuery = $bukudigitalQuery
            ->groupStart()
            ->like('JUDUL_BUKU', $search)
            ->orLike('PENULIS_BUKU', $search)
            ->groupEnd();
    }

    // Hitung total data
    $totalRecords = $bukudigitalQuery->countAllResults(false);

    // Hitung total halaman
    $totalPages = ceil($totalRecords / $perPage);

    // Ambil data dengan limit dan offset
    $bukudigital = $bukudigitalQuery
        ->orderBy('JUDUL_BUKU', 'ASC') // Urutkan jika diperlukan
        ->findAll($perPage, ($page - 1) * $perPage);

    return view('admin/bukudigital/manage', [
        'bukudigital' => $bukudigital,
        'search' => $search,
        'page' => (int)$page,
        'totalPages' => $totalPages
    ]);
}




    public function addBukuDigital()
    {
        $session = session();

        if ($session->get('LEVEL_USER') !== '1') {
            return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        return view('admin/bukudigital/add_bukudigital');
    }

    // Function to save the digital book
    public function saveBukuDigital()
    {
        $session = session();

        if ($session->get('LEVEL_USER') !== '1') {
            return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        $validation = \Config\Services::validation();
    
        $validation->setRules([
            'judul_buku'   => 'required|max_length[255]',
            'penulis_buku' => 'required|max_length[64]',
            'tahun_buku'   => 'required|valid_date[Y]',
            'sinopsis_buku'=> 'required',
            'sampul_buku'  => 'uploaded[sampul_buku]|is_image[sampul_buku]|mime_in[sampul_buku,image/png,image/jpeg,image/jpg]',
            'produk_buku'  => 'uploaded[produk_buku]|mime_in[produk_buku,application/pdf]'
        ]);
    
        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Validation failed: ' . json_encode($validation->getErrors()),
            ]);
        }
    
        // File handling
        $sampul = $this->request->getFile('sampul_buku');
        $produk = $this->request->getFile('produk_buku');
    
        $sampulName = $sampul->getRandomName();
        $produkName = $produk->getRandomName();
    
        try {
            // Move the files
            $sampul->move(FCPATH . 'uploads/bukudigital/sampul', $sampulName);
            $produk->move(FCPATH . 'uploads/bukudigital/pdf', $produkName);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'File upload error: ' . $e->getMessage(),
            ]);
        }
    
        // Prepare data for database insertion
        $data = [
            'JUDUL_BUKU' => $this->request->getPost('judul_buku'),
            'PENULIS_BUKU' => $this->request->getPost('penulis_buku'),
            'TAHUN_BUKU' => $this->request->getPost('tahun_buku'),
            'SINOPSIS_BUKU' => $this->request->getPost('sinopsis_buku'),
            'SAMPUL_BUKU' => $sampulName,
            'PRODUK_BUKU' => $produkName,
        ];
    
        // Attempt to insert data into the database
        try {
            $inserted = $this->bukuDigitalModel->insert($data);
            if ($inserted === false) {
                // Log the error if insertion fails
                log_message('error', 'Database error: ' . json_encode($this->bukuDigitalModel->errors()));
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to save digital book. Database error: ' . json_encode($this->bukuDigitalModel->errors()),
                ]);
            }
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Buku digital berhasil ditambahkan.',
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Database exception: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to save digital book. Exception: ' . $e->getMessage(),
            ]);
        }
    }

    public function viewBukuDigital($id)
{
    $session = session();

    if ($session->get('LEVEL_USER') !== '1') {
        return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
    // Load the book details from the database
    $book = $this->bukuDigitalModel->find($id);

    // Check if the book exists
    if (!$book) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException("Book with ID $id not found");
    }

    // Pass the book data to the view
    return view('admin/bukudigital/view_buku_digital', ['book' => $book]);
}

public function editBukuDigital($id_buku)
{
    $session = session();

    if ($session->get('LEVEL_USER') !== '1') {
        return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
    $book = $this->bukuDigitalModel->find($id_buku);

    if (!$book) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Buku Digital dengan ID $id_buku tidak ditemukan.");
    }

    return view('admin/bukudigital/edit_bukudigital', ['bukudigital' => $book]);
}


public function updateBukuDigital()
{
    $session = session();

    if ($session->get('LEVEL_USER') !== '1') {
        return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
    $id_buku = $this->request->getPost('id_buku');

    // Validation rules
    $validation = \Config\Services::validation();
    $validation->setRules([
        'judul_buku' => 'required|max_length[255]',
        'penulis_buku' => 'required|max_length[64]',
        'tahun_buku' => 'required|valid_date[Y]',
        'sinopsis_buku' => 'required',
        'sampul_buku' => 'permit_empty|is_image[sampul_buku]|mime_in[sampul_buku,image/png,image/jpeg,image/jpg]',
        'produk_buku' => 'permit_empty|mime_in[produk_buku,application/pdf]'
    ]);

    // Check validation
    if (!$validation->withRequest($this->request)->run()) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Mohon isi semua field dengan benar.',
            'errors'  => $validation->getErrors() // Send validation errors
        ]);
    }

    // Data to be updated
    $data = [
        'JUDUL_BUKU' => $this->request->getPost('judul_buku'),
        'PENULIS_BUKU' => $this->request->getPost('penulis_buku'),
        'TAHUN_BUKU' => $this->request->getPost('tahun_buku'),
        'SINOPSIS_BUKU' => $this->request->getPost('sinopsis_buku')
    ];

    // Handle cover image if uploaded
    $sampul = $this->request->getFile('sampul_buku');
    if ($sampul && $sampul->isValid() && !$sampul->hasMoved()) {
        // Delete old cover
        $oldSampul = $this->bukuDigitalModel->find($id_buku)['SAMPUL_BUKU'];
        if (is_file(FCPATH . 'uploads/bukudigital/sampul/' . $oldSampul)) {
            unlink(FCPATH . 'uploads/bukudigital/sampul/' . $oldSampul);
        }

        // Save new cover
        $sampulName = $sampul->getRandomName();
        $sampul->move(FCPATH . 'uploads/bukudigital/sampul', $sampulName);
        $data['SAMPUL_BUKU'] = $sampulName;
    }

    // Handle PDF file if uploaded
    $produk = $this->request->getFile('produk_buku');
    if ($produk && $produk->isValid() && !$produk->hasMoved()) {
        // Delete old PDF
        $oldProduk = $this->bukuDigitalModel->find($id_buku)['PRODUK_BUKU'];
        if (is_file(FCPATH . 'uploads/bukudigital/pdf/' . $oldProduk)) {
            unlink(FCPATH . 'uploads/bukudigital/pdf/' . $oldProduk);
        }

        // Save new PDF
        $produkName = $produk->getRandomName();
        $produk->move(FCPATH . 'uploads/bukudigital/pdf', $produkName);
        $data['PRODUK_BUKU'] = $produkName;
    }

    // Update digital book in database
    try {
        $this->bukuDigitalModel->update($id_buku, $data);
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Buku digital berhasil diperbarui.',
            'redirect' => site_url('admin/bukudigital/manage')
        ]);
    } catch (\Exception $e) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Terjadi kesalahan saat memperbarui buku: ' . $e->getMessage()
        ]);
    }
}
public function deleteBukuDigital($id_buku)
{
    $session = session();

    if ($session->get('LEVEL_USER') !== '1') {
        return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
    try {
        // Find the digital book by its ID
        $bukuDigital = $this->bukuDigitalModel->find($id_buku);

        // Check if the book exists
        if (!$bukuDigital) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Buku digital tidak ditemukan.'
            ]);
        }

        // Delete the sampul file if it exists
        if (is_file(FCPATH . 'uploads/bukudigital/sampul/' . $bukuDigital['SAMPUL_BUKU'])) {
            unlink(FCPATH . 'uploads/bukudigital/sampul/' . $bukuDigital['SAMPUL_BUKU']);
        }

        // Delete the produk file if it exists
        if (is_file(FCPATH . 'uploads/bukudigital/pdf/' . $bukuDigital['PRODUK_BUKU'])) {
            unlink(FCPATH . 'uploads/bukudigital/pdf/' . $bukuDigital['PRODUK_BUKU']);
        }

        // Delete the digital book record from the database
        $this->bukuDigitalModel->delete($id_buku);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Buku digital berhasil dihapus.'
        ]);
    } catch (\Exception $e) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Terjadi kesalahan: ' . $e->getMessage()
        ]);
    }
}

// ==========================
// FUNGSI UNTUK MANAJEMEN SARAN
// ==========================


public function manageSaran()
{
    $session = session();

    if ($session->get('LEVEL_USER') !== '1') {
        return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }

    $search = $this->request->getGet('search');
    $bulan = $this->request->getGet('bulan');
    $tahun = $this->request->getGet('tahun');
    $perPage = 10; // Jumlah data per halaman
    $page = $this->request->getGet('page') ?? 1;

    $saranQuery = $this->saranModel;

    if (!empty($search)) {
        $saranQuery->like('NAMA_SARAN', $search);
    }

    if (!empty($bulan)) {
        $saranQuery->where('MONTH(TANGGAL_SARAN)', $bulan);
    }

    if (!empty($tahun)) {
        $saranQuery->where('YEAR(TANGGAL_SARAN)', $tahun);
    }

    $totalRecords = $saranQuery->countAllResults(false);
    $totalPages = ceil($totalRecords / $perPage);
    $saranQuery->orderBy('TANGGAL_SARAN', 'DESC');
    $saranList = $saranQuery->findAll($perPage, ($page - 1) * $perPage);

    // Ambil semua tahun dari database untuk dropdown filter
    $allYears = $this->saranModel
        ->select("DISTINCT YEAR(TANGGAL_SARAN) AS tahun", false)
        ->orderBy("tahun", "ASC")
        ->findAll();

    $yearsRange = array_map(function ($item) {
        return $item['tahun'];
    }, $allYears);

    // Base URL untuk pagination
    $baseUrl = site_url('admin/saran/manage');

    // Build query params
    $queryParams = [
        'search' => $search,
        'bulan' => $bulan,
        'tahun' => $tahun,
    ];

    return view('admin/saran/manage', [
        'saranList' => $saranList,
        'search' => $search,
        'bulan' => $bulan,
        'tahun' => $tahun,
        'yearsRange' => $yearsRange,
        'page' => (int)$page,
        'totalPages' => $totalPages,
        'baseUrl' => $baseUrl,
        'queryParams' => $queryParams, // Kirim query params ke view
    ]);
}




// Method to delete a suggestion
public function deleteSaran($id)
{
    $session = session();

    if ($session->get('LEVEL_USER') !== '1') {
        return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
    // Check if the suggestion exists
    if ($this->saranModel->find($id)) {
        // Delete the suggestion
        $this->saranModel->delete($id);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Data berhasil dihapus.'
        ]);
    } else {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Data tidak ditemukan.'
        ]);
    }
}

public function detailSaran($id)
{
    $session = session();
    
    if ($session->get('LEVEL_USER') !== '1') {
        return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
    // Load model Saran
    $saranModel = new \App\Models\SaranModel();

    // Cari data saran berdasarkan ID
    $saran = $saranModel->find($id);

    // Jika data tidak ditemukan, tampilkan halaman 404
    if (!$saran) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException("Saran dengan ID $id tidak ditemukan.");
    }

    // Tampilkan view detail_saran dengan data
    return view('admin/saran/detail_saran', ['saran' => $saran]);
}

}