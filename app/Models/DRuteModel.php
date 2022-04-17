<?php

namespace App\Models;

use CodeIgniter\Model;

class DRuteModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'd_rute';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_rute', 'urutan', 'id_toko', 'created_at', 'updated_at'];

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
    public function getRuteToko($params)
    {
        $query = $this->db->table('d_rute as d')
            ->select('d.id as key_id, d.urutan, toko.*')
            ->join('toko', 'toko.id = d.id_toko')
            ;
        if (!empty($params['id_rute'])) {
            // $params['id_rute'] = $this->db->escape($params['id_rute']);
            $query = $query->where('d.id_rute', $params['id_rute']);
        }
        if (!empty($params['q'])) {
            $query = $query->like('toko.nama', $params['q']);
        }
        if (!empty($params['urutan'])) {
            $query = $query->where('d.urutan', $params['urutan']);
        } else {
            $query = $query->where('d.urutan >', 0);
        }

        if (!empty($params['order_by'])) {
            $query = $query->orderBy($params['order_by']);
        } else {
            $query = $query->orderBy('d.urutan ASC, d.id ASC');
        }

        $query = $query->get();
        $result = $query->getResultArray();

        return $result;
    }
}
