<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendUserDataFileMail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UserExport;


class CreateSendUserDataExportJob implements ShouldQueue
{
    use Queueable, SerializesModels;

    public string $receiverEmail;

    /**
     * Create a new job instance.
     */
    public function __construct(string $receiverEmail)
    {
        $this->receiverEmail = $receiverEmail;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $excelContent = Excel::raw(new UserExport, \Maatwebsite\Excel\Excel::XLSX);
        $fileName =  'User_Data_Export.xlsx';

        Mail::to($this->receiverEmail)->send(new SendUserDataFileMail($excelContent, $fileName));
    }

}
