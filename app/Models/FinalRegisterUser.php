<?php

namespace App\Models;

use App\Models\Department;
use Illuminate\Database\Eloquent\Model;

class FinalRegisterUser extends Model
{
    protected $table = 'users';
    protected $fillable = [
        'fullName',
        'fathersName',
        'mothersName',
        'dateOfBirth',
        'placeOfBirth',
        'idPassportNumber',
        'fullAddress',
        'phoneNumber',
        'whatsappNumber',
        'region',
        'placeOfResidence',
        'departmentOfOrigin',
        'village',
        'ethnicity',
        'numberOfSiblings',
        'nextOfKinName',
        'nextOfKinCity',
        'nextOfKinContact',
        'familyHeadName',
        'familyHeadCity',
        'familyHeadContact',
        'conversionDate',
        'baptismByImmersion',
        'baptismInHolySpirit',
        'homeChurch',
        'center',
        'discipleMakerName',
        'discipleMakerContact',
        'spiritualParentageName',
        'spiritualParentageContact',
        'spiritualParentageRelationship',
        'testimony',
        'maritalStatus',
        'spouseName',
        'spouseContact',
        'numberOfLegitimateChildren',
        'legitimateChildrenDetails',
        'numberOfDependents',
        'dependentsDetails',
        'siblingsDetails',
        'educationFinancer',
        'educationLevel',
        'degreeObtained',
        'activityBeforeHQ',
        'hqEntryDate',
        'hqDepartment',
        'originCountryCity',
        'departmentResponsibility',
        'timeInDepartment',
        'monthlyAllowance',
        'allowanceSince',
        'otherResponsibilities',
        'departmentChanges',
        'haveDisciples',
        'numberOfDisciples',
        'degreesHeld',
        'professionalTrainingReceived',
        'professionalTrainingLocation',
        'professionalTrainingDuration',
        'onTheJobTraining',
        'whyWorkAtHQ',
        'briefTestimony',
        'whoIntroducedToHQ',
        'callOfGod',
        'whatCallConsistsOf',
        'familyAwareOfCall',
        'familyReleasedForCall',
        'emergencyContactDeath',
        'burialLocation',
        'familyAwareOfBurialLocation',
        'yourPossessions',
        'sourcesOfIncome',
        'healthProblems',
        'underTreatment',
        'operationsDetails',
        'specialDiet',
        'commonFamilyIllnesses',
        'problemsWithAnyone',
        'reasonForProblems',
        'beenToPrison',
        'reasonForPrison',
        'bulletin3File',
        'medicalCertificateHopeClinicFile',
        'diplomasFile',
        'birthMarriageCertificatesFile',
        'cniFile',
        'familyCommitmentCallFile',
        'familyBurialAgreementFile',
        'gdprConsent'
        ];

        protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'dateOfBirth' => 'date',
            'conversionDate' => 'date',
            'hqEntryDate' => 'date',
            'allowanceSince' => 'date',
            'password' => 'hashed',
            'gdprConsent' => 'boolean',
            'numberOfSiblings' => 'integer',
            'numberOfLegitimateChildren' => 'integer',
            'numberOfDependents' => 'integer',
            'numberOfDisciples' => 'integer',
            'diplomasFile' => 'array',
            'birthMarriageCertificatesFile' => 'array'
        ];
    }
        public function Departement(){
        return $this->belongsTo(Department::class);
    }

    public function service(){
        return $this->belongsTo(Service::class);
    }

    public function headDepartment(){
        return $this->hasMany(Department::class,'head_id');
    }
}
