<?php

namespace App\Controllers;

use App\Models\DTransaksiModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class Dtransaksi extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */

    use ResponseTrait;

    private $tblname = 'd_transaksi';

    public function index()
    {
        // $db = \Config\Database::connect();
        // $builder = $db->table('m_transaksi as m');
        // $builder->select("m.id as id_rute, GROUP_CONCAT(DISTINCT toko.kota ORDER BY toko.id SEPARATOR ', ') as list_kota");
        // $builder->join('d_rute as d', 'd.id_rute = m.id')
        //     ->join('toko', 'toko.id = d.id_toko')
        //     ->groupBy('m.id')
        //     ;
        // $compiled = $builder->getCompiledSelect();

        // $builder = $db->table('d_rute');
        // $builder->select("id_rute, COUNT(id) as jum_toko")
        //     ->groupBy('id_rute')
        //     ;
        // $compiled_jum_toko = $builder->getCompiledSelect();

        // $model = new DTransaksiModel();

        $data = [];
        $tbl = $this->tblname;

        $db = \Config\Database::connect();
        $builder = $db->table($tbl);

        $cols = "{$tbl}.*, m.id_toko, m.id_user, m.jenis_transaksi"
            . ", barang.nama nama_barang"
            . ", toko.nama nama_toko, users.username";
        $builder->select($cols);
        $builder->join('m_transaksi m', "m.id = {$tbl}.id_transaksi");
        $builder->join('barang', "barang.id = {$tbl}.id_barang", 'left');
        $builder->join('toko', "toko.id = m.id_toko", 'left');
        $builder->join('users', "users.id = m.id_user", 'left');

        // $model->join('('.$compiled.') as t', 't.id_rute = m_rute.id', 'left');
        // $model->join('('.$compiled_jum_toko.') as t_det', 't_det.id_rute = m_rute.id', 'left');

        $searchStr = $this->request->getVar('q');
        if ($searchStr) {
            $builder->groupStart()
                    ->like("toko.nama", $searchStr)
                    ->orLike("barang.nama", $searchStr)
                ->groupEnd();
        }
        $qfield = $this->request->getVar('qf'); // field yg akan difilter. cth: nama_rute
        $qvalue = $this->request->getVar('qv'); // value yg akan dicari di field qf
        if ($qfield && $qvalue)
        {
            $qmode = $this->request->getVar('qmode');
            if ($qmode == 'exact') {
                $builder->where("{$tbl}.{$qfield}", $qvalue);
            } else {
                $builder->like("{$tbl}.{$qfield}", $qvalue);
            }
        }

        $groupBy = $this->request->getVar('gb');
        if ($groupBy) {
            $builder->groupBy("{$tbl}.{$groupBy}");
        } else {
            $builder->groupBy("{$tbl}.id");
        }

        $limit = $this->request->getVar('l');
        if ($limit) {
            $builder->limit((int)$limit);
        }

        $builder->orderBy("{$this->tblname}.id");

        $data = $builder->get()->getResult();
        // $asd = [
        //     'message' => $db->getLastQuery()->getQuery(),
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
        $model = new DTransaksiModel();

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
            'id_toko' => 'required',
            'id_user' => 'required',
            'nilai_transaksi' => 'required',
        ];

        $data = [
            'id_toko' => $this->request->getVar('id_toko'),
            'id_user' => $this->request->getVar('id_user'),
            'nilai_transaksi' => $this->request->getVar('nilai_transaksi'),
        ];

        // $response = [
        //     'status' => 201,
        //     'message' => 'test',
        //     'data' => $data,
        // ];
        // return $this->respond($response);

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }

        $model = new DTransaksiModel();
        $model->save($data);
        $insertedID = $model->getInsertID();

        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
                'success' => 'Data master transaksi berhasil ditambahkan',
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

        $model = new DTransaksiModel();

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
        $model = new DTransaksiModel();

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
