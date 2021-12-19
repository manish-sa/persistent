<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Exception;

class ListDirectoryFile extends BaseCommand
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
    protected $name = 'command:listdirectoryfile';

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
        $dir_path = CLI::prompt('Please enter a directory path', null, 'required');
        if(is_dir($dir_path)){
            $files = array_diff(scandir($dir_path), array('.', '..'));
            CLI::write('list of files and folders:');
            foreach ($files as $key => $file) {
                if(is_dir($dir_path."/".$file)){
                    CLI::write('directory: '. $file);
                }else{
                    CLI::write('file: '. $file);
                }
            }
        }else{
            CLI::write('directory not exist');
        }
    }
}
