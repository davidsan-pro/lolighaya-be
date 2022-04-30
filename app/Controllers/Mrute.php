<?php

namespace App\Controllers;

use App\Models\MRuteModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class Mrute extends ResourceController
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
        $builder = $db->table('m_rute as m');
        $builder->select("m.id as id_rute, GROUP_CONCAT(DISTINCT toko.kota ORDER BY toko.id SEPARATOR ', ') as list_kota");
        $builder->join('d_rute as d', 'd.id_rute = m.id')
            ->join('toko', 'toko.id = d.id_toko')
            ->groupBy('m.id')
            ;
        $compiled = $builder->getCompiledSelect();

        $builder = $db->table('d_rute');
        $builder->select("id_rute, COUNT(id) as jum_toko")
            ->groupBy('id_rute')
            ;
        $compiled_jum_toko = $builder->getCompiledSelect();

        $model = new MRuteModel();

        $data = [];

        $model->join('('.$compiled.') as t', 't.id_rute = m_rute.id', 'left');
        $model->join('('.$compiled_jum_toko.') as t_det', 't_det.id_rute = m_rute.id', 'left');

        $searchStr = $this->request->getVar('q');
        if ($searchStr) {
            $model->groupStart()
                    ->like('m_rute.nama_rute', $searchStr)
                ->groupEnd();
        }
        $qfield = $this->request->getVar('qf'); // field yg akan difilter. cth: nama_rute
        $qvalue = $this->request->getVar('qv'); // value yg akan dicari di field qf
        if ($qfield && $qvalue)
        {
            $qmode = $this->request->getVar('qmode');
            if ($qmode == 'exact') {
                $model->where('m_rute.'.$qfield, $qvalue);
            } else {
                $model->like('m_rute.'.$qfield, $qvalue);
            }
        }

        $groupBy = $this->request->getVar('gb');
        if ($groupBy) {
            $model->groupBy('m_rute.'.$groupBy);
        } else {
            $model->groupBy('m_rute.nama_rute, t.id_rute, t.list_kota');
        }

        $limit = $this->request->getVar('l');
        if ($limit) {
            $model->limit((int)$limit);
        }

        $model->orderBy('m_rute.nama_rute, m_rute.id');

        $data = $model->findAll();
        // $asd = [
        //     'message' => $model->db->getLastQuery()->getQuery(),
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
        $model = new MRuteModel();

        $qfield = $this->request->getVar('qf');
        $qvalue = $this->request->getVar('qv');
        $params = [];
        if ($qfield == 'id_rute') {
            $params[$qfield] = $qvalue;
        }

        $groupBy = $this->request->getVar('gb');
        if ($groupBy) {
            $model->groupBy($groupBy);
        }

        $data  = $model->findAllById($id, $params);

        if (!$data) {
            return $this->failNotFound('Data not found');
        }
        // $asd = [
        //     'status' => 0,
        //     'message' => $model->db->getLastQuery()->getQuery(),
        //     'data' => $data
        // ];
        // return $this->respond($asd);

        return $this->respond($data);
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
            'nama_rute' => 'required',
        ];

        $data = [];

        $namaRute = $this->request->getVar('nama_rute');
        $pilihHari = (array)$this->request->getVar('hari');
        for ($i=0; $i<7; $i++) {
            $temp = [
                'nama_rute' => $namaRute,
                'hari' => $i+1,
            ];
            foreach ($pilihHari as $key => $row) {
                $temp['status'] = $i == (int)$row ? 1 : 0;
            }
            $data[] = $temp;
        }

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }

        $model = new MRuteModel();
        $model->insertBatch($data);

        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
                'success' => 'Data master rute berhasil ditambahkan',
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

        $model = new MRuteModel();

        // $rules = [
        //     'nama_rute' => 'required|is_unique[m_rute.nama_rute]',
        // ];

        // if (!$this->validate($rules)) {
        //     return $this->fail($this->validator->getErrors());
        // }

        // dapatkan list hari yg baru
        $pilihHari = $this->request->getVar('hari'); // [1,2,3,5]
        // $inputHari = [1,2,4,5];
        // dapatkan semua data dr tabel m_rute yg berhubungan dgn nama_rute dan ID ini
        $list = $model->findAllById($id);
        if (!$list) {
            return $this->failNotFound('Data not found');
        }

        // try {
        //     $model->db->transBegin();
        //     // lakukan update field nama_rute
            $update_data = [
                'nama_rute' => $this->request->getVar('nama_rute'),
                'hari' => $pilihHari,
                'list_data' => $list,
            ];
            // $data = [];
            // foreach ($list as $rowList) {
            //     $temp = [
            //         'id' => $rowList['id'],
            //         'status' => 0,
            //     ];
            //     foreach ($pilihHari as $rowHari) {
            //         if ((int)$rowHari == (int)$rowList['hari']) {
            //             $temp['status'] = 1;
            //             break;
            //         }
            //     }
            //     $data[] = $temp;
            // }

            // $sql = $model->myUpdate($data);

            // $response = [
            //     'status'   => 200,
            //     'error'    => null,
            //     'data1' => $update_data,
            //     'data2' => $data,
            //     'data3' => $pilihHari,
            //     'sql' => $sql,
            //     'messages' => [
            //         'success' => 'Data master rute berhasil diupdate',
            //     ],
            // ];
            // return $this->respond($response);

            $model->customUpdate($id, $update_data);

            // $model->db->transCommit();

    
            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'Data master rute berhasil diupdate',
                ],
            ];
            return $this->respond($response);
        // } catch (\Exception $e) {
        //     $this->db->transRollback();
        //     die($e->getMessage());
        // }

        // return $this->respond($response);
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $model = new MRuteModel();

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
