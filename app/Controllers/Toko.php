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
        $db = \Config\Database::connect();

        $model = new TokoModel();

        $str = "select id_rute, id_toko, urutan from d_rute where urutan > 0";
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
            // $model->where('d.urutan >', 0);
        }
        $not_in_field = (array)$this->request->getVar('qf_not_in');
        $not_in_value = (array)$this->request->getVar('qv_not_in');

        $sql = [];
        for ($i=0; $i<count($not_in_field); $i++) {
            if ($not_in_field[$i] === 'id_rute') {
                $subQuery = $db->table('d_rute')
                    ->select('id_toko')
                    ->where('id_rute', $not_in_value[$i])
                    ->groupBy('id_toko')
                    ->get()->getResultArray();
                $sql[] = $db->getLastQuery()->getQuery();
                // $asd1 .= ';countsubquery='.count($subQuery);
                foreach ($subQuery as $x => $rowx) {
                    $model->where('toko.id !=', $rowx['id_toko']);
                }
                // if (count($subQuery)) {
                //     for ($x=0; $x<count($subQuery); $x++) {
                //         $arr[] = $subQuery[$x]['id_toko'];
                //     }
                //     $model->where('toko.id', 1);
                // }
            }
        }
        // if ($not_in_field && $not_in_value) {
        //     $model->whereNotIn($not_in_field, $not_in_value);
        // }
        
        $model->groupBy('toko.id');

        $data = $model->findAll();
        $sql[] = $model->getLastQuery()->getQuery();
        $result = [
            'data' => $data,
            'sql' => $sql,
            // 'sub' => $subQuery,
            // 'asd1' => json_decode($subQuery),
            'asd2' => $not_in_value,
        ];

        // $asd = [
        //     'get' => $this->request->getVar(),
        //     'sql' => $model->getLastQuery()->getQuery(),
        //     'data' => $data,
        // ];
        // return $this->respond($asd);

        return $this->respond($result);
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
