<?php

namespace App\Services;

use App\Models\Report;
use App\Models\ReportFeedback;
use Illuminate\Support\Facades\Storage;

class FeedbackService
{
    /**
     * Create feedback for a report with optional photo
     * 
     * @param Report $report
     * @param array $data - Contains 'description' and optional 'photo'
     * @param int $adminId
     * @return ReportFeedback
     */
    public function createFeedback(Report $report, array $data, int $adminId): ReportFeedback
    {
        $feedbackData = [
            'report_id' => $report->id,
            'admin_id'  => $adminId,
            'description' => $data['description'],
        ];

        // Handle photo upload if provided
        if (isset($data['photo']) && $data['photo']) {
            $photoPath = $data['photo']->store('report-feedbacks', 'public');
            $feedbackData['photo'] = $photoPath;
        }

        return ReportFeedback::create($feedbackData);
    }

    /**
     * Update feedback with optional new photo
     * 
     * @param ReportFeedback $feedback
     * @param array $data
     * @return ReportFeedback
     */
    public function updateFeedback(ReportFeedback $feedback, array $data): ReportFeedback
    {
        $updateData = [
            'description' => $data['description'],
        ];

        // Handle photo replacement if provided
        if (isset($data['photo']) && $data['photo']) {
            // Delete old photo if exists
            if ($feedback->photo && Storage::disk('public')->exists($feedback->photo)) {
                Storage::disk('public')->delete($feedback->photo);
            }

            // Store new photo
            $photoPath = $data['photo']->store('report-feedbacks', 'public');
            $updateData['photo'] = $photoPath;
        }

        $feedback->update($updateData);
        return $feedback;
    }

    /**
     * Delete feedback and its associated photo
     * 
     * @param ReportFeedback $feedback
     * @return bool
     */
    public function deleteFeedback(ReportFeedback $feedback): bool
    {
        // Delete photo from storage
        if ($feedback->photo && Storage::disk('public')->exists($feedback->photo)) {
            Storage::disk('public')->delete($feedback->photo);
        }

        $feedback->delete();
        return true;
    }

    /**
     * Get feedback for a report
     * 
     * @param Report $report
     * @return ReportFeedback|null
     */
    public function getFeedback(Report $report): ?ReportFeedback
    {
        return $report->feedback;
    }
}
