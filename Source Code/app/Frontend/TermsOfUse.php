<?php

namespace App\Frontend;

use Illuminate\Database\Eloquent\Model;
use Te7aHoudini\LaravelTrix\Traits\HasTrixRichText;

class TermsOfUse extends Model
{
    use HasTrixRichText;
    protected $guarded = [];
}
