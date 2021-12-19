<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class CopyFileRemoteServer extends BaseCommand
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
    protected $name = 'command:copyfileremoteserver';

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
        try{
            // $host = CLI::prompt('Please enter a host number', null, 'required');
            // $username = CLI::prompt('Please enter a username', null, 'required');
            // $password = CLI::prompt('Please enter a password', null, 'required');
            // $port = CLI::prompt('Please enter a post', null, 'required');
            // $file = CLI::prompt('Please enter a file path', null, 'required');

            $host = 'localhost';
            $username = 'manish';
            $password = 'manish';
            $port = '22';
            $local_file = '/var/www/final.log';
            $type = 'scp';

            $config = new \Config\Paths();
            $path = $config->writableDirectory ."/uploads/";

            switch ($type) {
                case 'sfpt':
                    $connection = ssh2_connect($host, $port);
                    ssh2_auth_password($connection, $username, $password);
                    $sftp = ssh2_sftp($connection);
                    if(is_resource($connection) && !is_file($local_file)){
                        CLI::write("File uploading in progress");
                        $resFile = fopen("ssh2.sftp://{$connection}/{$path}".basename($local_file), 'w');
                        $srcFile = fopen($local_file, 'r');
                        $writtenBytes = stream_copy_to_stream($srcFile, $resFile);
                        fclose($resFile);
                        fclose($srcFile);
                        CLI::write("File uploaded successfully");
                    }else{
                        CLI::write("Error in uploading ");
                    }
                    break;
                case 'scp':
                    $connection = ssh2_connect($host, $port);
                    ssh2_auth_password($connection, $username, $password);
                    if(is_resource($connection) && !is_file($local_file)){
                        CLI::write("File uploading in progress");
                        ssh2_scp_send($connection, $local_file, $path.basename($local_file), 0644);
                        CLI::write("File uploaded successfully");
                    }else{
                        CLI::write("Error in uploading ");
                    }
                    break;
                default:
                    $connection = ftp_connect($host);
                    $login_result = ftp_login($connection, $username, $username);
                    
                    if(is_resource($connection) && !is_file($local_file)){
                        if (ftp_put($connection, $path, $local_file, FTP_ASCII)) {
                            CLI::write("File uploaded successfully");
                        } else {
                            CLI::write("Error in uploading ");
                        }
                        ftp_close($connection);
                    }else{
                        CLI::write("Error in uploading ");
                    }
                    break;
            }            
        } catch (Exception $ex) {
            CLI::write("Error : ".$ex->getMessage());
        }
    }
}
