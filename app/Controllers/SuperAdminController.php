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


public function deleteUser($id)
{
    try {
        // Hapus user berdasarkan ID
        $result = $this->userModel->delete($id);

        if ($result) {
            return $this->response->setJSON(['success' => true, 'message' => 'User berhasil dihapus.']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Gagal menghapus user.']);
        }
    } catch (\Exception $e) {
        return $this->response->setJSON(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
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
    
            // Hapus kategori dari database
            $this->kategoriKoleksiModel->delete($id_kkoleksi);
    
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Kategori berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal menghapus kategori.'
            ]);
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

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Koleksi berhasil dihapus.'
        ]);
    } catch (\Exception $e) {
        log_message('error', $e->getMessage());
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Gagal menghapus koleksi.'
        ]);
    }
}



// ==========================
// FUNGSI UNTUK MANAJEMEN KOLEKSI
// ==========================

public function reservationManage()
{
    $reservasiModel = new \App\Models\ReservasiModel();
    $data['reservasi'] = $reservasiModel->findAll();

    if (empty($data['reservasi'])) {
        $data['reservasi'] = []; // Pastikan data selalu berupa array
    }

    return view('superadmin/reservasi/manage', $data);
}

public function reservationStatus($id_reservasi)
{
    try {
        // Ambil data status dari request JSON
        $request = $this->request->getJSON(true); // Mengembalikan sebagai array

        // Debugging: Pastikan ID dan data JSON diterima
        log_message('debug', 'Request JSON: ' . json_encode($request));
        log_message('debug', 'ID Reservasi: ' . $id_reservasi);

        // Validasi apakah status_reservasi tersedia
        if (isset($request['status_reservasi'])) {
            $status = $request['status_reservasi'];

            // Update status di database
            $updated = $this->reservasiModel->update($id_reservasi, ['STATUS_RESERVASI' => $status]);

            // Periksa apakah update berhasil
            if ($updated) {
                return $this->response->setJSON(['success' => true]);
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Gagal memperbarui status.']);
            }
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Status tidak ditemukan dalam request.']);
        }
    } catch (\Exception $e) {
        // Tangani jika terjadi kesalahan
        log_message('error', 'Error: ' . $e->getMessage());
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Terjadi kesalahan: ' . $e->getMessage()
        ]);
    }
}


public function deleteReservation($id_reservasi)
{
    try {
        $deleted = $this->reservasiModel->delete($id_reservasi);

        if ($deleted) {
            return $this->response->setJSON(['success' => true]);
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
        $data = [
            'bukutamu' => $this->bukuTamuModel->findAll(), // Ambil semua data buku tamu
            'title' => 'Manajemen Buku Tamu'
        ];

        return view('superadmin/bukutamu/manage', $data);
    }

    // Hapus data buku tamu
    public function deleteBukuTamu($id_tamu)
    {
        try {
            $tamu = $this->bukuTamuModel->find($id_tamu);

            if (!$tamu) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Data tamu tidak ditemukan.'
                ]);
            }

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

// SuperAdminController.php

// SuperAdminController.php

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
}
