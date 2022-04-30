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
        $model = new TokoModel();

        $str = "select id_rute, id_toko from d_rute";
        $model->join("({$str}) as d", 'd.id_toko = toko.id', 'left');

        $data = [];

        $searchStr = $this->request->getVar('q');
        if ($searchStr)
        {
            $model->groupStart()
                    ->like('toko.nama', $searchStr)
                ->groupEnd()
                ;
        }
        $not_in_table = $this->request->getVar('qt_not_in');
        if ($not_in_table == 'rute') {
            $model->where('d.id_rute', null);
        }
        $not_in_field = $this->request->getVar('qf_not_in');
        $not_in_value = $this->request->getVar('qv_not_in');
        if ($not_in_field && $not_in_value) {
            $model->whereNotIn($not_in_field, $not_in_value);
        }

        $data = $model->findAll();

        // $asd = [
        //     'get' => $this->request->getVar(),
        //     'sql' => $model->getLastQuery()->getQuery(),
        //     'data' => $data,
        // ];
        // return $this->respond($asd);

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
