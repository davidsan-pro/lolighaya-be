<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\BarangModel;

class Barang extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */

    use ResponseTrait;

    public function index()
    {
        $model = new BarangModel();

        $data = [];

        $searchStr = $this->request->getVar('q');
        if ($searchStr)
        {
            $model->groupStart()
                    ->like('nama', $searchStr)
                ->groupEnd();
        }
        $data = $model->findAll();

        return $this->respond($data);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $model = new BarangModel();
        $data = $model->find(['id' => $id]);

        if ( ! $data) {
            return $this->failNotFound('Data not found');
        }

        return $this->respond($data[0]);
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        helper(['form']);

        $rules = [
            'nama' => 'required',
        ];

        $data = [
            'nama' => $this->request->getVar('nama'),
            'stok' => $this->request->getVar('stok') ? : 0,
            'foto' => $this->request->getVar('foto'),
        ];

        if ( ! $this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }

        $model = new BarangModel();
        $model->save($data);

        $response = [
            'status' => 201,
            'error' => null,
            'messages' => [
                'success' => 'Data barang berhasil ditambahkan'
            ]
        ];
        return $this->respondCreated($response);
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        helper(['form']);

        $rules = [
            'nama' => 'required',
        ];

        $data = [
            'nama' => $this->request->getVar('nama'),
            'stok' => $this->request->getVar('stok') ? : 0,
            'foto' => $this->request->getVar('foto'),
        ];

        if ( ! $this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }
        
        $model = new BarangModel();

        $findById = $model->find(['id' => $id]);

        if ( ! $findById) {
            return $this->failNotFound('Data not found');
        }

        $model->update($id, $data);

        $response = [
            'status' => 200,
            'error' => null,
            'messages' => [
                'success' => 'Data barang berhasil diupdate'
            ]
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
        $model = new BarangModel();

        $findById = $model->find(['id' => $id]);

        if ( ! $findById) {
            return $this->failNotFound('Data not found');
        }

        $model->delete($id);

        $response = [
            'status' => 200,
            'error' => null,
            'messages' => [
                'success' => 'Data barang berhasil dihapus'
            ]
        ];
        return $this->respond($response);
    }
}
