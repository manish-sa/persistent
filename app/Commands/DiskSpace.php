<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class DiskSpace extends BaseCommand
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
    protected $name = 'command:diskspace';

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
        $total = round(disk_total_space("/") / 1024 / 1024 / 1024);
        $usage = round((disk_total_space("/")-disk_free_space("/")) / 1024 / 1024 / 1024);
        $df = round(disk_free_space("/") / 1024 / 1024 / 1024);
        CLI::write("Total Space: $total GB");
        CLI::write("Usage Space: $usage GB");
        CLI::write("Free Space: $df GB");
    }
}
