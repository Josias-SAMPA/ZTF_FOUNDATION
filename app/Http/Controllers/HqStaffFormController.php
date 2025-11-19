<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use App\Models\HqStaffForm;
use App\Models\PdfDownloadHistory;
use App\Models\StaffUser;
use App\Models\FirstRegistrationUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class HqStaffFormController extends Controller
{
    /**
     * Affiche le formulaire principal
     */
    public function showBigForm()
    {
        return view('formulaire.create');
    }

    /**
     * Affiche l'historique des téléchargements
     */
    public function downloadHistory()
    {
        try {
            // Récupérer l'historique des PDF générés
            $pdfHistories = PdfDownloadHistory::with('staffForm')
                ->orderBy('generated_at', 'desc')
                ->paginate(15);

            return view('formulaire.download-history', compact('pdfHistories'));
        } catch (Exception $e) {
            Log::error('Erreur lors de la récupération de l\'historique: ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors du chargement de l\'historique.');
        }
    }

    /**
     * Télécharge un PDF depuis l'historique
     */
    public function redownloadPDF($historyId)
    {
        try {
            // Récupérer l'enregistrement de l'historique
            $history = PdfDownloadHistory::findOrFail($historyId);

            // Vérifier que le fichier existe
            if (!Storage::exists($history->pdf_path)) {
                Log::error('Fichier PDF non trouvé: ' . $history->pdf_path);
                return back()->with('error', 'Le fichier PDF n\'a pas pu être trouvé.');
            }

            // Incrémenter le compteur de téléchargement
            $history->incrementDownloadCount();

            // Télécharger le fichier
            return Storage::download($history->pdf_path, $history->pdf_filename);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return back()->with('error', 'Cet enregistrement d\'historique n\'a pas été trouvé.');
        } catch (Exception $e) {
            Log::error('Erreur lors du téléchargement du PDF: ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors du téléchargement du PDF.');
        }
    }

    /**
     * Télécharge un PDF pour un utilisateur enregistré (avec vérification)
     */
    public function downloadUserStaffPDF($userId)
    {
        try {
            // Récupérer l'utilisateur enregistré via FirstRegistrationUser
            $user = FirstRegistrationUser::findOrFail($userId);

            // Récupérer le lien approuvé avec un PDF Staff
            $staffUserLink = StaffUser::where('user_id', $userId)
                ->where('status', 'approved')
                ->with('staff')
                ->firstOrFail();

            // Récupérer le PDF Staff lié
            $staff = $staffUserLink->staff;

            if (!$staff) {
                return back()->with('error', 'Le PDF Staff n\'a pas pu être trouvé.');
            }

            // Génération du PDF
            $pdf = PDF::loadView('formulaire.pdf', $staff->toArray())
                ->setPaper('a4', 'portrait')
                ->setOptions([
                    'defaultFont' => 'DejaVu Sans',
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true,
                    'isFontSubsettingEnabled' => true,
                    'dpi' => 300,
                    'defaultPaperSize' => 'a4',
                    'margin_left' => 20,
                    'margin_right' => 20,
                    'margin_top' => 20,
                    'margin_bottom' => 20,
                    'enable_php' => false,
                    'enable_javascript' => true,
                ]);

            // Génération du nom de fichier et du chemin
            $filename = 'staff_form_user_' . $userId . '_' . now()->format('Y-m-d_His') . '.pdf';
            $filepath = 'pdfs/staff_forms/' . $filename;

            // Stockage du PDF
            Storage::put('public/' . $filepath, $pdf->output());

            // Enregistrement dans l'historique
            PdfDownloadHistory::create([
                'hq_staff_form_id' => $staff->id,
                'pdf_filename' => $filename,
                'pdf_path' => $filepath,
                'file_size' => strlen($pdf->output()),
                'generated_by' => $user->first_name ?? 'User',
                'generated_at' => now(),
            ]);

            // Incrémenter le compteur de téléchargement
            $history = PdfDownloadHistory::where('pdf_path', $filepath)->first();
            if ($history) {
                $history->incrementDownloadCount();
            }

            // Téléchargement du PDF
            return $pdf->download($filename);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return back()->with('error', 'Cet utilisateur ou ce PDF n\'a pas été trouvé ou n\'est pas approuvé.');
        } catch (Exception $e) {
            Log::error('Erreur lors de la génération du PDF pour utilisateur: ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de la génération du PDF.');
        }
    }

    /**
     * Approuver un lien utilisateur -> PDF Staff
     */
    public function approvePDFLink($staffUserId)
    {
        try {
            $staffUserLink = StaffUser::findOrFail($staffUserId);
            $staffUserLink->approve('Approuvé par le système');

            return back()->with('success', 'Le lien utilisateur-PDF a été approuvé. L\'utilisateur peut maintenant télécharger son PDF.');
        } catch (Exception $e) {
            Log::error('Erreur lors de l\'approbation du lien: ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de l\'approbation.');
        }
    }

    /**
     * Rejeter un lien utilisateur -> PDF Staff
     */
    public function rejectPDFLink($staffUserId, Request $request)
    {
        try {
            $staffUserLink = StaffUser::findOrFail($staffUserId);
            $notes = $request->input('reason', 'Rejeté par le système');
            $staffUserLink->reject($notes);

            return back()->with('success', 'Le lien utilisateur-PDF a été rejeté.');
        } catch (Exception $e) {
            Log::error('Erreur lors du rejet du lien: ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors du rejet.');
        }
    }

    /**
     * Affiche la liste des PDFs en attente d'approbation
     */
    public function pendingApprovals()
    {
        try {
            $pendingLinks = StaffUser::where('status', 'pending')
                ->with(['user', 'staff'])
                ->orderBy('created_at', 'desc')
                ->paginate(15);

            return view('formulaire.pending-approvals', compact('pendingLinks'));
        } catch (Exception $e) {
            Log::error('Erreur lors de la récupération des approbations en attente: ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue.');
        }
    }

    /**
     * Télécharge le PDF d'un utilisateur spécifique
     */
    public function downloadUserPDF($id)
    {
        try {
            // Récupérer les données du formulaire pour l'utilisateur spécifique
            $staffForm = HqStaffForm::where('user_id', $id)->firstOrFail();

            // Génération du PDF
            $pdf = PDF::loadView('formulaire.pdf', $staffForm->toArray())
                ->setPaper('a4', 'portrait')
                ->setOptions([
                    'defaultFont' => 'DejaVu Sans',
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true,
                    'isFontSubsettingEnabled' => true,
                    'dpi' => 300,
                    'defaultPaperSize' => 'a4',
                    'margin_left' => 20,
                    'margin_right' => 20,
                    'margin_top' => 20,
                    'margin_bottom' => 20,
                    'enable_php' => false,
                    'enable_javascript' => true,
                ]);

            // Génération du nom de fichier et du chemin
            $filename = 'staff_form_' . $id . '_' . now()->format('Y-m-d_His') . '.pdf';
            $filepath = 'pdfs/staff_forms/' . $filename;

            // Stockage du PDF
            Storage::put('public/' . $filepath, $pdf->output());

            // Enregistrement dans l'historique
            $history = PdfDownloadHistory::create([
                'hq_staff_form_id' => $staffForm->id,
                'pdf_filename' => $filename,
                'pdf_path' => $filepath,
                'file_size' => strlen($pdf->output()),
                'generated_by' => Auth::user()->name ?? 'System',
                'generated_at' => now(),
            ]);

            // Incrémenter le compteur de téléchargement
            $history->incrementDownloadCount();

            // Téléchargement du PDF
            return $pdf->download($filename);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return back()->with('error', 'Le formulaire de cet utilisateur n\'a pas été trouvé.');
        } catch (Exception $e) {
            Log::error('Erreur lors de la génération du PDF: ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de la génération du PDF.');
        }
    }

    /**
     * Télécharge le PDF du formulaire
     */
    public function telechargerPDF(Request $request)
    {
        try {
            // Validation des données
            $validated = $request->validate([
                // Section 1 : Personal Information
                'fullName' => 'required|string|max:255',
                'fathersName' => 'nullable|string|max:255',
                'mothersName' => 'nullable|string|max:255',
                'dateOfBirth' => 'required|date',
                'placeOfBirth' => 'required|string|max:255',
                'idPassportNumber' => 'nullable|string|max:50',

                // Section 2 : Contact & Location
                'fullAddress' => 'required|string|max:500',
                'phoneNumber' => 'required|string|max:20',
                'whatsappNumber' => 'nullable|string|max:20',
                'region' => 'required|string|max:100',
                'placeOfResidence' => 'required|string|max:255',
                'departmentOfOrigin' => 'required|string|max:255',
                'village' => 'nullable|string|max:255',
                'ethnicity' => 'nullable|string|max:100',
                'numberOfSiblings' => 'nullable|integer|min:0',
                'nextOfKinName' => 'required|string|max:255',
                'nextOfKinCity' => 'required|string|max:255',
                'nextOfKinContact' => 'required|string|max:20',
                'familyHeadName' => 'required|string|max:255',
                'familyHeadCity' => 'required|string|max:255',
                'familyHeadContact' => 'required|string|max:20',

                // Section 3 : Spiritual Life
                'conversionDate' => 'required|date',
                'baptismByImmersion' => 'required|in:Yes,No',
                'baptismInHolySpirit' => 'required|in:Yes,No',
                'homeChurch' => 'required|string|max:255',
                'center' => 'required|string|max:255',
                'discipleMakerName' => 'required|string|max:255',
                'discipleMakerContact' => 'required|string|max:20',
                'spiritualParentageName' => 'required|string|max:255',
                'spiritualParentageContact' => 'required|string|max:20',
                'spiritualParentageRelationship' => 'required|string|max:500',
                'testimony' => 'required|string|max:1000',

                // Section 4 : Family Life
                'maritalStatus' => 'required|in:Married,Single,Engaged',
                'spouseName' => 'nullable|required_if:maritalStatus,Married|string|max:255',
                'spouseContact' => 'nullable|required_if:maritalStatus,Married|string|max:20',
                'numberOfLegitimateChildren' => 'nullable|integer|min:0',
                'legitimateChildrenDetails' => 'nullable|required_if:numberOfLegitimateChildren,>,0|string|max:1000',
                'numberOfDependents' => 'nullable|integer|min:0',
                'dependentsDetails' => 'nullable|required_if:numberOfDependents,>,0|string|max:1000',
                'siblingsDetails' => 'nullable|string|max:1000',

                // Section 5 : Professional Life
                'educationFinancer' => 'required|string|max:255',
                'educationLevel' => 'required|string|max:255',
                'degreeObtained' => 'nullable|string|max:255',
                'activityBeforeHQ' => 'required|string|max:500',
                'hqEntryDate' => 'required|date',
                'hqDepartment' => 'required|string|max:255',
                'originCountryCity' => 'required|string|max:255',
                'departmentResponsibility' => 'required|string|max:500',

                // Section 6 : Commissioning
                'whoIntroducedToHQ' => 'required|string|max:500',
                'callOfGod' => 'required|in:Yes,No',
                'whatCallConsistsOf' => 'nullable|required_if:callOfGod,Yes|string|max:1000',
                'familyAwareOfCall' => 'required|in:Yes,No',
                'emergencyContactDeath' => 'required|string|max:500',
                'burialLocation' => 'required|string|max:500',

                // Section 7 : Possessions & Health
                'yourPossessions' => 'nullable|string|max:1000',
                'sourcesOfIncome' => 'required|string|max:500',
                'healthProblems' => 'nullable|string|max:1000',
                'underTreatment' => 'required|in:Yes,No',
                'operationsDetails' => 'nullable|string|max:1000',

                // Section 8 : Judicial History
                'problemsWithAnyone' => 'required|in:Yes,No',
                'reasonForProblems' => 'nullable|required_if:problemsWithAnyone,Yes|string|max:1000',
                'beenToPrison' => 'required|in:Yes,No',
                'reasonForPrison' => 'nullable|required_if:beenToPrison,Yes|string|max:1000',

                // Section 9 : Documents
                'bulletin3File' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'medicalCertificateHopeClinicFile' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'diplomasFile' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'birthMarriageCertificatesFile' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'cniFile' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'familyCommitmentCallFile' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'familyBurialAgreementFile' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',

                // Consentement RGPD
                'gdprConsent' => 'required|accepted'
            ]);

            // Gestion des fichiers uploadés
            $paths = [];
            $fileFields = [
                'bulletin3File' => 'bulletin3_path',
                'medicalCertificateHopeClinicFile' => 'medical_certificate_path',
                'diplomasFile' => 'diplomas_path',
                'birthMarriageCertificatesFile' => 'birth_marriage_certificates_path',
                'cniFile' => 'cni_path',
                'familyCommitmentCallFile' => 'family_commitment_path',
                'familyBurialAgreementFile' => 'family_burial_agreement_path'
            ];

            foreach ($fileFields as $requestField => $dbField) {
                if ($request->hasFile($requestField)) {
                    $file = $request->file($requestField);
                    $path = $file->store('staff_documents', 'public');
                    $paths[$dbField] = Storage::url($path);
                }
            }

            // Fusion des données validées avec les chemins des fichiers
            $formData = array_merge($request->all(), $paths);

            // Sauvegarde en base de données
            $staffForm = HqStaffForm::create($formData);

            // Génération du PDF
            $pdf = PDF::loadView('formulaire.pdf', $formData)
                ->setPaper('a4', 'portrait')
                ->setOptions([
                    'defaultFont' => 'DejaVu Sans',
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true,
                    'isFontSubsettingEnabled' => true,
                    'dpi' => 300,
                    'defaultPaperSize' => 'a4',
                    'margin_left' => 20,
                    'margin_right' => 20,
                    'margin_top' => 20,
                    'margin_bottom' => 20,
                    'enable_php' => false,
                    'enable_javascript' => true,
                ]);

            // Génération du nom de fichier et du chemin
            $filename = 'staff_form_' . $staffForm->id . '_' . now()->format('Y-m-d_His') . '.pdf';
            $filepath = 'pdfs/staff_forms/' . $filename;

            // Stockage du PDF
            Storage::put('public/' . $filepath, $pdf->output());

            // Enregistrement dans l'historique
            PdfDownloadHistory::create([
                'hq_staff_form_id' => $staffForm->id,
                'pdf_filename' => $filename,
                'pdf_path' => $filepath,
                'file_size' => strlen($pdf->output()),
                'generated_by' => Auth::user()->name ?? 'System',
                'generated_at' => now(),
            ]);

            // Téléchargement du PDF
            return $pdf->download($filename);

        } catch (Exception $e) {
            Log::error('Erreur lors de la génération du PDF: ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de la génération du PDF. Veuillez réessayer.');
        }
    }
}
