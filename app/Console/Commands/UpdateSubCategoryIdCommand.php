<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ExamList;
use Carbon\Carbon;

class UpdateSubCategoryIdCommand extends Command
{
    protected $signature = 'subcat:update';

    protected $description = 'Update sub_cat_id based on exam_date for each exam list';

    public function handle()
    {
        // Log the start of the command execution
        \Log::info('Starting subcat:update command execution');
    
        // Retrieve all exam lists
        $examLists = ExamList::where('sub_cat_id', 41)->get();
    
        foreach ($examLists as $examList) {
            // Log the exam list ID being processed
            \Log::info('Processing exam list ID: ' . $examList->id);
    
            // Retrieve the exam date for each exam list
            $examDate = $examList->exam_date;
    
            // Convert the exam date to a Carbon instance
            $examDateCarbon = Carbon::parse($examDate);
    
            $currentDateTime = Carbon::now();
            \Log::info($examDateCarbon.$currentDateTime);
    
            if ($currentDateTime->gte($examDateCarbon)) {
                // Update the sub_cat_id
                $newSubCatId = 42; // Change this to the new sub category ID you want to set
                $examList->update(['sub_cat_id' => $newSubCatId]);
                $this->info('Sub category ID updated successfully for exam list ID ' . $examList->id);
            } else {
                $this->info('It\'s not time to update the sub category ID for exam list ID ' . $examList->id);
            }
        }
    
        // Log the end of the command execution
        \Log::info('subcat:update command execution completed');
    }
    
}
