<?php

namespace App\Models;

use CodeIgniter\Model;

class BusinessModel extends Model
{
    protected $table      = 'business_details';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id',
        'request_id',
        'business_type',

        // SOLE
        'legal_first_name',
        'legal_middle_name',
        'legal_last_name',
        'nationality',
        'address_line1',
        'address_line2',
        'zip',
        'country_id',
        'state_id',
        'city_id',
        'contact_phone',

        // REGISTERED
        'legal_business_name',
        'doing_business_as',
        'ein_registered',
        'account_number',
        'ifsc_code',
        'stakeholders',
        'registered_business_type',
        'primary_first_name',
        'primary_middle_name',
        'primary_last_name',
        'primary_dob',
        'primary_nationality',
        'ssn_last4',
        'contact_address1',
        'contact_address2',
        'contact_city',
        'contact_state',
        'contact_zip',
        'roles'

    ];

    protected $useTimestamps = true;

    // ✅ Correct method name
    public function saveBusinessDetails($data)
    {
        return $this->insert($data); // returns insert ID
    }

    public function getBusinessDetails($userId)
    {
        return $this->where('user_id', $userId)->first();
    }
}
