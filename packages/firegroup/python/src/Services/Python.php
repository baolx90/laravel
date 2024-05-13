<?php

namespace Firegroup\Python\Services;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class Python
{
    public function run(string $filePath, array $parameters = [])
    {
        $process = new Process(array_merge([config('python.interpreter'), base_path($filePath)], $parameters));
        $process->run();
        $process->wait();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return rtrim($process->getOutput(), "\n");
    }
}
