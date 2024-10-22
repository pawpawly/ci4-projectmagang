<?php

namespace App\Controllers;

use App\Models\UserModel; 
use App\Models\EventModel;
use App\Models\KategoriEventModel;
use App\Models\BeritaModel;
use CodeIgniter\Controller;

class SuperAdminController extends Controller
{
    protected $userModel;
    protected $eventModel;
    protected $kategoriEventModel;
    protected $beritaModel;

    public function __construct()
    {
        $this->userModel = new UserModel(); 
        $this->eventModel = new EventModel();
        $this->kategoriEventModel = new KategoriEventModel();
        $this->beritaModel = new BeritaModel();

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
        return redirect()->back()->withInput()->with('error', 'Mohon isi semua field dengan benar.');
    }

    // Data pengguna baru
    $data = [
        'NAMA_USER' => $this->request->getPost('nama_lengkap'),
        'USERNAME' => $this->request->getPost('username'),
        'PASSWORD_USER' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        'LEVEL_USER' => $this->request->getPost('level_user'),
    ];

    // Simpan ke database
    $this->userModel->insert($data);

    // Set flashdata untuk pesan sukses
    return redirect()->to('superadmin/user/manage')->with('success', 'Pengguna Berhasil Ditambahkan.');
}

    
    
    

    public function editUser($username)
    {
        $user = $this->userModel->where('USERNAME', $username)->first();

        if (!$user) {
            return redirect()->to('superadmin/user/manage')->with('error', 'User tidak ditemukan!');
        }

        return view('superadmin/user/edit_user', ['user' => $user]);
    }

    public function updateUser()
    {
        $originalUsername = $this->request->getPost('original_username');
        $newUsername = $this->request->getPost('username');

        $data = [
            'NAMA_USER' => $this->request->getPost('nama_lengkap'),
            'USERNAME' => $newUsername,
            'LEVEL_USER' => $this->request->getPost('level_user'),
        ];

        if ($this->request->getPost('password')) {
            $data['PASSWORD_USER'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $this->userModel->where('USERNAME', $originalUsername)->set($data)->update();
        return redirect()->to('superadmin/user/manage')->with('message', 'User berhasil diperbarui.');
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
        // Validasi form input
        $validation = \Config\Services::validation();
    
        // Aturan validasi untuk setiap field
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
    
        // Jika validasi berhasil, proses penyimpanan data
        $data = [
            'USERNAME' => session()->get('username'),
            'NAMA_BERITA' => $this->request->getPost('nama_berita'),
            'DESKRIPSI_BERITA' => $this->request->getPost('deskripsi_berita'),
            'SUMBER_BERITA' => $this->request->getPost('sumber_berita'),
            'TANGGAL_BERITA' => date('Y-m-d'),  // Tanggal otomatis
        ];
    
        $foto = $this->request->getFile('foto_berita');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $fotoName = $foto->getRandomName();
            $foto->move(FCPATH . 'uploads/berita/', $fotoName);
            $data['FOTO_BERITA'] = $fotoName;
        }
    
        // Simpan ke database
        $this->beritaModel->insert($data);
    
        return redirect()->to('superadmin/berita/manage')->with('success', 'Berita berhasil ditambahkan.');
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
        $data = [
            'NAMA_BERITA' => $this->request->getPost('nama_berita'),
            'DESKRIPSI_BERITA' => $this->request->getPost('deskripsi_berita'),
            'SUMBER_BERITA' => $this->request->getPost('sumber_berita'),
            'TANGGAL_BERITA' => date('Y-m-d'),  // Tanggal otomatis saat update
        ];

        $foto = $this->request->getFile('foto_berita');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $fotoLama = $this->beritaModel->find($id_berita)['FOTO_BERITA'];
            if (is_file(FCPATH . 'uploads/berita/' . $fotoLama)) {
                unlink(FCPATH . 'uploads/berita/' . $fotoLama);
            }

            $fotoName = $foto->getRandomName();
            $foto->move(FCPATH . 'uploads/berita/', $fotoName);
            $data['FOTO_BERITA'] = $fotoName;
        }

        $this->beritaModel->update($id_berita, $data);
        return redirect()->to('superadmin/berita/manage')->with('message', 'Berita berhasil diperbarui.');
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
        $data = [
            'KATEGORI_KEVENT' => $this->request->getPost('kategori_kevent'),
            'DESKRIPSI_KEVENT' => $this->request->getPost('deskripsi_kevent')
        ];

        $this->kategoriEventModel->insert($data);
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
        $id_kevent = $this->request->getPost('id_kevent');
        $data = [
            'KATEGORI_KEVENT' => $this->request->getPost('kategori_kevent'),
            'DESKRIPSI_KEVENT' => $this->request->getPost('deskripsi_kevent')
        ];

        $this->kategoriEventModel->update($id_kevent, $data);
        return redirect()->to('superadmin/event/category')->with('message', 'Kategori berhasil diperbarui.');
    }

    public function deleteCategory($id_kevent)
    {
        $this->kategoriEventModel->delete($id_kevent);
        return redirect()->to('superadmin/event/category')->with('message', 'Kategori berhasil dihapus.');
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
        $poster = $this->request->getFile('poster_event');
        $posterName = '';

        if ($poster->isValid() && !$poster->hasMoved()) {
            $posterName = $poster->getRandomName();
            $poster->move(FCPATH . 'uploads/poster/', $posterName);
        }

        $data = [
            'ID_KEVENT' => $this->request->getPost('kategori_acara'),
            'USERNAME' => session()->get('username'),
            'NAMA_EVENT' => $this->request->getPost('nama_event'),
            'DEKSRIPSI_EVENT' => $this->request->getPost('deskripsi_event'),
            'TANGGAL_EVENT' => date('Y-m-d', strtotime($this->request->getPost('tanggal_event'))),
            'JAM_EVENT' => $this->request->getPost('jam_event'),
            'FOTO_EVENT' => $posterName,
        ];

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
        
        // Data yang akan di-update
        $data = [
            'ID_KEVENT' => $this->request->getPost('kategori_id'),
            'NAMA_EVENT' => $this->request->getPost('nama_event'),
            'DEKSRIPSI_EVENT' => $this->request->getPost('deskripsi_event'),
            'TANGGAL_EVENT' => date('Y-m-d', strtotime($this->request->getPost('tanggal_event'))),
            'JAM_EVENT' => $this->request->getPost('jam_event'),
        ];
    
        // Cek apakah ada file foto yang diunggah
        $file = $this->request->getFile('foto_event');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Hapus foto lama
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

}    