<?php

namespace App\Console\Commands;

use App\Models\FileUpload;
use Faker\Core\File;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class AutoDeleteFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'file:auto_delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto delete file after time exist';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::info('Start delete file job');
        $files = FileUpload::where('times_download', '>', 0)->get();
        foreach($files as $file) {
            $id = $file->id;
            $created_at = $file->created_at;
            $day_exist = $file->day_exist;
            $now = strtotime(now());
            $timeExist = strtotime($created_at . " +" . $day_exist ."days");
            if($now > $timeExist) {
                FileUpload::where('id', $id)->update(['times_download' => 0]);
                $delete = \Illuminate\Support\Facades\File::delete(public_path($file->path));
            }
        }
        Log::info('End delete file job');
        return 0;
    }
}
