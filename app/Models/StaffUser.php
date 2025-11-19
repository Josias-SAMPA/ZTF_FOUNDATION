<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StaffUser extends Model
{
    protected $table = 'staff_user';

    protected $fillable = [
        'user_id',
        'staff_id',
        'status',
        'notes',
        'linked_at'
    ];

    protected $casts = [
        'linked_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relation avec FirstRegistrationUser
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(FirstRegistrationUser::class, 'user_id');
    }

    /**
     * Relation avec HqStaff (Staff)
     */
    public function staff(): BelongsTo
    {
        return $this->belongsTo(HqStaffForm::class, 'staff_id');
    }

    /**
     * Scope pour les PDFs en attente
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope pour les PDFs approuvés
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope pour les PDFs rejetés
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /**
     * Vérifier si l'utilisateur peut télécharger ce PDF
     */
    public function canDownload(): bool
    {
        return $this->status === 'approved';
    }

    /**
     * Marquer comme approuvé
     */
    public function approve($notes = null)
    {
        $this->status = 'approved';
        if ($notes) {
            $this->notes = $notes;
        }
        return $this->save();
    }

    /**
     * Marquer comme rejeté
     */
    public function reject($notes = null)
    {
        $this->status = 'rejected';
        if ($notes) {
            $this->notes = $notes;
        }
        return $this->save();
    }
}
