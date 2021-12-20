<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\RouterDataModel;
use Exception;

class RouterRest extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $spid = $this->request->getVar('spid');
        $router = new RouterDataModel();
        if(!empty($spid)){
            $router->like('spid', $spid);
        }
        $router->select('id, loopback, hostname, mac, spid');
        $router->where('deleted_at is NULL');
        $response = $router->orderBy('id', 'DESC')->findAll();
        $data = [
            'success' => true,
            'data' => $response
        ];
        return $this->response->setJSON($data);
    }

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function iprange()
    {
        $rules = [
            "ip_start" => "required",
            "ip_end" => "required",
        ];
        if (!$this->validate($rules)) {
            $response = [
                'status' => 500,
                'error' => true,
                'message' => $this->validator->getErrors(),
                'data' => []
            ];
            return $this->respondCreated($response);
        }

        $ip_start = $this->request->getVar('ip_start');
        $ip_end = $this->request->getVar('ip_end');
        $router = new RouterDataModel();
        $router->where("INET_ATON(loopback) BETWEEN INET_ATON('{$ip_start}') AND INET_ATON('{$ip_end}')");
        $router->select('id, loopback, hostname, mac, spid');
        $router->where('deleted_at is NULL');
        $response = $router->orderBy('id', 'DESC')->findAll();
        $data = [
            'success' => true,
            'data' => $response
        ];
        return $this->response->setJSON($data);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        //
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        $rules = [
            "spid" => "required|max_length[18]",
            "loopback" => "required|max_length[14]",
            "hostname" => "required|max_length[18]",
            "mac" => "required|max_length[17]",
        ];
        if (!$this->validate($rules)) {
            $response = [
                'status' => 500,
                'error' => true,
                'message' => $this->validator->getErrors(),
                'data' => []
            ];
            return $this->respondCreated($response);
        }

        $router = new RouterDataModel();
        try{
            $router->transStart();
            $data = [
                'spid' => $this->request->getVar('spid'),
                'hostname' => $this->request->getVar('hostname'),
                'loopback' => $this->request->getVar('loopback'),
                'mac'    => $this->request->getVar('mac'),
            ];
            $router->insert($data);
            $id = $router->getInsertID();
            if($id){
                $data = [
                    'success' => true,
                    'id' => $id
                ];
            }else{
                $data = [
                    'success' => false,
                    'msg' => 'Something went wrong'
                ]; 
            }
            $router->transComplete();
        } catch (Exception $ex) {
            $data = [
                'success' => false,
                'msg' => $ex->getMessage()
            ];
            $router->transRollback();
        }
        return $this->response->setJSON($data);
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($ip = null)
    {
        $rules = [
            "spid" => "required|max_length[18]",
            "hostname" => "required|max_length[18]",
            "mac" => "required|max_length[17]",
        ];
        if (!$this->validate($rules)) {
            $response = [
                'status' => 500,
                'error' => true,
                'message' => $this->validator->getErrors(),
                'data' => []
            ];
            return $this->respondCreated($response);
        }
        $router = new RouterDataModel();
        try{
            $router->transStart();
            $router->set('spid', $this->request->getVar('spid'));
            $router->set('hostname', $this->request->getVar('hostname'));
            $router->set('mac', $this->request->getVar('mac'));
            $router->where('loopback', $ip);
            $router->update();
            $response = $router->affectedRows();
            if($response){
                $data = [
                    'success' => true,
                    'ip' => $ip
                ];
            }else{
                $data = [
                    'success' => false,
                    'msg' => 'Something went wrong'
                ]; 
            }
            $router->transComplete();
        } catch (Exception $ex) {
            $data = [
                'success' => false,
                'msg' => $ex->getMessage()
            ];
            $router->transRollback();
        }
        return $this->response->setJSON($data);
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        try{
            $router = new RouterDataModel();
            $router->where('id', $id);
            $router->where('deleted_at IS NULL');
            $router->delete();
            $response = $router->affectedRows();
            if($response){
                $data = [
                    'success' => true,
                    'id' => $id
                ];
            }else{
                $data = [
                    'success' => false,
                    'msg' => 'Something went wrong'
                ]; 
            }
        } catch (Exception $ex) {
            $data = [
                'success' => false,
                'msg' => $ex->getMessage()
            ];
        }
        return $this->response->setJSON($data);
    }
}
