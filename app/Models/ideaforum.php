<?php

namespace App\Models;

use App\Models\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ideaforum extends Model
{
    use HasFactory;
}

class user extends ideaforum
{
    use HasFactory;
    
}

class post extends ideaforum
{
    use HasFactory;
}

class comment extends ideaforum
{
    use HasFactory;
}

class vote extends ideaforum
{
    use HasFactory;
}
