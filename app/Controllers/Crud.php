<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\RouterDataModel;
use Exception;

class Crud extends BaseController
{    
    public function index()
    {
        helper('form');
        $router = new RouterDataModel();
        $router->where('deleted_at is NULL');
        $data['routers'] = $router->orderBy('id', 'DESC')->findAll();
        return view('crud', $data);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function lists()
    {
        $router = new RouterDataModel();
        $router->where('deleted_at is NULL');
        $routers = $router->orderBy('id', 'DESC')->findAll();
        $json_data = array(            
            "recordsTotal" => count($routers),
            "recordsFiltered" => count($routers),
            "data" => $routers   // total data array
        );
        return $this->response->setJSON($json_data);
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function create()
    {
        $router = new RouterDataModel();
        try{
            $router->transStart();
            $data = [
                'spid' => $this->request->getPost('spid'),
                'hostname' => $this->request->getPost('hostname'),
                'loopback' => $this->request->getPost('loopback'),
                'mac'    => $this->request->getPost('mac'),
            ];
            $router->insert($data);
            $id = $router->getInsertID();
            $data = [
                'success' => true,
                'id' => $id
            ];
            $router->transComplete();
        } catch (Exception $ex) {
            $router->transRollback();
            $data = [
                'success' => false,
                'msg' => $ex->getMessage()
            ];
        }
        return $this->response->setJSON($data);
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        $router = new RouterDataModel();
        try{
            $router->transStart();
            $request = $this->request->getRawInput();
            $data = [
                'spid' => $request['spid'],
                'hostname' => $request['hostname'],
                'loopback' => $request['loopback'],
                'mac'    => $request['mac'],
            ];
            $router->update($id, $data);
            $data = [
                'success' => true,
                'id' => $id
            ];
            $router->transComplete();
        } catch (Exception $ex) {
            $router->transRollback();
            $data = [
                'success' => false,
                'msg' => $ex->getMessage()
            ];
        }
        return $this->response->setJSON($data);
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $router = new RouterDataModel();
        $router->select('loopback, hostname, mac, id, spid');
        $data['data'] = $router->where('id', $id)->first();
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
            $router->delete($id);
            $data = [
                'success' => true,
                'id' => $id
            ];
        } catch (Exception $ex) {
            $data = [
                'success' => false,
                'msg' => $ex->getMessage()
            ];
        }
        return $this->response->setJSON($data);
    }
}
