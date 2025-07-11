<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name : Service name without "Service" suffix}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new interface in Contracts/Services';

    /**
     * Execute the console command.
     */
     public function handle()
    {
        $name = $this->argument('name');
        $serviceName = $name . 'Service';

        $directory = app_path('Services');
        $path = "{$directory}/{$serviceName}.php";

        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        if (file_exists($path)) {
            $this->error("Service {$serviceName} already exists!");
            return;
        }

        // Isi file interface
        $stub = "<?php

namespace App\Service;

class {$serviceName}
{

//

}
";

        // Simpan file
        file_put_contents($path, $stub);

        $this->info("Service {$serviceName} created successfully at App\\Services\\{$serviceName}");
    }
}
