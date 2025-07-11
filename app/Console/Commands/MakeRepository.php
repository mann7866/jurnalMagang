<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeRepository extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {name : Repository name without "Repository" suffix}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new interface in Contracts/Repositories';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $repositoryName = $name . 'Repository';

        $directory = app_path('Contracts/Repositories');
        $path = "{$directory}/{$repositoryName}.php";

        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        if (file_exists($path)) {
            $this->error("Repository {$repositoryName} already exists!");
            return;
        }

        // Isi file interface
        $stub = "<?php

namespace App\Contracts\Repositories;

class {$repositoryName}
{
     public function __construct(
     //
     )
    {
     //
    }
}
";

        // Simpan file
        file_put_contents($path, $stub);

        $this->info("Repository {$repositoryName} created successfully at App\\Contracts\\Repositories\\{$repositoryName}");
    }
}
