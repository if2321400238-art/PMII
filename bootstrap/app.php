<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// Ensure git is on PATH for processes that rely on proc_open (e.g. sebastian/version)
$currentPath = getenv('PATH') ?: '';
$candidateGitPaths = [
    'C:\\Program Files\\Git\\cmd',
    'C:\\Program Files\\Git\\bin',
    'C:\\Program Files (x86)\\Git\\cmd',
    'C:\\Program Files (x86)\\Git\\bin',
    'C:\\laragon\\bin\\git\\cmd',
    'C:\\laragon\\bin\\git\\bin',
];

$pathsToAdd = [];
foreach ($candidateGitPaths as $candidate) {
    if (is_dir($candidate) && ! str_contains($currentPath, $candidate)) {
        $pathsToAdd[] = $candidate;
    }
}

if ($pathsToAdd) {
    $newPath = implode(PATH_SEPARATOR, array_merge($pathsToAdd, [$currentPath]));
    putenv('PATH='.$newPath);
}

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'auth.any' => \App\Http\Middleware\AuthenticateAny::class,
            'role' => \App\Http\Middleware\CheckRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
