<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('staff', function (Blueprint $table) {
            // 1. Personal Information (Identity)
            $table->string('fathers_name')->nullable()->after('name');
            $table->string('mothers_name')->nullable()->after('fathers_name');
            $table->date('date_of_birth')->nullable()->after('mothers_name');
            $table->string('place_of_birth')->nullable()->after('date_of_birth');
            $table->string('id_passport_number')->nullable()->after('place_of_birth');

            // 2. Contact Details & Location
            $table->text('full_address')->nullable()->after('id_passport_number');
            $table->string('whatsapp_number')->nullable()->after('phone');
            $table->string('region')->nullable();
            $table->string('place_of_residence')->nullable();
            $table->string('department_of_origin')->nullable();
            $table->string('village')->nullable();
            $table->string('ethnicity')->nullable();
            $table->integer('number_of_siblings')->nullable();
            $table->string('next_of_kin_name')->nullable();
            $table->string('next_of_kin_city')->nullable();
            $table->string('next_of_kin_contact')->nullable();
            $table->string('family_head_name')->nullable();
            $table->string('family_head_city')->nullable();
            $table->string('family_head_contact')->nullable();

            // 3. Spiritual Life
            $table->date('conversion_date')->nullable();
            $table->enum('baptism_by_immersion', ['Yes', 'No'])->nullable();
            $table->enum('baptism_in_holy_spirit', ['Yes', 'No'])->nullable();
            $table->string('home_church')->nullable();
            $table->string('center')->nullable();
            $table->string('disciple_maker_name')->nullable();
            $table->string('disciple_maker_contact')->nullable();
            $table->string('spiritual_parentage_name')->nullable();
            $table->string('spiritual_parentage_contact')->nullable();
            $table->text('spiritual_parentage_relationship')->nullable();
            $table->text('testimony')->nullable();

            // 4. Family Life
            $table->enum('marital_status', ['Married', 'Single', 'Engaged'])->nullable();
            $table->string('spouse_name')->nullable();
            $table->string('spouse_contact')->nullable();
            $table->integer('number_of_legitimate_children')->nullable();
            $table->text('legitimate_children_details')->nullable();
            $table->integer('number_of_dependents')->nullable();
            $table->text('dependents_details')->nullable();
            $table->text('siblings_details')->nullable();

            // 5. Professional Life
            $table->string('education_financer')->nullable();
            $table->string('education_level')->nullable();
            $table->string('degree_obtained')->nullable();
            $table->text('activity_before_hq')->nullable();
            $table->date('hq_entry_date')->nullable();
            $table->string('hq_department')->nullable();
            $table->string('origin_country_city')->nullable();
            $table->text('department_responsibility')->nullable();
            $table->string('time_in_department')->nullable();
            $table->enum('monthly_allowance', ['Yes', 'No'])->nullable();
            $table->date('allowance_since')->nullable();
            $table->text('other_responsibilities')->nullable();
            $table->text('department_changes')->nullable();
            $table->enum('have_disciples', ['Yes', 'No'])->nullable();
            $table->integer('number_of_disciples')->nullable();
            $table->string('degrees_held')->nullable();
            $table->string('professional_training_received')->nullable();
            $table->string('professional_training_location')->nullable();
            $table->string('professional_training_duration')->nullable();
            $table->enum('on_the_job_training', ['Yes', 'No'])->nullable();
            $table->text('why_work_at_hq')->nullable();
            $table->text('brief_testimony')->nullable();

            // 6. Commissioning
            $table->text('who_introduced_to_hq')->nullable();
            $table->enum('call_of_god', ['Yes', 'No'])->nullable();
            $table->text('what_call_consists_of')->nullable();
            $table->enum('family_aware_of_call', ['Yes', 'No'])->nullable();
            $table->enum('family_released_for_call', ['Yes', 'No'])->nullable();
            $table->string('emergency_contact_death')->nullable();
            $table->string('burial_location')->nullable();
            $table->enum('family_aware_of_burial_location', ['Yes', 'No'])->nullable();

            // 7. Possessions & Health History
            $table->text('your_possessions')->nullable();
            $table->text('sources_of_income')->nullable();
            $table->text('health_problems')->nullable();
            $table->enum('under_treatment', ['Yes', 'No'])->nullable();
            $table->text('operations_details')->nullable();
            $table->enum('special_diet', ['Yes', 'No'])->nullable();
            $table->text('common_family_illnesses')->nullable();

            // 8. Judicial History
            $table->enum('problems_with_anyone', ['Yes', 'No'])->nullable();
            $table->text('reason_for_problems')->nullable();
            $table->enum('been_to_prison', ['Yes', 'No'])->nullable();
            $table->text('reason_for_prison')->nullable();

            // 9. Documents to Provide
            $table->string('bulletin3_file')->nullable();
            $table->string('medical_certificate_hope_clinic_file')->nullable();
            $table->string('diplomas_file')->nullable();
            $table->string('birth_marriage_certificates_file')->nullable();
            $table->string('cni_file')->nullable();
            $table->string('family_commitment_call_file')->nullable();
            $table->string('family_burial_agreement_file')->nullable();

            // Authentication & Status
            $table->string('password')->nullable();
            $table->boolean('gdpr_consent')->default(false);
            $table->timestamp('submitted_at')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('staff', function (Blueprint $table) {
            // Supprimer tous les nouveaux champs ajoutés
            $table->dropColumn([
                'fathers_name', 'mothers_name', 'date_of_birth', 'place_of_birth', 'id_passport_number',
                'full_address', 'whatsapp_number', 'region', 'place_of_residence', 'department_of_origin',
                'village', 'ethnicity', 'number_of_siblings', 'next_of_kin_name', 'next_of_kin_city',
                'next_of_kin_contact', 'family_head_name', 'family_head_city', 'family_head_contact',
                'conversion_date', 'baptism_by_immersion', 'baptism_in_holy_spirit', 'home_church',
                'center', 'disciple_maker_name', 'disciple_maker_contact', 'spiritual_parentage_name',
                'spiritual_parentage_contact', 'spiritual_parentage_relationship', 'testimony',
                'marital_status', 'spouse_name', 'spouse_contact', 'number_of_legitimate_children',
                'legitimate_children_details', 'number_of_dependents', 'dependents_details', 'siblings_details',
                'education_financer', 'education_level', 'degree_obtained', 'activity_before_hq',
                'hq_entry_date', 'hq_department', 'origin_country_city', 'department_responsibility',
                'time_in_department', 'monthly_allowance', 'allowance_since', 'other_responsibilities',
                'department_changes', 'have_disciples', 'number_of_disciples', 'degrees_held',
                'professional_training_received', 'professional_training_location', 'professional_training_duration',
                'on_the_job_training', 'why_work_at_hq', 'brief_testimony',
                'who_introduced_to_hq', 'call_of_god', 'what_call_consists_of', 'family_aware_of_call',
                'family_released_for_call', 'emergency_contact_death', 'burial_location',
                'family_aware_of_burial_location', 'your_possessions', 'sources_of_income',
                'health_problems', 'under_treatment', 'operations_details', 'special_diet',
                'common_family_illnesses', 'problems_with_anyone', 'reason_for_problems',
                'been_to_prison', 'reason_for_prison', 'bulletin3_file', 'medical_certificate_hope_clinic_file',
                'diplomas_file', 'birth_marriage_certificates_file', 'cni_file', 'family_commitment_call_file',
                'family_burial_agreement_file', 'password', 'gdpr_consent', 'submitted_at', 'status'
            ]);
        });
    }
};
