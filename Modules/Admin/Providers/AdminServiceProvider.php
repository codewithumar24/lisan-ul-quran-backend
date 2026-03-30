<?php

namespace Modules\Admin\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Modules\Admin\Contracts\Repositories\ArabicLetterRepositoryContract;
use Modules\Admin\Contracts\Repositories\LessonRepositoryContract;
use Modules\Admin\Contracts\Repositories\MakhrajCategoryRepositoryContract;
use Modules\Admin\Contracts\Repositories\PracticeExerciseRepositoryContract;
use Modules\Admin\Contracts\Repositories\QuizQuestionRepositoryContract;
use Modules\Admin\Contracts\Repositories\QuizRepositoryContract;
use Modules\Admin\Contracts\Repositories\TajweedRuleRepositoryContract;
use Modules\Admin\Contracts\Services\ArabicLetterContract;
use Modules\Admin\Contracts\Services\LessonContract;
use Modules\Admin\Contracts\Services\MakhrajCategoryContract;
use Modules\Admin\Contracts\Services\PracticeExerciseContract;
use Modules\Admin\Contracts\Services\QuizContract;
use Modules\Admin\Contracts\Services\QuizQuestionContract;
use Modules\Admin\Contracts\Services\TajweedRuleContract;
use Modules\Admin\Repositories\ArabicLetterRepository;
use Modules\Admin\Repositories\LessonRepository;
use Modules\Admin\Repositories\MakhrajCategoryRepository;
use Modules\Admin\Repositories\PracticeExerciseRepository;
use Modules\Admin\Repositories\QuizQuestionRepository;
use Modules\Admin\Repositories\QuizRepository;
use Modules\Admin\Repositories\TajweedRuleRepository;
use Modules\Admin\Services\ArabicLetterService;
use Modules\Admin\Services\LessonService;
use Modules\Admin\Services\MakhrajCategoryService;
use Modules\Admin\Services\PracticeExerciseService;
use Modules\Admin\Services\QuizQuestionService;
use Modules\Admin\Services\QuizService;
use Modules\Admin\Services\TajweedRuleService;
use Nwidart\Modules\Traits\PathNamespace;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class AdminServiceProvider extends ServiceProvider
{
    use PathNamespace;

    protected string $name = 'Admin';

    protected string $nameLower = 'admin';

    /**
     * Boot the application events.
     */
    public function boot(): void
    {
        $this->registerCommands();
        $this->registerCommandSchedules();
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->name, 'database/migrations'));
    }

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->register(EventServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);


        $this->app->bind(ArabicLetterRepositoryContract::class, ArabicLetterRepository::class);
        $this->app->bind(ArabicLetterContract::class, ArabicLetterService::class);

        // Add to register method:
        $this->app->bind(MakhrajCategoryRepositoryContract::class, MakhrajCategoryRepository::class);
        $this->app->bind(MakhrajCategoryContract::class, MakhrajCategoryService::class);

        $this->app->bind(TajweedRuleRepositoryContract::class, TajweedRuleRepository::class);
        $this->app->bind(TajweedRuleContract::class, TajweedRuleService::class);
        // Add to register method:
        $this->app->bind(LessonRepositoryContract::class, LessonRepository::class);
        $this->app->bind(LessonContract::class, LessonService::class);

        // Add to register method:
        $this->app->bind(PracticeExerciseRepositoryContract::class, PracticeExerciseRepository::class);
        $this->app->bind(PracticeExerciseContract::class, PracticeExerciseService::class);

        $this->app->bind(QuizRepositoryContract::class, QuizRepository::class);
        $this->app->bind(QuizContract::class, QuizService::class);

        $this->app->bind(QuizQuestionRepositoryContract::class, QuizQuestionRepository::class);
        $this->app->bind(QuizQuestionContract::class, QuizQuestionService::class);
    }

    /**
     * Register commands in the format of Command::class
     */
    protected function registerCommands(): void
    {
        // $this->commands([]);
    }

    /**
     * Register command Schedules.
     */
    protected function registerCommandSchedules(): void
    {
        // $this->app->booted(function () {
        //     $schedule = $this->app->make(Schedule::class);
        //     $schedule->command('inspire')->hourly();
        // });
    }

    /**
     * Register translations.
     */
    public function registerTranslations(): void
    {
        $langPath = resource_path('lang/modules/' . $this->nameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->nameLower);
            $this->loadJsonTranslationsFrom($langPath);
        } else {
            $this->loadTranslationsFrom(module_path($this->name, 'lang'), $this->nameLower);
            $this->loadJsonTranslationsFrom(module_path($this->name, 'lang'));
        }
    }

    /**
     * Register config.
     */
    protected function registerConfig(): void
    {
        $configPath = module_path($this->name, config('modules.paths.generator.config.path'));

        if (is_dir($configPath)) {
            $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($configPath));

            foreach ($iterator as $file) {
                if ($file->isFile() && $file->getExtension() === 'php') {
                    $config = str_replace($configPath . DIRECTORY_SEPARATOR, '', $file->getPathname());
                    $config_key = str_replace([DIRECTORY_SEPARATOR, '.php'], ['.', ''], $config);
                    $segments = explode('.', $this->nameLower . '.' . $config_key);

                    // Remove duplicated adjacent segments
                    $normalized = [];
                    foreach ($segments as $segment) {
                        if (end($normalized) !== $segment) {
                            $normalized[] = $segment;
                        }
                    }

                    $key = ($config === 'config.php') ? $this->nameLower : implode('.', $normalized);

                    $this->publishes([$file->getPathname() => config_path($config)], 'config');
                    $this->merge_config_from($file->getPathname(), $key);
                }
            }
        }
    }

    /**
     * Merge config from the given path recursively.
     */
    protected function merge_config_from(string $path, string $key): void
    {
        $existing = config($key, []);
        $module_config = require $path;

        config([$key => array_replace_recursive($existing, $module_config)]);
    }

    /**
     * Register views.
     */
    public function registerViews(): void
    {
        $viewPath = resource_path('views/modules/' . $this->nameLower);
        $sourcePath = module_path($this->name, 'resources/views');

        $this->publishes([$sourcePath => $viewPath], ['views', $this->nameLower . '-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->nameLower);

        Blade::componentNamespace(config('modules.namespace') . '\\' . $this->name . '\\View\\Components', $this->nameLower);
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [];
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (config('view.paths') as $path) {
            if (is_dir($path . '/modules/' . $this->nameLower)) {
                $paths[] = $path . '/modules/' . $this->nameLower;
            }
        }

        return $paths;
    }
}
