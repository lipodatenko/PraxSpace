<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user';


    public function contacts()
    {
        return $this->hasMany(Contact::class, 'user_id');
    }

    public function address()
    {
        return $this->hasOne(Address::class, 'user_id');
    }
}
