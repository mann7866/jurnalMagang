<?php
namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use App\Contracts\Interfaces\JournalInterface;
use App\Contracts\Interfaces\StudentInterface;
use App\Contracts\Interfaces\TeacherInterface;
use App\Contracts\Repositories\JournalRepository;
use App\Contracts\Repositories\StudentRepository;
use App\Contracts\Repositories\TeacherRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(StudentInterface::class, StudentRepository::class);
        $this->app->bind(TeacherInterface::class, TeacherRepository::class);
        $this->app->bind(JournalInterface::class, JournalRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $key = 'generate_journal_' . Carbon::yesterday()->toDateString();

        if (! Cache::has($key)) {
            app(abstract : \App\Http\Controllers\api\Student\JournalController::class)->generateEmptyJournalByDate();
            Cache::put($key, true, now()->addDay());
        }
    }
}
