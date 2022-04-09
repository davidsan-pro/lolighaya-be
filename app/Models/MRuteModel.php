<?php

namespace App\Models;

use CodeIgniter\Model;

class MRuteModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'm_rute';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nama_rute', 'hari', 'status', 'created_at', 'updated_at'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    // additional functions
    public function findAllById(int $id, $params=[])
    {
        $id = $this->db->escape($id);

        $query = $this->db->table($this->table.' as m')
            ->select('m.*')
            ->join(
                "(
                    select m1.*
                    from {$this->table} as m1
                    where m1.id = {$id}
                ) as mt
                ", 'mt.nama_rute = m.nama_rute'
            )
            ;
        if (!empty($params['id_rute'])) {
            $query = $query->where('m.id', $params['id_rute']);
        }
        $query = $query->get();
        $result = $query->getResultArray();

        return $result;
    }
    // end public function findAllById

    public function customUpdate(int $id, $update_data=[]) 
    {
        $active_days = $update_data['hari']; // array angka hari yg aktif
        $nama_rute = $update_data['nama_rute'];
        $list_data = $update_data['list_data'];

        // // sanitize inputs tdk diperlukan kalo pake method query builder nya CI
        // $id = $this->db->escape($id);
        // foreach ($active_days as &$row)
        // {
        //     $row = $this->db->escape($row);
        // }

        // siapkan variabel utk updateBatch
        $data = [];
        foreach ($list_data as $rowList) {
            $temp = [
                'id' => $rowList['id'],
                'nama_rute' => $nama_rute,
                'status' => 0,
            ];
            foreach ($active_days as $rowHari) {
                if ((int)$rowHari == (int)$rowList['hari']) {
                    $temp['status'] = 1;
                    break;
                }
            }
            $data[] = $temp;
        }
        
        $result = null;
        if ($data) {
            $result = $this->db->table('m_rute')->updateBatch($data, 'id');
        }
        return $result;
    }
    // end public function customUpdate

    public function myUpdate($data)
    {
        $this->db->table('m_rute')->updateBatch($data, 'id');

        return $this->db->getLastQuery()->getQuery();
    }
}
