<?php

namespace Controllers\Home\Console;

use System\Core;
use Symfony\Component\Process\Process;

use function console\text;
use function console\success;
use function console\warning;
use function language\translate;
use function module\loadControllersOptions;

class CronCommand
{
    protected $timeout = 86400;             // redefine in child class if need increase value
    protected $commandRun = 'cron:run';     // redefine in child class if need use custom command
    protected $commandExec = 'cron:exec';   // redefine in child class if need use custom command
    protected $cronTasksDirectory = ROOT . "/../tmp/cron";

    protected $tasks = [];

    public function __construct()
    {
        loadControllersOptions('cron.php');

        $this->tasks = Core::Cron()->getAll();

        if(!is_dir($this->cronTasksDirectory)){
            mkdir($this->cronTasksDirectory, 0755, true);
        }
    }

    public function run()
    {
        $processes = [];
        foreach($this->tasks as $key => $task){
            $command = [PHP_BINARY, CLI_MODE, $this->commandRun, $key];
            $commandString = implode(' ', $command);

            if(!$this->checkCronTask($key, $task, $commandString)){ continue; }

            $process = new Process($command);
            $process->setTimeout($this->timeout);
            $process->start();

            $processes[$commandString] = $process;
        }

        print text(translate("cron.processesLeft", ['%total%' => count($processes)]), 46);

        while(count($processes)){
            foreach($processes as $key => $process){
                /** @var Process $process */

                usleep(10);

                if($process->isRunning()){
                    try{
                        $process->checkTimeout();
                    }catch(\Exception $exception){
                        $process->stop();
                    }
                }else{
                    unset($processes[$key]);
                    print translate("cron.processDoneProcessesLeft", [
                            '%total%' => trim(text(count($processes), 41)),
                            '%cmd%' => trim(text($key, 46))
                        ]) . PHP_EOL;
                }
            }
        }

        return true;
    }

    /**
     * Child method
     *
     * @see CronCommand::run() as parent
     * @param $key
     * @return bool
     */
    public function runCronTask($key)
    {
        if(isset($this->tasks[$key])){
            $taskFile = $this->cronTasksDirectory . "/{$key}.json";

            $this->updateCronTaskFile($taskFile, [
                'start' => time()
            ], true);

            $command = [PHP_BINARY, CLI_MODE, $this->commandExec, $key];
            $result = shell_exec(implode(' ', $command));

            $this->updateCronTaskFile($taskFile, [
                'stop' => time(),
                'result' => $result]
            );
            return true;
        }
        return false;
    }

    /**
     * Run from shell_exec() for skip errors and save result
     *
     * @see CronCommand::runCronTask()
     * @param $key
     * @return bool|mixed
     */
    public function executeCronTask($key)
    {
        if(isset($this->tasks[$key])){
            $task = $this->tasks[$key];

            if(method_exists($task['class'], $task['method'])){
                $object = new $task['class']();
                return call_user_func_array([$object, $task['method']], []);
            }
        }
        return false;
    }

    protected function checkCronTask($key, array $cronTask, $command)
    {
        $taskFile = $this->cronTasksDirectory . "/{$key}.json";

        if(!file_exists($taskFile)){
            print success(translate('cron.newTask', ['%task%' => $command]));
            return true;
        }

        $content = file_get_contents($taskFile);
        $content = json_decode($content, true);

        if(!isset($content['start'])){
            print success(translate('cron.newTaskWithoutStartStamp', ['%task%' => $command]));
            return true;
        }

        if(isset($content['stop'])){
            if($content['stop'] + $cronTask['frequency'] < time()){
                print success(translate('cron.expiredByStopStamp', ['%task%' => $command]));
                return true;
            }
            print warning(translate('cron.cronTaskNotReadyByStop', ['%task%' => $command]));
            return false;
        }

        if($content['start'] + $cronTask['frequency'] + $cronTask['timeout'] < time()){
            print success(translate('cron.expiredByTimeout', ['%task%' => $command]));
            return true;
        }

        print warning(translate('cron.cronTaskNotReady', ['%task%' => $command]));
        return false;
    }

    protected function updateCronTaskFile($file, array $data, $rewrite = false)
    {
        if(!$rewrite && file_exists($file)){
            if($content = file_get_contents($file)){
                $content = json_decode($content, true);
                $data = array_replace($content, $data);
            }
        }
        return file_put_contents($file, json_encode($data));
    }
}