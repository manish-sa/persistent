<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\RouterDataModel;

class UniqueNumber extends BaseCommand
{
    /**
     * The Command's Group
     *
     * @var string
     */
    protected $group = 'CodeIgniter';

    /**
     * The Command's Name
     *
     * @var string
     */
    protected $name = 'command:uniquenumber';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = '';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'command:name [arguments] [options]';

    /**
     * The Command's Arguments
     *
     * @var array
     */
    protected $arguments = [];

    /**
     * The Command's Options
     *
     * @var array
     */
    protected $options = [];

    /**
     * Actually execute a command.
     *
     * @param array $params
     */
    public function run(array $params)
    {
        $number = CLI::prompt('Please enter a number', null, 'required');        
        if(is_numeric($number)){
            for ($i=0; $i < $number; $i++) {
                $spid = uniqid();
                $mac = implode(':', str_split(substr(md5(mt_rand()), 0, 12), 2));
                $ip = long2ip(rand(0, 4294967295));
                $host =  substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(14/strlen($x)) )),1,14);
                $temp = [
                    'spid' => $spid,
                    'hostname' => $host,
                    'loopback' => $ip,
                    'mac'    => $mac
                ];
                $data[] = $temp;
            }
            try{
                $router = new RouterDataModel();
                $router->transStart();
                $router->insertBatch($data);
                $router->transComplete();
                CLI::write("Success");
            } catch (Exception $ex) {
                $router->transRollback();
                CLI::write("Error ".$ex->getMessage());
            }
        }else{
            CLI::write("Not a number");
        }
    }
}
