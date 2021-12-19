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
        $local_file = '/var/www/final.log';
        $local_path = "/var/www";
        $number = 2;
        try{
            $connection = ssh2_connect($host, $port);
            ssh2_auth_password($connection, $username, $password);
            $sftp = ssh2_sftp($connection);


            $config = new \Config\Paths();
            $path = $config->writableDirectory ."/uploads/";
            print_r(ssh2_exec($connection, "zip -r filename.zip $path"));
            die;

            CLI::write("Creating file on server");
            for ($i=0; $i < $number; $i++) { 
                $server_file = "file_".$i."_".basename($local_file);
                $server_file = "ssh2.sftp://{$connection}/{$path}".$server_file;
                $resFile = fopen($server_file, 'w');
                $srcFile = fopen($local_file, 'r');
                $writtenBytes = stream_copy_to_stream($srcFile, $resFile);
                fclose($resFile);
                fclose($srcFile);
            }

            // zip -r filename.zip foldername/
            CLI::write("Download zip file on local path");
        } catch (Exception $ex) {
            CLI::write("Error : ".$ex->getMessage());
        }
    }
}
