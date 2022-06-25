<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;

class Users extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */

    use ResponseTrait;

    private $tblname = 'users';

    public function index()
    {
        // $model = new UserModel();
        $db = \Config\Database::connect();
        $builder = $db->table($this->tblname);

        $data = [];

        $searchStr = $this->request->getVar('q');
        if ($searchStr)
        {
            $builder->groupStart()
                    ->like('username', $searchStr)
                    ->orLike('nama', $searchStr)
                ->groupEnd()
                ;
        }

        $qfield = $this->request->getVar('qf'); // field yg akan difilter. cth: nama_rute
        $qvalue = $this->request->getVar('qv'); // value yg akan dicari di field qf
        if ($qfield && $qvalue)
        {
            $qmode = $this->request->getVar('qmode');
            if ($qmode == 'exact') {
                $builder->where("{$this->tblname}.{$qfield}", $qvalue);
            } else {
                $builder->like("{$this->tblname}.{$qfield}", $qvalue);
            }
        }

        // $data = $model->findAll();
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
        $model = new UserModel();
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
            'username' => 'required',
            'password' => 'required',
            'nama' => 'required',
            'email' => 'required',
            'telepon' => 'required',
        ];

        $data = [
            'username' => $this->request->getVar('username'),
            'password' => $this->request->getVar('password'),
            'profile_pic' => $this->request->getVar('profile_pic') ? : '',
            'nama' => $this->request->getVar('nama'),
            'email' => $this->request->getVar('email'),
            'telepon' => $this->request->getVar('telepon'),
        ];

        if ( ! $this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }

        $model = new UserModel();
        $model->save($data);

        $response = [
            'status' => 201,
            'error' => null,
            'messages' => [
                'success' => 'Data user berhasil ditambahkan'
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
            'username' => 'required',
            'password' => 'required',
            'nama' => 'required',
        ];

        $data = [
            'username' => $this->request->getVar('username'),
            'password' => $this->request->getVar('password'),
            'profile_pic' => $this->request->getVar('profile_pic') ? : '',
            'nama' => $this->request->getVar('nama'),
            'email' => $this->request->getVar('email'),
            'telepon' => $this->request->getVar('telepon'),
        ];

        if ( ! $this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }
        
        $model = new UserModel();

        $findById = $model->find(['id' => $id]);

        if ( ! $findById) {
            return $this->failNotFound('Data not found');
        }

        $model->update($id, $data);

        $response = [
            'status' => 200,
            'error' => null,
            'messages' => [
                'success' => 'Data user berhasil diupdate'
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
        $model = new UserModel();

        $findById = $model->find(['id' => $id]);

        if ( ! $findById) {
            return $this->failNotFound('Data not found');
        }

        $model->delete($id);

        $response = [
            'status' => 200,
            'error' => null,
            'messages' => [
                'success' => 'Data user berhasil dihapus'
            ]
        ];
        return $this->respond($response);
    }
    
    public function login()
    {
        helper(['form']);

        $rules = [
            'username' => 'required',
            'password' => 'required',
        ];
        if ( ! $this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }
        
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        // check if the username is in the `users` table
        $tbl = $this->tblname;
        $db = \Config\Database::connect();
        $builder = $db->table($this->tblname);
        $q = $builder->select("{$tbl}.id, {$tbl}.username, {$tbl}.email, {$tbl}.telepon, {$tbl}.nama, {$tbl}.foto")
                ->where('username', $username)
                ->where('password', $password)
                ->get()
                ;
        $cek = $q->getRow();
        if (empty($cek)) {
            return $this->failNotFound('Data not found');
        }
        
        $status = !empty($cek) ? 201 : 403;
        $message = $status 
            ? "Login berhasil. Selamat datang kembali, {$this->request->getVar('username')}."
            : "Login gagal."
            ;
        
        $response = [
            'status' => $status,
            'id' => $cek->id ? : null,
            'data' => $cek,
            'sql' => $db->getLastQuery()->getQuery(),
            'message' => $message,
        ];
        return $this->respond($response);
    }
}
