<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RenameLink extends Model
{
    use HasFactory;

    protected $primaryKey = "pk";

    protected $table = "rename_link";

    protected $fillable = [
        'link_simrs_dicom',
        'link_simrs_expertise',
        'dokrad_lastname',
    ];
}
