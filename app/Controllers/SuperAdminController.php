<?php

namespace App\Controllers;

use App\Models\UserModel; 
use App\Models\EventModel;
use App\Models\KategoriEventModel;
use App\Models\BeritaModel;
use App\Models\KoleksiModel;
use App\Models\KategoriKoleksiModel;
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
    protected $db;

    public function __construct()
    {
        $this->userModel = new UserModel(); 
        $this->eventModel = new EventModel();
        $this->kategoriEventModel = new KategoriEventModel();
        $this->beritaModel = new BeritaModel();
        $this->koleksiModel = new KoleksiModel();
        $this->kategoriKoleksiModel = new KategoriKoleksiModel();
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

        // Load view dashboard
        return view('superadmin/dashboard');
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
    // Validasi input dari form
    $validation = $this->validate([
        'nama_lengkap' => 'required',
        'username' => 'required|is_unique[USER.USERNAME]',
        'password' => 'required|min_length[1]',
        'level_user' => 'required'
    ]);

    if (!$validation) {
        // Cek apakah kesalahan disebabkan oleh username duplikat
        if ($this->validator->hasError('username')) {
            $errorMessage = 'Username sudah digunakan, silakan gunakan username lain.';
        } else {
            $errorMessage = 'Mohon isi semua field dengan benar.';
        }

        return redirect()->back()->withInput()->with('error', $errorMessage);
    }

    // Data pengguna baru
    $data = [
        'NAMA_USER' => $this->request->getPost('nama_lengkap'),
        'USERNAME' => $this->request->getPost('username'),
        'PASSWORD_USER' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        'LEVEL_USER' => $this->request->getPost('level_user'),
    ];

    try {
        // Simpan ke database
        $this->userModel->insert($data);

        // Set flashdata untuk pesan sukses
        return redirect()->to('superadmin/user/manage')->with('success', 'Pengguna Berhasil Ditambahkan.');
    } catch (\Exception $e) {
        // Jika terjadi kesalahan, tampilkan pesan error
        return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan pengguna: ' . $e->getMessage());
    }
}


public function updateUser()
{
    if (!$this->request->is('post')) {
        return redirect()->back()->with('error', 'Invalid request method.');
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
        return redirect()->back()->withInput()->with('error', 'Mohon isi semua field dengan benar.');
    }

    $data = [
        'NAMA_USER' => $this->request->getPost('nama_lengkap'),
        'USERNAME' => $newUsername,
        'LEVEL_USER' => $this->request->getPost('level_user'),
    ];

    if ($this->request->getPost('password')) {
        $data['PASSWORD_USER'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
    }

    $result = $this->userModel->updateUserWithTransaction($originalUsername, $data);

    if ($result) {
        if ($originalUsername === session()->get('username')) {
            session()->destroy(); // Hancurkan session jika username sendiri diubah
            return redirect()->to('login')->with('message', 'Username Anda telah berubah. Silakan login kembali.');
        }
        return redirect()->to('superadmin/user/manage')->with('message', 'User berhasil diperbarui.');
    } else {
        return redirect()->back()->with('error', 'Gagal memperbarui user.');
    }
}

    public function deleteUser($username)
    {
        try {
            $user = $this->userModel->getUserByUsername($username);
    
            if (!$user) {
                return $this->response->setStatusCode(404)
                    ->setJSON(['error' => 'Pengguna tidak ditemukan.']);
            }
    
            // Hapus pengguna
            $this->userModel->delete($username);
    
            // Ambil data pengguna terbaru setelah penghapusan
            $updatedUsers = $this->userModel->findAll();
    
            // Kirim respons JSON dengan daftar pengguna terbaru
            return $this->response->setStatusCode(200)
                ->setJSON(['message' => 'Pengguna berhasil dihapus.', 'users' => $updatedUsers]);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)
                ->setJSON(['error' => 'Terjadi kesalahan saat menghapus pengguna.']);
        }
    }
    
    
    // ==========================
    // FUNGSI UNTUK MANAJEMEN BERITA
    // ==========================
    
    public function beritaManage()
    {
        $data['berita'] = $this->beritaModel->getBeritaWithUser();
        return view('superadmin/berita/manage', $data);
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
            return redirect()->back()->withInput()->with('error', $validation->getErrors());
        }
    
        // Ambil USERNAME dari session
        $username = session()->get('username');
    
        // Ambil NAMA_USER berdasarkan USERNAME
        $user = $this->userModel->where('USERNAME', $username)->first();
        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan.');
        }
        
        // Siapkan data berita untuk disimpan
        $data = [
            'USERNAME' => $username,  // Simpan USERNAME
            'PENYIAR_BERITA' => $user['NAMA_USER'],  // Simpan NAMA_USER di PENYIAR_BERITA
            'NAMA_BERITA' => $this->request->getPost('nama_berita'),
            'DESKRIPSI_BERITA' => $this->request->getPost('deskripsi_berita'),
            'SUMBER_BERITA' => $this->request->getPost('sumber_berita'),
            'TANGGAL_BERITA' => date('Y-m-d'),  // Otomatis ambil tanggal
        ];
    
        // Proses upload foto
        $foto = $this->request->getFile('foto_berita');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $fotoName = $foto->getRandomName();
            $foto->move(FCPATH . 'uploads/berita/', $fotoName);
            $data['FOTO_BERITA'] = $fotoName;
        }
    
        // Simpan berita ke database
        try {
            $this->beritaModel->insert($data);
            return redirect()->to('superadmin/berita/manage')->with('success', 'Berita berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan berita: ' . $e->getMessage());
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
    
        // Jika validasi gagal, kembalikan ke form dengan pesan error
        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('error', 'Mohon isi semua field dengan benar.');
        }
    
        // Data yang akan diperbarui (tanpa TANGGAL_BERITA)
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
            return redirect()->to('superadmin/berita/manage')->with('message', 'Berita berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui berita: ' . $e->getMessage());
        }
    }
    

    public function deleteBerita($id_berita)
    {
        $berita = $this->beritaModel->find($id_berita);
        if ($berita && is_file(FCPATH . 'uploads/berita/' . $berita['FOTO_BERITA'])) {
            unlink(FCPATH . 'uploads/berita/' . $berita['FOTO_BERITA']);
        }

        $this->beritaModel->delete($id_berita);
        return redirect()->to('superadmin/berita/manage')->with('message', 'Berita berhasil dihapus.');
    }


    // ==========================
    // FUNGSI UNTUK MANAJEMEN KATEGORI EVENT
    // ==========================

    public function eventCategory()
    {
        $categories = $this->kategoriEventModel->findAll();
        return view('superadmin/event/category', ['categories' => $categories]);
    }

    public function addCategoryForm()
    {
        return view('superadmin/event/add_category');
    }

    public function saveCategory()
    {
        // Validasi input dari form
        $validation = \Config\Services::validation();
    
        // Aturan validasi
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
    
        // Jika validasi gagal
        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('error', $validation->getErrors());
        }
    
        // Data kategori yang akan disimpan
        $data = [
            'KATEGORI_KEVENT' => $this->request->getPost('kategori_kevent'),
            'DESKRIPSI_KEVENT' => $this->request->getPost('deskripsi_kevent')
        ];
    
        // Simpan ke database
        $this->kategoriEventModel->insert($data);
    
        // Redirect dengan pesan sukses
        return redirect()->to('superadmin/event/category')->with('message', 'Kategori berhasil ditambahkan.');
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
            return redirect()->back()
                ->withInput()
                ->with('validation', $validation);
        }
    
        $id_kevent = $this->request->getPost('id_kevent');
        $data = [
            'KATEGORI_KEVENT' => $this->request->getPost('kategori_kevent'),
            'DESKRIPSI_KEVENT' => $this->request->getPost('deskripsi_kevent'),
        ];
    
        try {
            $this->kategoriEventModel->update($id_kevent, $data);
            return redirect()->to('superadmin/event/category')
                ->with('message', 'Kategori berhasil diperbarui.');
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memperbarui kategori.');
        }
    }
    
    
    

    public function deleteCategory($id_kevent)
    {
        // Cek apakah kategori masih digunakan di tabel event
        $eventCount = $this->db->table('event')
            ->where('ID_KEVENT', $id_kevent)
            ->countAllResults();
    
        if ($eventCount > 0) {
            return redirect()->to('superadmin/event/category')
                ->with('error', 'Tidak Bisa Menghapus Karena Ada Event yang Berlangsung.');
        }
    
        // Hapus kategori jika tidak terhubung dengan event
        try {
            $this->kategoriEventModel->delete($id_kevent);
            return redirect()->to('superadmin/event/category')
                ->with('message', 'Kategori berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->to('superadmin/event/category')
                ->with('error', 'Terjadi kesalahan saat menghapus kategori.');
        }
    }
    


    // ==========================
    // FUNGSI UNTUK MANAJEMEN  EVENT
    // ==========================

    public function eventManage()
    {
        $events = $this->eventModel
            ->select('event.*, kategori_event.KATEGORI_KEVENT as NAMA_KATEGORI')
            ->join('kategori_event', 'kategori_event.ID_KEVENT = event.ID_KEVENT')
            ->findAll();
        return view('superadmin/event/manage', ['events' => $events]);
    }

    public function addEventForm()
    {
        $categories = $this->kategoriEventModel->findAll();
        return view('superadmin/event/add_event', ['categories' => $categories]);
    }

    public function saveEvent()
    {
        // Validasi form input
        $validation = \Config\Services::validation();
    
        $validation->setRules([
            'nama_event' => 'required',
            'kategori_acara' => 'required',
            'tanggal_event' => 'required|valid_date[Y-m-d]|checkFutureDate',
            'jam_event' => 'required',
            'deskripsi_event' => 'required',
            'poster_event' => 'uploaded[poster_event]|is_image[poster_event]|mime_in[poster_event,image/jpg,image/jpeg,image/png]',
        ], [
            'tanggal_event' => [
                'checkFutureDate' => 'Tanggal acara tidak boleh di masa lalu. Harap pilih tanggal yang valid.',
            ]
        ]);
    
        // Jika validasi gagal
        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()
                ->withInput()
                ->with('validation', $validation->getErrors());
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
    
        return redirect()->to('superadmin/event/manage')->with('message', 'Event berhasil ditambahkan.');
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
                    'checkFutureDate' => CustomValidation::checkFutureDateError()
                ]
            ],
            'jam_event' => 'required',
            'deskripsi_event' => 'required',
            'foto_event' => 'permit_empty|uploaded[foto_event]|is_image[foto_event]|mime_in[foto_event,image/jpg,image/jpeg,image/png]'
        ]);

        // Jika validasi gagal
        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()
                ->withInput()
                ->with('validation', $validation)
                ->with('error', 'Mohon isi semua field dengan benar.');
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
            return redirect()->to('superadmin/event/manage')->with('message', 'Event berhasil diperbarui.');
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memperbarui event.');
        }
    }
    
    
    public function deleteEvent($id_event)
{
    try {
        $event = $this->eventModel->find($id_event);

        if (!$event) {
            return redirect()->to('superadmin/event/manage')->with('error', 'Event tidak ditemukan.');
        }

        // Hapus foto jika ada
        if (!empty($event['FOTO_EVENT'])) {
            $posterPath = FCPATH . 'uploads/poster/' . $event['FOTO_EVENT'];
            if (is_file($posterPath)) {
                unlink($posterPath);
            }
        }

        // Hapus event dari database
        $this->eventModel->delete($id_event);
        return redirect()->to('superadmin/event/manage')->with('message', 'Event berhasil dihapus.');
    } catch (\Exception $e) {
        log_message('error', $e->getMessage());
        return redirect()->back()->with('error', 'Gagal menghapus event.');
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

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('validation', $validation);
        }

        $data = [
            'KATEGORI_KKOLEKSI' => $this->request->getPost('kategori_kkoleksi'),
            'DESKRIPSI_KKOLEKSI' => $this->request->getPost('deskripsi_kkoleksi')
        ];

        $this->kategoriKoleksiModel->insert($data);

        return redirect()->to('superadmin/koleksi/category')->with('message', 'Kategori berhasil ditambahkan.');
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
    
        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('validation', $validation);
        }
    
        $id_kkoleksi = $this->request->getPost('id_kkoleksi');
        $data = [
            'KATEGORI_KKOLEKSI' => $this->request->getPost('kategori_kkoleksi'),
            'DESKRIPSI_KKOLEKSI' => $this->request->getPost('deskripsi_kkoleksi'),
        ];
    
        try {
            $this->kategoriKoleksiModel->update($id_kkoleksi, $data);
            return redirect()->to('superadmin/koleksi/category')->with('message', 'Kategori berhasil diperbarui.');
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memperbarui kategori.');
        }
    }
    public function deleteKategoriKoleksi($id_kkoleksi)
{
    try {
        // Cek apakah kategori ada
        $category = $this->kategoriKoleksiModel->find($id_kkoleksi);
        if (!$category) {
            return redirect()->to('superadmin/koleksi/category')->with('error', 'Kategori tidak ditemukan.');
        }

        // Hapus kategori
        $this->kategoriKoleksiModel->delete($id_kkoleksi);
        return redirect()->to('superadmin/koleksi/category')->with('message', 'Kategori berhasil dihapus.');
    } catch (\Exception $e) {
        log_message('error', $e->getMessage());
        return redirect()->back()->with('error', 'Gagal menghapus kategori.');
    }
}

    
// ==========================
// FUNGSI UNTUK MANAJEMEN KOLEKSI
// ==========================

public function koleksiManage()
{
    $koleksi = $this->koleksiModel
        ->select('koleksi.*, kategori_koleksi.KATEGORI_KKOLEKSI as NAMA_KATEGORI')
        ->join('kategori_koleksi', 'kategori_koleksi.ID_KKOLEKSI = koleksi.ID_KKOLEKSI', 'left')
        ->findAll();

    return view('superadmin/koleksi/manage', ['koleksi' => $koleksi]);
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
        return redirect()->back()
            ->withInput()
            ->with('validation', $validation->getErrors());
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
        'DESKRIPSI_KOLEKSI' => $this->request->getPost('deskripsi_koleksi'), // Perbaikan di sini
        'FOTO_KOLEKSI' => $fotoName
    ];

    $this->koleksiModel->insert($data);
    return redirect()->to('superadmin/koleksi/manage')->with('message', 'Koleksi berhasil ditambahkan.');
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

    $validation = \Config\Services::validation();
    $validation->setRules([
        'nama_koleksi' => 'required',
        'kategori_koleksi' => 'required',
        'deskripsi_koleksi' => 'required',
        'foto_koleksi' => 'permit_empty|uploaded[foto_koleksi]|is_image[foto_koleksi]|mime_in[foto_koleksi,image/jpg,image/jpeg,image/png]'
    ]);

    if (!$validation->withRequest($this->request)->run()) {
        return redirect()->back()
            ->withInput()
            ->with('validation', $validation->getErrors());
    }

    $data = [
        'ID_KKOLEKSI' => $this->request->getPost('kategori_koleksi'),
        'NAMA_KOLEKSI' => $this->request->getPost('nama_koleksi'),
        'DESKRIPSI_KOLEKSI' => $this->request->getPost('deskripsi_koleksi')
    ];
    

    $file = $this->request->getFile('foto_koleksi');
    if ($file && $file->isValid() && !$file->hasMoved()) {
        $oldKoleksi = $this->koleksiModel->find($id_koleksi);
        if (!empty($oldKoleksi['FOTO_KOLEKSI'])) {
            $oldFotoPath = FCPATH . 'uploads/koleksi/' . $oldKoleksi['FOTO_KOLEKSI'];
            if (is_file($oldFotoPath)) {
                unlink($oldFotoPath);
            }
        }

        $newName = $file->getRandomName();
        $file->move(FCPATH . 'uploads/koleksi/', $newName);
        $data['FOTO_KOLEKSI'] = $newName;
    }

    $this->koleksiModel->update($id_koleksi, $data);
    return redirect()->to('superadmin/koleksi/manage')->with('message', 'Koleksi berhasil diperbarui.');
}

public function deleteKoleksi($id_koleksi)
{
    try {
        $koleksi = $this->koleksiModel->find($id_koleksi);

        if (!$koleksi) {
            return redirect()->to('superadmin/koleksi/manage')->with('error', 'Koleksi tidak ditemukan.');
        }

        if (!empty($koleksi['FOTO_KOLEKSI'])) {
            $fotoPath = FCPATH . 'uploads/koleksi/' . $koleksi['FOTO_KOLEKSI'];
            if (is_file($fotoPath)) {
                unlink($fotoPath);
            }
        }

        $this->koleksiModel->delete($id_koleksi);
        return redirect()->to('superadmin/koleksi/manage')->with('message', 'Koleksi berhasil dihapus.');
    } catch (\Exception $e) {
        log_message('error', $e->getMessage());
        return redirect()->back()->with('error', 'Gagal menghapus koleksi.');
    }
}
}