<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Department> $departments
 * @property-read int|null $departments_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Committee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Committee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Committee query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Committee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Committee whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Committee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Committee whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Committee whereUpdatedAt($value)
 */
	class Committee extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $department_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Department $department
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepartementSkill newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepartementSkill newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepartementSkill query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepartementSkill whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepartementSkill whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepartementSkill whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepartementSkill whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepartementSkill whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepartementSkill whereUpdatedAt($value)
 */
	class DepartementSkill extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $description
 * @property int|null $head_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $head_assigned_at
 * @property bool $email_notifications
 * @property string $report_frequency
 * @property bool $two_factor_enabled
 * @property int $session_timeout
 * @property string $theme
 * @property string $language
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $departmentUsers
 * @property-read int|null $department_users_count
 * @property-read \App\Models\User|null $head
 * @property-read \App\Models\User|null $headDepartment
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Service> $services
 * @property-read int|null $services_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DepartementSkill> $skills
 * @property-read int|null $skills_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereEmailNotifications($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereHeadAssignedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereHeadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereReportFrequency($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereSessionTimeout($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereTheme($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereTwoFactorEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereUpdatedAt($value)
 */
	class Department extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string|null $name
 * @property string $matricule
 * @property string $email
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $registered_at
 * @property string|null $info_updated_at
 * @property string|null $last_login_at
 * @property string|null $last_activity_at
 * @property string|null $last_seen_at
 * @property string|null $last_login_ip
 * @property bool $is_online
 * @property int|null $department_id
 * @property int|null $committee_id
 * @property int|null $service_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $is_active
 * @property string|null $phone
 * @property string|null $position
 * @property-read \App\Models\Department|null $Departement
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Department> $headDepartment
 * @property-read int|null $head_department_count
 * @property-read \App\Models\Service|null $service
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinalRegisterUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinalRegisterUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinalRegisterUser query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinalRegisterUser whereCommitteeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinalRegisterUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinalRegisterUser whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinalRegisterUser whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinalRegisterUser whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinalRegisterUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinalRegisterUser whereInfoUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinalRegisterUser whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinalRegisterUser whereIsOnline($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinalRegisterUser whereLastActivityAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinalRegisterUser whereLastLoginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinalRegisterUser whereLastLoginIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinalRegisterUser whereLastSeenAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinalRegisterUser whereMatricule($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinalRegisterUser whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinalRegisterUser wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinalRegisterUser wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinalRegisterUser wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinalRegisterUser whereRegisteredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinalRegisterUser whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinalRegisterUser whereServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinalRegisterUser whereUpdatedAt($value)
 */
	class FinalRegisterUser extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $first_name
 * @property string $first_email
 * @property string|null $email_verified_at
 * @property string $first_password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FirstRegistrationUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FirstRegistrationUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FirstRegistrationUser query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FirstRegistrationUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FirstRegistrationUser whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FirstRegistrationUser whereFirstEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FirstRegistrationUser whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FirstRegistrationUser whereFirstPassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FirstRegistrationUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FirstRegistrationUser whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FirstRegistrationUser whereUpdatedAt($value)
 */
	class FirstRegistrationUser extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $fullName
 * @property string|null $fathersName
 * @property string|null $mothersName
 * @property \Illuminate\Support\Carbon $dateOfBirth
 * @property string|null $placeOfBirth
 * @property string|null $idPassportNumber
 * @property string|null $fullAddress
 * @property string $phoneNumber
 * @property string|null $whatsappNumber
 * @property string|null $region
 * @property string|null $placeOfResidence
 * @property string|null $departmentOfOrigin
 * @property string|null $village
 * @property string|null $ethnicity
 * @property int|null $numberOfSiblings
 * @property string|null $nextOfKinName
 * @property string|null $nextOfKinCity
 * @property string|null $nextOfKinContact
 * @property string|null $familyHeadName
 * @property string|null $familyHeadCity
 * @property string|null $familyHeadContact
 * @property \Illuminate\Support\Carbon|null $conversionDate
 * @property string|null $baptismByImmersion
 * @property string|null $baptismInHolySpirit
 * @property string|null $homeChurch
 * @property string|null $center
 * @property string|null $discipleMakerName
 * @property string|null $discipleMakerContact
 * @property string|null $spiritualParentageName
 * @property string|null $spiritualParentageContact
 * @property string|null $spiritualParentageRelationship
 * @property string|null $testimony
 * @property string $maritalStatus
 * @property string|null $spouseName
 * @property string|null $spouseContact
 * @property int|null $numberOfLegitimateChildren
 * @property string|null $legitimateChildrenDetails
 * @property int|null $numberOfDependents
 * @property string|null $dependentsDetails
 * @property string|null $siblingsDetails
 * @property string|null $educationFinancer
 * @property string|null $educationLevel
 * @property string|null $degreeObtained
 * @property string|null $activityBeforeHQ
 * @property \Illuminate\Support\Carbon|null $hqEntryDate
 * @property string|null $hqDepartment
 * @property string|null $originCountryCity
 * @property string|null $departmentResponsibility
 * @property string|null $whoIntroducedToHQ
 * @property string|null $callOfGod
 * @property string|null $whatCallConsistsOf
 * @property string|null $familyAwareOfCall
 * @property string|null $emergencyContactDeath
 * @property string|null $burialLocation
 * @property string|null $yourPossessions
 * @property string|null $sourcesOfIncome
 * @property string|null $healthProblems
 * @property string|null $underTreatment
 * @property string|null $operationsDetails
 * @property string|null $problemsWithAnyone
 * @property string|null $reasonForProblems
 * @property string|null $beenToPrison
 * @property string|null $reasonForPrison
 * @property string|null $bulletin3_path
 * @property string|null $medical_certificate_path
 * @property string|null $diplomas_path
 * @property string|null $birth_marriage_certificates_path
 * @property string|null $cni_path
 * @property string|null $family_commitment_path
 * @property string|null $family_burial_agreement_path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereActivityBeforeHQ($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereBaptismByImmersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereBaptismInHolySpirit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereBeenToPrison($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereBirthMarriageCertificatesPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereBulletin3Path($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereBurialLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereCallOfGod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereCenter($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereCniPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereConversionDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereDegreeObtained($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereDepartmentOfOrigin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereDepartmentResponsibility($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereDependentsDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereDiplomasPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereDiscipleMakerContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereDiscipleMakerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereEducationFinancer($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereEducationLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereEmergencyContactDeath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereEthnicity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereFamilyAwareOfCall($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereFamilyBurialAgreementPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereFamilyCommitmentPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereFamilyHeadCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereFamilyHeadContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereFamilyHeadName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereFathersName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereFullAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereHealthProblems($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereHomeChurch($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereHqDepartment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereHqEntryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereIdPassportNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereLegitimateChildrenDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereMaritalStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereMedicalCertificatePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereMothersName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereNextOfKinCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereNextOfKinContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereNextOfKinName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereNumberOfDependents($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereNumberOfLegitimateChildren($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereNumberOfSiblings($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereOperationsDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereOriginCountryCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm wherePlaceOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm wherePlaceOfResidence($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereProblemsWithAnyone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereReasonForPrison($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereReasonForProblems($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereSiblingsDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereSourcesOfIncome($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereSpiritualParentageContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereSpiritualParentageName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereSpiritualParentageRelationship($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereSpouseContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereSpouseName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereTestimony($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereUnderTreatment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereVillage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereWhatCallConsistsOf($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereWhatsappNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereWhoIntroducedToHQ($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HqStaffForm whereYourPossessions($value)
 */
	class HqStaffForm extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $guard_name
 * @property string $display_name
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Role> $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereUpdatedAt($value)
 */
	class Permission extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $guard_name
 * @property string $display_name
 * @property string $description
 * @property int $grade
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $code
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereGrade($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereUpdatedAt($value)
 */
	class Role extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int|null $department_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $department_code
 * @property bool $is_active
 * @property-read \App\Models\Department|null $department
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereDepartmentCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereUpdatedAt($value)
 */
	class Service extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $key
 * @property string|null $value
 * @property string $group
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereValue($value)
 */
	class Setting extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $filename
 * @property string $pdf_file
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StaffPdf newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StaffPdf newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StaffPdf query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StaffPdf whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StaffPdf whereFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StaffPdf whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StaffPdf wherePdfFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StaffPdf whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StaffPdf whereUserId($value)
 */
	class StaffPdf extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string|null $name
 * @property string $matricule
 * @property string $email
 * @property string $password
 * @property string|null $remember_token
 * @property string|null $email_verified_at
 * @property \Illuminate\Support\Carbon|null $registered_at
 * @property \Illuminate\Support\Carbon|null $info_updated_at
 * @property \Illuminate\Support\Carbon|null $last_login_at
 * @property \Illuminate\Support\Carbon|null $last_activity_at
 * @property string|null $last_seen_at
 * @property string|null $last_login_ip
 * @property bool $is_online
 * @property int|null $department_id
 * @property int|null $committee_id
 * @property int|null $service_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $is_active
 * @property string|null $phone
 * @property string|null $position
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Passport\Client> $clients
 * @property-read int|null $clients_count
 * @property-read \App\Models\Committee|null $comite
 * @property-read \App\Models\Department|null $department
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Department> $departments
 * @property-read int|null $departments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Department> $head
 * @property-read int|null $head_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Passport\Client> $oauthApps
 * @property-read int|null $oauth_apps_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \App\Models\Service|null $service
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Service> $services
 * @property-read int|null $services_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Passport\Token> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCommitteeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereInfoUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIsOnline($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastActivityAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastLoginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastLoginIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastSeenAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereMatricule($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRegisteredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

