<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\TokoModel;

class toko extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */

    use ResponseTrait;

    public function index()
    {
        // $tmp = [
        //     'status' => 0,
        //     'message' => 'asdasdasd',
        // ];
        // return $this->respond($tmp);
        $model = new TokoModel();

        $data = [];

        $searchStr = $this->request->getVar('q');
        if ($searchStr)
        {
            $model->groupStart()
                            ->like('nama', $searchStr)
                        ->groupEnd()
                        ;
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
        $model = new TokoModel();
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
            'alamat' => 'required',
            'kota' => 'required',
            'kecamatan' => 'required',
            'telepon' => 'required'
        ];

        $data = [
            'nama' => $this->request->getVar('nama'),
            'foto' => $this->request->getVar('foto'),
            'alamat' => $this->request->getVar('alamat'),
            'kota' => $this->request->getVar('kota'),
            'kecamatan' => $this->request->getVar('kecamatan'),
            'telepon' => $this->request->getVar('telepon'),
        ];

        if ( ! $this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }

        $model = new TokoModel();
        $model->save($data);

        $response = [
            'status' => 201,
            'error' => null,
            'messages' => [
                'success' => 'Data toko berhasil ditambahkan'
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
            'foto' => $this->request->getVar('foto'),
            'alamat' => $this->request->getVar('alamat'),
            'kota' => $this->request->getVar('kota'),
            'kecamatan' => $this->request->getVar('kecamatan'),
            'telepon' => $this->request->getVar('telepon'),
        ];

        if ( ! $this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }
        
        $model = new TokoModel();

        $findById = $model->find(['id' => $id]);

        if ( ! $findById) {
            return $this->failNotFound('Data not found');
        }

        $model->update($id, $data);

        $response = [
            'status' => 200,
            'error' => null,
            'messages' => [
                'success' => 'Data toko berhasil diupdate'
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
        $model = new TokoModel();

        $findById = $model->find(['id' => $id]);

        if ( ! $findById) {
            return $this->failNotFound('Data not found');
        }

        $model->delete($id);

        $response = [
            'status' => 200,
            'error' => null,
            'messages' => [
                'success' => 'Data toko berhasil dihapus'
            ]
        ];
        return $this->respond($response);
    }
}
