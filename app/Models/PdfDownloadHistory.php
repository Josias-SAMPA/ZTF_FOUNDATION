<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PdfDownloadHistory extends Model
{
    use HasFactory;

    protected $table = 'pdf_download_histories';

    protected $fillable = [
        'hq_staff_form_id',
        'pdf_filename',
        'pdf_path',
        'file_size',
        'generated_by',
        'generated_at',
        'download_count',
        'last_downloaded_at'
    ];

    protected $casts = [
        'generated_at' => 'datetime',
        'last_downloaded_at' => 'datetime',
        'file_size' => 'integer',
        'download_count' => 'integer',
    ];

    /**
     * Relation avec HqStaffForm
     */
    public function staffForm()
    {
        return $this->belongsTo(HqStaffForm::class, 'hq_staff_form_id');
    }

    /**
     * Incrémenter le compteur de téléchargement
     */
    public function incrementDownloadCount()
    {
        $this->increment('download_count');
        $this->update(['last_downloaded_at' => now()]);
    }

    /**
     * Scope pour les PDFs actifs
     */
    public function scopeActive($query)
    {
        return $query->whereNotNull('pdf_path');
    }

    /**
     * Scope pour les PDFs récents
     */
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('generated_at', '>=', now()->subDays($days))
                     ->orderBy('generated_at', 'desc');
    }

    /**
     * Obtenir la taille du fichier formatée
     */
    public function getFormattedFileSizeAttribute()
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));

        return round($bytes, 2) . ' ' . $units[$pow];
    }
}
