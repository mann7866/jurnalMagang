<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeEnum extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:enum {name : Enum name without "Enum" suffix}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new enum in Enums';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $enumName = $name . 'Enum';

        $directory = app_path('Enums');
        $path = "{$directory}/{$enumName}.php";

        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        if (file_exists($path)) {
            $this->error("Enum {$enumName} already exists!");
            return;
        }

        $stub = "<?php

namespace App\Enums;

enum {$enumName}: string
{
    //
}
";

        // Simpan file
        file_put_contents($path, $stub);

        $this->info("Enum {$enumName} created successfully at App\\Enums\\{$enumName}");
    }
}
