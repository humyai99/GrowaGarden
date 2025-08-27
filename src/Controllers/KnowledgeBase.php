<?php

namespace Controllers;

use Core\Controller;

class KnowledgeBase extends Controller {
    private $kbModel;

    public function __construct() {
        $this->kbModel = $this->model('KnowledgeBase');
    }

    /**
     * Index method to display all KB articles
     */
    public function index() {
        $articles = $this->kbModel->getAll();

        $data = [
            'title' => 'IT Knowledge Base',
            'articles' => $articles
        ];

        $this->view('kb/index', $data);
    }

    /**
     * Show a single KB article
     * @param int $id
     */
    public function show($id) {
        $article = $this->kbModel->findById($id);

        if (!$article) {
            // Optionally, redirect to a 404 page
            header('location: ' . URL_ROOT . '/knowledgebase');
            exit();
        }

        $data = [
            'title' => $article->title,
            'article' => $article
        ];

        $this->view('kb/show', $data);
    }
}
