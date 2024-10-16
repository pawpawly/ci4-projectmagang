<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\KategoriEventModel;
use App\Models\EventModel;
use CodeIgniter\Controller;

class SuperAdminController extends Controller
{
    protected $userModel;
    protected $kategoriEventModel;
    protected $eventModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->kategoriEventModel = new KategoriEventModel();
        $this->eventModel = new EventModel();

        helper('url');
        header("Cache-Control: no-cache, must-revalidate, max-age=0");
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    }

    public function index()
    {
        $users = $this->userModel->findAll();
        return view('superadmin/user_management', ['users' => $users]);
    }

    public function dashboard()
    {
        return view('superadmin/dashboard');
    }

    public function addUserForm()
    {
        return view('superadmin/add_user');
    }

    public function saveUser()
    {
        $username = $this->request->getPost('username');

        if ($this->userModel->where('USERNAME', $username)->first()) {
            return redirect()->back()->with('error', 'Username sudah digunakan!');
        }

        $data = [
            'NAMA_USER' => $this->request->getPost('nama_lengkap'),
            'USERNAME' => $username,
            'PASSWORD_USER' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'LEVEL_USER' => $this->request->getPost('level_user'),
        ];

        $this->userModel->insert($data);
        return redirect()->to('superadmin/user-management')->with('message', 'User berhasil ditambahkan.');
    }

    public function deleteUser($username)
    {
        try {
            if ($this->userModel->where('USERNAME', $username)->delete()) {
                return redirect()->to('superadmin/user-management')->with('message', 'User berhasil dihapus.');
            } else {
                return redirect()->to('superadmin/user-management')->with('error', 'Gagal menghapus user.');
            }
        } catch (\Exception $e) {
            return redirect()->to('superadmin/user-management')->with('error', $e->getMessage());
        }
    }

    public function editUser($username)
    {
        $user = $this->userModel->where('USERNAME', $username)->first();

        if (!$user) {
            return redirect()->to('superadmin/user-management')->with('error', 'User tidak ditemukan!');
        }

        return view('superadmin/edit_user', ['user' => $user]);
    }

    public function updateUser()
    {
        $originalUsername = $this->request->getPost('original_username');
        $newUsername = $this->request->getPost('username');
        $isSelfEdit = session()->get('username') === $originalUsername;

        if ($newUsername !== $originalUsername && $this->userModel->where('USERNAME', $newUsername)->first()) {
            return redirect()->back()->with('error', 'Username sudah digunakan!');
        }

        $data = [
            'NAMA_USER' => $this->request->getPost('nama_lengkap'),
            'USERNAME' => $newUsername,
            'LEVEL_USER' => $this->request->getPost('level_user'),
        ];

        if ($this->request->getPost('password')) {
            $data['PASSWORD_USER'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $this->userModel->where('USERNAME', $originalUsername)->set($data)->update();

        if ($isSelfEdit) {
            session()->destroy();
            return redirect()->to('/login')->with('message', 'Profil Anda telah diperbarui, silakan login kembali.');
        }

        return redirect()->to('superadmin/user-management')->with('message', 'User berhasil diperbarui.');
    }

    public function eventCategory()
    {
        // Ambil semua kategori event dari database
        $categories = $this->kategoriEventModel->findAll();
    
        // Kirim data ke view bersama dengan flashdata untuk pesan
        return view('superadmin/event/category', [
            'categories' => $categories
        ]);
    }

    public function addCategoryForm()
    {
        return view('superadmin/event/add_category');
    }
    

    public function saveCategory()
    {
        // Ambil input dari form
        $kategoriKevent = $this->request->getPost('kategori_kevent');
        $deskripsiKevent = $this->request->getPost('deskripsi_kevent');
    
        // Validasi jika input kosong
        if (empty($kategoriKevent) || empty($deskripsiKevent)) {
            return redirect()->back()->withInput()->with('error', 'Semua field harus diisi!');
        }
    
        // Persiapkan data untuk disimpan
        $data = [
            'KATEGORI_KEVENT' => $kategoriKevent,
            'DESKRIPSI_KEVENT' => $deskripsiKevent,
        ];
    
        try {
            // Simpan ke database
            if ($this->kategoriEventModel->insert($data)) {
                return redirect()->to('event/category')->with('message', 'Kategori berhasil ditambahkan.');
            } else {
                return redirect()->back()->withInput()->with('error', 'Gagal menambahkan kategori.');
            }
        } catch (\Exception $e) {
            // Log error untuk debugging
            log_message('error', $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function deleteCategory($id_kevent)
{
    try {
        if ($this->kategoriEventModel->delete($id_kevent)) {
            return redirect()->to('/event/category')
                ->with('message', 'Kategori berhasil dihapus.');
        } else {
            return redirect()->to('/event/category')
                ->with('error', 'Gagal menghapus kategori.');
        }
    } catch (\Exception $e) {
        log_message('error', $e->getMessage());
        return redirect()->to('/event/category')
            ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}
public function editCategory($id_kevent)
{
    // Cari kategori berdasarkan ID
    $category = $this->kategoriEventModel->find($id_kevent);

    // Jika kategori tidak ditemukan
    if (!$category) {
        return redirect()->to('/event/category')->with('error', 'Kategori tidak ditemukan!');
    }

    // Tampilkan form edit kategori
    return view('superadmin/event/edit_category', ['category' => $category]);
}

public function updateCategory()
{
    $id_kevent = $this->request->getPost('id_kevent'); // Ambil ID dari form

    $data = [
        'KATEGORI_KEVENT' => $this->request->getPost('kategori_kevent'),
        'DESKRIPSI_KEVENT' => $this->request->getPost('deskripsi_kevent'),
    ];

    try {
        $this->kategoriEventModel->update($id_kevent, $data);
        return redirect()->to('/event/category')->with('message', 'Kategori berhasil diperbarui.');
    } catch (\Exception $e) {
        log_message('error', $e->getMessage());
        return redirect()->back()->with('error', 'Gagal memperbarui kategori!');
    }
}
     
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
    } else {
        return redirect()->back()->with('error', 'Gagal mengupload poster.');
    }

    $data = [
        'ID_KEVENT' => $this->request->getPost('kategori_acara'),
        'USERNAME' => session()->get('username'),
        'NAMA_EVENT' => $this->request->getPost('nama_event'),
        'DEKSRIPSI_EVENT' => $this->request->getPost('deskripsi_event'),
        'TANGGAL_EVENT' => $this->request->getPost('tanggal_event'),
        'FOTO_EVENT' => $posterName,
    ];

    try {
        $this->eventModel->insert($data);
        return redirect()->to('event/manage')->with('message', 'Event berhasil ditambahkan.');
    } catch (\Exception $e) {
        log_message('error', $e->getMessage());
        return redirect()->back()->with('error', 'Gagal menambahkan event.');
    }
}
public function deleteEvent($id_event)
{
    try {
        // Ambil informasi event dari database
        $event = $this->eventModel->find($id_event);

        if (!$event) {
            return redirect()->to('/event/manage')->with('error', 'Event tidak ditemukan!');
        }

        // Cek apakah file poster ada dan hapus
        $poster = $event['FOTO_EVENT'];
        if (file_exists(WRITEPATH . '../public/uploads/poster/' . $poster)) {
            unlink(WRITEPATH . '../public/uploads/poster/' . $poster);
        }

        // Hapus event dari database
        $this->eventModel->delete($id_event);

        return redirect()->to('/event/manage')->with('message', 'Event berhasil dihapus.');
    } catch (\Exception $e) {
        log_message('error', $e->getMessage());
        return redirect()->back()->with('error', 'Gagal menghapus event! ' . $e->getMessage());
    }
}

public function editEvent($id_event)
{
    // Cari event berdasarkan ID_EVENT
    $event = $this->eventModel->find($id_event);
    $categories = $this->kategoriEventModel->findAll(); // Ambil kategori untuk dropdown

    // Jika event tidak ditemukan, tampilkan error
    if (!$event) {
        return redirect()->to('/event/manage')->with('error', 'Event tidak ditemukan!');
    }

    // Kirim data event dan kategori ke view edit
    return view('superadmin/event/edit_event', [
        'event' => $event,
        'categories' => $categories
    ]);
}

public function updateEvent()
{
    $id_event = $this->request->getPost('id_event'); // Ambil ID event dari form

    // Ambil input dari form
    $data = [
        'ID_KEVENT'      => $this->request->getPost('kategori_id'),
        'NAMA_EVENT'     => $this->request->getPost('nama_event'),
        'DEKSRIPSI_EVENT' => $this->request->getPost('deskripsi_event'),
        'TANGGAL_EVENT'  => $this->request->getPost('tanggal_event'),
    ];

    // Cek apakah ada file poster baru yang diupload
    $file = $this->request->getFile('foto_event');
    if ($file->isValid() && !$file->hasMoved()) {
        // Ambil informasi event lama untuk menghapus file lama
        $oldEvent = $this->eventModel->find($id_event);
        $oldPoster = $oldEvent['FOTO_EVENT'];

        // Hapus file poster lama jika ada
        if (file_exists(WRITEPATH . '../public/uploads/poster/' . $oldPoster)) {
            unlink(WRITEPATH . '../public/uploads/poster/' . $oldPoster);
        }

        // Simpan file poster baru
        $newName = $file->getRandomName();
        $file->move(WRITEPATH . '../public/uploads/poster/', $newName);
        $data['FOTO_EVENT'] = $newName;
    }

    try {
        // Update data event di database
        $this->eventModel->update($id_event, $data);
        return redirect()->to('/event/manage')->with('message', 'Event berhasil diperbarui.');
    } catch (\Exception $e) {
        log_message('error', $e->getMessage());
        return redirect()->back()->with('error', 'Gagal memperbarui event! ' . $e->getMessage());
    }
}



}
