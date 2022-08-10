<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Uploads;
use Carbon\Carbon;
use Storage;

class DueDeleter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'due:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Uploaded files will be deleted by due dates';

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
        $uploads = Uploads::whereDate('due_at', '<=', Carbon::today())->get();
        foreach($uploads as $upload){
            if($upload->url != 'noimage123.png'){
                if (Storage::exists('/public/uploads/'.$upload->url)) {
                    Storage::delete('/public/uploads/'.$upload->url);
                }
            }
        }
        $uploads = Uploads::whereDate('due_at', '<=', Carbon::today())->delete();
        echo "done";
        return 0;
    }
}
