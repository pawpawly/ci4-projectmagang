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

class SuperAdminController extends Controller
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

    // ============================
    // Manajemen Pengguna (CRUD)
    // ============================
    public function dashboard()
{
    // Pastikan hanya pengguna dengan level superadmin yang bisa mengakses
    if (!session()->get('isLoggedIn') || session()->get('LEVEL_USER') !== '2') {
        return redirect()->to(site_url('login'))->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini!');
    }

    // Tangkap data statistik bulanan dan harian
    $year = $this->request->getGet('year') ?? date('Y');
    $date = $this->request->getGet('date') ?? date('Y-m-d');

    // Statistik Bulanan
    $resultBulanan = $this->db->query("
        SELECT 
            MONTH(TGLKUNJUNGAN_TAMU) AS bulan, 
            SUM(JKL_TAMU) AS laki, 
            SUM(JKP_TAMU) AS perempuan, 
            YEAR(TGLKUNJUNGAN_TAMU) AS tahun
        FROM bukutamu 
        WHERE YEAR(TGLKUNJUNGAN_TAMU) IN (SELECT DISTINCT YEAR(TGLKUNJUNGAN_TAMU) FROM bukutamu)
        GROUP BY YEAR(TGLKUNJUNGAN_TAMU), MONTH(TGLKUNJUNGAN_TAMU)
    ")->getResultArray();

    // Ambil tahun yang ada pada data
    $years = array_unique(array_column($resultBulanan, 'tahun'));
    sort($years);

    // Statistik Bulanan
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

    // Kirim data ke view dashboard
    return view('superadmin/dashboard', [
        'dataBulanan' => $dataBulanan,
        'dataHarian' => $dataHarian,
        'year' => $year,
        'date' => $date,
        'years' => $years,  // Mengirimkan data tahun yang tersedia ke view
    ]);
}

    
    
    
    public function userManage()
    {
        $users = $this->userModel->findAll();
        return view('superadmin/user/manage', ['users' => $users]);
    }

    public function addUserForm()
    {
        return view('superadmin/user/add_user');
    }

public function editUser($username)
{
    $user = $this->userModel->getUserByUsername($username);

    if (!$user) {
        return redirect()->to('superadmin/user/manage')->with('error', 'User tidak ditemukan!');
    }

    return view('superadmin/user/edit_user', ['user' => $user]);
}


public function saveUser()
{
    $validation = $this->validate([
        'nama_lengkap' => 'required',
        'username' => 'required|is_unique[USER.USERNAME]',
        'password' => 'required|min_length[8]',
        'level_user' => 'required'
    ]);

    if (!$validation) {
        $errors = $this->validator->getErrors();

        // Ubah pesan kesalahan menjadi lebih ramah pengguna
        if (isset($errors['username']) && str_contains($errors['username'], 'unique')) {
            $errors['username'] = 'Username telah digunakan, silakan gunakan username lain.';
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => implode(', ', $errors)
        ]);
    }

    $data = [
        'NAMA_USER' => $this->request->getPost('nama_lengkap'),
        'USERNAME' => $this->request->getPost('username'),
        'PASSWORD_USER' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        'LEVEL_USER' => $this->request->getPost('level_user'),
    ];

    try {
        $this->userModel->insert($data);
        return $this->response->setJSON(['success' => true]);
    } catch (\Exception $e) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Terjadi kesalahan saat menambahkan pengguna: ' . $e->getMessage()
        ]);
    }
}


public function updateUser()
{
    if (!$this->request->is('post')) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Invalid request method.'
        ]);
    }

    $originalUsername = $this->request->getPost('original_username');
    $newUsername = $this->request->getPost('username');

    // Validasi input form
    $validation = $this->validate([
        'nama_lengkap' => 'required',
        'username' => "required|is_unique[USER.USERNAME,USERNAME,{$originalUsername}]",
        'level_user' => 'required'
    ]);

    if (!$validation) {
        $message = $this->validator->hasError('username') 
            ? 'Username telah digunakan, silakan gunakan username lain.' 
            : 'Mohon isi semua field dengan benar.';

        return $this->response->setJSON([
            'success' => false,
            'message' => $message
        ]);
    }

    $data = [
        'NAMA_USER' => $this->request->getPost('nama_lengkap'),
        'USERNAME' => $newUsername,
        'LEVEL_USER' => $this->request->getPost('level_user'),
    ];

    if ($this->request->getPost('password')) {
        $data['PASSWORD_USER'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
    }

    $this->userModel->updateUserWithTransaction($originalUsername, $data);

    if ($originalUsername === session()->get('username')) {
        session()->destroy(); // Hancurkan session jika username sendiri diubah
    
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Username Anda telah berubah. Silakan login kembali.',
            'redirect' => site_url('login')
        ]);
    } else {
        return $this->response->setJSON([
            'success' => true,
            'message' => 'User berhasil diperbarui.',
            'redirect' => site_url('superadmin/user/manage')
        ]);
    }
}    


public function deleteUser($username)
{
    $session = session(); // Inisialisasi session
    $userModel = new \App\Models\UserModel(); // Pastikan ini model yang benar untuk tabel user Anda

    try {
        // Hapus pengguna berdasarkan username
        if ($userModel->where('username', $username)->delete()) {
            // Jika username yang dihapus adalah pengguna yang sedang login
            if ($session->get('username') === $username) {
                $session->destroy(); // Hapus session
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Akun Anda telah dihapus. Anda akan diarahkan ke halaman login.',
                    'redirect' => site_url('/login')
                ]);
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Pengguna berhasil dihapus.'
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Gagal menghapus pengguna.'
        ]);
    } catch (\Exception $e) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Terjadi kesalahan: ' . $e->getMessage()
        ]);
    }
}



    
    
    // ==========================
    // FUNGSI UNTUK MANAJEMEN BERITA
    // ==========================
    
    public function beritaManage()
    {
        // Mengambil filter dari request
        $search = $this->request->getGet('search');
        $month = $this->request->getGet('month');
        $year = $this->request->getGet('year');
        
        // Query untuk data berita
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
    
        // Ambil data berita setelah filter
        $berita = $beritaQuery->findAll();
    
        // Ambil tahun unik dari data berita
        $yearsRange = array_unique(array_map(function($item) {
            return date('Y', strtotime($item['TANGGAL_BERITA']));
        }, $berita));
        
        // Sort tahun secara ascending
        sort($yearsRange);
    
        return view('superadmin/berita/manage', [
            'berita' => $berita,
            'search' => $search,
            'month' => $month,
            'year' => $year,
            'yearsRange' => $yearsRange
        ]);
    }
    
    
    public function detailBerita($id)
    {
        // Ambil data berita berdasarkan ID
        $beritaModel = new BeritaModel();
        $berita = $beritaModel->find($id);
    
        if (!$berita) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Berita dengan ID $id tidak ditemukan.");
        }
    
        // Render view detail_berita
        return view('superadmin/berita/detail_berita', ['berita' => $berita]);
    }
    
    
    

    public function addBeritaForm()
    {
        return view('superadmin/berita/add_berita');
    }

    public function saveBerita()
    {
        // Validasi input
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
        $berita = $this->beritaModel->find($id_berita);

        if (!$berita) {
            return redirect()->to('superadmin/berita/manage')->with('error', 'Berita tidak ditemukan!');
        }

        return view('superadmin/berita/edit_berita', ['berita' => $berita]);
    }

    public function updateBerita()
    {
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
                'redirect' => site_url('superadmin/berita/manage')
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
        $categories = $this->kategoriEventModel->findAll();
        return view('superadmin/event/category', ['categories' => $categories]);
    }

    public function addCategory()
    {
        // Ambil semua kategori dari database
        $categories = $this->kategoriEventModel->findAll();
    
        // Kirim data kategori ke view
        return view('superadmin/event/add_category', ['categories' => $categories]);
    }
    

    public function saveCategory()
    {
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
                'message' => 'Mohon isi semua field dengan benar.'
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
        $category = $this->kategoriEventModel->find($id_kevent);
    
        if (!$category) {
            return redirect()->to('superadmin/event/category')->with('error', 'Kategori tidak ditemukan.');
        }
    
        return view('superadmin/event/edit_category', ['category' => $category]);
    }
    
    public function updateCategory()
    {
        $validation = \Config\Services::validation();
    
        $validation->setRules([
            'kategori_kevent' => 'required',
            'deskripsi_kevent' => 'required',
        ], [
            'kategori_kevent' => [
                'required' => 'Nama kategori tidak boleh kosong.'
            ],
            'deskripsi_kevent' => [
                'required' => 'Deskripsi kategori tidak boleh kosong.'
            ]
        ]);
    
        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Mohon isi semua field dengan benar.',
                'errors' => $validation->getErrors()
            ]);
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
        // Mengambil filter dari request
        $search = $this->request->getGet('search');
        $category = $this->request->getGet('category');
        $month = $this->request->getGet('month');
        $year = $this->request->getGet('year');
        
        // Menghitung tahun saat ini dan rentang tahun
        $currentYear = date('Y');
        $yearsRange = range($currentYear - 10, $currentYear); // Menampilkan 10 tahun terakhir
        
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
    
        // Ambil data event
        $events = $eventsQuery->findAll();
    
        // Ambil kategori event untuk filter kategori
        $categories = $this->kategoriEventModel->findAll();
    
        // Kirim data ke view
        return view('superadmin/event/manage', [
            'events' => $events,
            'search' => $search,
            'category' => $category,
            'categories' => $categories,
            'month' => $month,
            'year' => $year,
            'yearsRange' => $yearsRange
        ]);
    }
    
    
    public function eventDetail($id)
    {
        $eventModel = new \App\Models\EventModel();
        $event = $eventModel->select('event.*, kategori_event.KATEGORI_KEVENT as NAMA_KATEGORI')
                            ->join('kategori_event', 'kategori_event.ID_KEVENT = event.ID_KEVENT', 'left')
                            ->where('event.ID_EVENT', $id)
                            ->first();
    
        if (!$event) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Event with ID $id not found");
        }
    
        return view('superadmin/event/detail_event', ['event' => $event]);
    }
    


    public function addEventForm()
    {
        $categories = $this->kategoriEventModel->findAll();
        return view('superadmin/event/add_event', ['categories' => $categories]);
    }

    public function saveEvent()
    {
        $validation = \Config\Services::validation();
    
        // Aturan Validasi
        $validation->setRules([
            'nama_event' => 'required',
            'kategori_acara' => 'required',
            'tanggal_event' => 'required|valid_date[Y-m-d]|checkFutureDate',
            'jam_event' => 'required',
            'deskripsi_event' => 'required',
            'poster_event' => 'uploaded[poster_event]|is_image[poster_event]|mime_in[poster_event,image/jpg,image/jpeg,image/png]',
        ], [
            'nama_event' => ['required' => 'Nama event wajib diisi.'],
            'kategori_acara' => ['required' => 'Kategori acara wajib dipilih.'],
            'tanggal_event' => [
                'required' => 'Tanggal event wajib diisi.',
                'checkFutureDate' => 'Tidak boleh memilih tanggal masa lalu.'
            ],
            'jam_event' => ['required' => 'Jam mulai wajib diisi.'],
            'deskripsi_event' => ['required' => 'Deskripsi acara wajib diisi.'],
            'poster_event' => [
                'uploaded' => 'Poster acara wajib diunggah.',
                'is_image' => 'File harus berupa gambar.',
                'mime_in' => 'Poster harus berformat jpg, jpeg, atau png.'
            ]
        ]);
    
        // Validasi gagal
        if (!$validation->withRequest($this->request)->run()) {
            $errors = $validation->getErrors();
            
            // Cek apakah error hanya terkait dengan tanggal masa lalu
            if (isset($errors['tanggal_event']) && count($errors) === 1) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Tidak boleh memilih tanggal masa lalu.'
                ]);
            } 
    
            // Jika ada error selain tanggal
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Semua field wajib diisi!'
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
            'TANGGAL_EVENT' => date('Y-m-d', strtotime($this->request->getPost('tanggal_event'))),
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
        $event = $this->eventModel->find($id_event);
        $categories = $this->kategoriEventModel->findAll();

        if (!$event) {
            return redirect()->to('superadmin/event/manage')->with('error', 'Event tidak ditemukan.');
        }

        return view('superadmin/event/edit_event', [
            'event' => $event,
            'categories' => $categories
        ]);
    }

    public function updateEvent()
    {
        $id_event = $this->request->getPost('id_event');
    
        // Setup validation rules
        $validation = \Config\Services::validation();
    
        $validation->setRules([
            'nama_event' => 'required',
            'kategori_id' => 'required',
            'tanggal_event' => [
                'rules' => 'required|valid_date[Y-m-d]|checkFutureDate',
                'errors' => [
                    'required' => 'Tanggal acara wajib diisi.',
                    'valid_date' => 'Format tanggal tidak valid.',
                    'checkFutureDate' => 'Tidak boleh memilih tanggal dari masa lalu.'
                ]
            ],
            'jam_event' => 'required',
            'deskripsi_event' => 'required',
            'foto_event' => 'permit_empty|is_image[foto_event]|mime_in[foto_event,image/jpg,image/jpeg,image/png]'
        ]);
    
        // Validasi gagal
        if (!$validation->withRequest($this->request)->run()) {
            $errors = $validation->getErrors();
    
            // Cek apakah ada error terkait tanggal
            if (isset($errors['tanggal_event']) && count($errors) === 1) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Tidak boleh memilih tanggal dari masa lalu!'
                ]);
            }
    
            // Jika ada error selain tanggal
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Semua field wajib diisi!'
            ]);
        }
    
        // Data untuk di-update
        $data = [
            'ID_KEVENT' => $this->request->getPost('kategori_id'),
            'NAMA_EVENT' => $this->request->getPost('nama_event'),
            'DEKSRIPSI_EVENT' => $this->request->getPost('deskripsi_event'),
            'TANGGAL_EVENT' => date('Y-m-d', strtotime($this->request->getPost('tanggal_event'))),
            'JAM_EVENT' => $this->request->getPost('jam_event')
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
        $categories = $this->kategoriKoleksiModel->findAll();

        return view('superadmin/koleksi/category', [
            'categories' => $categories
        ]);
    }

    // Menampilkan form tambah kategori koleksi
    public function addKategoriKoleksiForm()
    {
        return view('superadmin/koleksi/add_category');
    }

    // Menyimpan kategori koleksi baru
    public function saveKategoriKoleksi()
    {
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
        $category = $this->kategoriKoleksiModel->find($id_kkoleksi);
    
        if (!$category) {
            return redirect()->to('superadmin/koleksi/category')->with('error', 'Kategori tidak ditemukan.');
        }
    
        return view('superadmin/koleksi/edit_category', ['category' => $category]);
    }
    
    public function updateKategoriKoleksi()
    {
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
    // Dapatkan nilai pencarian dan kategori dari request
    $search = $this->request->getGet('search');
    $category = $this->request->getGet('category');

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

    // Ambil hasil query
    $koleksi = $koleksiQuery->findAll();
    $categories = $this->kategoriKoleksiModel->findAll();

    return view('superadmin/koleksi/manage', [
        'koleksi' => $koleksi,
        'categories' => $categories,
        'request' => $this->request
    ]);
}

public function koleksiDetail($id)
{
    $koleksiModel = new \App\Models\KoleksiModel();

    // Ensure correct join with kategori_koleksi to get the KATEGORI_KKOLEKSI
    $collection = $koleksiModel->select('koleksi.*, kategori_koleksi.KATEGORI_KKOLEKSI')
                               ->join('kategori_koleksi', 'kategori_koleksi.ID_KKOLEKSI = koleksi.ID_KKOLEKSI', 'left')
                               ->where('koleksi.ID_KOLEKSI', $id)
                               ->first();

    if (!$collection) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Koleksi dengan ID $id tidak ditemukan.");
    }

    return view('superadmin/koleksi/detail_collection', ['collection' => $collection]);
}

public function addKoleksiForm()
{
    $categories = $this->kategoriKoleksiModel->findAll();
    return view('superadmin/koleksi/add_collection', ['categories' => $categories]);
}

public function saveKoleksi()
{
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
    $koleksi = $this->koleksiModel->find($id_koleksi);
    $categories = $this->kategoriKoleksiModel->findAll();

    if (!$koleksi) {
        return redirect()->to('superadmin/koleksi/manage')->with('error', 'Koleksi tidak ditemukan.');
    }

    return view('superadmin/koleksi/edit_collection', [
        'koleksi' => $koleksi,
        'categories' => $categories
    ]);
}



public function updateKoleksi()
{
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
    // Ambil parameter filter dari request
    $search = $this->request->getGet('search');
    $status = $this->request->getGet('status');
    $bulan = $this->request->getGet('bulan');
    $tahun = $this->request->getGet('tahun');
    
    // Menghitung tahun saat ini dan satu tahun ke depan
    $currentYear = date('Y');
    $yearsRange = range($currentYear - 1, $currentYear);

    // Query untuk data reservasi
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

    // Ambil data reservasi berdasarkan filter
    $reservasi = $reservasiQuery->findAll();

    // Ambil data tahun dan bulan unik dari tabel reservasi
    $yearsRange = array_unique(array_map(function($reservasiItem) {
        return date('Y', strtotime($reservasiItem['TANGGAL_RESERVASI']));
    }, $reservasi));
    sort($yearsRange);

    $monthsRange = array_unique(array_map(function($reservasiItem) {
        return date('n', strtotime($reservasiItem['TANGGAL_RESERVASI']));
    }, $reservasi));

    // Kirimkan data ke view
    return view('superadmin/reservasi/manage', [
        'reservasi' => $reservasi,
        'search' => $search,
        'status' => $status,
        'bulan' => $bulan,
        'tahun' => $tahun,
        'yearsRange' => $yearsRange,
        'monthsRange' => $monthsRange
    ]);
}


public function detail_reservasi($id)
{
    // Mengambil data reservasi berdasarkan ID
    $reservasi = $this->reservasiModel->find($id);

    // Jika data reservasi tidak ditemukan, tampilkan halaman 404
    if (!$reservasi) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Reservasi dengan ID $id tidak ditemukan.");
    }

    // Mengirim data ke view detail_reservasi.php
    return view('superadmin/reservasi/detail_reservasi', [
        'reservasi' => $reservasi
    ]);
}

public function updateStatus($id_reservasi)
{
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
    // Mengambil filter dari request
    $search = $this->request->getGet('search');
    $tipeTamu = $this->request->getGet('tipe_tamu');
    $bulan = $this->request->getGet('bulan');
    $tahun = $this->request->getGet('tahun');
    
    // Menghitung tahun saat ini
    $currentYear = date('Y');

    // Query untuk mengambil semua data buku tamu
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

    $bukutamu = $bukuTamuQuery->findAll();

    // Ambil data tahun dan bulan unik dari tabel buku tamu
    $yearsRange = array_unique(array_map(function($tamu) {
        return date('Y', strtotime($tamu['TGLKUNJUNGAN_TAMU']));
    }, $bukutamu));
    sort($yearsRange);

    $monthsRange = array_unique(array_map(function($tamu) {
        return date('n', strtotime($tamu['TGLKUNJUNGAN_TAMU']));
    }, $bukutamu));

    // Kirimkan data ke view
    return view('superadmin/bukutamu/manage', [
        'bukutamu' => $bukutamu,
        'search' => $search,
        'tipeTamu' => $tipeTamu,
        'bulan' => $bulan,
        'tahun' => $tahun,
        'yearsRange' => $yearsRange,
        'monthsRange' => $monthsRange
    ]);
}




    // Hapus data buku tamu
    public function deleteBukuTamu($id_tamu)
    {
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
        // Load model
        $bukuTamuModel = new BukuTamuModel();
    
        // Find guest by ID
        $tamu = $bukuTamuModel->find($id_tamu);
    
        if (!$tamu) {
            return redirect()->to('/superadmin/bukutamu/manage')->with('error', 'Data tamu tidak ditemukan.');
        }
    
        // Pass the data to the view
        return view('superadmin/bukutamu/detail_guestbook', [
            'tamu' => $tamu
        ]);
    }
    


public function grantGuestbookAccess()
{
    // Set session khusus untuk autentikasi buku tamu
    session()->set('guestbook_auth', true);

    // Hapus sesi login untuk mencegah akses kembali ke halaman superadmin
    session()->remove('isLoggedIn');
    
    // Redirect langsung ke form buku tamu
    return redirect()->to('/bukutamu/form');
}


public function form()
{
    // Tampilkan form buku tamu tanpa menghapus sesi guestbook_auth
    return view('bukutamu/form_guestbook');
}

    
// ==========================
// FUNGSI UNTUK MANAJEMEN BUKU DIGITAL
// ==========================


public function manageBukuDigital()
{
    // Ambil input pencarian dari permintaan GET
    $search = $this->request->getGet('search');

    // Query dasar untuk mengambil data buku digital
    $bukudigitalQuery = $this->bukuDigitalModel;

    // Jika ada input pencarian, filter berdasarkan judul dan penulis
    if ($search) {
        $bukudigitalQuery = $bukudigitalQuery
            ->groupStart() // Mulai grup kondisi pencarian
            ->like('JUDUL_BUKU', $search)
            ->orLike('PENULIS_BUKU', $search)
            ->groupEnd(); // Akhiri grup kondisi pencarian
    }

    // Dapatkan hasil query
    $bukudigital = $bukudigitalQuery->findAll();

    return view('superadmin/bukudigital/manage', [
        'bukudigital' => $bukudigital,
        'search' => $search, // Pass search term to view
    ]);
}



    public function addBukuDigital()
    {
        return view('superadmin/bukudigital/add_bukudigital');
    }

    // Function to save the digital book
    public function saveBukuDigital()
    {
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
    // Load the book details from the database
    $book = $this->bukuDigitalModel->find($id);

    // Check if the book exists
    if (!$book) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException("Book with ID $id not found");
    }

    // Pass the book data to the view
    return view('superadmin/bukudigital/view_buku_digital', ['book' => $book]);
}

public function editBukuDigital($id_buku)
{
    $book = $this->bukuDigitalModel->find($id_buku);

    if (!$book) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Buku Digital dengan ID $id_buku tidak ditemukan.");
    }

    return view('superadmin/bukudigital/edit_bukudigital', ['bukudigital' => $book]);
}


public function updateBukuDigital()
{
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
            'redirect' => site_url('superadmin/bukudigital/manage')
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
    // Mengambil filter dari request
    $search = $this->request->getGet('search');
    $bulan = $this->request->getGet('bulan');
    $tahun = $this->request->getGet('tahun');
    
    // Query untuk data saran
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

    // Ambil data saran setelah filter
    $saranList = $saranQuery->findAll();

    // Ambil tahun unik dari data saran
    $yearsRange = array_unique(array_map(function($saran) {
        return date('Y', strtotime($saran['TANGGAL_SARAN']));
    }, $saranList));
    
    // Sort tahun secara ascending
    sort($yearsRange);

    return view('superadmin/saran/manage', [
        'saranList' => $saranList,
        'search' => $search,
        'bulan' => $bulan,
        'tahun' => $tahun,
        'yearsRange' => $yearsRange
    ]);
}


// Method to delete a suggestion
public function deleteSaran($id)
{
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
}