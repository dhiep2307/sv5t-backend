<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ApprovalRequestFileCriteria extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_url',
        'approval_request_id',
        'requirement_criteria_id',
        'active'
    ];

    protected $hidden = [
    ];

    public function approvalRequest(): HasOne
    {
        return $this->hasOne(ApprovalRequest::class);
    }

    public function requirementCriteria(): HasOne
    {
        return $this->hasOne(RequirementCriteria::class);
    }

}