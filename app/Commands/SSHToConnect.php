<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Exception;

class SSHToConnect extends BaseCommand
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
    protected $name = 'command:sshtoconnect';

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
            $host = CLI::prompt('Please enter a host number', null, 'required');
            $username = CLI::prompt('Please enter a username', null, 'required');
            $password = CLI::prompt('Please enter a password', null, 'required');
            $port = CLI::prompt('Please enter a post', null, 'required');
            $path = CLI::prompt('Please enter a dir path');

            $connection = ssh2_connect($host, $port);
            ssh2_auth_password($connection, $username, $password);

            $sftp = ssh2_sftp($connection);
            $sftp_fd = intval($sftp);

            if(is_resource($connection) && !empty($path)){
                $handle = opendir("ssh2.sftp://$sftp_fd/$path");
                while (false != ($entry = readdir($handle))){
                    CLI::write("File Name : $entry");
                }
            }
        } catch (Exception $ex) {
            CLI::write("Error : ".$ex->getMessage());
        }
    }
}
