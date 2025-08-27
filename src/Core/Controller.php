<?php

namespace Core;

/*
 * Base Controller
 * Loads the models and views
 */
abstract class Controller {
    // Load model
    public function model($model) {
        $modelClass = 'Models\\' . $model;
        // Check if the model class exists before instantiating
        if (class_exists($modelClass)) {
            return new $modelClass();
        } else {
            // Or you could throw an exception
            die('Model does not exist: ' . $model);
        }
    }

    // Load view
    // Loads a view file from the 'templates' directory
    public function view($view, $data = []) {
        // Construct the path to the view file
        $viewFile = APP_ROOT . '/templates/' . $view . '.php';

        // Check for view file
        if (file_exists($viewFile)) {
            // Extract data array to variables
            extract($data);

            // Require the view file
            require_once $viewFile;
        } else {
            // View does not exist
            die('View does not exist: ' . $view);
        }
    }
}
