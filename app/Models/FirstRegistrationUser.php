<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FirstRegistrationUser extends Model
{
    protected $table = 'first_registration_users';
    protected $fillable = [
        'first_name','first_email','first_password','is_verified'
    ];

    /**
     * Relations avec la table pivot staff_user
     */
    public function staffUsers(): HasMany
    {
        return $this->hasMany(StaffUser::class, 'user_id');
    }

    /**
     * Relation avec les PDFs Staff via la table pivot
     */
    public function staffForms()
    {
        return $this->hasManyThrough(
            HqStaffForm::class,
            StaffUser::class,
            'user_id',
            'id',
            'id',
            'staff_id'
        );
    }

    /**
     * Vérifier si l'utilisateur a un PDF enregistré et approuvé
     */
    public function hasApprovedStaffForm(): bool
    {
        return $this->staffUsers()
            ->where('status', 'approved')
            ->exists();
    }

    /**
     * Obtenir le PDF approuvé de l'utilisateur
     */
    public function getApprovedStaffForm()
    {
        return $this->staffUsers()
            ->where('status', 'approved')
            ->first();
    }

    /**
     * Lier un utilisateur à un PDF Staff
     */
    public function linkToStaff($staffId, $notes = null)
    {
        return $this->staffUsers()->create([
            'staff_id' => $staffId,
            'status' => 'pending',
            'notes' => $notes
        ]);
    }
}
