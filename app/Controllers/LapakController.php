<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;
use App\Models\LapakModel;

class LapakController extends ResourceController
{
    use ResponseTrait;

    protected $format    = 'json';
    public function __construct()
    {
        $this->lapakModel = new LapakModel();
    }

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $lapak = $this->lapakModel->findAll();
        $filteredProducts = [];

        // Filter the products to include only the required columns
        foreach ($lapak as $product) {
            $filteredProduct = [
                'id'                 => $product['id'],
                'img_lapak'          => $product['img_lapak'],
                'title_lapak'        => $product['title_lapak'],
                'price'              => $product['price'],
                'short_description'  => $product['short_description'],
            ];

            $filteredProducts[] = $filteredProduct;
        }
        return $this->respond($filteredProducts);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $lapak = $this->lapakModel->find($id);
        if (!$lapak) {
            return $this->failNotFound('Product not found.');
        }
        
        return $this->respond($lapak);
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        $data = $this->request->getJSON(true);

        // Validate input data
        $validation =  \Config\Services::validation();
        $validation->setRules([
            'img_lapak' => 'required',
            'title_lapak' => 'required',
            'price' => 'required|numeric',
            'short_description' => 'required',
            'description_lapak' => 'required'
        ]);

        if (!$validation->run($data)) {
            return $this->failValidationErrors($validation->getErrors());
        }

        $this->lapakModel->insert($data);
        $response = [
            'status' => 201,
            'error' => null,
            'message' => 'Product created successfully.'
        ];
        
        return $this->respondCreated($response);
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        $data = $this->request->getJSON(true);

        // Validate input data
        $validation =  \Config\Services::validation();
        $validation->setRules([
            'img_lapak' => 'required',
            'title_lapak' => 'required',
            'price' => 'required|numeric',
            'short_description' => 'required',
            'description_lapak' => 'required'
        ]);

        if (!$validation->run($data)) {
            return $this->failValidationErrors($validation->getErrors());
        }

        $lapak = $this->lapakModel->find($id);
        
        if (!$lapak) {
            return $this->failNotFound('Product not found.');
        }

        $this->lapakModel->update($id, $data);
        $response = [
            'status' => 200,
            'error' => null,
            'message' => 'Product updated successfully.'
        ];
        
        return $this->respond($response);
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $product = $this->lapakModel->find($id);
        
        if (!$product) {
            return $this->failNotFound('Product not found.');
        }

        $this->lapakModel->delete($id);
        $response = [
            'status' => 200,
            'error' => null,
            'message' => 'Product deleted successfully.'
        ];
        
        return $this->respondDeleted($response);
    }

    public function countItems()
    {
        $count = $this->lapakModel->countAll();

        $data = [
            'lapak_count' => $count
        ];

        return $this->respond($data);
    }

    
    public function search()
    {
        $searchStr = $this->request->getVar("q");
        $lapak = $this->lapakModel->like('title_lapak', $searchStr)->findAll();

        if (!$lapak) {
            return $this->respond(['message' => 'Product not found'], 404);
        }

        $filteredProducts = [];

        // Filter the products to include only the required columns
        foreach ($lapak as $product) {
            $filteredProduct = [
                'id'                 => $product['id'],
                'img_lapak'          => $product['img_lapak'],
                'title_lapak'        => $product['title_lapak'],
                'price'              => $product['price'],
                'short_description'  => $product['short_description'],
            ];

            $filteredProducts[] = $filteredProduct;
        }

        return $this->respond($filteredProducts);
    }
}
