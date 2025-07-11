<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeInterface extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:interface {name : Interface name without "Interface" suffix}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new interface in Contracts/Interfaces';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $interfaceName = $name . 'Interface';

        $directory = app_path('Contracts/Interfaces');
        $path = "{$directory}/{$interfaceName}.php";

        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        if (file_exists($path)) {
            $this->error("Interface {$interfaceName} already exists!");
            return;
        }

        $stub = "<?php

namespace App\Contracts\Interfaces;

interface {$interfaceName}
{
    //
}
";

        // Simpan file
        file_put_contents($path, $stub);

        $this->info("Interface {$interfaceName} created successfully at App\\Contracts\\Interfaces\\{$interfaceName}");
    }
}
