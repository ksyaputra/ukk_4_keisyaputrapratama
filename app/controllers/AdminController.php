<?php
class AdminController extends Controller {
    private $bookModel;
    private $userModel;
    private $loanModel;
    private $categoryModel;

    public function __construct() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            $_SESSION['flash'] = 'Akses ditolak! Silakan login sebagai Admin.';
            header('Location: ' . BASEURL . '/auth');
            exit;
        }
        $this->bookModel = $this->model('Book');
        $this->userModel = $this->model('User');
        $this->loanModel = $this->model('Loan');
        $this->categoryModel = $this->model('Category');
    }

    // ========== DASHBOARD ==========
    public function index() {
        $data['title'] = 'Dashboard Admin';
        $data['page'] = 'dashboard';
        $data['user'] = $_SESSION['user'];
        $data['totalBooks'] = $this->bookModel->countAll();
        $data['totalMembers'] = $this->userModel->countAll();
        $data['activeLoans'] = $this->loanModel->countActive();
        $data['totalFines'] = $this->loanModel->getTotalFines();
        $data['recentLoans'] = $this->loanModel->getRecentLoans(5);

        $this->view('layouts/header', $data);
        $this->view('admin/index', $data);
        $this->view('layouts/footer');
    }

    // ========== KATEGORI ==========
    public function categories() {
        $data['title'] = 'Kelola Kategori';
        $data['page'] = 'categories';
        $data['user'] = $_SESSION['user'];
        $data['categories'] = $this->categoryModel->getAllCategories();

        $this->view('layouts/header', $data);
        $this->view('admin/categories', $data);
        $this->view('layouts/footer');
    }

    public function addCategory() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->categoryModel->addCategory($_POST['name']);
            $_SESSION['success'] = 'Kategori berhasil ditambahkan!';
            $this->redirect('admin/categories');
        }
    }

    public function editCategory($id = null) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $id) {
            $this->categoryModel->updateCategory(['id' => $id, 'name' => $_POST['name']]);
            $_SESSION['success'] = 'Kategori berhasil diperbarui!';
            $this->redirect('admin/categories');
        }
    }

    public function deleteCategory($id = null) {
        if ($id) {
            $this->categoryModel->deleteCategory($id);
            $_SESSION['success'] = 'Kategori berhasil dihapus!';
            $this->redirect('admin/categories');
        }
    }

    // ========== BUKU ==========
    public function books() {
        $data['title'] = 'Kelola Buku';
        $data['page'] = 'books';
        $data['user'] = $_SESSION['user'];
        $data['books'] = $this->bookModel->getAllBooks();
        $data['categories'] = $this->categoryModel->getAllCategories();

        $this->view('layouts/header', $data);
        $this->view('admin/books', $data);
        $this->view('layouts/footer');
    }

    public function addBook() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->bookModel->addBook([
                'category_id' => $_POST['category_id'],
                'title' => $_POST['title'],
                'author' => $_POST['author'],
                'publish_year' => $_POST['publish_year'],
                'quantity' => $_POST['quantity'],
                'cover_image' => 'default_cover.png'
            ]);
            $_SESSION['success'] = 'Buku berhasil ditambahkan!';
            $this->redirect('admin/books');
        }
    }

    public function editBook($id = null) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $id) {
            $book = $this->bookModel->getBookById($id);
            $this->bookModel->updateBook([
                'id' => $id,
                'category_id' => $_POST['category_id'],
                'title' => $_POST['title'],
                'author' => $_POST['author'],
                'publish_year' => $_POST['publish_year'],
                'quantity' => $_POST['quantity'],
                'cover_image' => $book['cover_image']
            ]);
            $_SESSION['success'] = 'Buku berhasil diperbarui!';
            $this->redirect('admin/books');
        }
    }

    public function deleteBook($id = null) {
        if ($id) {
            $this->bookModel->deleteBook($id);
            $_SESSION['success'] = 'Buku berhasil dihapus!';
            $this->redirect('admin/books');
        }
    }

    // ========== ANGGOTA ==========
    public function members() {
        $data['title'] = 'Kelola Anggota';
        $data['page'] = 'members';
        $data['user'] = $_SESSION['user'];
        $data['members'] = $this->userModel->getAllMembers();

        $this->view('layouts/header', $data);
        $this->view('admin/members', $data);
        $this->view('layouts/footer');
    }

    public function deleteMember($id = null) {
        if ($id) {
            $this->userModel->deleteUser($id);
            $_SESSION['success'] = 'Anggota berhasil dihapus!';
            $this->redirect('admin/members');
        }
    }

    // ========== PEMINJAMAN ==========
    public function loans() {
        $data['title'] = 'Kelola Peminjaman';
        $data['page'] = 'loans';
        $data['user'] = $_SESSION['user'];
        $data['loans'] = $this->loanModel->getAllLoans();

        $this->view('layouts/header', $data);
        $this->view('admin/loans', $data);
        $this->view('layouts/footer');
    }

    public function returnLoan($id = null) {
        if ($id) {
            $loan = $this->loanModel->getLoanById($id);
            $this->loanModel->returnBook($id);
            // Kembalikan stok buku
            $this->bookModel->updateQuantity($loan['book_id'], 1);
            $_SESSION['success'] = 'Buku berhasil dikembalikan!';
            $this->redirect('admin/loans');
        }
    }
}
