<?php

namespace App\Services;

use App\Models\Report;
use App\Models\User;
use App\Models\Waste;

class RewardPointService
{
    const REWARD_POINTS_PER_COMPLETED_REPORT = 10;
    const REWARD_POINTS_PER_COMPLETED_WASTE = 10;

    public function awardPointsForCompletedReport(Report $report): bool
    {
        if ($report->is_rewarded) {
            return false;
        }

        if ($report->status !== 'Selesai') {
            return false;
        }

        $user = $report->user;

        $user->increment('points', self::REWARD_POINTS_PER_COMPLETED_REPORT);

        $report->update(['is_rewarded' => true]);

        $user->rewards()->create([
            'points'      => self::REWARD_POINTS_PER_COMPLETED_REPORT,
            'type'        => 'laporan',
            'description' => 'Laporan sampah berhasil diselesaikan',
        ]);

        return true;
    }

    public function awardPointsForCompletedWaste(Waste $waste): bool
    {
        if ($waste->is_rewarded) {
            return false;
        }

        if ($waste->status !== 'Selesai') {
            return false;
        }

        $user = $waste->user;

        $user->increment('points', self::REWARD_POINTS_PER_COMPLETED_WASTE);

        $waste->update(['is_rewarded' => true]);

        $user->rewards()->create([
            'points'      => self::REWARD_POINTS_PER_COMPLETED_WASTE,
            'type'        => 'setor',
            'description' => 'Setor sampah berhasil diproses',
        ]);

        return true;
    }

    public function getUserTotalPoints(User $user): int
    {
        return $user->points ?? 0;
    }

    public function resetUserPoints(User $user): bool
    {
        $user->update(['points' => 0]);
        return true;
    }
}