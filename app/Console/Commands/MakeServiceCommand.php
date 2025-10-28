<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PHPUnit\Framework\MockObject\Builder\Stub;

class MakeServiceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name : The name of the service class}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creer une nouvelle classe de service';

    protected $type = 'Service';

    public function getStub()
    {
        return base_path('stubs/service.stub');
    }

    public function getDefaultNameSpace($rootNamespace)
    {
        return $rootNamespace.'\Services';
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $servicePath = app_path('Services/' . str_replace('/', '\\', $name) . '.php');
        $serviceDir = dirname($servicePath);

        if (!file_exists($serviceDir)) {
            mkdir($serviceDir, 0755, true);
        }

        if (file_exists($servicePath)) {
            $this->error('Service already exists!');
            return;
        }

        $stub = file_get_contents($this->getStub());
        $namespace = 'App\\Services\\' . str_replace('/', '\\', dirname($name));
        $className = basename($name);

        $stub = str_replace(
            ['{{ namespace }}', '{{ class }}'],
            [$namespace, $className],
            $stub
        );

        file_put_contents($servicePath, $stub);

        $this->info('Service created successfully.');
    }
}
