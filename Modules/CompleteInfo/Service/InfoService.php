<?php

namespace Modules\CompleteInfo\Service;

use http\Env\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Modules\CompleteInfo\Models\Education;
use Modules\CompleteInfo\Models\Residence;
use Modules\CompleteInfo\Models\Speciality;
use Modules\CompleteInfo\Models\Talent;
use Modules\Shared\Enums\UserType;
use Modules\Auth\Mail\VerificationEmail;
use Modules\Shared\Models\User;

class InfoService {
    public function Residences()
    {
        return Residence::all();
    }
    public function Specialities()
    {
        return Speciality::all();
    }
    public function Talents()
    {
        return Talent::all();
    }
    public function Educations()
    {
        return Education::all();
    }

}
