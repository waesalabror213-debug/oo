<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\CategoryModel;
use App\Models\CulinaryLocationModel;
use App\Models\ReviewModel;
use App\Models\TagModel;
use App\Models\FavoriteModel;

class UserController extends BaseController
{
    public function index()
    {
        $locationModel = new CulinaryLocationModel();
        $categoryModel = new CategoryModel();
        
        $search = $this->request->getVar('search');
        $category = $this->request->getVar('category');
        $rating = $this->request->getVar('rating');
        $lat = $this->request->getVar('lat');
        $lng = $this->request->getVar('lng');

        // Jika tidak ada pencarian/filter, tampilkan 3 Makanan dan 3 Minuman
        if (!$search && !$category && !$rating && !$lat && !$lng) {
            $makanan = $locationModel->select('culinary_locations.*, categories.name as category_name')
                                    ->join('categories', 'categories.id = culinary_locations.category_id')
                                    ->where('culinary_locations.status', 'approved')
                                    ->where('culinary_locations.category_id', 1) // Makanan Berat
                                    ->limit(3)
                                    ->findAll();

            $minuman = $locationModel->select('culinary_locations.*, categories.name as category_name')
                                    ->join('categories', 'categories.id = culinary_locations.category_id')
                                    ->where('culinary_locations.status', 'approved')
                                    ->where('culinary_locations.category_id', 3) // Minuman Segar
                                    ->limit(3)
                                    ->findAll();

            $data = [
                'makanan'    => $makanan,
                'minuman'    => $minuman,
                'categories' => $categoryModel->findAll(),
                'search'     => $search,
                'category'   => $category,
                'rating'     => $rating,
                'title'      => 'PUASKULINER - Sensasi Makan Terpuas',
                'is_home'    => true
            ];

            return view('user/index', $data);
        }

        $query = $locationModel->select('culinary_locations.*, categories.name as category_name')
                               ->join('categories', 'categories.id = culinary_locations.category_id')
                               ->where('culinary_locations.status', 'approved');

        if ($lat && $lng) {
            $query->select("(6371 * acos(cos(radians($lat)) * cos(radians(latitude)) * cos(radians(longitude) - radians($lng)) + sin(radians($lat)) * sin(radians(latitude)))) AS distance")
                  ->orderBy('distance', 'ASC');
        } else {
            $query->orderBy('culinary_locations.created_at', 'DESC');
        }

        if ($search) {
            $query->groupStart()
                  ->like('culinary_locations.name', $search)
                  ->orLike('culinary_locations.address', $search)
                  ->groupEnd();
        }

        if ($category) {
            $query->where('culinary_locations.category_id', $category);
        }

        if ($rating) {
            $query->where('rating_avg >=', $rating);
        }

        $data = [
            'locations'  => $query->paginate(6, 'locations'),
            'pager'      => $query->pager,
            'categories' => $categoryModel->findAll(),
            'search'     => $search,
            'category'   => $category,
            'rating'     => $rating,
            'title'      => 'Hasil Pencarian - PUASKULINER',
            'is_home'    => false
        ];

        return view('user/index', $data);
    }

    public function submit()
    {
        $categoryModel = new CategoryModel();
        $tagModel = new TagModel();
        
        $data = [
            'categories' => $categoryModel->findAll(),
            'tags'       => $tagModel->findAll(),
            'title'      => 'Tambah Lokasi - PUASKULINER'
        ];
        
        return view('user/submit', $data);
    }

    public function storeSubmission()
    {
        $locationModel = new CulinaryLocationModel();
        $photoModel = new \App\Models\CulinaryPhotoModel();
        
        $data = [
            'category_id' => $this->request->getPost('category_id'),
            'name'        => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'address'     => $this->request->getPost('address'),
            'latitude'    => $this->request->getPost('latitude'),
            'longitude'   => $this->request->getPost('longitude'),
            'maps_url'    => $this->request->getPost('maps_url'),
            'status'      => 'pending',
        ];

        $locationId = $locationModel->insert($data);

        // Handle tags
        $tags = $this->request->getPost('tags');
        if ($tags) {
            $db = \Config\Database::connect();
            foreach ($tags as $tagId) {
                $db->table('location_tags')->insert([
                    'location_id' => $locationId,
                    'tag_id'      => $tagId
                ]);
            }
        }

        // Handle up to 3 photos
        $photos = $this->request->getFileMultiple('photos');
        if ($photos) {
            $db = \Config\Database::connect();
            $count = 0;
            foreach ($photos as $file) {
                if ($count >= 3) break;
                if ($file->isValid() && !$file->hasMoved()) {
                    $fileName = $file->getRandomName();
                    $file->move(FCPATH . 'uploads/locations', $fileName);
                    
                    // Resize Main Photo
                    \Config\Services::image()
                        ->withFile(FCPATH . 'uploads/locations/' . $fileName)
                        ->resize(800, 800, true, 'height')
                        ->save(FCPATH . 'uploads/locations/' . $fileName);
                    
                    // Create Thumbnail
                    \Config\Services::image()
                        ->withFile(FCPATH . 'uploads/locations/' . $fileName)
                        ->resize(300, 300, true, 'center')
                        ->save(FCPATH . 'uploads/locations/thumbnails/' . $fileName);

                    // If first photo, set as main photo in culinary_locations
                    if ($count == 0) {
                        $locationModel->update($locationId, ['photo' => $fileName]);
                    }

                    $db->table('culinary_photos')->insert([
                        'location_id' => $locationId,
                        'photo_path'  => $fileName,
                        'created_at'  => date('Y-m-d H:i:s')
                    ]);
                    $count++;
                }
            }
        }

        return redirect()->to('/')->with('success', 'Lokasi berhasil dikirim dan menunggu persetujuan admin.');
    }

    public function editReview($id)
    {
        $reviewModel = new ReviewModel();
        $review = $reviewModel->find($id);

        if (!$review || $review['user_id'] != session()->get('id')) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses.');
        }

        // Check 24 hours
        $createdAt = new \DateTime($review['created_at']);
        $now = new \DateTime();
        $diff = $now->diff($createdAt);
        $hours = $diff->h + ($diff->days * 24);

        if ($hours >= 24) {
            return redirect()->back()->with('error', 'Review hanya dapat diubah dalam 24 jam pertama.');
        }

        $data = [
            'review' => $review,
            'title'  => 'Edit Review'
        ];

        return view('user/edit_review', $data);
    }

    public function updateReview($id)
    {
        $reviewModel = new ReviewModel();
        $locationModel = new CulinaryLocationModel();
        
        $review = $reviewModel->find($id);
        if (!$review || $review['user_id'] != session()->get('id')) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses.');
        }

        $data = [
            'rating'  => $this->request->getPost('rating'),
            'comment' => $this->request->getPost('comment'),
        ];

        $reviewModel->update($id, $data);

        // Update rating_avg for location
        $locationId = $review['location_id'];
        $avg = $reviewModel->where('location_id', $locationId)->selectAvg('rating')->first();
        $locationModel->update($locationId, ['rating_avg' => $avg['rating'] ?? 0]);

        return redirect()->to('/location/' . $locationId)->with('success', 'Review berhasil diperbarui.');
    }

    public function requestClosure($locationId)
    {
        $locationModel = new CulinaryLocationModel();
        $locationModel->update($locationId, ['closure_requested' => 1]);
        return redirect()->back()->with('success', 'Permintaan penutupan lokasi telah dikirim ke admin.');
    }

    public function apiPuaskuliner()
    {
        $locationModel = new CulinaryLocationModel();
        $lat = $this->request->getVar('lat');
        $lng = $this->request->getVar('lng');
        $radius = $this->request->getVar('radius') ?: 5; // Default 5km

        $db = \Config\Database::connect();
        // Haversine formula for distance calculation
        $sql = "SELECT *, (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance 
                FROM culinary_locations 
                WHERE status = 'approved' 
                AND latitude IS NOT NULL 
                AND longitude IS NOT NULL
                HAVING distance < ? 
                ORDER BY distance";
        
        $results = $db->query($sql, [$lat, $lng, $lat, $radius])->getResultArray();

        return $this->response->setJSON($results);
    }

    public function detail($id)
    {
        $locationModel = new CulinaryLocationModel();
        $reviewModel = new ReviewModel();
        $favoriteModel = new FavoriteModel();

        $location = $locationModel->select('culinary_locations.*, categories.name as category_name')
                                   ->join('categories', 'categories.id = culinary_locations.category_id')
                                   ->find($id);

        if (!$location) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $reviews = $reviewModel->select('reviews.*, users.username')
                               ->join('users', 'users.id = reviews.user_id')
                               ->where('location_id', $id)
                               ->orderBy('created_at', 'DESC')
                               ->findAll();

        $isFavorite = false;
        if (session()->get('isLoggedIn')) {
            $isFavorite = $favoriteModel->where(['user_id' => session()->get('id'), 'location_id' => $id])->first() ? true : false;
        }

        $data = [
            'location'   => $location,
            'reviews'    => $reviews,
            'isFavorite' => $isFavorite,
            'title'      => $location['name']
        ];

        return view('user/detail', $data);
    }

    public function toggleFavorite($locationId)
    {
        $favoriteModel = new FavoriteModel();
        $userModel = new \App\Models\UserModel();
        $userId = session()->get('id');

        // Cek apakah user masih ada di database
        if (!$userId || !$userModel->find($userId)) {
            session()->destroy();
            return redirect()->to('/login')->with('error', 'Sesi Anda telah berakhir. Silakan login kembali.');
        }

        $existing = $favoriteModel->where(['user_id' => $userId, 'location_id' => $locationId])->first();

        if ($existing) {
            $favoriteModel->delete($existing['id']);
            return redirect()->back()->with('success', 'Lokasi dihapus dari favorit.');
        } else {
            $favoriteModel->insert(['user_id' => $userId, 'location_id' => $locationId]);
            return redirect()->back()->with('success', 'Lokasi ditambahkan ke favorit.');
        }
    }

    public function favorites()
    {
        $favoriteModel = new FavoriteModel();
        $userId = session()->get('id');

        $favorites = $favoriteModel->select('culinary_locations.*, categories.name as category_name')
                                   ->join('culinary_locations', 'culinary_locations.id = favorites.location_id')
                                   ->join('categories', 'categories.id = culinary_locations.category_id')
                                   ->where('favorites.user_id', $userId)
                                   ->findAll();

        $data = [
            'locations' => $favorites,
            'title'     => 'Favorit Saya'
        ];

        return view('user/favorites', $data);
    }

    public function addReview($locationId)
    {
        $reviewModel = new ReviewModel();
        $locationModel = new CulinaryLocationModel();
        $userModel = new \App\Models\UserModel();

        $userId = session()->get('id');
        
        // Cek apakah user masih ada di database (mencegah FK error jika DB di-reset)
        if (!$userId || !$userModel->find($userId)) {
            session()->destroy();
            return redirect()->to('/login')->with('error', 'Sesi Anda telah berakhir atau database telah di-reset. Silakan login kembali.');
        }

        $file = $this->request->getFile('photo');
        $fileName = '';
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/reviews', $fileName);

            // Image resizing using CI4 Image Library
            \Config\Services::image()
                ->withFile(FCPATH . 'uploads/reviews/' . $fileName)
                ->resize(800, 800, true, 'height')
                ->save(FCPATH . 'uploads/reviews/' . $fileName);

            // Create Thumbnail
            \Config\Services::image()
                ->withFile(FCPATH . 'uploads/reviews/' . $fileName)
                ->resize(200, 200, true, 'center')
                ->save(FCPATH . 'uploads/reviews/thumbnails/' . $fileName);
        }

        $data = [
            'user_id'     => $userId,
            'location_id' => (int) $locationId,
            'rating'      => (int) $this->request->getPost('rating'),
            'comment'     => $this->request->getPost('comment'),
            'photo'       => $fileName,
        ];

        try {
            $reviewModel->insert($data);

            // Update rating_avg for location
            $avg = $reviewModel->where('location_id', $locationId)->selectAvg('rating')->first();
            $locationModel->update($locationId, ['rating_avg' => $avg['rating'] ?? 0]);

            return redirect()->back()->with('success', 'Ulasan Anda berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
