<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class TelnetZip extends BaseCommand
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
    protected $name = 'command:telnetzip';

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
        $host = 'localhost';
        $username = 'manish';
        $password = 'manish';
        $port = '22';
        try{
            $connection = ssh2_connect($host, $port);
            ssh2_auth_password($connection, $username, $password);
            $sftp = ssh2_sftp($connection);

            $config = new \Config\Paths();
            $path = $config->writableDirectory ."/uploads/";

            CLI::write("Creating file on server");
            $file_name = array();
            $file_arr = array();
            for ($i=0; $i < $number; $i++) { 
                $server_file = "file_".$i.".log";
                $file_arr[] = $server_file;
                ssh2_exec($connection, "cd {$path} && touch {$server_file}");
            }
            
            // zip -r filename.zip folder name
            CLI::write("convert files into zip");
            $zipfile = "file.zip";
            $file_arr = implode(" ", $file_arr);
            ssh2_exec($connection, "cd {$path} && zip -r {$zipfile} {$file_arr}");


            $local_path = $config->writableDirectory."/{$zipfile}";
            CLI::write("download zip file");
            ssh2_scp_recv($connection, $path.$zipfile, $local_path);

            CLI::write("extracting zip file");
            system("unzip $local_path -d {$config->writableDirectory}");
        } catch (Exception $ex) {
            CLI::write("Error : ".$ex->getMessage());
        }
    }
}
