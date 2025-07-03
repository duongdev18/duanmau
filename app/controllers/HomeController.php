<?php
class HomeController extends Controller {
    public function __construct() {
        // Load models if needed
        // $this->productModel = $this->model('Product');
    }
    
    public function index() {
        $data = [
            'title' => 'Welcome to ' . SITE_NAME,
            'description' => 'Shop the latest products online'
        ];
        
        $this->view('templates/header', $data);
        $this->view('home/index', $data);
        $this->view('templates/footer');
    }
} 