<?php

namespace App\Models;

use App\Models\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ideaforum extends Model
{
    use HasFactory;
}

class _users extends ideaforum
{
    use HasFactory;

}

class _posts extends ideaforum
{
    use HasFactory;
}

class _comments extends ideaforum
{
    use HasFactory;
}

class _votes extends ideaforum
{
    use HasFactory;
}
