<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class TelnetCreateFiles extends BaseCommand
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
    protected $name = 'command:telnetcreatefiles';

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
        $fp = fsockopen("127.0.0.1", "80", $errno, $errstr); 
        if($fp) { 
            CLI::write('Telnet socket connected');
            $out = "GET / HTTP/1.1\r\n";
            $out .= "Host: localhost\r\n";
            $out .= "Connection: Close\r\n\r\n";
            fwrite($fp, $out);
            $output = '';
            while (!feof($fp)) {
                $output .= fgets($fp, 128);
            }
            fclose($fp);
            file_put_contents( 'output.txt', $output );
        } else { 
            CLI::write('Telnet socket connection failed');
        }
    }
}
