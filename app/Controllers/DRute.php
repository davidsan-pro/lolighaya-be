<?php

namespace App\Controllers;

use App\Models\DRuteModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class Drute extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */

    use ResponseTrait;

    public function index()
    {
        $model = new DRuteModel();

        $data = [];

        $qfield = $this->request->getVar('qf');
        $qvalue = $this->request->getVar('qv');

        $params = [];
        if ($qfield) {
            $params[$qfield] = $qvalue;
        }
        $searchStr = $this->request->getVar('q');
        if ($searchStr) {
            $params['q'] = $searchStr;
        }

        $data = $model->getRuteToko($params);

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
        // $asd = [
        //     'status' => 0,
        //     'get' => $this->request->getVar(),
        //     'message' => 'asdasd',
        // ];
        // return $this->respond($asd);

        $model = new DRuteModel();
        $data  = $model->find(['id' => $id]);

        if (!$data) {
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
        $db = \Config\Database::connect();
        // 1. dapatkan no.urut terakhir
        $builder = $db->table('d_rute');
        $builder->select("id_rute, id_toko, urutan")
            ->orderBy('urutan DESC')
            ->limit(1)
        ;
        $query           = $builder->get()->getResultArray();
        $urutan_terakhir = $query[0]['urutan'];

        helper(['form']);

        $rules = [
            'id_rute' => 'required',
            'id_toko' => 'required',
        ];

        $data = [
            'id_rute' => $this->request->getVar('id_rute'),
            'id_toko' => $this->request->getVar('id_toko'),
            'urutan'  => $urutan_terakhir + 1,
        ];

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }

        $model = new DRuteModel();
        $model->save($data);

        // setelah insert data detail rute
        // 2. susun ulang no.urutnya

        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
                'success' => 'Data detail rute berhasil ditambahkan',
            ],
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
            'stok' => $this->request->getVar('stok') ?: 0,
            'foto' => $this->request->getVar('foto'),
        ];

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }

        $model = new DRuteModel();

        $findById = $model->find(['id' => $id]);

        if (!$findById) {
            return $this->failNotFound('Data not found');
        }

        $model->update($id, $data);

        $response = [
            'status'   => 200,
            'error'    => null,
            'messages' => [
                'success' => 'Data master rute berhasil diupdate',
            ],
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
        $model = new DRuteModel();

        $findById = $model->find(['id' => $id]);

        if (!$findById) {
            return $this->failNotFound('Data not found');
        }

        $model->delete($id);

        $response = [
            'status'   => 200,
            'error'    => null,
            'messages' => [
                'success' => 'Data master rute berhasil dihapus',
            ],
        ];
        return $this->respond($response);
    }
}
