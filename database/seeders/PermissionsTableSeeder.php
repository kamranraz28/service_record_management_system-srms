<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_access',
            ],
            [
                'id'    => 6,
                'title' => 'role_create',
            ],
            [
                'id'    => 7,
                'title' => 'role_edit',
            ],
            [
                'id'    => 8,
                'title' => 'role_show',
            ],
            [
                'id'    => 9,
                'title' => 'role_delete',
            ],
            [
                'id'    => 10,
                'title' => 'role_access',
            ],
            [
                'id'    => 11,
                'title' => 'user_create',
            ],
            [
                'id'    => 12,
                'title' => 'user_edit',
            ],
            [
                'id'    => 13,
                'title' => 'user_show',
            ],
            [
                'id'    => 14,
                'title' => 'user_delete',
            ],
            [
                'id'    => 15,
                'title' => 'user_access',
            ],
            [
                'id'    => 16,
                'title' => 'division_create',
            ],
            [
                'id'    => 17,
                'title' => 'division_edit',
            ],
            [
                'id'    => 18,
                'title' => 'division_show',
            ],
            [
                'id'    => 19,
                'title' => 'division_delete',
            ],
            [
                'id'    => 20,
                'title' => 'division_access',
            ],
            [
                'id'    => 21,
                'title' => 'configuration_access',
            ],
            [
                'id'    => 22,
                'title' => 'district_create',
            ],
            [
                'id'    => 23,
                'title' => 'district_edit',
            ],
            [
                'id'    => 24,
                'title' => 'district_show',
            ],
            [
                'id'    => 25,
                'title' => 'district_delete',
            ],
            [
                'id'    => 26,
                'title' => 'district_access',
            ],
            [
                'id'    => 27,
                'title' => 'maritalstatus_create',
            ],
            [
                'id'    => 28,
                'title' => 'maritalstatus_edit',
            ],
            [
                'id'    => 29,
                'title' => 'maritalstatus_show',
            ],
            [
                'id'    => 30,
                'title' => 'maritalstatus_access',
            ],
            [
                'id'    => 31,
                'title' => 'gender_create',
            ],
            [
                'id'    => 32,
                'title' => 'gender_edit',
            ],
            [
                'id'    => 33,
                'title' => 'gender_show',
            ],
            [
                'id'    => 34,
                'title' => 'gender_delete',
            ],
            [
                'id'    => 35,
                'title' => 'gender_access',
            ],
            [
                'id'    => 36,
                'title' => 'religion_create',
            ],
            [
                'id'    => 37,
                'title' => 'religion_edit',
            ],
            [
                'id'    => 38,
                'title' => 'religion_show',
            ],
            [
                'id'    => 39,
                'title' => 'religion_delete',
            ],
            [
                'id'    => 40,
                'title' => 'religion_access',
            ],
            [
                'id'    => 41,
                'title' => 'blood_group_create',
            ],
            [
                'id'    => 42,
                'title' => 'blood_group_edit',
            ],
            [
                'id'    => 43,
                'title' => 'blood_group_show',
            ],
            [
                'id'    => 44,
                'title' => 'blood_group_delete',
            ],
            [
                'id'    => 45,
                'title' => 'blood_group_access',
            ],
            [
                'id'    => 46,
                'title' => 'quotum_create',
            ],
            [
                'id'    => 47,
                'title' => 'quotum_edit',
            ],
            [
                'id'    => 48,
                'title' => 'quotum_show',
            ],
            [
                'id'    => 49,
                'title' => 'quotum_delete',
            ],
            [
                'id'    => 50,
                'title' => 'quotum_access',
            ],
            [
                'id'    => 51,
                'title' => 'examination_create',
            ],
            [
                'id'    => 52,
                'title' => 'examination_edit',
            ],
            [
                'id'    => 53,
                'title' => 'examination_show',
            ],
            [
                'id'    => 54,
                'title' => 'examination_access',
            ],
            [
                'id'    => 55,
                'title' => 'exam_board_create',
            ],
            [
                'id'    => 56,
                'title' => 'exam_board_edit',
            ],
            [
                'id'    => 57,
                'title' => 'exam_board_show',
            ],
            [
                'id'    => 58,
                'title' => 'exam_board_delete',
            ],
            [
                'id'    => 59,
                'title' => 'exam_board_access',
            ],
            [
                'id'    => 60,
                'title' => 'office_unit_create',
            ],
            [
                'id'    => 61,
                'title' => 'office_unit_edit',
            ],
            [
                'id'    => 62,
                'title' => 'office_unit_show',
            ],
            [
                'id'    => 63,
                'title' => 'office_unit_delete',
            ],
            [
                'id'    => 64,
                'title' => 'office_unit_access',
            ],
            [
                'id'    => 65,
                'title' => 'designation_create',
            ],
            [
                'id'    => 66,
                'title' => 'designation_edit',
            ],
            [
                'id'    => 67,
                'title' => 'designation_show',
            ],
            [
                'id'    => 68,
                'title' => 'designation_delete',
            ],
            [
                'id'    => 69,
                'title' => 'designation_access',
            ],
            [
                'id'    => 70,
                'title' => 'leave_category_create',
            ],
            [
                'id'    => 71,
                'title' => 'leave_category_edit',
            ],
            [
                'id'    => 72,
                'title' => 'leave_category_show',
            ],
            [
                'id'    => 73,
                'title' => 'leave_category_delete',
            ],
            [
                'id'    => 74,
                'title' => 'leave_category_access',
            ],
            [
                'id'    => 75,
                'title' => 'leave_type_create',
            ],
            [
                'id'    => 76,
                'title' => 'leave_type_edit',
            ],
            [
                'id'    => 77,
                'title' => 'leave_type_show',
            ],
            [
                'id'    => 78,
                'title' => 'leave_type_delete',
            ],
            [
                'id'    => 79,
                'title' => 'leave_type_access',
            ],
            [
                'id'    => 80,
                'title' => 'training_type_create',
            ],
            [
                'id'    => 81,
                'title' => 'training_type_edit',
            ],
            [
                'id'    => 82,
                'title' => 'training_type_show',
            ],
            [
                'id'    => 83,
                'title' => 'training_type_delete',
            ],
            [
                'id'    => 84,
                'title' => 'training_type_access',
            ],
            [
                'id'    => 85,
                'title' => 'country_create',
            ],
            [
                'id'    => 86,
                'title' => 'country_edit',
            ],
            [
                'id'    => 87,
                'title' => 'country_show',
            ],
            [
                'id'    => 88,
                'title' => 'country_delete',
            ],
            [
                'id'    => 89,
                'title' => 'country_access',
            ],
            [
                'id'    => 90,
                'title' => 'travel_purpose_create',
            ],
            [
                'id'    => 91,
                'title' => 'travel_purpose_edit',
            ],
            [
                'id'    => 92,
                'title' => 'travel_purpose_show',
            ],
            [
                'id'    => 93,
                'title' => 'travel_purpose_delete',
            ],
            [
                'id'    => 94,
                'title' => 'travel_purpose_access',
            ],
            [
                'id'    => 95,
                'title' => 'employee_list_create',
            ],
            [
                'id'    => 96,
                'title' => 'employee_list_edit',
            ],
            [
                'id'    => 97,
                'title' => 'employee_list_show',
            ],
            [
                'id'    => 98,
                'title' => 'employee_list_delete',
            ],
            [
                'id'    => 99,
                'title' => 'employee_list_access',
            ],
            [
                'id'    => 100,
                'title' => 'license_type_create',
            ],
            [
                'id'    => 101,
                'title' => 'license_type_edit',
            ],
            [
                'id'    => 102,
                'title' => 'license_type_show',
            ],
            [
                'id'    => 103,
                'title' => 'license_type_delete',
            ],
            [
                'id'    => 104,
                'title' => 'license_type_access',
            ],
            [
                'id'    => 105,
                'title' => 'job_type_create',
            ],
            [
                'id'    => 106,
                'title' => 'job_type_edit',
            ],
            [
                'id'    => 107,
                'title' => 'job_type_show',
            ],
            [
                'id'    => 108,
                'title' => 'job_type_delete',
            ],
            [
                'id'    => 109,
                'title' => 'job_type_access',
            ],
            [
                'id'    => 110,
                'title' => 'grade_create',
            ],
            [
                'id'    => 111,
                'title' => 'grade_edit',
            ],
            [
                'id'    => 112,
                'title' => 'grade_show',
            ],
            [
                'id'    => 113,
                'title' => 'grade_delete',
            ],
            [
                'id'    => 114,
                'title' => 'grade_access',
            ],
            [
                'id'    => 115,
                'title' => 'employee_detail_access',
            ],
            [
                'id'    => 116,
                'title' => 'education_informatione_create',
            ],
            [
                'id'    => 117,
                'title' => 'education_informatione_edit',
            ],
            [
                'id'    => 118,
                'title' => 'education_informatione_show',
            ],
            [
                'id'    => 119,
                'title' => 'education_informatione_delete',
            ],
            [
                'id'    => 120,
                'title' => 'education_informatione_access',
            ],
            [
                'id'    => 121,
                'title' => 'professionale_create',
            ],
            [
                'id'    => 122,
                'title' => 'professionale_edit',
            ],
            [
                'id'    => 123,
                'title' => 'professionale_show',
            ],
            [
                'id'    => 124,
                'title' => 'professionale_delete',
            ],
            [
                'id'    => 125,
                'title' => 'professionale_access',
            ],
            [
                'id'    => 126,
                'title' => 'addressdetaile_create',
            ],
            [
                'id'    => 127,
                'title' => 'addressdetaile_edit',
            ],
            [
                'id'    => 128,
                'title' => 'addressdetaile_show',
            ],
            [
                'id'    => 129,
                'title' => 'addressdetaile_delete',
            ],
            [
                'id'    => 130,
                'title' => 'addressdetaile_access',
            ],
            [
                'id'    => 131,
                'title' => 'upazila_create',
            ],
            [
                'id'    => 132,
                'title' => 'upazila_edit',
            ],
            [
                'id'    => 133,
                'title' => 'upazila_show',
            ],
            [
                'id'    => 134,
                'title' => 'upazila_delete',
            ],
            [
                'id'    => 135,
                'title' => 'upazila_access',
            ],
            [
                'id'    => 136,
                'title' => 'emergence_contacte_create',
            ],
            [
                'id'    => 137,
                'title' => 'emergence_contacte_edit',
            ],
            [
                'id'    => 138,
                'title' => 'emergence_contacte_show',
            ],
            [
                'id'    => 139,
                'title' => 'emergence_contacte_delete',
            ],
            [
                'id'    => 140,
                'title' => 'emergence_contacte_access',
            ],
            [
                'id'    => 141,
                'title' => 'spouse_informatione_create',
            ],
            [
                'id'    => 142,
                'title' => 'spouse_informatione_edit',
            ],
            [
                'id'    => 143,
                'title' => 'spouse_informatione_show',
            ],
            [
                'id'    => 144,
                'title' => 'spouse_informatione_delete',
            ],
            [
                'id'    => 145,
                'title' => 'spouse_informatione_access',
            ],
            [
                'id'    => 146,
                'title' => 'child_create',
            ],
            [
                'id'    => 147,
                'title' => 'child_edit',
            ],
            [
                'id'    => 148,
                'title' => 'child_show',
            ],
            [
                'id'    => 149,
                'title' => 'child_delete',
            ],
            [
                'id'    => 150,
                'title' => 'child_access',
            ],
            [
                'id'    => 151,
                'title' => 'job_history_create',
            ],
            [
                'id'    => 152,
                'title' => 'job_history_edit',
            ],
            [
                'id'    => 153,
                'title' => 'job_history_show',
            ],
            [
                'id'    => 154,
                'title' => 'job_history_delete',
            ],
            [
                'id'    => 155,
                'title' => 'job_history_access',
            ],
            [
                'id'    => 156,
                'title' => 'employee_promotion_create',
            ],
            [
                'id'    => 157,
                'title' => 'employee_promotion_edit',
            ],
            [
                'id'    => 158,
                'title' => 'employee_promotion_show',
            ],
            [
                'id'    => 159,
                'title' => 'employee_promotion_delete',
            ],
            [
                'id'    => 160,
                'title' => 'employee_promotion_access',
            ],
            [
                'id'    => 161,
                'title' => 'leave_record_create',
            ],
            [
                'id'    => 162,
                'title' => 'leave_record_edit',
            ],
            [
                'id'    => 163,
                'title' => 'leave_record_show',
            ],
            [
                'id'    => 164,
                'title' => 'leave_record_delete',
            ],
            [
                'id'    => 165,
                'title' => 'leave_record_access',
            ],
            [
                'id'    => 166,
                'title' => 'training_create',
            ],
            [
                'id'    => 167,
                'title' => 'training_edit',
            ],
            [
                'id'    => 168,
                'title' => 'training_show',
            ],
            [
                'id'    => 169,
                'title' => 'training_delete',
            ],
            [
                'id'    => 170,
                'title' => 'training_access',
            ],
            [
                'id'    => 171,
                'title' => 'traveltype_create',
            ],
            [
                'id'    => 172,
                'title' => 'traveltype_edit',
            ],
            [
                'id'    => 173,
                'title' => 'traveltype_show',
            ],
            [
                'id'    => 174,
                'title' => 'traveltype_delete',
            ],
            [
                'id'    => 175,
                'title' => 'traveltype_access',
            ],
            [
                'id'    => 176,
                'title' => 'travel_record_create',
            ],
            [
                'id'    => 177,
                'title' => 'travel_record_edit',
            ],
            [
                'id'    => 178,
                'title' => 'travel_record_show',
            ],
            [
                'id'    => 179,
                'title' => 'travel_record_delete',
            ],
            [
                'id'    => 180,
                'title' => 'travel_record_access',
            ],
            [
                'id'    => 181,
                'title' => 'extracurriculam_create',
            ],
            [
                'id'    => 182,
                'title' => 'extracurriculam_edit',
            ],
            [
                'id'    => 183,
                'title' => 'extracurriculam_show',
            ],
            [
                'id'    => 184,
                'title' => 'extracurriculam_delete',
            ],
            [
                'id'    => 185,
                'title' => 'extracurriculam_access',
            ],
            [
                'id'    => 186,
                'title' => 'publication_create',
            ],
            [
                'id'    => 187,
                'title' => 'publication_edit',
            ],
            [
                'id'    => 188,
                'title' => 'publication_show',
            ],
            [
                'id'    => 189,
                'title' => 'publication_delete',
            ],
            [
                'id'    => 190,
                'title' => 'publication_access',
            ],
            [
                'id'    => 191,
                'title' => 'language_create',
            ],
            [
                'id'    => 192,
                'title' => 'language_edit',
            ],
            [
                'id'    => 193,
                'title' => 'language_show',
            ],
            [
                'id'    => 194,
                'title' => 'language_delete',
            ],
            [
                'id'    => 195,
                'title' => 'language_access',
            ],
            [
                'id'    => 196,
                'title' => 'criminal_prosecutione_create',
            ],
            [
                'id'    => 197,
                'title' => 'criminal_prosecutione_edit',
            ],
            [
                'id'    => 198,
                'title' => 'criminal_prosecutione_show',
            ],
            [
                'id'    => 199,
                'title' => 'criminal_prosecutione_delete',
            ],
            [
                'id'    => 200,
                'title' => 'criminal_prosecutione_access',
            ],
            [
                'id'    => 201,
                'title' => 'criminalpro_disciplinary_create',
            ],
            [
                'id'    => 202,
                'title' => 'criminalpro_disciplinary_edit',
            ],
            [
                'id'    => 203,
                'title' => 'criminalpro_disciplinary_show',
            ],
            [
                'id'    => 204,
                'title' => 'criminalpro_disciplinary_delete',
            ],
            [
                'id'    => 205,
                'title' => 'criminalpro_disciplinary_access',
            ],
            [
                'id'    => 206,
                'title' => 'acr_monitoring_create',
            ],
            [
                'id'    => 207,
                'title' => 'acr_monitoring_edit',
            ],
            [
                'id'    => 208,
                'title' => 'acr_monitoring_show',
            ],
            [
                'id'    => 209,
                'title' => 'acr_monitoring_delete',
            ],
            [
                'id'    => 210,
                'title' => 'acr_monitoring_access',
            ],
            [
                'id'    => 211,
                'title' => 'audit_log_show',
            ],
            [
                'id'    => 212,
                'title' => 'audit_log_access',
            ],
            [
                'id'    => 213,
                'title' => 'faq_management_access',
            ],
            [
                'id'    => 214,
                'title' => 'faq_category_create',
            ],
            [
                'id'    => 215,
                'title' => 'faq_category_edit',
            ],
            [
                'id'    => 216,
                'title' => 'faq_category_show',
            ],
            [
                'id'    => 217,
                'title' => 'faq_category_delete',
            ],
            [
                'id'    => 218,
                'title' => 'faq_category_access',
            ],
            [
                'id'    => 219,
                'title' => 'faq_question_create',
            ],
            [
                'id'    => 220,
                'title' => 'faq_question_edit',
            ],
            [
                'id'    => 221,
                'title' => 'faq_question_show',
            ],
            [
                'id'    => 222,
                'title' => 'faq_question_delete',
            ],
            [
                'id'    => 223,
                'title' => 'faq_question_access',
            ],
            [
                'id'    => 224,
                'title' => 'edu_config_access',
            ],
            [
                'id'    => 225,
                'title' => 'office_config_access',
            ],
            [
                'id'    => 226,
                'title' => 'site_setting_create',
            ],
            [
                'id'    => 227,
                'title' => 'site_setting_edit',
            ],
            [
                'id'    => 228,
                'title' => 'site_setting_show',
            ],
            [
                'id'    => 229,
                'title' => 'site_setting_delete',
            ],
            [
                'id'    => 230,
                'title' => 'site_setting_access',
            ],
            [
                'id'    => 231,
                'title' => 'batch_create',
            ],
            [
                'id'    => 232,
                'title' => 'batch_edit',
            ],
            [
                'id'    => 233,
                'title' => 'batch_show',
            ],
            [
                'id'    => 234,
                'title' => 'batch_delete',
            ],
            [
                'id'    => 235,
                'title' => 'batch_access',
            ],
            [
                'id'    => 236,
                'title' => 'joininginfo_create',
            ],
            [
                'id'    => 237,
                'title' => 'joininginfo_edit',
            ],
            [
                'id'    => 238,
                'title' => 'joininginfo_show',
            ],
            [
                'id'    => 239,
                'title' => 'joininginfo_delete',
            ],
            [
                'id'    => 240,
                'title' => 'joininginfo_access',
            ],
            [
                'id'    => 241,
                'title' => 'project_revenuelone_create',
            ],
            [
                'id'    => 242,
                'title' => 'project_revenuelone_edit',
            ],
            [
                'id'    => 243,
                'title' => 'project_revenuelone_show',
            ],
            [
                'id'    => 244,
                'title' => 'project_revenuelone_delete',
            ],
            [
                'id'    => 245,
                'title' => 'project_revenuelone_access',
            ],
            [
                'id'    => 246,
                'title' => 'project_revenue_exam_create',
            ],
            [
                'id'    => 247,
                'title' => 'project_revenue_exam_edit',
            ],
            [
                'id'    => 248,
                'title' => 'project_revenue_exam_show',
            ],
            [
                'id'    => 249,
                'title' => 'project_revenue_exam_access',
            ],
            [
                'id'    => 250,
                'title' => 'service_particular_create',
            ],
            [
                'id'    => 251,
                'title' => 'service_particular_edit',
            ],
            [
                'id'    => 252,
                'title' => 'service_particular_show',
            ],
            [
                'id'    => 253,
                'title' => 'service_particular_delete',
            ],
            [
                'id'    => 254,
                'title' => 'service_particular_access',
            ],
            [
                'id'    => 255,
                'title' => 'foreign_travel_personal_create',
            ],
            [
                'id'    => 256,
                'title' => 'foreign_travel_personal_edit',
            ],
            [
                'id'    => 257,
                'title' => 'foreign_travel_personal_show',
            ],
            [
                'id'    => 258,
                'title' => 'foreign_travel_personal_delete',
            ],
            [
                'id'    => 259,
                'title' => 'foreign_travel_personal_access',
            ],
            [
                'id'    => 260,
                'title' => 'social_ass_pr_attachment_create',
            ],
            [
                'id'    => 261,
                'title' => 'social_ass_pr_attachment_edit',
            ],
            [
                'id'    => 262,
                'title' => 'social_ass_pr_attachment_show',
            ],
            [
                'id'    => 263,
                'title' => 'social_ass_pr_attachment_access',
            ],
            [
                'id'    => 264,
                'title' => 'award_create',
            ],
            [
                'id'    => 265,
                'title' => 'award_edit',
            ],
            [
                'id'    => 266,
                'title' => 'award_show',
            ],
            [
                'id'    => 267,
                'title' => 'award_delete',
            ],
            [
                'id'    => 268,
                'title' => 'award_access',
            ],
            [
                'id'    => 269,
                'title' => 'other_service_job_create',
            ],
            [
                'id'    => 270,
                'title' => 'other_service_job_edit',
            ],
            [
                'id'    => 271,
                'title' => 'other_service_job_show',
            ],
            [
                'id'    => 272,
                'title' => 'other_service_job_delete',
            ],
            [
                'id'    => 273,
                'title' => 'other_service_job_access',
            ],
            [
                'id'    => 274,
                'title' => 'language_proficiency_create',
            ],
            [
                'id'    => 275,
                'title' => 'language_proficiency_edit',
            ],
            [
                'id'    => 276,
                'title' => 'language_proficiency_show',
            ],
            [
                'id'    => 277,
                'title' => 'language_proficiency_delete',
            ],
            [
                'id'    => 278,
                'title' => 'language_proficiency_access',
            ],
            [
                'id'    => 279,
                'title' => 'language_list_create',
            ],
            [
                'id'    => 280,
                'title' => 'language_list_edit',
            ],
            [
                'id'    => 281,
                'title' => 'language_list_show',
            ],
            [
                'id'    => 282,
                'title' => 'language_list_delete',
            ],
            [
                'id'    => 283,
                'title' => 'language_list_access',
            ],
            [
                'id'    => 284,
                'title' => 'status_create',
            ],
            [
                'id'    => 285,
                'title' => 'status_edit',
            ],
            [
                'id'    => 286,
                'title' => 'status_show',
            ],
            [
                'id'    => 287,
                'title' => 'status_delete',
            ],
            [
                'id'    => 288,
                'title' => 'status_access',
            ],
            [
                'id'    => 289,
                'title' => 'year_create',
            ],
            [
                'id'    => 290,
                'title' => 'year_edit',
            ],
            [
                'id'    => 291,
                'title' => 'year_show',
            ],
            [
                'id'    => 292,
                'title' => 'year_delete',
            ],
            [
                'id'    => 293,
                'title' => 'year_access',
            ],
            [
                'id'    => 294,
                'title' => 'freedom_fighte_relation_create',
            ],
            [
                'id'    => 295,
                'title' => 'freedom_fighte_relation_edit',
            ],
            [
                'id'    => 296,
                'title' => 'freedom_fighte_relation_show',
            ],
            [
                'id'    => 297,
                'title' => 'freedom_fighte_relation_delete',
            ],
            [
                'id'    => 298,
                'title' => 'freedom_fighte_relation_access',
            ],
            [
                'id'    => 299,
                'title' => 'achievementschools_university_create',
            ],
            [
                'id'    => 300,
                'title' => 'achievementschools_university_edit',
            ],
            [
                'id'    => 301,
                'title' => 'achievementschools_university_show',
            ],
            [
                'id'    => 302,
                'title' => 'achievementschools_university_delete',
            ],
            [
                'id'    => 303,
                'title' => 'achievementschools_university_access',
            ],
            [
                'id'    => 304,
                'title' => 'project_create',
            ],
            [
                'id'    => 305,
                'title' => 'project_edit',
            ],
            [
                'id'    => 306,
                'title' => 'project_show',
            ],
            [
                'id'    => 307,
                'title' => 'project_delete',
            ],
            [
                'id'    => 308,
                'title' => 'project_access',
            ],
            [
                'id'    => 309,
                'title' => 'forest_state_create',
            ],
            [
                'id'    => 310,
                'title' => 'forest_state_edit',
            ],
            [
                'id'    => 311,
                'title' => 'forest_state_show',
            ],
            [
                'id'    => 312,
                'title' => 'forest_state_delete',
            ],
            [
                'id'    => 313,
                'title' => 'forest_state_access',
            ],
            [
                'id'    => 314,
                'title' => 'forest_range_create',
            ],
            [
                'id'    => 315,
                'title' => 'forest_range_edit',
            ],
            [
                'id'    => 316,
                'title' => 'forest_range_show',
            ],
            [
                'id'    => 317,
                'title' => 'forest_range_delete',
            ],
            [
                'id'    => 318,
                'title' => 'forest_range_access',
            ],
            [
                'id'    => 319,
                'title' => 'forest_beat_create',
            ],
            [
                'id'    => 320,
                'title' => 'forest_beat_edit',
            ],
            [
                'id'    => 321,
                'title' => 'forest_beat_show',
            ],
            [
                'id'    => 322,
                'title' => 'forest_beat_delete',
            ],
            [
                'id'    => 323,
                'title' => 'forest_beat_access',
            ],
            [
                'id'    => 324,
                'title' => 'job_configuration_access',
            ],
            [
                'id'    => 325,
                'title' => 'forest_division_create',
            ],
            [
                'id'    => 326,
                'title' => 'forest_division_edit',
            ],
            [
                'id'    => 327,
                'title' => 'forest_division_show',
            ],
            [
                'id'    => 328,
                'title' => 'forest_division_delete',
            ],
            [
                'id'    => 329,
                'title' => 'forest_division_access',
            ],
            [
                'id'    => 330,
                'title' => 'exam_degree_create',
            ],
            [
                'id'    => 331,
                'title' => 'exam_degree_edit',
            ],
            [
                'id'    => 332,
                'title' => 'exam_degree_show',
            ],
            [
                'id'    => 333,
                'title' => 'exam_degree_delete',
            ],
            [
                'id'    => 334,
                'title' => 'exam_degree_access',
            ],
            [
                'id'    => 335,
                'title' => 'result_group_create',
            ],
            [
                'id'    => 336,
                'title' => 'result_group_edit',
            ],
            [
                'id'    => 337,
                'title' => 'result_group_show',
            ],
            [
                'id'    => 338,
                'title' => 'result_group_delete',
            ],
            [
                'id'    => 339,
                'title' => 'result_group_access',
            ],
            [
                'id'    => 340,
                'title' => 'result_create',
            ],
            [
                'id'    => 341,
                'title' => 'result_edit',
            ],
            [
                'id'    => 342,
                'title' => 'result_show',
            ],
            [
                'id'    => 343,
                'title' => 'result_delete',
            ],
            [
                'id'    => 344,
                'title' => 'result_access',
            ],
            [
                'id'    => 345,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
