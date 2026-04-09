<?php
class UserController extends Controller {
    private $bookModel;
    private $loanModel;
    private $userModel;
    private $reviewModel;
    private $categoryModel;

    public function __construct() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'user') {
            $_SESSION['flash'] = 'Silakan login terlebih dahulu!';
            header('Location: ' . BASEURL . '/auth');
            exit;
        }
        $this->bookModel = $this->model('Book');
        $this->loanModel = $this->model('Loan');
        $this->userModel = $this->model('User');
        $this->reviewModel = $this->model('Review');
        $this->categoryModel = $this->model('Category');
    }

    // ========== DASHBOARD ==========
    public function index() {
        $data['title'] = 'Dashboard';
        $data['page'] = 'dashboard';
        $data['user'] = $_SESSION['user'];
        $data['activeLoans'] = $this->loanModel->getActiveLoansByUserId($_SESSION['user']['id']);
        $data['totalBooks'] = $this->bookModel->countAll();
        $data['myActiveCount'] = count($data['activeLoans']);

        $this->view('layouts/header', $data);
        $this->view('user/index', $data);
        $this->view('layouts/footer');
    }

    // ========== JELAJAHI BUKU ==========
    public function books() {
        $data['title'] = 'Jelajahi Buku';
        $data['page'] = 'books';
        $data['user'] = $_SESSION['user'];

        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $data['books'] = $this->bookModel->searchBooks($_GET['search']);
            $data['keyword'] = $_GET['search'];
        } else {
            $data['books'] = $this->bookModel->getAllBooks();
            $data['keyword'] = '';
        }

        $data['categories'] = $this->categoryModel->getAllCategories();

        $this->view('layouts/header', $data);
        $this->view('user/books', $data);
        $this->view('layouts/footer');
    }

    // ========== DETAIL BUKU ==========
    public function bookDetail($id = null) {
        if (!$id) $this->redirect('user/books');

        $data['title'] = 'Detail Buku';
        $data['page'] = 'books';
        $data['user'] = $_SESSION['user'];
        $data['book'] = $this->bookModel->getBookById($id);
        $data['reviews'] = $this->reviewModel->getReviewsByBookId($id);
        $data['rating'] = $this->reviewModel->getAverageRating($id);
        $data['hasReviewed'] = $this->reviewModel->hasReviewed($_SESSION['user']['id'], $id);
        $data['activeLoan'] = $this->loanModel->checkActiveLoan($_SESSION['user']['id'], $id);

        if (!$data['book']) $this->redirect('user/books');

        $this->view('layouts/header', $data);
        $this->view('user/book_detail', $data);
        $this->view('layouts/footer');
    }

    // ========== PINJAM BUKU ==========
    public function borrow($bookId = null) {
        if (!$bookId) $this->redirect('user/books');

        $book = $this->bookModel->getBookById($bookId);
        if (!$book || $book['quantity'] <= 0) {
            $_SESSION['flash'] = 'Buku tidak tersedia untuk dipinjam!';
            $this->redirect('user/books');
            return;
        }

        // Cek apakah sudah meminjam buku ini
        $existing = $this->loanModel->checkActiveLoan($_SESSION['user']['id'], $bookId);
        if ($existing) {
            $_SESSION['flash'] = 'Anda sudah meminjam buku ini!';
            $this->redirect('user/bookDetail/' . $bookId);
            return;
        }

        $borrowDate = date('Y-m-d');
        $dueDate = date('Y-m-d', strtotime('+7 days'));

        $this->loanModel->addLoan([
            'user_id' => $_SESSION['user']['id'],
            'book_id' => $bookId,
            'borrow_date' => $borrowDate,
            'due_date' => $dueDate
        ]);

        // Kurangi stok
        $this->bookModel->updateQuantity($bookId, -1);

        $_SESSION['success'] = 'Buku berhasil dipinjam! Jatuh tempo: ' . date('d M Y', strtotime($dueDate));
        $this->redirect('user/loans');
    }

    // ========== PEMINJAMAN SAYA ==========
    public function loans() {
        $data['title'] = 'Peminjaman Saya';
        $data['page'] = 'loans';
        $data['user'] = $_SESSION['user'];
        $data['loans'] = $this->loanModel->getLoansByUserId($_SESSION['user']['id']);

        $this->view('layouts/header', $data);
        $this->view('user/loans', $data);
        $this->view('layouts/footer');
    }

    // ========== KEMBALIKAN BUKU ==========
    public function returnBook($loanId = null) {
        if (!$loanId) $this->redirect('user/loans');

        $loan = $this->loanModel->getLoanById($loanId);

        if (!$loan || $loan['user_id'] != $_SESSION['user']['id']) {
            $_SESSION['flash'] = 'Data peminjaman tidak ditemukan!';
            $this->redirect('user/loans');
            return;
        }

        $this->loanModel->returnBook($loanId);
        $this->bookModel->updateQuantity($loan['book_id'], 1);

        $returnDate = date('Y-m-d');
        if ($returnDate > $loan['due_date']) {
            $diff = (strtotime($returnDate) - strtotime($loan['due_date'])) / 86400;
            $fine = $diff * 1000;
            $_SESSION['success'] = 'Buku dikembalikan. Terlambat ' . $diff . ' hari, denda: Rp ' . number_format($fine, 0, ',', '.');
        } else {
            $_SESSION['success'] = 'Buku berhasil dikembalikan tepat waktu!';
        }

        $this->redirect('user/loans');
    }

    // ========== BERI ULASAN ==========
    public function addReview($bookId = null) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $bookId) {
            $this->reviewModel->addReview([
                'user_id' => $_SESSION['user']['id'],
                'book_id' => $bookId,
                'rating' => $_POST['rating'],
                'comment' => $_POST['comment']
            ]);
            $_SESSION['success'] = 'Ulasan berhasil dikirim!';
            $this->redirect('user/bookDetail/' . $bookId);
        }
    }

    // ========== PROFIL ==========
    public function profile() {
        $data['title'] = 'Profil Saya';
        $data['page'] = 'profile';
        $data['user'] = $_SESSION['user'];
        $data['userData'] = $this->userModel->getUserById($_SESSION['user']['id']);
        $data['totalLoans'] = count($this->loanModel->getLoansByUserId($_SESSION['user']['id']));
        $data['activeLoans'] = count($this->loanModel->getActiveLoansByUserId($_SESSION['user']['id']));

        $this->view('layouts/header', $data);
        $this->view('user/profile', $data);
        $this->view('layouts/footer');
    }

    public function updateProfile() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $avatar = $_SESSION['user']['avatar'];

            $this->userModel->updateProfile([
                'id' => $_SESSION['user']['id'],
                'fullname' => $_POST['fullname'],
                'avatar' => $avatar
            ]);

            $_SESSION['user']['fullname'] = $_POST['fullname'];
            $_SESSION['success'] = 'Profil berhasil diperbarui!';
            $this->redirect('user/profile');
        }
    }
}
