<?php

namespace LivewireUI\Spotlight;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\ImplicitlyBoundMethod;

class Spotlight extends Component
{
    public static array $commands = [];

    public array $dependencyQueryResults = [];

    public static function registerCommand(string $command): void
    {
        tap(new $command, function (SpotlightCommand $command) {
            self::$commands[] = $command;
        });
    }

    public static function registerCommandIf(bool $condition, string $command): void
    {
        if ($condition === false) {
            return;
        }

        self::registerCommand($command);
    }

    public static function registerCommandUnless(bool $condition, string $command): void
    {
        if ($condition === true) {
            return;
        }

        self::registerCommand($command);
    }

    protected function getCommandById(string $id): ?SpotlightCommand
    {
        return collect(self::$commands)->first(function ($command) use ($id) {
            return $command->getId() === $id;
        });
    }

    public function searchDependency(string $commandId, $dependency, $query, $resolvedDependencies = []): void
    {
        $command = $this->getCommandById($commandId);
        $method = Str::camel('search ' . $dependency);

        if (is_object($command) and method_exists($command, $method)) {
            $params = array_merge(['query' => $query], (array) $resolvedDependencies);

            $this->dependencyQueryResults = collect(ImplicitlyBoundMethod::call(app(), [$command, $method], $params))
                ->map(function (SpotlightSearchResult $result) {
                    return [
                        'id' => $result->getId(),
                        'name' => $result->getName(),
                        'description' => $result->getDescription(),
                        'synonyms' => $result->getSynonyms(),
                    ];
                })->toArray();
        }
    }

    public function execute(string $commandId, array $dependencies = []): void
    {
        $command = $this->getCommandById($commandId);

        if (method_exists($command, 'execute')) {
            $params = array_merge(['spotlight' => $this], $dependencies);

            /**
             * @psalm-suppress InvalidArgument
             */
            ImplicitlyBoundMethod::call(app(), [$command, 'execute'], $params);
        }
    }

    public function render(): View | Factory
    {
        return view('livewire-ui-spotlight::spotlight', [
            'commands' => collect(self::$commands)
                ->filter(function (SpotlightCommand $command) {
                    if (! method_exists($command, 'shouldBeShown')) {
                        return true;
                    }

                    /**
                     * @psalm-suppress InvalidArgument
                     */
                    return app()->call([$command, 'shouldBeShown']);
                })
                ->values()
                ->map(function (SpotlightCommand $command) {
                    return [
                        'id' => $command->getId(),
                        'name' => $command->getName(),
                        'description' => $command->getDescription(),
                        'synonyms' => $command->getSynonyms(),
                        'dependencies' => $command->dependencies()?->toArray() ?? [],
                    ];
                }),
        ]);
    }
}
