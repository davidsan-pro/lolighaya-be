<?php

namespace App\Controllers;

use App\Models\MTransaksiModel;
use App\Models\DTransaksiModel;
use App\Models\BarangModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class Mtransaksi extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */

    use ResponseTrait;

    private $tblname = 'm_transaksi';

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

        // $model = new MTransaksiModel();

        $tbl = 'm_transaksi';

        $db = \Config\Database::connect();
        $builder = $db->table($tbl);
        
        $data = [];

        $cols = "{$tbl}.*, toko.nama nama_toko, users.username"
            . ", (select count(id_barang) from d_transaksi where id_transaksi = {$tbl}.id group by id_transaksi) as jum_jenis_brg"
            ;
        $builder->select($cols);
        $builder->join('toko', "toko.id = {$tbl}.id_toko", 'left');
        $builder->join('d_transaksi as d', "d.id_transaksi = {$tbl}.id", 'left');
        $builder->join('barang', "barang.id = d.id_barang", 'left');
        $builder->join('users', "users.id = {$tbl}.id_user", 'left');

        // $builder->join('('.$compiled.') as t', 't.id_rute = m_rute.id', 'left');
        // $builder->join('('.$compiled_jum_toko.') as t_det', 't_det.id_rute = m_rute.id', 'left');

        $searchStr = $this->request->getVar('q');
        if ($searchStr) {
            $builder->groupStart()
                    ->like("toko.nama", $searchStr)
                    ->orLike("barang.nama", $searchStr)
                ->groupEnd();
        }

        $qfield = (array)$this->request->getVar('qf'); // field yg akan difilter. cth: nama_rute
        $qvalue = (array)$this->request->getVar('qv'); // value yg akan dicari di field qf
        $qmode = (array)$this->request->getVar('qmode');
        foreach ($qfield as $i => $qf)
        {
            if (empty($qfield[$i]) || empty($qvalue[$i])) {
                continue;
            }

            if ($qfield[$i] == 'start_date') {
                $builder->where("{$tbl}.updated_at >=", $qvalue[$i]);
            } else if ($qfield[$i] == 'end_date') {
                $builder->where("{$tbl}.updated_at <=", $qvalue[$i]);
            } else if ($qfield[$i] == 'id_toko') {
                $builder->where("toko.id", $qvalue[$i]);
            } else if ($qfield[$i] == 'username') {
                if ($qmode[$i] == 'exact') {
                    $builder->where('users.username', $qvalue[$i]);
                } else {
                    $builder->like('users.username', $qvalue[$i]);
                }
            } else {
                if ($qmode[$i] == 'exact') {
                    $builder->where("{$tbl}.{$qfield[$i]}", $qvalue[$i]);
                } else {
                    $builder->like("{$tbl}.{$qfield[$i]}", $qvalue[$i]);
                }
            }
        }
        // end foreach ($qfield as $i => $qf)

        $groupBy = (array)$this->request->getVar('gb');
        if ($groupBy) {
            foreach ($groupBy as $i => $rowgb)
            {
                $builder->groupBy("{$tbl}.{$rowgb}");
            }
        } else {
            $builder->groupBy("{$tbl}.id");
        }

        $limit = $this->request->getVar('l');
        if ($limit) {
            $builder->limit((int)$limit);
        }

        $orderByField = (array)$this->request->getVar('sbf');
        $orderByMode = (array)$this->request->getVar('sbm');
        if ($orderByField && $orderByMode) {
            foreach ($orderByField as $i => $rowOrder)
            {
                $builder->orderBy("{$tbl}.{$rowOrder}", $orderByMode[$i]);
            }
        } else {
            $builder->orderBy("{$tbl}.id ASC");
        }

        // $data = $builder->get();
        // $asd = [
        //     'message' => 'test',
        //     // 'jumlah' => $builder->countAllResults(),
        //     // 'data' => $data,
        //     'asd' => $this->request->getVar('asd'),
        //     // 'qs' => $this->request->getVar(),
        //     // 'tmp' => $qfield,
        // ];
        // return $this->respond($asd);

        $data = $builder->get()->getResult();

        return $this->respond($data);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        // $model = new MTransaksiModel();

        // $qfield = $this->request->getVar('qf');
        // $qvalue = $this->request->getVar('qv');
        // $params = [];
        // if ($qfield == 'id_rute') {
        //     $params[$qfield] = $qvalue;
        // }

        // $groupBy = $this->request->getVar('gb');
        // if ($groupBy) {
        //     $model->groupBy($groupBy);
        // }

        // $data  = $model->findById($id, $params);

        if (!$id) {
            $this->fail('Parameter ID tidak boleh kosong');
        }
        
        $tbl = 'm_transaksi';

        $db = \Config\Database::connect();
        $builder = $db->table($tbl);
        
        $data = [];

        $cols = "{$tbl}.*, toko.nama nama_toko, users.username"
            . ", (select count(id_barang) from d_transaksi where id_transaksi = {$tbl}.id group by id_transaksi) as jum_jenis_brg"
            ;
        $builder->select($cols);
        $builder->join('toko', "toko.id = {$tbl}.id_toko", 'left');
        $builder->join('d_transaksi as d', "d.id_transaksi = {$tbl}.id", 'left');
        $builder->join('barang', "barang.id = d.id_barang", 'left');
        $builder->join('users', "users.id = {$tbl}.id_user", 'left');
        $builder->where("{$tbl}.id", $id);

        $searchStr = $this->request->getVar('q');
        if ($searchStr) {
            $builder->groupStart()
                    ->like("toko.nama", $searchStr)
                    ->orLike("barang.nama", $searchStr)
                ->groupEnd();
        }

        $qfield = (array)$this->request->getVar('qf'); // field yg akan difilter. cth: nama_rute
        $qvalue = (array)$this->request->getVar('qv'); // value yg akan dicari di field qf
        $qmode = (array)$this->request->getVar('qmode');
        foreach ($qfield as $i => $qf)
        {
            if (empty($qfield[$i]) || empty($qvalue[$i])) {
                continue;
            }

            if ($qfield[$i] == 'start_date') {
                $builder->where("{$tbl}.updated_at >=", $qvalue[$i]);
            } else if ($qfield[$i] == 'end_date') {
                $builder->where("{$tbl}.updated_at <=", $qvalue[$i]);
            } else if ($qfield[$i] == 'id_toko') {
                $builder->where("toko.id", $qvalue[$i]);
            } else if ($qfield[$i] == 'username') {
                if ($qmode[$i] == 'exact') {
                    $builder->where('users.username', $qvalue[$i]);
                } else {
                    $builder->like('users.username', $qvalue[$i]);
                }
            } else {
                if ($qmode[$i] == 'exact') {
                    $builder->where("{$tbl}.{$qfield[$i]}", $qvalue[$i]);
                } else {
                    $builder->like("{$tbl}.{$qfield[$i]}", $qvalue[$i]);
                }
            }
        }
        // end foreach ($qfield as $i => $qf)

        $groupBy = (array)$this->request->getVar('gb');
        if ($groupBy) {
            foreach ($groupBy as $i => $rowgb)
            {
                $builder->groupBy("{$tbl}.{$rowgb}");
            }
        } else {
            $builder->groupBy("{$tbl}.id");
        }

        $limit = $this->request->getVar('l');
        if ($limit) {
            $builder->limit((int)$limit);
        }

        $orderByField = (array)$this->request->getVar('sbf');
        $orderByMode = (array)$this->request->getVar('sbm');
        if ($orderByField && $orderByMode) {
            foreach ($orderByField as $i => $rowOrder)
            {
                $builder->orderBy("{$tbl}.{$rowOrder}", $orderByMode[$i]);
            }
        } else {
            $builder->orderBy("{$tbl}.id ASC");
        }

        $data = $builder->get()->getResult();
        
        // if (!$data) {
        //     return $this->failNotFound('Data not found');
        // }
        // $asd = [
        //     'status' => 0,
        //     'message' => $db->getLastQuery()->getQuery(),
        //     'data' => $data,
        // ];
        // return $this->respond($asd);

        return $this->respond($data);
    }
    // end public function show
    
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

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }

        $model = new MTransaksiModel();
        $model->save($data);
        $insertID = $model->getInsertID();

        // simpan ke tabel detail
        $details = (array)$this->request->getVar('details');

        $data = [];
        for ($i=0; $i<count($details); $i++) {
            $details[$i] = (array)$details[$i];
            $data[] = [
                'id_transaksi' => $insertID,
                'id_barang' => $details[$i]['id'],
                'harga' => empty($details[$i]['harga']) ? 0 : $details[$i]['harga'],
                'titip' => empty($details[$i]['titip']) ? 0 : $details[$i]['titip'],
                'sisa' => empty($details[$i]['sisa']) ? 0 : $details[$i]['sisa'],
                'laku' => empty($details[$i]['laku']) ? 0 : $details[$i]['laku'],
            ];
        }
        $db = \Config\Database::connect();
        $builder = $db->table('d_transaksi');
        if ($data) {
            $builder->insertBatch($data);
        }

        // sesuaikan angka sisa stok di tabel barang
        $db = \Config\Database::connect();
        $builder = $db->table('barang');

        $whereInID = [];
        for ($i=0; $i<count($details); $i++) {
            $whereInID[] = $details[$i]['id'];
        }
        $barang = [];
        if (!empty($whereInID)) {
            $builder->whereIn('id', $whereInID);
            $barang = $builder->get()->getResultArray();
        }
        $data = [];
        for ($i=0; $i<count($details); $i++) {
            $jumlahTitip = empty($details[$i]['jumlahTitip']) ? 0 : $details[$i]['jumlahTitip'];
            $sisa = empty($details[$i]['sisa']) ? 0 : $details[$i]['sisa'];

            for ($j=0; $j<count($barang); $j++) {
                if ($details[$i]['id'] == $barang[$j]['id']) {
                    $data[] = [
                        'id' => $barang[$j]['id'],
                        'stok' => $barang[$j]['stok'] - $jumlahTitip + $sisa,
                    ];
                }
                // end if ($details[$i]['id'] == $barang[$j]['id']) 
            }
            // end for ($j=0; $j<count($barang); $j++) 
        }
        // end for ($i=0; $i<count($details); $i++) 
        if ($data) {
            $builder->updateBatch($data, 'id');
        }

        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
                'success' => 'Data transaksi berhasil ditambahkan',
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

        $model = new MTransaksiModel();

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
        $model = new MTransaksiModel();

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
